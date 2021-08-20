<?php
// tel: blackestwhite at telegram
include 'Telegram.php';
include './config.php';
include 'currencies.php';
$telegram          = new Telegram($TOKEN);
$chat_id           = $telegram->ChatID();
$text              = $telegram->Text();
$callback_data     = $telegram->Callback_Data();
$callback_query    = $telegram->Callback_Query();
$callback_chat_id  = $telegram->Callback_ChatID();
$message_id        = $telegram->MessageID();

if ($callback_data == 'now') {
    $answerText = json_decode( file_get_contents($GLOBALS['price_path']) );
    foreach($currencies as $currency){
        $$currency = $answerText->{"${currency}"};
    }
    
    $answerTxt = "⚡ Prices right now\n";
    foreach($currencies as $currency){
        $answerTxt = $answerTxt."\n".strtoupper($currency)." \$".$$currency;
    }
    
    $content = array('callback_query_id' => $callback_query["id"], 'text' => $answerTxt, 'show_alert' => true);
    $telegram->answerCallbackQuery($content);
}

// pass argument to examine that the request is sent by cron curl client
if( isset($_GET['do']) ){
    if($_GET['do'] == 411) {
        function do1() {
            $telegram = $GLOBALS["telegram"];
            $res = json_decode(file_get_contents($GLOBALS['price_path']));
            
            // reads last.txt if exists to calculate price changes
            if (file_exists('last.txt')) {
                $last = file_get_contents('last.txt');
                $last = json_decode($last);
            }
            
            foreach($GLOBALS['currencies'] as $cur) {
                if ($last->{"${cur}"} == 0) {
                    $$cur = "Initiated Now";
                }else{
                    $$cur = floatval($res->{"${cur}"}/$last->{"${cur}"})*100 - 100;
                    $$cur = strval(sprintf("%.3f", $$cur));
                }
            }
                
                $blueBall = "🔵";
                $redBall = "🔴";
                $textTxt = "";
                foreach($GLOBALS['currencies'] as $cur) {
                    $upperCaseSymbol = strtoupper($cur);
                    $textTxt = $textTxt.($last->{"${cur}"} > $res->{"${cur}"} ? $redBall : $blueBall)." ${upperCaseSymbol}: $".$res->{"${cur}"}."  (*".$$cur."%*) \n";
                }
                $CH_USERNAME = $GLOBALS['CH_USERNAME'];
                $textTxt = $textTxt."\n${CH_USERNAME}";
                
            // writes to last.txt the prices to calculate price changes
            $res = json_encode($res);
            $last = file_put_contents('last.txt', $res);
            
            
            $option = array( 
                array(
                    $telegram->buildInlineKeyboardButton("Live Price","","now","")
                )
            );
        
                $keyb = $telegram->buildInlineKeyBoard($option);
                $CH_USERNAME = $GLOBALS['CH_USERNAME'];
                $content = array('chat_id' => $CH_USERNAME, 'text' => $textTxt ,'parse_mode' => 'markdown' ,'reply_markup' => $keyb);
        
                $telegram->sendMessage($content);
        }
        $text = do1();
        
    }
}
?>
