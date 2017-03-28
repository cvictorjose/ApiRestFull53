@extends('pdf.app')
@section('content')
<body>

<?php
use App\OrderElement;
use App\Product;
$order_elements=array();

$result = json_decode($result, true);
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
    $total          = $value["total"];
    $order_id       = $value["order_id"];
    $code_transaction    = $value["code_transaction"];

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
                    <div class="table-cell"><b  class="title"> ID dell'ordine #</b> {{$bar_code}}</div>
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
        <div class="table-cell bottom" style="width:10%;">Importo</div>
    </div>
    
    <?php
    $totale=0;
    $products=array();
    foreach ($order_elements as $key => $value) {
        $vat_rate       = $value['vat_rate']->vat_rate;
        $price          = $value['price'];
        $importo_iva    = floatval($price*($vat_rate/100));
        $imponibile     = $price - $importo_iva;
        $totale+=$price;
        $product_id=$value['vat_rate']->product_id;

        if (!in_array($product_id, $products)) {
            $p = (new OrderElement())->getPriceQuantity($order_id, $product_id);
            array_push($products, $product_id);
            $total_tickets= number_format($p->total_sales, 2, ',', '');
            ?>
            <div class="table-row">
                <div class="table-cell">{{$value['vat_rate']->title}}</div>
                <div class="table-cell">{{$p->total_qta}}</div>
                <div class="table-cell">{{$total_tickets}}</div>
            </div>

            <?php
        }//endIF
    }//endForEach
    $totale= number_format($totale, 2, ',', '');
  ?>
    <div class="table-row">
        <div class="table-cell bordertop"></div>
        <div class="table-cell bordertop">TOTALE &euro;</div>
        <div class="table-cell bordertop">{{$totale}}</div>
    </div>
</div>{{--endTableProducts--}}
@endsection



