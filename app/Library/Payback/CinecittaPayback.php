<?php

namespace App\Library\Payback;

use App\Order;
use Illuminate\Support\Facades\DB;
use ClassMap;


require_once __DIR__ . '/vendor/autoload.php';


class CinecittaPayback {

	public $options = [];
	public $store;

	public $periodi;
	public $punti;
	public $process_punti = false;
	public $sumTable = [ [0,1,2,3,4,5,6,7,8,9], [0,2,4,6,8,1,3,5,7,9] ];
	public $card_number_prefix = '637152';

	const CARDNUMBER_FIELD_NAME = 'payback_card'; // nome del campo della tabella identity

	public function __construct() {

		$payback_wsdl = DB::connection('mysql2')->table('wp_options')->where('option_name', 'options_payback_wsdl')->value('option_value');
		$payback_username = DB::connection('mysql2')->table('wp_options')->where('option_name', 'options_payback_username')->value('option_value');
		$payback_password = DB::connection('mysql2')->table('wp_options')->where('option_name', 'options_payback_password')->value('option_value');

		//mail('roberta@gag.it', '$payback_wsdl', var_export($payback_wsdl, true));

		$this->options = [
			\WsdlToPhp\PackageBase\AbstractSoapClientBase::WSDL_URL      => $payback_wsdl,
			\WsdlToPhp\PackageBase\AbstractSoapClientBase::WSDL_CLASSMAP => ClassMap::get(),
			\WsdlToPhp\PackageBase\AbstractSoapClientBase::WSDL_TRACE    => true,
			\WsdlToPhp\PackageBase\AbstractSoapClientBase::WSDL_LOGIN    => $payback_username,
			\WsdlToPhp\PackageBase\AbstractSoapClientBase::WSDL_PASSWORD => $payback_password
		];

		/*global $sitepress;

		if(is_object($sitepress)) {
			$sitepress->switch_lang('it', true);
		}*/

		$this->active  = (bool)(int)DB::connection('mysql2')->table('wp_options')->where('option_name', 'options_payback_active')->value('option_value');
		$this->periodi = DB::connection('mysql2')->table('wp_options')->where('option_name', 'like', 'options_payback_punti_periodi_0_%')->get();

		$this->periodi = json_decode($this->periodi, true);

		//mail('roberta@gag.it', '$this->periodi', var_export($this->periodi, true));
		//mail('roberta@gag.it', '$this', var_export($this, true));

		$this->redefinePeriods();
		//mail('roberta@gag.it', '$this->periodi bis', var_export($this->periodi, true));

	}

	private function redefinePeriods(){

		$arr = [];

		if(!empty($this->periodi)){

			foreach($this->periodi as $k => $periodo){

				$arr[str_replace('options_payback_punti_periodi_0_', '', $periodo['option_name'])] = $periodo['option_value'];

			}

			$this->periodi = [$arr];

		}

	}

	private function set_point_limits($purchase_time = null) {

		if(empty($purchase_time)) {
			$purchase_time = time();
		}

		$data_inizio = 0;

		$valid_periodo = [
			'punti_intero'  => 0,
			'punti_ridotto' => 0,
			'soglia_intero' => 0,
			'soglia_extra'  => 0,
			'punti_extra'   => 0
		];

		foreach($this->periodi as $periodo) {

			$periodo['data_inizio'] = strtotime($periodo['data_inizio']);

			if($periodo['data_inizio'] <= $purchase_time && $periodo['data_inizio'] > $data_inizio) {
				$valid_periodo = $periodo;
				$data_inizio = $periodo['data_inizio'];
			}

		}

		unset($periodo['data_inizio']);

		if($valid_periodo['punti_ridotto'] || $valid_periodo['punti_intero'] || $valid_periodo['punti_extra']) {
			$this->process_punti = true;
		}

		$this->punti = $valid_periodo;

	}

	private function calculate_check_digit($number){

		$length = strlen($number);
		$sum  = 0;
		$flip = 1;

		// Sum digits (last one is check digit, which is not in parameter)
		for($i = ($length - 1); $i >= 0; --$i) {
			$sum += $this->sumTable[ $flip++ & 0x1 ][ $number[$i] ];
		}

		// Multiply by 9
		$sum *= 9;

		// Last digit of sum is check digit
		return (int)substr($sum, -1, 1);

	}

