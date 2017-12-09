<?php

echo "建置中";

	//header('Location: /line-bot-sdk-php-master/line-bot-sdk-tiny/echo_bot.php');
    //exit;

/*phpinfo();
$redis = new Redis();
$redis->connect("127.0.0.1","6379"); 
$redis->set("ceshi","hello"); 
echo $redis->get("ceshi"); */

/*require './vendor/autoload.php';

$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient('cVsroaGRUpS+p4UblzflT7SSczaCCBXxmJjq5T6u2cj+Q5M73X3qVdjlFiEVnHFHdDuwpWUwjSV4SqnwEFNMkvkJixqkTajgOR/w9mziLCrHzjdgYNmvFGoqWT1jj5PjkJ3HNzhO+KucRDyCCBt+jAdB04t89/1O/w1cDnyilFU=');
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => '3c7176983193ed3aec81757c0984986c']);

$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('hello');
$redis = new Redis();
$redis->connect('127.0.0.1', 6379, 3.1);
$msg = $redis->lPop('msgq');

if ($msg){
        $json_array = json_decode($msg,true);
        $response = $bot->pushMessage($json_array["events"][0]["source"]["userId"], $textMessageBuilder);
		echo $response;
};
$redis->close();*/

?>