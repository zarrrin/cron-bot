<?php
    $url = 'https://api.coingecko.com/api/v3/coins/markets?vs_currency=usd&order=market_cap_desc&per_page=12&page=1&sparkline=false';
    $json = file_get_contents($url);
    $data = json_decode($json, true);
    $currencies = [];
    foreach ($data as $key => $value) {
        // push to array
        if ($value['symbol'] == 'usdt' || $value['symbol'] == 'usdc') {
            continue;
        }else{
            array_push($currencies, $value['symbol']);
        }
    }
?>