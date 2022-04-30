<?php

session_start();

error_reporting(0);

if(!isset($_SESSION["Account"])){
	header('Location: login.php');
}
	
if(!empty($_POST['send_text'])){	
		
	if(isset($_SESSION['ChooseUser'])){
		$ChooseUser = $_SESSION['ChooseUser'];
	}else{
		$ChooseUser = '%';
	}

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

	//$channel_id = "";
	//$channel_secret = "";
	$channel_access_token = "";

	$send_text = $_POST['send_text'];

	$db_res = mysqli_query($db,"SELECT UserID,Sub FROM users WHERE Account LIKE '".$ChooseUser."'");
	
	/*$stmt = $db->prepare("SELECT UserID,Sub FROM users WHERE Account LIKE ?");
	$stmt->bind_param("s", $ChooseUser);	
	$stmt->execute();
	$stmt->bind_result($userid,$Sub);*/

	while($row=mysqli_fetch_array($db_res,MYSQLI_NUM)){ /*$stmt->fetch()*/
		if ($row[1]==1){
			push($channel_access_token,$row[0],'text',$send_text);
			/*$json = json_encode($data);
			$stmt_msg = $db->prepare("INSERT INTO message (src,IP,From_User,Cnt_Type,Cnt_ID,Msg,MsgType,MsgText) VALUES ('send',?,?,'user',?,?,'text',?)");
			$stmt_msg->bind_param('sssss',$myip,$Account,$userid,$json,$send_text);
			$stmt_msg->execute();
			$stmt_msg->close();*/
			mysqli_query($db,"INSERT INTO message (src,IP,From_User,Cnt_Type,Cnt_ID,Msg,MsgType,MsgText) 
		VALUES ('send','".$myip."','".$_SESSION["Account"]."','user','".$row[0]."','".$data."','text','".$send_text."')");
		}
	}

	mysqli_free_result($db_res);
	mysqli_close($db);

}

header('Location: admin.php');

?>
