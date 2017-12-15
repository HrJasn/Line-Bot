<?php

	session_start();
	
	if($_SESSION["Account"] == null){		
		header('Location: login.php');
	}elseif(!empty($_POST['pw'])){
		
		include("db_include.php");

		$db = mysqli_connect($DB_Server,$DB_User,$DB_Passwd);
		mysqli_select_db($db,"line");
		mysqli_query($db,"SET NAMES 'utf8'");													
		
		$pw = $_POST['pw'];
		$pwagn = $_POST['pwagn'];
		
		if($pw!=null && $pwagn!=null && $pw==$pwagn){
			$hash = password_hash($pw, PASSWORD_DEFAULT);
			mysqli_query($db,"UPDATE users SET Password = '".$hash."' WHERE Account = '".$_SESSION["Account"]."'");	
			header('Location: login.php');
		}else{
			header('Location: reset_passwd.php');
		}
		
		mysqli_close($db);
		
	}
?>
<!DOCTYPE html>
<html lang="zh-hans">

<head>

<meta charset="utf8">
<title>多啦A夢Line-API 修改密碼</title>
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

<div class="title">修改密碼</div>

	<form name="form" method="post" action="reset_passwd.php">

		<input class="pwd" type="password" name="pw" /> <br>
		<input class="pwd" type="password" name="pwagn" /> <br>
		<input class="userbtn" type="submit" name="button" value="修改密碼" />
		<script>document.getElementsByName("pw")[0].focus();</script>

	</form>

	<div class="listbtn">
		<ul class="drop-down-menu">
			<li><a href="javascript: void(0)">≡</a>
					<ul>
						<li><a href="index.php">首頁</a></li>
						<li><a href="admin.php">管理介面</a></li>
						<li><a href="logout.php">登出</a></li>
					</ul>
			</li>
		</ul>
	</div>

</body>

</html>
