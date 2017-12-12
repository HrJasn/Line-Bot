<?php

error_reporting(0);

include("db_include.php");
$db = mysqli_connect($DB_Server,$DB_User,$DB_Passwd);
mysqli_select_db($db,"line");
mysqli_query($db,"SET NAMES 'utf8'");

if(!empty($_SERVER['HTTP_CLIENT_IP'])){
   $myip = $_SERVER['HTTP_CLIENT_IP'];
}else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
   $myip = $_SERVER['HTTP_X_FORWARDED_FOR'];
}else{
   $myip = $_SERVER['REMOTE_ADDR'];
}

$access_token ='bxFwr3Y8HcIg2vkudiwGpjVy7bIXcJQqtH0fYIcaTyFD1TFIV3CC8SSDDNkFWql3dDuwpWUwjSV4SqnwEFNMkvkJixqkTajgOR/w9mziLCq0auUlLDOq2cbu42CLBaPG8Z9imBTsNX6A05Kq2cpOvAdB04t89/1O/w1cDnyilFU=';
//define('TOKEN', '你的Channel Access Token');
 
$json_string = file_get_contents('php://input');

$file = fopen("C:\\web\\Line_log\\Line_Reply_log.txt", "a+");
fwrite($file, "IP:".$myip."\n");
$json_obj = json_decode($json_string);
 
$event = $json_obj->{"events"}[0];
$type  = $event->{"message"}->{"type"};
$userId = $event->{"source"}->{"userId"};
fwrite($file, "User ID:".$userId."\n");
$text = $event->{"message"}->{"text"};
fwrite($file, "對方發訊：".$text."\n");
$message = $event->{"message"};
$reply_token = $event->{"replyToken"};

mysqli_query($db,"INSERT INTO users (UserID) VALUES ('".$userId."')");

fwrite($file, "-------------------------------------------------\n");         
fwrite($file, $json_string."\n");

$post_data = [
  "replyToken" => $reply_token,
  "messages" => [
    [
      "type" => "text",
      "text" => '你發送了： '.$message->{"text"}
    ]
  ]
];

fwrite($file, "-------------------------------------------------\n");
fwrite($file, json_encode($post_data)."\n");
 
$ch = curl_init("https://api.line.me/v2/bot/message/reply");
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Authorization: Bearer '.$access_token
    //'Authorization: Bearer '. TOKEN
));
$result = curl_exec($ch);
fwrite($file, "-------------------------------------------------\n");
fwrite($file, $result."\n"); 
fwrite($file, "=================================================\n");
fclose($file);
curl_close($ch);
mysqli_close($db);

header('Location: index.php');

?>