	public function process_purchase($order_id) {

		if(!$this->active) {
			return false;
		}

		$this->set_point_limits();

		if(!$this->process_punti) {
			return false;
		}
				

		$order = Order::where('id', $order_id)->firstOrFail();

		$order_element = DB::table('order_element')->where('order_id', $order->id)->get();
		$order_element = json_decode($order_element, true);

		$items = [];            
		
		
		//print_r($order_element);
		
		foreach($order_element as $element){

			$product = DB::table('product')->where('id', $element['product_id'])->first();
						

			if($product->type == 'ticket'){ // solo i biglietti concorrono all'accumulo punti
			
				$ticket = DB::table('ticket')->where('product_id', $product->id)->first();
				$rate = DB::table('rate')->where('id', $ticket->rate_id)->first();
				
				$element['rid_code'] =  $rate->rid_code;
				$items[] = $element;

			}

		}
		
		//mail('roberta@gag.it', '$items', var_export($items, true));

		//Genereazione numero payback 16 cifre
		$card_number = DB::table('identity')->where('id', $order->identity_id)->value( self::CARDNUMBER_FIELD_NAME );
		
		//mail('roberta@gag.it', '$card_number', var_export($card_number, true));

		if(strlen($card_number) == 16) {

			$card_number = substr($card_number, 0, 15);

		} elseif(strlen($card_number) == 13) {

			$card_number = substr($card_number, 3, 9);

			$card_number = $this->card_number_prefix . $card_number;

		} elseif(strlen($card_number) == 10) {

			$card_number = substr($card_number, 0, 9);

			$card_number = $this->card_number_prefix . $card_number;

		} else {
			//No processing if wrong card number length
			return false;
		}

		$card_number_check_digit = $this->calculate_check_digit($card_number);
		$card_number_16 = $card_number . $card_number_check_digit;

		$rewardable_price = 0;
		$total_price = 0;
		$total_base_points = 0;
		$rewardable_items = 0;
		$purchaseItemDetails = array();
		$transactions = array();

		foreach($items as $item) {

			$item_total_price = ($item['quantity'] * $item['price']);
			$total_price += $item_total_price;

			$item_rewardable_price = ($item['quantity'] * $item['price']);
			$rewardable_price += $item_rewardable_price;
			$rewardable_items++;

			if($item['price'] >= $this->punti['soglia_intero']) {
				$pointsAmount = $this->punti['punti_intero'] * $item['quantity'];
			} else {
				$pointsAmount = $this->punti['punti_ridotto'] * $item['quantity'];
			}

			$total_base_points += $pointsAmount;

			$purchaseItemDetails[] = new \StructType\PurchaseItemDetails(
				$pointsAmount,
				//$item['id'],
				$item['rid_code'],
				$item['title'],
				null,
				null,
				null,
				null,
				null,
				null,
				null,
				null,
				null,
				null,
				number_format($item['price'], 3, '.', ''),
				(int)$item['quantity'],
				null,
				number_format($item_total_price, 3, '.', ''),
				number_format($item_rewardable_price, 3, '.', '')
			);

		}

		//Base transaction
		$totalPoints = new \StructType\LoyaltyUnitType(number_format($total_base_points, 3, '.', ''));

		$transaction = new \StructType\TransactionDetails(
			\EnumType\TransactionTypeType::VALUE_100,
			null,
			$totalPoints,
			null,
			array(),
			null
		);

		$transactions[] = $transaction;

		//Promotional transaction, if item number exceeds promotional limit
		if($rewardable_items >= $this->punti['soglia_extra'] && $this->punti['punti_extra'] > 0) {

			$totalPoints = new \StructType\LoyaltyUnitType(number_format($this->punti['punti_extra'], 3, '.', ''));

			$transaction = new \StructType\TransactionDetails(
				\EnumType\TransactionTypeType::VALUE_100,
				null,
				$totalPoints,
				null,
				array(),
				null
			);

			$transactions[] = $transaction;

		}

		$identification = new \StructType\MemberIdentificationType($card_number_16, '1');
		$authentication = new \StructType\MemberAliasIdentificationType($identification);

		$partnerShortName = $this->options[\WsdlToPhp\PackageBase\AbstractSoapClientBase::WSDL_LOGIN];
		$partner = new \StructType\PartnerContextType($partnerShortName);

		//$effectiveDate = substr_replace(date_i18n('c', false, true), substr(microtime(), 1, 8), 19, 0);;
		$effectiveDate = $lastmod = date('c');
		$communicationChannel = "15";

		$collectEventData = new \StructType\CollectEventType($partner, $effectiveDate, (string)$order->id, $communicationChannel);
		$purchaseEventType = '1';
		$rewardableLegalValue = new \StructType\LegalUnitType(number_format($rewardable_price, 3, '.', ''));
		$totalPurchaseLegalValue = new \StructType\LegalUnitType(number_format($total_price, 3, '.', ''));
		$paymentType = '9';
		$couponCodes = array();

		$process_request = new \StructType\ProcessPurchaseEventRequest(
			$authentication,
			$collectEventData,
			$purchaseEventType,
			$rewardableLegalValue,
			$totalPurchaseLegalValue,
			$paymentType,
			$couponCodes,
			$purchaseItemDetails,
			$transactions
		);

		$principal = $partnerShortName;
		$credential = $this->options[\WsdlToPhp\PackageBase\AbstractSoapClientBase::WSDL_PASSWORD];

		$consumerAuthentication = new \StructType\ConsumerAuthenticationType($principal, $credential);

		$partner2 = new \StructType\PartnerContextType($partnerShortName);

		$consumerIdentification = new \StructType\ConsumerIdentificationType(
			$consumerAuthentication,
			$partner2,
			null,
			null,
			'1'
		);

		$process_request->setConsumerIdentification($consumerIdentification);
		
		//mail('roberta@gag.it', 'payback $process_request', var_export($process_request, true));
		//mail('roberta@gag.it', '$this->options', var_export($this->options, true));

		$process = new \ServiceType\Process($this->options);

		if ($process->ProcessPurchaseEvent($process_request) !== false) {
			$result = $process->getResult();
		} else {
			$result = $process->getLastError();
		}

		$fault_message = $result->getFaultMessage();
		
		//mail('roberta@gag.it', 'payback $fault_message', var_export($fault_message, true));

		if(empty($fault_message)) {
			$fault_code = '';
		} else {
			$fault_code = $fault_message->getCode();
		}

		//Repeated transaction, not a real error
		if($fault_code != 'LOY-00175') {
			//update_field('debug_payback', @json_encode($result), $order_id);
		}

		if(empty($fault_code) || $fault_code == 'LOY-00175') {
			//update_field('esito_payback', 'OK', $order_id);
		} else {
			//update_field('esito_payback', 'KO', $order_id);
		}

		//mail('roberta@gag.it', 'payback $result', var_export($result, true));

		if(/*$_SERVER['REMOTE_ADDR'] == '194.116.253.174' &&*/ isset($_GET['debug'])) {
			print_r($result);
			echo htmlspecialchars($process->getLastRequest());
		}

		if(empty($fault_code)) {

			$punti_payback = 0;

			$transactions = $result->getTransactions();

			foreach($transactions as $transaction) {

				$total_points = $transaction->getTotalPoints();
				$punti_payback += $total_points->getLoyaltyAmount();

			}

			//update_field('punti_payback', $punti_payback, $order_id);

			return [
				'total_points' => $total_points,
				'punti_payback' => $punti_payback
			];

		} else {
			return false;
		}
	}

