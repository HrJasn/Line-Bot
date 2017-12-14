<?php

	session_start();
	
	if($_SESSION["Account"] == null){		
		header('Location: login.php');		
	}

?>
<!DOCTYPE html>
<html lang="zh-hans">

<head>

<meta charset="utf8">
<title>多啦A夢Line-API 管理</title>
<meta http-equiv="Pragma" content="private" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta http-equiv="Cache-Control" content="private, max-age=600, pre-check=600" />

<link rel=stylesheet type="text/css" href="css\line-template.css"> 
<link rel=stylesheet type="text/css" href="css\menu.css"> 

</head>

<body>

<div class="title">公告</div>

<div class="listbtn">
	<ul class="drop-down-menu">
		<li><a href="javascript: void(0)">≡</a>
				<ul>
					<li><a href="index.php">首頁</a></li>
					<li><a href="reset_passwd.php">修改密碼</a></li>
					<li><a href="logout.php">登出</a></li>
				</ul>
		</li>
	</ul>
</div>


<form class="post" action="push.php" method="post">
	<input class="sdtext" type="text" name="send_text"><input class="sdbtn" type="submit" name="pushText" value="發送">
	<script>document.getElementsByName("send_text")[0].focus();</script>
</form>

</body>

</html>
