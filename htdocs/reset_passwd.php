<?php

	session_start();
	
	if($_SESSION["Account"] == null){		
		header('Location: login.php');
	}elseif(!empty($_POST['oldpw'])){
		
		if(!empty($_POST['pw']) && !empty($_POST['pwagn']) && $_POST['pw']==$_POST['pwagn']){
		
			include("db_include.php");

			$db = mysqli_connect($DB_Server,$DB_User,$DB_Passwd);
			mysqli_select_db($db,"line");
			mysqli_query($db,"SET NAMES 'utf8'");

			$id = $_SESSION["Account"];
			$oldpw = $_POST['oldpw'];			
			$pw = $_POST['pw'];
			$pwagn = $_POST['pwagn'];
			
			$result = mysqli_query($db,"SELECT Password,Permission FROM users where Account = '".$id."'");
			$row = mysqli_fetch_array($result,MYSQLI_NUM);

			if(password_verify($pw,$row[0]))
			{			
				$hash = password_hash($pw, PASSWORD_DEFAULT);
				mysqli_query($db,"UPDATE users SET Password = '".$hash."' WHERE Account = '".$_SESSION["Account"]."'");	
				header('Location: login.php');
			}else{
				$_SESSION["reset_passwd"] = "舊密碼不正確";
			}
			
			mysqli_close($db);
		
		}else{
			$_SESSION["reset_passwd"] = "新密碼、確認密碼輸入錯誤";
		}
	}else{
		$_SESSION["reset_passwd"] = "未輸入舊密碼";
		//header('Location: reset_passwd.php');
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

<div id="alert" class="alert" style="display:none;">
	<script>
		var alert = document.getElementById("alert");
		alert.style.display = "<?php echo !empty($_SESSION["reset_passwd"])?'':'none';?>";
		alert.innerText = "<?php echo $_SESSION["reset_passwd"];?>";	
	</script>
</div>

<div class="title">修改密碼</div>

	<form name="form" method="post" action="reset_passwd.php">

		<input class="pwd" type="password" name="oldpw" placeholder="舊密碼" onfocus="this.placeholder = ''" onblur="this.placeholder = '舊密碼'" /> <br>
		<input class="pwd" type="password" name="pw" placeholder="新密碼" onfocus="this.placeholder = ''" onblur="this.placeholder = '新密碼'"  /> <br>
		<input class="pwd" type="password" name="pwagn" placeholder="確認新密碼" onfocus="this.placeholder = ''" onblur="this.placeholder = '確認新密碼'"  /> <br>
		<input class="userbtn" type="submit" name="button" value="修改密碼" />
		<script>document.getElementsByName("oldpw")[0].focus();</script>

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

