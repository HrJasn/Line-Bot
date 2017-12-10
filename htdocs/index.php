<?php

echo "建置中";

require_once('LINEBotTiny.php');

$channelAccessToken = 'Your Channel Access Token';
$channelSecret = 'Your Channel Secret';

$client = new LINEBotTiny($channelAccessToken, $channelSecret);

foreach ($client->parseEvents() as $event) {
    $client->replyMessage(array(
        'replyToken' => $event['replyToken'],
        'messages' => array(
            array(
                'type' => 'text',
                'text' => $message['text']
            )
        )
    ));
};

?>