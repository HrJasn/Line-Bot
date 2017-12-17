<?php

	session_start();
	
	if($_SESSION["Account"] != null){		
		header('Location: admin.php');
	}

	if( !get_magic_quotes_gpc() )
	{
		if( is_array($_GET) )
		{
			while( list($k, $v) = each($_GET) )
			{
				if( is_array($_GET[$k]) )
				{
					while( list($k2, $v2) = each($_GET[$k]) )
					{
						$_GET[$k][$k2] = addslashes($v2);
					}
					@reset($_GET[$k]);
				}
				else
				{
					$_GET[$k] = addslashes($v);
				}
			}
			@reset($_GET);
		}
	 
		if( is_array($_POST) )
		{
			while( list($k, $v) = each($_POST) )
			{
				if( is_array($_POST[$k]) )
				{
					while( list($k2, $v2) = each($_POST[$k]) )
					{
						$_POST[$k][$k2] = addslashes($v2);
					}
					@reset($_POST[$k]);
				}
				else
				{
					$_POST[$k] = addslashes($v);
				}
			}
			@reset($_POST);
		}
	 
		/*if( is_array($_COOKIE) )
		{
			while( list($k, $v) = each($_COOKIE) )
			{
				if( is_array($_COOKIE[$k]) )
				{
					while( list($k2, $v2) = each($_COOKIE[$k]) )
					{
						$_COOKIE[$k][$k2] = addslashes($v2);
					}
					@reset($_COOKIE[$k]);
				}
				else
				{
					$_COOKIE[$k] = addslashes($v);
				}
			}
			@reset($_COOKIE);
		}*/
	}

?>
<!DOCTYPE html>
<html lang="zh-hans">

<head>

<meta charset="utf8">
<title>多啦A夢Line-API 登入</title>
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
	font-size:1em;
}

</style>

</head>

<body>

<div id="alert" class="alert" style="display:none;">
	<script>
		var alert = document.getElementById("alert");
		alert.style.display = "<?php echo !empty($_SESSION["login_alert"])?'':'none';?>";
		alert.innerText = "<?php echo $_SESSION["login_alert"];?>";	
	</script>
</div>

<div class="title">登入</div>

	<form name="form" method="post" action="connect.php">

		<input class="act" type="text" name="id" placeholder="帳號" onfocus="this.placeholder = ''" onblur="this.placeholder = '帳號'"/> <br>
		<input class="pwd" type="password" name="pw"  placeholder="密碼" onfocus="this.placeholder = ''" onblur="this.placeholder = '密碼'"/> <br>
		<input class="userbtn" type="submit" name="button" value="登入" />
		<script>document.getElementsByName("id")[0].focus();</script>

	</form>

<div class="listbtn">
	<ul class="drop-down-menu">
		<li><a href="javascript: void(0)">≡</a>
				<ul>
					<li><a href="index.php">首頁</a></li>
					<li><a href="forget_passwd.php">忘記密碼</a></li>
				</ul>
		</li>
	</ul>
</div>

</body>

</html>