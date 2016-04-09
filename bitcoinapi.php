<?php
$bitcoin_price = file_get_contents('https://api.coindesk.com/v1/bpi/currentprice.json');
$price = json_decode($bitcoin_price, true);
$usd = $price['bpi']['rate_float'];
echo $usd;
?>