<?php

	session_start();

	if(!empty($_POST['id'])){
		
		include("db_include.php");
		include("line.php");

		$channel_access_token = "bxFwr3Y8HcIg2vkudiwGpjVy7bIXcJQqtH0fYIcaTyFD1TFIV3CC8SSDDNkFWql3dDuwpWUwjSV4SqnwEFNMkvkJixqkTajgOR/w9mziLCq0auUlLDOq2cbu42CLBaPG8Z9imBTsNX6A05Kq2cpOvAdB04t89/1O/w1cDnyilFU=";

		$db = mysqli_connect($DB_Server,$DB_User,$DB_Passwd);
		mysqli_select_db($db,"line");
		mysqli_query($db,"SET NAMES 'utf8'");													
		
		$id = $_POST['id'];
		$pw = substr(md5(rand()),0,8);

		$stmt = $db->prepare("SELECT UserID from users WHERE Account = ?");
		$stmt->bind_param("s", $id);		
		$stmt->execute();
		$stmt->bind_result($userid);
		$stmt->fetch();
		$stmt->close();

		if($userid!=null){
			$stmt = $db->prepare("UPDATE users SET Password = ? WHERE Account = ?");
			$stmt->bind_param("ss", $hash, $id);
			$hash = password_hash($pw,PASSWORD_DEFAULT);
			$stmt->execute();
			$stmt->close();
			$pw="您的暫時密碼：".$pw;	
			push($channel_access_token,$userid,'text',$pw);
			header('Location: login.php');
		}else{
			$_SESSION["forget_alert"] = '無此帳號';
			header('Location: forget_passwd.php');
		}
		
		//mysqli_free_result($db_res);
		mysqli_close($db);
	
	}else{
		//$_SESSION["forget_alert"] = '請輸入帳號';
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

<div id="alert" class="alert" style="display:none;">
	<script>
		var alert = document.getElementById("alert");
		alert.style.display = "<?php echo isset($_SESSION["forget_alert"])?'':'none';?>";
		alert.innerText = "<?php echo isset($_SESSION["forget_alert"])?$_SESSION["forget_alert"]:'';?>";	
	</script>
</div>

<div class="title">忘記密碼</div>

	<form name="form" method="post" action="forget_passwd.php">

		<input class="act" type="text" name="id" placeholder="帳號" onfocus="this.placeholder = ''" onblur="this.placeholder = '帳號'" /> <br>
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
