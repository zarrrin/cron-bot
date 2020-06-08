<?php
header("content-type: application/json");
$url = 'https://api.coingecko.com/api/v3/simple/price?ids=bitcoin%2Cripple%2Cethereum%2Clitecoin%2Cbitcoin-cash&vs_currencies=usd';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
$res = curl_exec($ch);
?>
