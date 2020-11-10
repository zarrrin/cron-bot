<?php
header("content-type: application/json");
$btc = json_decode(file_get_contents("https://www.binance.com/api/v3/avgPrice?symbol=BTCUSDT"))->price;
$eth = json_decode(file_get_contents("https://www.binance.com/api/v3/avgPrice?symbol=ETHUSDT"))->price;
$xrp = json_decode(file_get_contents("https://www.binance.com/api/v3/avgPrice?symbol=XRPUSDT"))->price;
$link = json_decode(file_get_contents("https://www.binance.com/api/v3/avgPrice?symbol=LINKUSDT"))->price;
$bch = json_decode(file_get_contents("https://www.binance.com/api/v3/avgPrice?symbol=BCHUSDT"))->price;
$bnb = json_decode(file_get_contents("https://www.binance.com/api/v3/avgPrice?symbol=BNBUSDT"))->price;

$btc = sprintf("%.4f", $btc);
$eth = sprintf("%.4f", $eth);
$xrp = sprintf("%.4f", $xrp);
$link = sprintf("%.4f", $link);
$bch = sprintf("%.4f", $bch);
$bnb = sprintf("%.4f", $bnb);

$prices = [
        'btc' => $btc,
        'eth' => $eth,
        'xrp' => $xrp,
        'link' => $link,
        'bch' => $bch,
        'bnb' => $bnb,
    ];
$prices = json_encode($prices);
echo $prices;

?>
