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

<style>

body{
background-color:#EEFFDD;
font-family: Microsoft JhengHei;
}

#title{

position:fixed;
top:0px;
left:0px;
width:100%;
height:50px;

border:0px;
color: #FFFFFF;
background-color:#66FF88;

font-size:30px;
text-align:center;
line-height:50px;

}

#lgout{

position:fixed;
top:0px;
right:0px;
width:100px;
height:50px;

border:2px;
color: #FFFFFF;
background-color:#66FF88;

font-size:30px;
text-align:center;
line-height:50px;

}

#home{

position:fixed;
top:0px;
left:0px;
width:100px;
height:50px;

border:2px;
color: #FFFFFF;
background-color:#66FF88;

font-size:30px;
text-align:center;
line-height:50px;

}

#post{
position:fixed;
bottom:0px;
left:0px;
width:100%;
}

input[type="submit"]{

width:100px;
height:55px;
font-size:30px;

opacity:1;
transform: translate(0,0);
transition:all .2s ease-in 0s;
border:1px;
background-color:#88FF88;
color: #FFFFFF;
text-shadow: 0px 0px 2px #FFFFFF;

}

input[type="submit"]:hover{
border:2px;
opacity:1;
background-color:#66FF88;
box-shadow: 0px 0px 10px #FFFFFF inset;
}

input[type="text"]{

width: calc(100% - 109px);
height:50px;
font-size:30px;

border:3px;
border-style:solid;
background-color:#ffffff;
color: #88CCFF;
text-shadow: 0px 0px 2px #88CCFF;

}

</style>

</head>

<body>

<div id="title">公告</div>

<div><input id="lgout" type="button" value="登出" onclick="location.href='logout.php';" /></div>

<div><input id="home" type="button" value="首頁" onclick="location.href='index.php';" /></div>

<form id="post" action="push.php" method="post">
	<input type="text" name="send_text"><input type="submit" name="pushText" value="發送">
	<script>document.getElementsByName("send_text")[0].focus();</script>
</form>

</body>

</html>
