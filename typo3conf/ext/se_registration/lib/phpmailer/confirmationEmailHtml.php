<html>
<body style='background: white; color: black;  font-size: 12px; width: 600px;'>
<p>Dear <?=$this->customer_title?> <?=$this->customer_lastname?></p>

<center>
<p style='padding: 10px'><strong>PLEASE READ CAREFULLY</strong></p>
</center>

<?
$event = $this->event();
$venue = $event->venue();
$ticket = $this->ticket();

?>

<p style='padding: 10px'>you have booked <strong><?=$this->quantity?> tickets</strong> to <strong><?=$title?></strong> at <?=$venue->title?>, <?=str_replace("\n",",",$venue->address)?> on <strong><?=$date?></strong> at <strong><?=$event->startTime?></strong></p>

<center>
<p style='padding: 10px'>YOUR REFERENCE NUMBER IS:</p>
<p style='color: red; font-weight: bold;'><?=$this->order_ref ?></p>
</center>

<p style='padding: 10px'><?=$this->collectionInstructions()?></p>

<p style='padding: 10px'><?=$event->disclaimers?></p>

<center>
<p style='padding: 10px'>You have been charged the total sum of <?=$this->getPrice(false)?></p>
<p style='padding: 10px'>Plus a booking fee of <?=$this->getBookingFee()?></p>
</center>

<p style='padding: 10px'>Please print off a copy of this confirmation and do not delete as <strong>you will need this reference number on the night of the show</strong>, you may be refused entry without this.</p>

<p style='padding: 10px'>For any enquiries prior to the event please call the C2 box office on 01273 673311</p>

<p>See you soon @ <?=$venue->title?>!</p>
<p>www.concorde2.co.uk  </p>
</body>
</html>