	public function process_offline_purchase($item) { // TODO: allineare con modifiche fatte in calculate_check_digit()

		if(!$this->active) {
			return array(
				'error' => 'La contabilizzazione Payback non è attiva'
			);
		}

		$this->set_point_limits(strtotime($item['data']));

		if(!$this->process_punti) {
			return array(
				'error' => 'Non esiste un periodo di attribuzione punti valido nella configurazione Payback'
			);
		}

		//Genereazione numero payback 16 cifre
		$card_number = $item['carta_fedelta'];

		if(strlen($card_number) == 16) {
			$card_number = substr($card_number, 0, 15);
		} elseif(strlen($card_number) == 13 || strlen($card_number) == 12) {
			$card_number = substr($card_number, 3, 9);
			$card_number = $this->card_number_prefix.$card_number;
		} elseif(strlen($card_number) == 10) {
			$card_number = substr($card_number, 0, 9);
			$card_number = $this->card_number_prefix.$card_number;
		} else {
			//No processing if wrong card number length
			return array(
				'error' => 'Lunghezza di numero di carta payback non valida'
			);
		}

		$card_number_check_digit = $this->calculate_check_digit($card_number);
		$card_number_16 = $card_number.$card_number_check_digit;

		$purchaseItemDetails = array();
		$transactions = array();

		if($item['prezzo'] >= $this->punti['soglia_intero']) {
			$pointsAmount = $this->punti['punti_intero'];
		} else {
			$pointsAmount = $this->punti['punti_ridotto'];
		}

		$prezzo_formatted = number_format($item['prezzo'], 3, '.', '');

		$purchaseItemDetails[] = new \StructType\PurchaseItemDetails(
			$pointsAmount,
			($item['prezzo'] >= $this->punti['soglia_intero']) ? 'int' : 'rid',
			($item['prezzo'] >= $this->punti['soglia_intero']) ? 'Intero' : 'Ridotto',
			null,
			null,
			null,
			null,
			null,
			null,
			null,
			null,
			null,
			null,
			$prezzo_formatted,
			1,
			null,
			$prezzo_formatted,
			$prezzo_formatted
		);

		//Base transaction
		$totalPoints = new \StructType\LoyaltyUnitType(number_format($pointsAmount, 3, '.', ''));

		$transaction = new \StructType\TransactionDetails(
			\EnumType\TransactionTypeType::VALUE_100,
			null,
			$totalPoints,
			null,
			array(),
			null
		);

		$transactions[] = $transaction;

		$identification = new \StructType\MemberIdentificationType($card_number_16, "1");
		$authentication = new \StructType\MemberAliasIdentificationType($identification);

		$partnerShortName = $this->options[\WsdlToPhp\PackageBase\AbstractSoapClientBase::WSDL_LOGIN];

		$partner = new \StructType\PartnerContextType($partnerShortName);

		$effectiveDate = substr_replace(date('c', strtotime($item['data'])), substr(microtime(), 1, 8), 19, 0);;

		$communicationChannel = "4";

		$collectEventData = new \StructType\CollectEventType($partner, $effectiveDate, (string)$item['order_id'], $communicationChannel);
		$purchaseEventType = "1";
		$rewardableLegalValue = new \StructType\LegalUnitType($prezzo_formatted);
		$totalPurchaseLegalValue = new \StructType\LegalUnitType($prezzo_formatted);
		$paymentType = null;
		$couponCodes = array();

		$process_request = new \StructType\ProcessPurchaseEventRequest(
			$authentication,
			$collectEventData,
			$purchaseEventType,
			$rewardableLegalValue,
			$totalPurchaseLegalValue,
			$paymentType,
			$couponCodes,
			$purchaseItemDetails,
			$transactions
		);

		$principal = $partnerShortName;
		$credential = $this->options[\WsdlToPhp\PackageBase\AbstractSoapClientBase::WSDL_PASSWORD];

		$consumerAuthentication = new \StructType\ConsumerAuthenticationType($principal, $credential);
		$partner2 = new \StructType\PartnerContextType($partnerShortName);

		$consumerIdentification = new \StructType\ConsumerIdentificationType(
			$consumerAuthentication,
			$partner2,
			null,
			null,
			"1"
		);

		$process_request->setConsumerIdentification($consumerIdentification);

		$process = new \ServiceType\Process($this->options);

        error_log("PAYBACK | PROCESS: " . print_r($process, true));
        error_log("PAYBACK | PROCESS REQUEST: " . print_r($process_request, true));

		if ($process->ProcessPurchaseEvent($process_request) !== false) {
			$result = $process->getResult();

            error_log("PAYBACK | PURCHASE SUCCESS: " . print_r($result, true));
		} else {
			$result = $process->getLastError();

            error_log("PAYBACK | PURCHASE ERROR: " . print_r($result, true));
		}

		$fault_message = $result->getFaultMessage();

		if(!empty($fault_message)) {

            error_log("PAYBACK | FAULT MESSAGE: " . print_r($fault_message, true));

            $fault_message_text = $fault_message->getMessage();

            error_log("PAYBACK | FAULT MESSAGE TEXT: " . print_r($fault_message_text, true));

			return array(
				'error' => $fault_message_text
			);

		} else {

			$punti_payback = 0;

			$transactions = $result->getTransactions();

			foreach($transactions as $transaction) {
				$total_points = $transaction->getTotalPoints();

                error_log("PAYBACK | PUNTI TRANSAZIONE: ".print_r($punti_payback, true));

                $total_points_loyaltyamount = $total_points->getLoyaltyAmount();
				$punti_payback += $total_points_loyaltyamount;

                error_log("PAYBACK | PUNTI TRANSAZIONE (loyalty amount): " . print_r($punti_payback, true));
			}

            error_log("PAYBACK | SALDO PUNTI: " . $punti_payback);

			return array(
				'punti' => $punti_payback
			);

		}

	}

}
