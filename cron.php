<?php
date_default_timezone_set("asia/tehran");
function do1() {
    $res = file_get_contents('./price.php');
    // reads last.txt if not exists to calculate price changes
    if (file_exists('last.txt')) {
        $last = file_get_contents('last.txt');
        $last = json_decode($last);
    }
    $res = json_decode($res);

    //get percentage of price changes
    $BTCper = floatval($res->bitcoin->usd/$last->bitcoin->usd)*100 - 100;
    $ETHper = floatval($res->ethereum->usd/$last->ethereum->usd)*100 - 100;
    $XRPper = floatval($res->ripple->usd/$last->ripple->usd)*100 - 100;
    $LTCper = floatval($res->litecoin->usd/$last->litecoin->usd)*100 - 100;
    $BCHper = floatval($res->{'bitcoin-cash'}->usd/$last->{'bitcoin-cash'}->usd)*100 - 100;
    $ADAper = floatval($res->cardano->usd/$last->cardano->usd)*100 - 100;
    //show 3 decimal points
	$BTCper = strval(sprintf("%.3f", $BTCper));
	$ETHper = strval(sprintf("%.3f", $ETHper));
	$XRPper = strval(sprintf("%.3f", $XRPper));
	$LTCper = strval(sprintf("%.3f", $LTCper));
	$BCHper = strval(sprintf("%.3f", $BCHper));

        $texttt =
            ($last->bitcoin->usd > $res->bitcoin->usd ? "🔴":"🔵").
            " BTC:  $".$res->bitcoin->usd."  (*". $BTCper ."%*) %0A".
            ($last->ethereum->usd > $res->ethereum->usd ? "🔴":"🔵").
            " ETH:  $".$res->ethereum->usd."  (*". $ETHper ."%*) %0A".
            ($last->ripple->usd > $res->ripple->usd ? "🔴":"🔵").
            " XRP:  $".$res->ripple->usd."  (*". $XRPper ."%*) %0A".
            ($last->litecoin->usd > $res->litecoin->usd ? "🔴":"🔵").
            " LTC:  $".$res->litecoin->usd."  (*". $LTCper ."%*) %0A".
            ($last->{'bitcoin-cash'}->usd > $res->{'bitcoin-cash'}->usd ? "🔴":"🔵").
            " BCH:  $".$res->{'bitcoin-cash'}->usd."  (*". $BCHper ."%*) %0A".
            ($last->cardano->usd > $res->cardano->usd ?  "🔴":"🔵").
            " Ada: $".$res->cardano->usd."  (*". $ADAper ."%*) %0A".
            "%0A@ZarrrinCryptoPrice";

    // writes to last.txt the prices to calculate price changes
    $res = json_encode($res);
    $last = file_put_contents('last.txt', $res);
    $bot_token = getenv('TOKEN');
    $channel_username = getenv('CH_USERNAME');
    // sends the request in Markdown modes
    file_get_contents('https://api.telegram.org/bot'.$bot_token.'/sendMessage?chat_id=@'.$channel_username.'&text='.$texttt.'&parse_mode=markdown');
}
$text = do1();
?>
