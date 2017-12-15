<?php

	if(!empty($_POST['id'])){
		
		include("db_include.php");
		include("line.php");

		$channel_access_token = "bxFwr3Y8HcIg2vkudiwGpjVy7bIXcJQqtH0fYIcaTyFD1TFIV3CC8SSDDNkFWql3dDuwpWUwjSV4SqnwEFNMkvkJixqkTajgOR/w9mziLCq0auUlLDOq2cbu42CLBaPG8Z9imBTsNX6A05Kq2cpOvAdB04t89/1O/w1cDnyilFU=";

		$db = mysqli_connect($DB_Server,$DB_User,$DB_Passwd);
		mysqli_select_db($db,"line");
		mysqli_query($db,"SET NAMES 'utf8'");													
		
		$id = $_POST['id'];
		$pw = substr(md5(rand()),0,8);
		$hash = password_hash($pw, PASSWORD_DEFAULT);

		mysqli_query($db,"UPDATE users SET Password = '".$hash."' WHERE Account = '".$id."'");	
		$db_res = mysqli_query($db,"SELECT UserID from users WHERE Account = '".$id."'");
		$row=mysqli_fetch_array($db_res,MYSQLI_NUM);
		
		$pw="您的暫時密碼：".$pw;
		
		push($channel_access_token,$row[0],'text',$pw);
		
		mysqli_close($db);

		header('Location: login.php');
		
	}
?>
<!DOCTYPE html>
<html lang="zh-hans">

<head>

<meta charset="utf8">
<title>多啦A夢Line-API 忘記密碼</title>
<meta http-equiv="Pragma" content="private" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta http-equiv="Cache-Control" content="private, max-age=600, pre-check=600" />

<link rel=stylesheet type="text/css" href="css\line-template.css"> 
<link rel=stylesheet type="text/css" href="css\menu.css"> 

<style>

form{
position:fixed;
width:100%;
top: calc(50% - 100px);
left:0px;
text-align:center;
}

</style>

</head>

<body>

<div class="title">忘記密碼</div>

	<form name="form" method="post" action="forget_passwd.php">

		<input class="act" type="text" name="id" /> <br>
		<input class="userbtn" type="submit" name="button" value="發送暫時密碼" />
		<script>document.getElementsByName("id")[0].focus();</script>

	</form>

	<div class="listbtn">
		<ul class="drop-down-menu">
			<li><a href="javascript: void(0)">≡</a>
					<ul>
						<li><a href="index.php">首頁</a></li>
					</ul>
			</li>
		</ul>
	</div>

</body>

</html>
