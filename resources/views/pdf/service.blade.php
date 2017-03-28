@extends('pdf.app')
@section('content')
<body>

<?php
use App\Product;
use App\TicketSale;
use App\OrderElement;
?>

<div class="table" style="padding-top:50px;">
    <div class="table-row">
        <div class="table-cell left">
            <div class="table border">
                <div class="table-row "  style="padding-top:50px;">
                    <div class="table-cell"><b  class="title"> ID dell'ordine #</b> {{$barcode}}</div>
                </div>
                <div class="table-row ">
                    <div class="table-cell">{!!  DNS1D::getBarcodeHTML($barcode, "C128",2,53) !!}</div>
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
                echo $fullname."<br />";
            }
            echo  $address."<br />";
            // $address.",". $postal_code.",".$city.",". $region.",". $country."<br />";
            ?>
            Email {{$email}}<br />Telefono {{$phone}}
        </div>
    </div>
</div>

<?php if(count($hotel_orders)>0): ?>
<div class="table" style="padding-top:30px;">
    <div class="table-row ">
        <div class="table-cell">Gentile {{$fullname}} hai acquistato camere in promozione Parco+Hotel
            dal <?php $date_ts = strtotime($date); echo date('d/m/Y', $date_ts); ?> al <?php echo date('d/m/Y', ($date_ts+86400)); ?>: 
            <ul>
            <?php
                foreach((array) $hotel_orders as $hok => $hov){
                    printf('<li>%s %s presso %s (%s)</li>', $hov->rooms, $hov->room_type, $hov->hotel, $hov->hotel_address);
                }
            ?>
            </ul>
        </div>
    </div>
</div>
<?php endif; ?>

<div class="table" style="padding-top:30px;">
    <div class="table-row ">
        <div class="table-cell">Gentile {{$fullname}} ecco i servizi accessori che hai acquistato
            per il giorno {{$date}}:</div>
    </div>
</div>


<div class="table border" style="padding-top:20px;">
    <div class="table-row">
        <div class="table-cell bottom" style="width:20%;">Articolo</div>
        <div class="table-cell bottom" style="width:45%;">Descrizione</div>
        <div class="table-cell bottom" style="width:10%;">Quantit&aacute;</div>
        <div class="table-cell bottom" style="width:10%; ">Importo</div>
    </div>
    
    <?php
    $totale=0;

    $list_id_service = array();
    $products=array();
     if($order_elements>0){
        foreach ($order_elements as $key => $value) {
            $price= number_format($value['price'], 2, ',', '');
            $totale+=$price;

            array_push($list_id_service,$value['vat_rate']->id);
            $product_id=$value['vat_rate']->product_id;

            $product_description=$value['vat_rate']->description;

            //Controllo Navetta, Se trova Partenza da cambia il suo contenuto
            if (preg_match('/Partenza da Roma Termini/',$product_description))$product_description="Navetta da Roma Termini (vedi
            dettagli e orari sul sito)";

            if (!in_array($product_id, $products)) {
                $p = (new OrderElement())->getPriceQuantity($order_id, $product_id);
                array_push($products, $product_id);
                $total_tickets= number_format($p->total_sales, 2, ',', '');
                ?>
                <div class="table-row">
                    <div class="table-cell">{{$value['vat_rate']->title}}</div>
                    <div class="table-cell">{{$product_description}}</div>
                    <div class="table-cell"  style="text-align: center;">{{$p->total_qta}}</div>
                    <div class="table-cell">{{$total_tickets}}</div>
                </div>
            <?php
            }//endIF
        }//endForEach
    }


    $totale_percorso=0;
    $list_id_percorso = array();
    $percorsi=array();

    if($order_percorsi>0){
        foreach ($order_percorsi as $key => $value) {
            $price= number_format($value['price'], 2, ',', '');
            $totale_percorso+=$price;

            array_push($list_id_percorso,$value['vat_rate']->id);
            $product_id=$value['vat_rate']->product_id;

            if (!in_array($product_id, $percorsi)) {
                $p = (new OrderElement())->getPriceQuantity($order_id, $product_id);
                array_push($percorsi, $product_id);
                $total_tickets_p= number_format($p->total_sales, 2, ',', '');
                ?>
                <div class="table-row">
                    <div class="table-cell">{{$value['vat_rate']->title}}</div>
                    <div class="table-cell">{{$value['vat_rate']->description}}</div>
                    <div class="table-cell"  style="text-align: center;">{{$p->total_qta}}</div>
                    <div class="table-cell">{{$total_tickets_p}}</div>
                </div>
            <?php
            }//endIF
        }//endForEach
    }
    $totale= $totale+$totale_percorso;
    $totale= number_format($totale, 2, ',', '');
  ?>
    <div class="table-row">
        <div class="table-cell bordertop"></div>
        <div class="table-cell bordertop"></div>
        <div class="table-cell bordertop">TOTALE &euro;</div>
        <div class="table-cell bordertop">{{$totale}}</div>
    </div>
</div>{{--endTableProducts--}}



<div class="table" style="padding-top:30px;">
    <div class="table-row ">
        <div class="table-cell">Vivi al meglio la tua giornata a Cinecitt&aacute; World, di seguito troverai i nostri
            servizi che puoi acquistare in qualsiasi momento.
        </div>
    </div>

    <div class="table-row">
        <div class="table-cell">
            <ul>
                <?php
                // FIXME: we need to find a way to specify a default ticketsale
                $ticketsale     = TicketSale::find(1);
                $servicegroup   = $ticketsale->defaultServiceGroup();
                $services       = $servicegroup->services->sortBy('service_category_id');
                $services_array = array();
                foreach($services as $service){
                    $id = $service->id;
                    if (!in_array($id, $list_id_service)) {
                        echo "<li>
                        ".$service->title." - ".$service->description." -Prezzo:".$service->price."&euro;</li>";
                    }
                }
                ?>
            </ul>
        </div>
    </div>
</div>
@endsection



