<?php
include 'Telegram.php';
include 'config.php';
$telegram          = new Telegram($TOKEN);
$chat_id           = $telegram->ChatID();
$text              = $telegram->Text();
$callback_data     = $telegram->Callback_Data();
$callback_query    = $telegram->Callback_Query();
$callback_chat_id  = $telegram->Callback_ChatID();
$message_id        = $telegram->MessageID();

if ($callback_data == 'now') {
    $answerText = json_decode( file_get_contents($price_path) );
    $btc = $answerText->btc;
    $eth = $answerText->eth;
    $xrp = $answerText->xrp;
    $link = $answerText->link;
    $bch = $answerText->bch;
    $bnb = $answerText->bnb;
$answerText = "⚡ Prices Right Now :

BTC: \$${btc}
ETH: \$${eth}
XRP: \$${xrp}
LINK: \$${link}
BCH: \$${bch}
BNB: \$${bnb}
";
    $content = array('callback_query_id' => $callback_query["id"], 'text' => $answerText, 'show_alert' => true);
    $telegram->answerCallbackQuery($content);
}

// pass argument to examine that the request is sent by cron curl client
if( isset($_GET['do']) ){
    if($_GET['do'] == 'passed argument') {
        function do1() {
            $telegram = $GLOBALS["telegram"];
            $res = file_get_contents($price_path);
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
            $LINKper = floatval($res->link/$last->link)*100 - 100;
            $BCHper = floatval($res->bch/$last->bch)*100 - 100;
            $BNBper = floatval($res->bnb/$last->bnb)*100 - 100;
            //show 3 decimal points
        	$BTCper = strval(sprintf("%.3f", $BTCper));
        	$ETHper = strval(sprintf("%.3f", $ETHper));
        	$XRPper = strval(sprintf("%.3f", $XRPper));
        	$LINKper = strval(sprintf("%.3f", $LINKper));
        	$BCHper = strval(sprintf("%.3f", $BCHper));
        	$BNBper = strval(sprintf("%.3f", $BNBper));
        
                $texttt =
                    ($last->btc > $res->btc ? "🔴":"🔵").
                    " BTC:  $".$res->btc."  (*". $BTCper ."%*) \n".
                    ($last->eth > $res->eth ? "🔴":"🔵").
                    " ETH:  $".$res->eth."  (*". $ETHper ."%*) \n".
                    ($last->xrp > $res->xrp ? "🔴":"🔵").
                    " XRP:  $".$res->xrp."  (*". $XRPper ."%*) \n".
                    ($last->ltc > $res->ltc ? "🔴":"🔵").
                    " LINK:  $".$res->link."  (*". $LINKper ."%*) \n".
                    ($last->bch > $res->bch ? "🔴":"🔵").
                    " BCH:  $".$res->bch."  (*". $BCHper ."%*) \n".
                    ($last->ada > $res->ada ?  "🔴":"🔵").
                    " BNB: $".$res->bnb."  (*". $BNBper ."%*) \n".
                    "\n @ZarrrinCryptoPrice";
        
            // writes to last.txt the prices to calculate price changes
            $res = json_encode($res);
            $last = file_put_contents('last.txt', $res);
            
            
            $option = array( 
        
        		array(
       
        			$telegram->buildInlineKeyboardButton("Live Price","","now","")
        
        		)
        
        	);
        
        	$keyb = $telegram->buildInlineKeyBoard($option);
            $CH_USERNAME = $GLOBALS["CH_USERNAME"];
        	$content = array('chat_id' =>  $CH_USERNAME, 'text' => $texttt ,'parse_mode' => 'markdown' ,'reply_markup' => $keyb);
        
        	$telegram->sendMessage($content);
        }
        $text = do1();
        
    }
}


?>
