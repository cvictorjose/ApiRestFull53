@extends('pdf.app')
@section('content')
<body>

<?php
use App\Identity;
use App\Order;
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
            <?php
                $order = Order::find($order_id);
                $identity = Identity::find($order->identity_id);
            ?>
            <b>Gentile</b><br/>
            <?php
            if (!empty($identity->company)){
                echo $identity->company."<br />";
                echo "P.IVA:". $identity->company_vat."<br />";

            }else{
                echo $identity->name." ".$identity->surname."<br />";
            }
            echo  $identity->address."<br />";
            // $address.",". $postal_code.",".$city.",". $region.",". $country."<br />";
            ?>
            Email <?= $identity->email ?><br />Telefono <?= $identity->phone ?>
        </div>
    </div>
</div>

<?php if(count($hotel_orders)>0): ?>
<div class="table" style="padding-top:30px;">
    <div class="table-row ">
        <div class="table-cell">Gentile <?= $identity->name ?> <?= $identity->surname ?> hai acquistato camere in promozione Parco+Hotel
            dal <?php $date_ts = strtotime($order->visit_date); echo date('d/m/Y', $date_ts); ?> al <?php echo date('d/m/Y', ($date_ts+86400)); ?>: 
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
                    echo "<li>".$service->title." - ".$service->description." -Prezzo:".$service->price."&euro;</li>";
                }
                ?>
            </ul>
        </div>
    </div>
</div>
@endsection



