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

include("db_include.php");
$db = mysqli_connect($DB_Server,$DB_User,$DB_Passwd);
mysqli_select_db($db,"line");
mysqli_query($db,"SET NAMES 'utf8'");

$file = fopen("C:\\web\\Line_log\\Line_Push_log.txt", "a+");
$send_text = $_POST['send_text'];
$send_string = urldecode($send_text);
fwrite($file, "=================================================\n");
fwrite($file, "IP:".$myip."\n");
fwrite($file, "發送訊息：".$send_string."\n");
fwrite($file, "-------------------------------------------------\n");

$db_res = mysqli_query($db,"SELECT UserID FROM users");

while($row=mysqli_fetch_array($db_res,MYSQLI_NUM)) {
	fwrite($file, "SQL:".$row[0]."\n");
	push($row[0]);
}

mysqli_free_result($db_res);
fclose($file);
mysqli_close($db);

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
<title>多啦A夢Line-API</title>
<meta http-equiv="Pragma" content="private" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta http-equiv="Cache-Control" content="private, max-age=600, pre-check=600" />

<style>

body{
background-color:#EEFFDD;
font-family: Microsoft JhengHei;
}

#title{

position:fixed;
top:0px;
left:0px;
width:100%;
height:50px;

border:0px;
color: #FFFFFF;
background-color:#66FF88;

font-size:30px;
text-align:center;
line-height:50px;

}

#post{
position:fixed;
bottom:0px;
left:0px;
width:100%;
}

input[type="submit"]{

width:100px;
height:55px;
font-size:30px;

opacity:1;
transform: translate(0,0);
transition:all .2s ease-in 0s;
border:1px;
background-color:#88FF88;
color: #FFFFFF;
text-shadow: 0px 0px 2px #FFFFFF;

}

input[type="submit"]:hover{
border:2px;
opacity:1;
background-color:#66FF88;
box-shadow: 0px 0px 10px #FFFFFF inset;
}

input[type="text"]{

width: calc(100% - 109px);
height:50px;
font-size:30px;

border:3px;
border-style:solid;
background-color:#ffffff;
color: #88CCFF;
text-shadow: 0px 0px 2px #88CCFF;

}

</style>

</head>

<body>

<div id="title">公告</div>
<form id="post" action="admin.php" method="post">
<input type="text" name="send_text"><input type="submit" name="pushText" value="發送">
<script>document.getElementsByName("send_text")[0].focus();</script>
</form>

</body>

</html>
