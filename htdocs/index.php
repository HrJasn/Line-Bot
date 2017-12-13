<?php

	session_start();
	
	if($_SESSION["Account"] != null){		
		$btx = '管理介面';
	}else{
		$btx = '前往登入';
	}

?>

<!DOCTYPE html>
<html lang="zh-hans">

<head>

<meta charset="utf8">
<title>多啦A夢Line-API</title>
<meta http-equiv="Pragma" content="private" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta http-equiv="Cache-Control" content="private, max-age=600, pre-check=600" />

<style>

body{
background-color:#66FF88;
font-family: Microsoft JhengHei;
}

#QR{

position:fixed;
top: calc(50% - 180px);
width:100%;
height:100%;

text-align:center;
line-height:50%;

}

#lgbt{

width:360px;
height:60px;
font-size:30px;

border:1px;
background-color:#44FF44;
color: #FFFFFF;
text-shadow: 0px 0px 2px #FFFFFF;

}

</style>

</head>

<body>

<div id="QR">
<a href="https://line.me/R/ti/p/%40llt8759o"><img src="https://qr-official.line.me/L/AlEw7-Px4h.png"></a>
<div><input id="lgbt" type="button" value="<?php echo $btx;?>" onclick="location.href='login.php';" /></div>
</div>

</body>

</html>