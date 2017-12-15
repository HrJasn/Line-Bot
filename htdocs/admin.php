<?php

	session_start();
	
	if(empty($_SESSION["Account"])){		
		header('Location: login.php');		
	}
	
	if(!empty($_POST['ChooseUser'])){
		$_SESSION['ChooseUser'] = $_POST['ChooseUser'];
	}

?>
<!DOCTYPE html>
<html lang="zh-hans" style="height:95%">

<head>

<meta charset="utf8">
<title>多啦A夢Line-API 管理</title>
<meta http-equiv="Pragma" content="private" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta http-equiv="Cache-Control" content="private, max-age=600, pre-check=600" />

<link rel=stylesheet type="text/css" href="css\line-template.css"> 
<link rel=stylesheet type="text/css" href="css\menu.css">

<script>

function AutoRefresh(){
	var iframe = document.getElementById('load_message');
	iframe.src = iframe.src;
	setTimeout("AutoRefresh()", 5000);
}

</script>

</head>

<body style="height:100%" onload="JavaScript:AutoRefresh();">

<iframe id="load_message" src="load_message.php" width="100%" frameborder="0" scrolling="no" style="overflow:hidden;height:100%;width:100%" height="100%" width="100%" ></iframe>

<form action="admin.php" method="post" style="font-size:1em;-moz-appearance:none;text-align:center;text-align-last:center;" >
	<select class="title" name="ChooseUser" onchange="this.form.submit()" style="font-size:1em;-moz-appearance:none;text-align:center;text-align-last:center;">
		<option value='%' style="font-size:0.5em;-moz-appearance:none;text-align:center;text-align-last:center;" >公告</option>
		<?php		
								
			include("db_include.php");

			$db = mysqli_connect($DB_Server,$DB_User,$DB_Passwd);
			mysqli_select_db($db,"line");
			mysqli_query($db,"SET NAMES 'utf8'");

			$db_res = mysqli_query($db,"SELECT Account from users");
			
			if(!empty($_SESSION['ChooseUser'])){
				$ChooseUser = $_SESSION['ChooseUser'];
			}
			
			while ($row=mysqli_fetch_array($db_res,MYSQLI_NUM)){
				if($row[0]==$ChooseUser){
					echo "<option value='".$row[0]."' style='font-size:0.5em;-moz-appearance:none;text-align:center;' selected>".$row[0]."</option>";
				}else{
					echo "<option value='".$row[0]."' style='font-size:0.5em;-moz-appearance:none;text-align:center;' >".$row[0]."</option>";
				}
			}
			
			mysqli_free_result($db_res);
			mysqli_close($db);

		?>
	</select>
</form>

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
