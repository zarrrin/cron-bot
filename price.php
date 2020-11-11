<?php
header("content-type: application/json");
include 'currencies.php';
foreach ($currencies as $currency){
  $$currency = sprintf("%.4f",json_decode(file_get_contents("https://www.binance.com/api/v3/avgPrice?symbol=${currency}USDT"))->price);
}
$prices = [];
foreach ($currencies as $cur){
  $prices[$cur] = $$cur;
}
$prices = json_encode($prices);
echo $prices;

?>
