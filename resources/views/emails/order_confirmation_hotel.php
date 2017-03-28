<?php
if($_SERVER['HTTP_HOST'] == 'devel.ws.cinecittaworld.gag.it'){
    $pdf_order_url = sprintf('http://devel.cinecittaworld.gag.it/biglietteria-2017-pdf/?barcode=%s', $barcode);
}else{
    $pdf_order_url = sprintf('http://www.cinecittaworld.it/biglietteria-2017-pdf/?barcode=%s', $barcode);
}

use App\OrderElement;
use Carbon\Carbon;
$order_elements=array();
?>

<html>
<body style="font-size: 14px;">

<p>
Ciao <?= $identity->name ?>,
</p>

<?php
if ($ticket>0) printf("<p>
ecco i tuoi biglietti per venire a Cinecitt&agrave; World!<br>
Puoi scaricarli da questo <a href=\"%s\">link</a></p>

<p>
Per entrare al parco stampa i biglietti o mostrali direttamente dal tuo smartphone ai tornelli di ingresso.<br>
I bambini sotto il metro entrano gratis, dopo avere ritirato il loro biglietto omaggio alle casse del Parco.</p>", $pdf_order_url);

$date = Carbon::parse($order->visit_date)->format('d-m-Y');
if ($service>0) echo " <p>I servizi che hai acquistato sono validi per il giorno $date.</p>";

?>


<!--<p>
[IF NAVETTA] Il servizio navetta parte alle ore 9:45 da Roma Termini (Via Marsala) e ritorna alle ore 18:00 dal Parco. Sia per l’andata che per il ritorno è necessario presentarsi almeno 15 minuti in anticipo rispetto all’orario di partenza.[ENDIF NAVETTA]
</p>

<p>
[IF MENU]Il giorno della tua visita potrai recarti alle casse del Parco per convertire la ricevuta dei menu allegata nel buono consumazione rispettivo.[ENDIF MENU]
</p>-->

<p>Ti aspettiamo al parco  <?php if (isset($date)) echo "il ".$date; ?>!</p>
<p>Lo staff di Cinecitt&agrave; World &ndash; Il parco divertimenti del Cinema e della TV</p>

<p><a href="<?= $pdf_order_url ?>">Clicca qui per scaricare i tuoi biglietti</a></p>

<p><b> ID dell'ordine #</b> <?= $barcode ?></p>
<p>Di seguito il riepilogo del tuo acquisto:</p>


<table width="50%" cellpadding="0" cellspacing="0" border="0" style="font-size: 13px">

    <tr>
        <td width="60%" ><b>Articolo</b></td>
        <td style="text-align: right"><b>Quantit&agrave;</b></td>
        <td style="text-align: right"><b>Importo</b></td>
    </tr>
    <?php
    $totale=0;
    $products=array();
    foreach ($carrello as $key => $value) {
        $totale+=$value['price'];
        $product_id=$value['product_id'];

        if (!in_array($product_id, $products)) {
            $p = (new OrderElement())->getPriceQuantity($order->id, $product_id);
            array_push($products, $product_id);
            $total_tickets= number_format($p->total_sales, 2, ',', '');
            ?>

            <tr>
                <td><?=$value['title'];?></td>
                <td style="text-align: right;"><?=$p->total_qta;?></td>
                <td style="text-align: right"><?=$total_tickets;?></td>
            </tr>

            <?php
        }//endIF
    }//endForEach
    $totale= number_format($totale, 2, ',', '');
    ?>
    <tr>
        <td></td>
        <td></td>
        <td style="text-align: right; padding-top: 10px;"><strong>TOTALE = <?=$totale;?></strong></td>
    </tr>
</table>
</p>

<p>
Hai prenotato le seguenti camere in promozione Parco+Hotel, dal <?= $date ?> al <?php echo date('d-m-Y', (strtotime($date)+86400)); ?>: 
    <ul>
    <?php
        foreach((array) $hotel_orders as $hok => $hov){
            printf('<li>%s %s presso %s (%s)</li>', $hov->rooms, $hov->room_type, $hov->hotel, $hov->hotel_address);
        }
    ?>
    </ul>
</p>
</body>
</html>
