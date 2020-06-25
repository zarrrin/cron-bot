<?php
header("content-type: application/json");
$btc = json_decode(file_get_contents("https://www.binance.com/api/v3/avgPrice?symbol=BTCUSDT"))->price;
$eth = json_decode(file_get_contents("https://www.binance.com/api/v3/avgPrice?symbol=ETHUSDT"))->price;
$xrp = json_decode(file_get_contents("https://www.binance.com/api/v3/avgPrice?symbol=XRPUSDT"))->price;
$ltc = json_decode(file_get_contents("https://www.binance.com/api/v3/avgPrice?symbol=LTCUSDT"))->price;
$bch = json_decode(file_get_contents("https://www.binance.com/api/v3/avgPrice?symbol=BCHUSDT"))->price;
$ada = json_decode(file_get_contents("https://www.binance.com/api/v3/avgPrice?symbol=ADAUSDT"))->price;

$btc = sprintf("%.4f", $btc);
$eth = sprintf("%.4f", $eth);
$xrp = sprintf("%.4f", $xrp);
$ltc = sprintf("%.4f", $ltc);
$bch = sprintf("%.4f", $bch);
$ada = sprintf("%.4f", $ada);

$prices = [
        'btc' => $btc,
        'eth' => $eth,
        'xrp' => $xrp,
        'ltc' => $ltc,
        'bch' => $bch,
        'ada' => $ada,
    ];
$prices = json_encode($prices);
echo $prices;

?>
