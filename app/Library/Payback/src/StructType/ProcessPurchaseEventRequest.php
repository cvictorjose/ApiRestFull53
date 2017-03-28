<?php

namespace StructType;

use \WsdlToPhp\PackageBase\AbstractStructBase;

/**
 * This class stands for ProcessPurchaseEventRequest StructType
 * Meta informations extracted from the WSDL
 * - documentation: INTF#038: Collect points with a purchase or retro-credit. Provide information on the purchase or retro and optionally provide basket information and/or rated transactions which include the points issued for the purchase. The business
 * process executes plausibility checks on each event.
 * @subpackage Structs
 */
class ProcessPurchaseEventRequest extends AuthorisedRequest
{
    /**
     * The Authentication
     * Meta informations extracted from the WSDL
     * - documentation: Data used to identify and authenticate the member.
     * @var \StructType\MemberAliasIdentificationType
     */
    public $Authentication;
    /**
     * The CollectEventData
     * Meta informations extracted from the WSDL
     * - documentation: General Data for collect events
     * @var \StructType\CollectEventType
     */
    public $CollectEventData;
    /**
     * The PurchaseEventType
     * Meta informations extracted from the WSDL
     * - documentation: Type of the purchase event: 1 - Purchase; 2 - RetroCredit
     * @var string
     */
    public $PurchaseEventType;
    /**
     * The RewardableLegalValue
     * Meta informations extracted from the WSDL
     * - documentation: Monetary value of the purchase that is rewarded
     * - minOccurs: 0
     * @var \StructType\LegalUnitType
     */
    public $RewardableLegalValue;
    /**
     * The TotalPurchaseLegalValue
     * Meta informations extracted from the WSDL
     * - documentation: Monetary value of the total purchase including items that are not rewardable
     * - minOccurs: 0
     * @var \StructType\LegalUnitType
     */
    public $TotalPurchaseLegalValue;
    /**
     * The PaymentType
     * Meta informations extracted from the WSDL
     * - documentation: Payment type of purchase:1 - Cash2 - Credit Card3 - Debit Card4 - Voucher5 - Fleet Card6 - Cheque7 - Loyalty Currency8 - Collect on Delivery9 - Online Payment10 - Food Stamp / EBT99 - Others
     * - minOccurs: 0
     * @var string
     */
    public $PaymentType;
    /**
     * The CouponCodes
     * Meta informations extracted from the WSDL
     * - documentation: Optional list of coupon codes (e.g barcode printed on coupon)that represent coupons which were captured during customer's purchase event.
     * - maxOccurs: unbounded
     * - minOccurs: 0
     * - maxLength: 255
     * - minLength: 1
     * @var string[]
     */
    public $CouponCodes;
    /**
     * The PurchaseItemDetails
     * Meta informations extracted from the WSDL
     * - documentation: Optional shopping basket; this list needs to contain at least one item in case PB does the base and promotion rating.
     * - maxOccurs: unbounded
     * - minOccurs: 0
     * @var \StructType\PurchaseItemDetails[]
     */
    public $PurchaseItemDetails;
    /**
     * The Transactions
     * Meta informations extracted from the WSDL
     * - documentation: Optional rated transactions for the eventUse cases:1) no transaction element at all: PB does the base and promotion rating2) one base transaction: PB does the promotion rating only3) one base transaction and one promotion
     * transaction: PB does the promotion rating only (check for any additional offers)
     * - maxOccurs: unbounded
     * - minOccurs: 0
     * @var \StructType\TransactionDetails[]
     */
    public $Transactions;
    /**
     * Constructor method for ProcessPurchaseEventRequest
     * @uses ProcessPurchaseEventRequest::setAuthentication()
     * @uses ProcessPurchaseEventRequest::setCollectEventData()
     * @uses ProcessPurchaseEventRequest::setPurchaseEventType()
     * @uses ProcessPurchaseEventRequest::setRewardableLegalValue()
     * @uses ProcessPurchaseEventRequest::setTotalPurchaseLegalValue()
     * @uses ProcessPurchaseEventRequest::setPaymentType()
     * @uses ProcessPurchaseEventRequest::setCouponCodes()
     * @uses ProcessPurchaseEventRequest::setPurchaseItemDetails()
     * @uses ProcessPurchaseEventRequest::setTransactions()
     * @param \StructType\MemberAliasIdentificationType $authentication
     * @param \StructType\CollectEventType $collectEventData
     * @param string $purchaseEventType
     * @param \StructType\LegalUnitType $rewardableLegalValue
     * @param \StructType\LegalUnitType $totalPurchaseLegalValue
     * @param string $paymentType
     * @param string[] $couponCodes
     * @param \StructType\PurchaseItemDetails[] $purchaseItemDetails
     * @param \StructType\TransactionDetails[] $transactions
     */
    public function __construct(\StructType\MemberAliasIdentificationType $authentication = null, \StructType\CollectEventType $collectEventData = null, $purchaseEventType = null, \StructType\LegalUnitType $rewardableLegalValue = null, \StructType\LegalUnitType $totalPurchaseLegalValue = null, $paymentType = null, array $couponCodes = array(), array $purchaseItemDetails = array(), array $transactions = array())
    {
        $this
            ->setAuthentication($authentication)
            ->setCollectEventData($collectEventData)
            ->setPurchaseEventType($purchaseEventType)
            ->setRewardableLegalValue($rewardableLegalValue)
            ->setTotalPurchaseLegalValue($totalPurchaseLegalValue)
            ->setPaymentType($paymentType)
            ->setCouponCodes($couponCodes)
            ->setPurchaseItemDetails($purchaseItemDetails)
            ->setTransactions($transactions);
    }
    /**
     * Get Authentication value
     * @return \StructType\MemberAliasIdentificationType|null
     */
    public function getAuthentication()
    {
        return $this->Authentication;
    }
    /**
     * Set Authentication value
     * @param \StructType\MemberAliasIdentificationType $authentication
     * @return \StructType\ProcessPurchaseEventRequest
     */
    public function setAuthentication(\StructType\MemberAliasIdentificationType $authentication = null)
    {
        $this->Authentication = $authentication;
        return $this;
    }
    /**
     * Get CollectEventData value
     * @return \StructType\CollectEventType|null
     */
    public function getCollectEventData()
    {
        return $this->CollectEventData;
    }
    /**
     * Set CollectEventData value
     * @param \StructType\CollectEventType $collectEventData
     * @return \StructType\ProcessPurchaseEventRequest
     */
    public function setCollectEventData(\StructType\CollectEventType $collectEventData = null)
    {
        $this->CollectEventData = $collectEventData;
        return $this;
    }
    /**
     * Get PurchaseEventType value
     * @return string|null
     */
    public function getPurchaseEventType()
    {
        return $this->PurchaseEventType;
    }
    /**
     * Set PurchaseEventType value
     * @uses \EnumType\PurchaseEventTypeType::valueIsValid()
     * @uses \EnumType\PurchaseEventTypeType::getValidValues()
     * @throws \InvalidArgumentException
     * @param string $purchaseEventType
     * @return \StructType\ProcessPurchaseEventRequest
     */
    public function setPurchaseEventType($purchaseEventType = null)
    {
        // validation for constraint: enumeration
        if (!\EnumType\PurchaseEventTypeType::valueIsValid($purchaseEventType)) {
            throw new \InvalidArgumentException(sprintf('Value "%s" is invalid, please use one of: %s', $purchaseEventType, implode(', ', \EnumType\PurchaseEventTypeType::getValidValues())), __LINE__);
        }
        $this->PurchaseEventType = $purchaseEventType;
        return $this;
    }
    /**
     * Get RewardableLegalValue value
     * @return \StructType\LegalUnitType|null
     */
    public function getRewardableLegalValue()
    {
        return $this->RewardableLegalValue;
    }
    /**
     * Set RewardableLegalValue value
     * @param \StructType\LegalUnitType $rewardableLegalValue
     * @return \StructType\ProcessPurchaseEventRequest
     */
    public function setRewardableLegalValue(\StructType\LegalUnitType $rewardableLegalValue = null)
    {
        $this->RewardableLegalValue = $rewardableLegalValue;
        return $this;
    }
    /**
     * Get TotalPurchaseLegalValue value
     * @return \StructType\LegalUnitType|null
     */
    public function getTotalPurchaseLegalValue()
    {
        return $this->TotalPurchaseLegalValue;
    }
    /**
     * Set TotalPurchaseLegalValue value
     * @param \StructType\LegalUnitType $totalPurchaseLegalValue
     * @return \StructType\ProcessPurchaseEventRequest
     */
    public function setTotalPurchaseLegalValue(\StructType\LegalUnitType $totalPurchaseLegalValue = null)
    {
        $this->TotalPurchaseLegalValue = $totalPurchaseLegalValue;
        return $this;
    }
    /**
     * Get PaymentType value
     * @return string|null
     */
    public function getPaymentType()
    {
        return $this->PaymentType;
    }
    /**
     * Set PaymentType value
     * @uses \EnumType\PaymentTypeType::valueIsValid()
     * @uses \EnumType\PaymentTypeType::getValidValues()
     * @throws \InvalidArgumentException
     * @param string $paymentType
     * @return \StructType\ProcessPurchaseEventRequest
     */
    public function setPaymentType($paymentType = null)
    {
        // validation for constraint: enumeration
        if (!\EnumType\PaymentTypeType::valueIsValid($paymentType)) {
            throw new \InvalidArgumentException(sprintf('Value "%s" is invalid, please use one of: %s', $paymentType, implode(', ', \EnumType\PaymentTypeType::getValidValues())), __LINE__);
        }
        $this->PaymentType = $paymentType;
        return $this;
    }
    /**
     * Get CouponCodes value
     * @return string[]|null
     */
    public function getCouponCodes()
    {
        return $this->CouponCodes;
    }
    /**
     * Set CouponCodes value
     * @throws \InvalidArgumentException
     * @param string[] $couponCodes
     * @return \StructType\ProcessPurchaseEventRequest
     */
    public function setCouponCodes(array $couponCodes = array())
    {
        // validation for constraint: maxLength
        if ((is_scalar($couponCodes) && strlen($couponCodes) > 255) || (is_array($couponCodes) && count($couponCodes) > 255)) {
            throw new \InvalidArgumentException(sprintf('Invalid length, please provide an array with 255 element(s) or a scalar of 255 character(s) at most, "%d" length given', is_scalar($couponCodes) ? strlen($couponCodes) : count($couponCodes)), __LINE__);
        }
        // validation for constraint: minLength
        //if ((is_scalar($couponCodes) && strlen($couponCodes) < 1) || (is_array($couponCodes) && count($couponCodes) < 1)) {
        if (!is_scalar($couponCodes) && !is_array($couponCodes)) {
            throw new \InvalidArgumentException('Invalid length, please provide an array or a scalar', __LINE__);
        }
        foreach ($couponCodes as $processPurchaseEventRequestCouponCodesItem) {
            // validation for constraint: itemType
            if (!is_string($processPurchaseEventRequestCouponCodesItem)) {
                throw new \InvalidArgumentException(sprintf('The CouponCodes property can only contain items of string, "%s" given', is_object($processPurchaseEventRequestCouponCodesItem) ? get_class($processPurchaseEventRequestCouponCodesItem) : gettype($processPurchaseEventRequestCouponCodesItem)), __LINE__);
            }
        }
        $this->CouponCodes = $couponCodes;
        return $this;
    }
    /**
     * Add item to CouponCodes value
     * @throws \InvalidArgumentException
     * @param string $item
     * @return \StructType\ProcessPurchaseEventRequest
     */
    public function addToCouponCodes($item)
    {
        // validation for constraint: maxLength
        if ((is_scalar($item) && strlen($item) > 255) || (is_array($item) && count($item) > 255)) {
            throw new \InvalidArgumentException(sprintf('Invalid length, please provide an array with 255 element(s) or a scalar of 255 character(s) at most, "%d" length given', is_scalar($item) ? strlen($item) : count($item)), __LINE__);
        }
        // validation for constraint: minLength
        if ((is_scalar($item) && strlen($item) < 1) || (is_array($item) && count($item) < 1)) {
            throw new \InvalidArgumentException('Invalid length, please provide an array with 1 element(s) or a scalar of 1 character(s) at least', __LINE__);
        }
        // validation for constraint: itemType
        if (!is_string($item)) {
            throw new \InvalidArgumentException(sprintf('The CouponCodes property can only contain items of string, "%s" given', is_object($item) ? get_class($item) : gettype($item)), __LINE__);
        }
        $this->CouponCodes[] = $item;
        return $this;
    }
    /**
     * Get PurchaseItemDetails value
     * @return \StructType\PurchaseItemDetails[]|null
     */
    public function getPurchaseItemDetails()
    {
        return $this->PurchaseItemDetails;
    }
    /**
     * Set PurchaseItemDetails value
     * @throws \InvalidArgumentException
     * @param \StructType\PurchaseItemDetails[] $purchaseItemDetails
     * @return \StructType\ProcessPurchaseEventRequest
     */
    public function setPurchaseItemDetails(array $purchaseItemDetails = array())
    {
        foreach ($purchaseItemDetails as $processPurchaseEventRequestPurchaseItemDetailsItem) {
            // validation for constraint: itemType
            if (!$processPurchaseEventRequestPurchaseItemDetailsItem instanceof \StructType\PurchaseItemDetails) {
                throw new \InvalidArgumentException(sprintf('The PurchaseItemDetails property can only contain items of \StructType\PurchaseItemDetails, "%s" given', is_object($processPurchaseEventRequestPurchaseItemDetailsItem) ? get_class($processPurchaseEventRequestPurchaseItemDetailsItem) : gettype($processPurchaseEventRequestPurchaseItemDetailsItem)), __LINE__);
            }
        }
        $this->PurchaseItemDetails = $purchaseItemDetails;
        return $this;
    }
    /**
     * Add item to PurchaseItemDetails value
     * @throws \InvalidArgumentException
     * @param \StructType\PurchaseItemDetails $item
     * @return \StructType\ProcessPurchaseEventRequest
     */
    public function addToPurchaseItemDetails(\StructType\PurchaseItemDetails $item)
    {
        // validation for constraint: itemType
        if (!$item instanceof \StructType\PurchaseItemDetails) {
            throw new \InvalidArgumentException(sprintf('The PurchaseItemDetails property can only contain items of \StructType\PurchaseItemDetails, "%s" given', is_object($item) ? get_class($item) : gettype($item)), __LINE__);
        }
        $this->PurchaseItemDetails[] = $item;
        return $this;
    }
    /**
     * Get Transactions value
     * @return \StructType\TransactionDetails[]|null
     */
    public function getTransactions()
    {
        return $this->Transactions;
    }
    /**
     * Set Transactions value
     * @throws \InvalidArgumentException
     * @param \StructType\TransactionDetails[] $transactions
     * @return \StructType\ProcessPurchaseEventRequest
     */
    public function setTransactions(array $transactions = array())
    {
        foreach ($transactions as $processPurchaseEventRequestTransactionsItem) {
            // validation for constraint: itemType
            if (!$processPurchaseEventRequestTransactionsItem instanceof \StructType\TransactionDetails) {
                throw new \InvalidArgumentException(sprintf('The Transactions property can only contain items of \StructType\TransactionDetails, "%s" given', is_object($processPurchaseEventRequestTransactionsItem) ? get_class($processPurchaseEventRequestTransactionsItem) : gettype($processPurchaseEventRequestTransactionsItem)), __LINE__);
            }
        }
        $this->Transactions = $transactions;
        return $this;
    }
    /**
     * Add item to Transactions value
     * @throws \InvalidArgumentException
     * @param \StructType\TransactionDetails $item
     * @return \StructType\ProcessPurchaseEventRequest
     */
    public function addToTransactions(\StructType\TransactionDetails $item)
    {
        // validation for constraint: itemType
        if (!$item instanceof \StructType\TransactionDetails) {
            throw new \InvalidArgumentException(sprintf('The Transactions property can only contain items of \StructType\TransactionDetails, "%s" given', is_object($item) ? get_class($item) : gettype($item)), __LINE__);
        }
        $this->Transactions[] = $item;
        return $this;
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see AbstractStructBase::__set_state()
     * @uses AbstractStructBase::__set_state()
     * @param array $array the exported values
     * @return \StructType\ProcessPurchaseEventRequest
     */
    public static function __set_state(array $array)
    {
        return parent::__set_state($array);
    }
    /**
     * Method returning the class name
     * @return string __CLASS__
     */
    public function __toString()
    {
        return __CLASS__;
    }
}
