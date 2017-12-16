<?php

	session_start();
	
	if(!empty($_POST['id'])){
	
		if(!empty($_POST['pw'])){

			$id = $_POST['id'];
			$pw = $_POST['pw'];

			include("db_include.php");

			$db = mysqli_connect($DB_Server,$DB_User,$DB_Passwd);
			mysqli_select_db($db,"line");
			mysqli_query($db,"SET NAMES 'utf8'");
			
			$result = mysqli_query($db,"SELECT Account,Password,COUNT(Account),Permission FROM users where Account = '".$id."'");
			$row = mysqli_fetch_array($result,MYSQLI_NUM);

			if($row[2] == '0'){
				$_SESSION["login_alert"] = "無此帳號";
			}elseif($pw != null && password_verify($pw,$row[1]) && $row[3] == 'Admin'){			
				$_SESSION["Account"] = $id;
			}else{
				$_SESSION["login_alert"] = "密碼錯誤";
			}
			
			mysqli_close($db);
			
		}else{
			$_SESSION["login_alert"] = "請輸入密碼";
		}
	
	}else{
		$_SESSION["login_alert"] = "請輸入帳號";
	}
	
	header('Location: login.php');

?>