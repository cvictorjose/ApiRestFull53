@extends('pdf.app')
@section('content')
<body>

<?php
use App\Product;
use App\OrderElement;
$order_elements=array();
//$result = json_decode($result, true);

$code_transaction="";
$transaction="";
$datapagamento ="";

foreach ($result as $key => $value) {
    $firstname      = $value["name"];
    $surname        = $value["surname"];
    $email          = $value["email"];
    $phone          = $value["phone"];
    $address        = $value["address"];
    $postal_code    = $value["postal_code"];
    $city           = $value["city"];
    $region         = $value["region"];
    $country        = $value["country"];
    $company        = $value["company"];
    $company_vat    = $value["company_vat"];
    $method         = $value["method"];
    $total          = $value["total"];
    $order_id       = $value["order_id"];
    // $datapagamento  = $value["datapagamento"];
    // $transaction    = $value["transaction"];
    // $code_transaction = $value["code_transaction"];


    // return  Product::find(2)->first()->service->vat_rate;
    $p = Product::where('id', $value["product_id"])->firstOrFail();
    $order_elements[]    = array(
        'title'=> $value["OrderElementTitle"],
        'price'=> $value["price"],
        'quantity'=> $value["quantity"],
        'vat_rate'=> $p->getIva(),
    );
}//endForEach
?>

<div class="table" style="padding-top:50px;">
    <div class="table-row">
        <div class="table-cell left">
            <div class="table border">
                <div class="table-row "  style="padding-top:50px;">
                    <div class="table-cell"><b  class="title"> ID dell'ordine #</b> {{$barcode}}</div>
                </div>

                <div class="table-row "  style="padding-top:50px;">
                    <div class="table-cell"><b  class="title">Fattura #</b> {{$invoice}}</div>
                </div>

                {{--<div class="table-row">
                    <div class="table-cell"><b  class="title">Metodo di pagamento:</b>{{$method}}</div>
                </div>--}}

                {{--<div class="table-row">
                    <div class="table-cell"><b  class="title">Transaction #</b>{{$transaction}}</div>
                </div>--}}

                <div class="table-row">
                    <div class="table-cell"><b  class="title">Emissione: </b>{{$date}}</div>
                </div>
            </div>
        </div>

        <div class="table-cell right">
            <b>Gentile</b><br/>
            <?php
            if (!empty($company)){
                echo $company."<br />";
                echo $pi="P.IVA:". $company_vat."<br />";

            }else{
                echo $firstname." ".$surname."<br />";
            }
            echo  $address."<br />";
           // $address.",". $postal_code.",".$city.",". $region.",". $country."<br />";
            ?>
            Email {{$email}}<br />Telefono {{$phone}}
        </div>
    </div>
</div>

<div class="table border" style="padding-top:50px;">
    <div class="table-row">
        <div class="table-cell bottom" style="width:50%;">Articolo</div>
        <div class="table-cell bottom" style="width:10%;">Quantit&aacute;</div>
        <div class="table-cell bottom" style="width:10%;">% IVA</div>
        <div class="table-cell bottom" style="width:10%;">IVA</div>
        <div class="table-cell bottom" style="width:10%;">Imponibile</div>
        <div class="table-cell bottom" style="width:10%;">Importo</div>
    </div>
    
    <?php
    $totale=0;
    $products=array();
    foreach ($order_elements as $key => $value) {
        $vat_rate       = $value['vat_rate']->vat_rate;
        $price          = $value['price'];
        $totale+=$price;
        $product_id     =$value['vat_rate']->product_id;

        if (!in_array($product_id, $products)) {
            $p = (new OrderElement())->getPriceQuantity($order_id, $product_id);
            array_push($products, $product_id);
            $total_tickets= $p->total_sales;
            $importo_iva    = floatval($total_tickets*($vat_rate/100));
            $imponibile     = $total_tickets - $importo_iva;
            ?>
                <div class="table-row">
                    <div class="table-cell">{{$value['vat_rate']->title}}</div>
                    <div class="table-cell">{{$p->total_qta}}</div>
                    <div class="table-cell">{{$vat_rate}}%</div>
                    <div class="table-cell">{{number_format($importo_iva, 2, ',', '')}}</div>
                    <div class="table-cell">{{number_format($imponibile, 2, ',', '')}}</div>
                    <div class="table-cell">{{number_format($total_tickets, 2, ',', '')}}</div>
                </div>

            <?php
            if ($vat_rate==4){
                if (empty($imponibile_4)){$imponibile_4=$imponibile;}else{$imponibile_4+=$imponibile;}
                if (empty($price_4)){$price_4=$total_tickets;}else{$price_4+=$total_tickets;}
                if (empty($importo_iva_4)){$importo_iva_4=$importo_iva;}else{$importo_iva_4+=$importo_iva;}

                $iva_4= array(
                'imponibile'=> $imponibile,
                'aliquota'=> $importo_iva,
                'importo'=> $price_4);

            }elseif ($vat_rate==10){
                if (empty($imponibile_10)){$imponibile_10=$imponibile;}else{$imponibile_10+=$imponibile;}
                if (empty($price_10)){$price_10=$total_tickets;}else{$price_10+=$total_tickets;}
                if (empty($importo_iva_10)){$importo_iva_10=$importo_iva;}else{$importo_iva_10+=$importo_iva;}

                $iva_10 = array(
                'imponibile'=> $imponibile_10,
                'aliquota'=> $importo_iva_10,
                'importo'=> $price_10);
            }else{
                if (empty($imponibile_22)){$imponibile_22=$imponibile;}else{$imponibile_22+=$imponibile;}
                if (empty($price_22)){$price_22=$total_tickets;}else{$price_22+=$total_tickets;}
                if (empty($importo_iva_22)){$importo_iva_22=$importo_iva;}else{$importo_iva_22+=$importo_iva;}

                $iva_22 = array(
                'imponibile'=> $imponibile,
                'aliquota'=> $importo_iva,
                'importo'=> $price_22);
            }
         }//endIF
    }//endForEach
 ?>
