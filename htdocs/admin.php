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
include("line.php");

$db = mysqli_connect($DB_Server,$DB_User,$DB_Passwd);
mysqli_select_db($db,"line");
mysqli_query($db,"SET NAMES 'utf8'");

$channel_id = "1549672834";
$channel_secret = "3f330e05765e49b96f1a25a787252779";
$channel_access_token = "bxFwr3Y8HcIg2vkudiwGpjVy7bIXcJQqtH0fYIcaTyFD1TFIV3CC8SSDDNkFWql3dDuwpWUwjSV4SqnwEFNMkvkJixqkTajgOR/w9mziLCq0auUlLDOq2cbu42CLBaPG8Z9imBTsNX6A05Kq2cpOvAdB04t89/1O/w1cDnyilFU=";

$send_text = $_POST['send_text'];

//UPDATE users SET `Sub` = 1 WHERE `UserID` != 'U1ddc6f73c2cad9824edfcd1c1b879bd3' 

$db_res = mysqli_query($db,"SELECT UserID,Sub FROM users");

while ($row=mysqli_fetch_array($db_res,MYSQLI_NUM)) {
	if ($row[1]==1){
		push($channel_access_token,$row[0],'text',$send_text);
		mysqli_query($db,"INSERT INTO message (src,IP,Cnt_Type,Cnt_ID,Msg,MsgType,MsgText) 
	VALUES ('send','".$myip."','user','".$row[0]."','".$data."','text','".$send_text."')");
	}
}

mysqli_free_result($db_res);
mysqli_close($db);

}

?>
