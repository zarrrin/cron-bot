<?php
header("content-type: application/json");
include 'currencies.php';
foreach ($currencies as $currency){
  $uppercaseSym = strtoupper($currency);
  $url = "https://www.binance.com/api/v3/avgPrice?symbol=".$uppercaseSym."USDT";
  $x = json_decode(file_get_contents($url));
  $$currency = sprintf("%.4f", $x->{'price'});
}
$prices = [];
foreach ($currencies as $cur){
  $prices[$cur] = $$cur;
}
$prices = json_encode($prices);
echo $prices;

?>
