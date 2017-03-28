<?php
use App\OrderElement;
use Carbon\Carbon;
?>

<html>
<body>
<p>
Gentile <?= $hotel_orders[0]->hotel ?>,
di seguito i dati relativi alla prenotazione in oggetto:

<ul>
    <li>Nome e cognome: <strong><?= $identity->name ?> <?= $identity->surname ?></strong></li>
    <li>Email: <strong><?= $identity->email ?></strong></li>
    <li>Tel.: <strong><?= $identity->phone ?></strong></li>
</ul>

Dal <strong><?= $order_day ?></strong> al <strong><?= $order_dayafter ?></strong>

<h3>Stanze prenotate</h3>
<ul>
<?php
foreach((array) $hotel_orders as $hok => $hov){
    printf('<li><strong>%s</strong> %s</li>', $hov->rooms, $hov->room_type);
}
?>
</ul>
</p>
</body>
</html>
