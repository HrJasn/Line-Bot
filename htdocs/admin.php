<?php

error_reporting(0);

if(!empty($_POST['send_text'])){

if(!empty($_SERVER['HTTP_CLIENT_IP'])){
   $myip = $_SERVER['HTTP_CLIENT_IP'];
}else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
   $myip = $_SERVER['HTTP_X_FORWARDED_FOR'];
}else{
   $myip = $_SERVER['REMOTE_ADDR'];
}

$file = fopen("C:\\web\\Line_log\\Line_Push_log.txt", "a+");
$send_text = $_POST['send_text'];
$send_string = urldecode($send_text);
fwrite($file, "=================================================\n");
fwrite($file, "IP:".$myip."\n");
fwrite($file, "發送訊息：".$send_string."\n");
fwrite($file, "-------------------------------------------------\n");
fclose($file);

push('U1ddc6f73c2cad9824edfcd1c1b879bd3'); //HrJasn

// push('U550d8023617ed0da10e2ac61503df0d3'); //楊先生

// push('Ue4cad86c9b6654b8e846003d733d2147');

// push('Uafca7d784e7f713c8c4b4487b9e6d8af'); //陳老闆

}

function push($user_id){

$send_text = $_POST['send_text'];

$file = fopen("C:\\web\\Line_log\\Line_Push_log.txt", "a+");
$json_string = file_get_contents('php://input');
fwrite($file, $json_string."\n");

$access_token = 'bxFwr3Y8HcIg2vkudiwGpjVy7bIXcJQqtH0fYIcaTyFD1TFIV3CC8SSDDNkFWql3dDuwpWUwjSV4SqnwEFNMkvkJixqkTajgOR/w9mziLCq0auUlLDOq2cbu42CLBaPG8Z9imBTsNX6A05Kq2cpOvAdB04t89/1O/w1cDnyilFU=';

$response_format_text=[
	"type"=>"text",
	"text"=>"公告：".$send_text
];

$post_data=[
	"to"=>$user_id,
	"messages"=>[$response_format_text]
];

fwrite($file, json_encode($post_data)."\n");

$ch = curl_init("https://api.line.me/v2/bot/message/push");
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
fwrite($file, $result."\n\n");
fwrite($file, "-------------------------------------------------\n");
fclose($file);
curl_close($ch);

}

?>

<!DOCTYPE html>
<html lang="zh-hans">

<head>

<meta charset="utf8">
<title>Sunwell測試用Line-API</title>
<meta http-equiv="Pragma" content="private" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta http-equiv="Cache-Control" content="private, max-age=600, pre-check=600" />

</head>

<body>

<form action="admin.php" method="post">
發送文字公告：<input type="text" name="send_text"> <input type="submit" name="pushText" value="發送公告">
<script>document.getElementsByName("send_text")[0].focus();</script>
</form>

</body>

</html>
