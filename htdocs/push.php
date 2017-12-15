<?php

session_start();

error_reporting(0);

if($_SESSION["Account"] == null){
	header('Location: login.php');
}
	
if(!empty($_POST['send_text'])){	
				
	$ChooseUser = $_SESSION['ChooseUser'];

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

	$db_res = mysqli_query($db,"SELECT UserID,Sub FROM users WHERE Account LIKE '".$ChooseUser."'");

	while ($row=mysqli_fetch_array($db_res,MYSQLI_NUM)) {
		if ($row[1]==1){
			push($channel_access_token,$row[0],'text',$send_text);
			mysqli_query($db,"INSERT INTO message (src,IP,From_User,Cnt_Type,Cnt_ID,Msg,MsgType,MsgText) 
		VALUES ('send','".$myip."','".$_SESSION["Account"]."','user','".$row[0]."','".$data."','text','".$send_text."')");
		}
	}

	mysqli_free_result($db_res);
	mysqli_close($db);

}

header('Location: admin.php');

?>