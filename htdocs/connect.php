<?php

	session_start();
	//session_register('Account');
	
	$id = $_POST['id'];
	$pw = $_POST['pw'];

	include("db_include.php");

	$db = mysqli_connect($DB_Server,$DB_User,$DB_Passwd);
	mysqli_select_db($db,"line");
	mysqli_query($db,"SET NAMES 'utf8'");
	
	$result = mysqli_query($db,"SELECT Account,Password,Permission FROM users where Account = '".$id."'");
	$row = mysqli_fetch_array($result,MYSQLI_NUM);
	
	echo '$id:'.$id;
	echo '$pw:'.$pw;
	echo '$row[0]:'.$row[0];
	echo '$row[1]:'.$row[1];
	echo '$row[2]:'.$row[2];
	
	if($id != null && $pw != null && $row[0] == $id && $row[1] == $pw && $row[2] == 'Admin')
	{			
			$_SESSION["Account"] = $id;
	}
	
	mysqli_close($db);
	
	header('Location: login.php');

?>