</div>{{--endTableProducts--}}

<div class="table border" style="padding-top:30px;">
    <div class="table-row" align="center">
        <div class="table-cell bottom" style="width:52%;">Descrizione IVA</div>
        <div class="table-cell bottom" style="width:12%;">% IVA</div>
        <div class="table-cell bottom" style="width:12%;">IVA</div>
        <div class="table-cell bottom" style="width:12%;">Imponibile</div>
        <div class="table-cell bottom" style="width:12%;">Importo</div>
    </div>

    <?php
    $html="";

    if(!empty($iva_4)){
        $aliquota_4    = $iva_4['aliquota'];
        $imponibile_4  = $iva_4['imponibile'];
        $importo_4     = $iva_4['importo'];

        $html.='<div class="table-row" align="center">
                    <div class="table-cell">IVA 4</div>
                    <div class="table-cell">4%</div>
                    <div class="table-cell">'.number_format($aliquota_4, 2, ',', '').'</div>
                    <div class="table-cell">'.number_format($imponibile_4, 2, ',', '').'</div>
                    <div class="table-cell">'.number_format($importo_4, 2, ',', '').'</div>
                </div>';
    }else{
        $aliquota_4=0; $imponibile_4=0; $importo_4=0;
    }


    if(!empty($iva_10)){
        $aliquota_10    = $iva_10['aliquota'];
        $imponibile_10  = $iva_10['imponibile'];
        $importo_10     = $iva_10['importo'];

        $html.='<div class="table-row" align="center">
                    <div class="table-cell">IVA 10</div>
                    <div class="table-cell">10%</div>
                    <div class="table-cell">'.number_format($aliquota_10, 2, ',', '').'</div>
                    <div class="table-cell">'.number_format($imponibile_10, 2, ',', '').'</div>
                    <div class="table-cell">'.number_format($importo_10, 2, ',', '').'</div>
                </div>';
    }else{
        $aliquota_10=0; $imponibile_10=0; $importo_10=0;
    }


    if(!empty($iva_22)){
        $aliquota_22    = $iva_22['aliquota'];
        $imponibile_22  = $iva_22['imponibile'];
        $importo_22     = $iva_22['importo'];

        $html.='<div class="table-row" align="center">
                    <div class="table-cell">IVA 22</div>
                    <div class="table-cell">22%</div>
                    <div class="table-cell">'.number_format($aliquota_22, 2, ',', '').'</div>
                    <div class="table-cell">'.number_format($imponibile_22, 2, ',', '').'</div>
                    <div class="table-cell">'.number_format($importo_22, 2, ',', '').'</div>
                </div>';
    }else{
        $aliquota_22=0; $imponibile_22=0; $importo_22=0;
    }

    $total_imponibile   = number_format(($imponibile_10 + $imponibile_4 + $imponibile_22), 2, ',', '');
    $total_aliquota     = number_format(($aliquota_4 + $aliquota_10 + $aliquota_22), 2, ',', '');
    $total_importo      = number_format(($importo_4 + $importo_10 + $importo_22), 2, ',', '');



    echo $html; //Print Table 4,10,22
    ?>
    <div class="table-row" align="center">
        <div class="table-cell bordertop">TOTALE &euro;</div>
        <div class="table-cell bordertop"></div>
        <div class="table-cell bordertop">{{$total_aliquota}}</div>
        <div class="table-cell bordertop">{{$total_imponibile}}</div>
        <div class="table-cell bordertop">{{$total_importo}}</div>
    </div>
</div>{{--endTableTotale--}}
@endsection



