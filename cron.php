<?php
require 'config.php';

function do1() {
    $res = file_get_contents('https://safaryglass.ir/bots/price.php');
    // reads last.txt if exists to calculate price changes
    if (file_exists('last.txt')) {
        $last = file_get_contents('last.txt');
        $last = json_decode($last);
    }
    $res = json_decode($res);
    //get percentage of price changes
    $BTCper = floatval($res->btc/$last->btc)*100 - 100;
    $ETHper = floatval($res->eth/$last->eth)*100 - 100;
    $XRPper = floatval($res->xrp/$last->xrp)*100 - 100;
    $LTCper = floatval($res->ltc/$last->ltc)*100 - 100;
    $BCHper = floatval($res->bch/$last->bch)*100 - 100;
    $ADAper = floatval($res->ada/$last->ada)*100 - 100;
    //show 3 decimal points
	$BTCper = strval(sprintf("%.3f", $BTCper));
	$ETHper = strval(sprintf("%.3f", $ETHper));
	$XRPper = strval(sprintf("%.3f", $XRPper));
	$LTCper = strval(sprintf("%.3f", $LTCper));
	$BCHper = strval(sprintf("%.3f", $BCHper));
	$ADAper = strval(sprintf("%.3f", $ADAper));

        $texttt =
            ($last->btc > $res->btc ? "ðŸ”´":"ðŸ”µ").
            " BTC:  $".$res->btc."  (*". $BTCper ."%*) %0A".
            ($last->eth > $res->eth ? "ðŸ”´":"ðŸ”µ").
            " ETH:  $".$res->eth."  (*". $ETHper ."%*) %0A".
            ($last->xrp > $res->xrp ? "ðŸ”´":"ðŸ”µ").
            " XRP:  $".$res->xrp."  (*". $XRPper ."%*) %0A".
            ($last->ltc > $res->ltc ? "ðŸ”´":"ðŸ”µ").
            " LTC:  $".$res->ltc."  (*". $LTCper ."%*) %0A".
            ($last->bch > $res->bch ? "ðŸ”´":"ðŸ”µ").
            " BCH:  $".$res->bch."  (*". $BCHper ."%*) %0A".
            ($last->ada > $res->ada ?  "ðŸ”´":"ðŸ”µ").
            " Ada: $".$res->ada."  (*". $ADAper ."%*) %0A".
            "%0A@ZarrrinCryptoPrice";

    // writes to last.txt the prices to calculate price changes
    $res = json_encode($res);
    $last = file_put_contents('last.txt', $res);
    
    
    // sends the request in Markdown modes
    
    $TOKEN = $GLOBALS["TOKEN"];
    $CH_USERNAME = $GLOBALS["CH_USERNAME"];
    $bot = "bot${TOKEN}";
    file_get_contents("https://api.telegram.org/${bot}/sendMessage?chat_id=@${CH_USERNAME}&text=${texttt}&parse_mode=markdown");
}
$text = do1();
?>
