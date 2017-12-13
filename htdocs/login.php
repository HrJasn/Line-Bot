<?php

	session_start();
	
	if($_SESSION["Account"] != null){		
		header('Location: admin.php');		
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

<style>

body{
background-color:#EEFFDD;
font-family: Microsoft JhengHei;
}

form{
position:fixed;
width:100%;
top: calc(50% - 100px);
left:0px;
text-align:center;
}

input[type="submit"]{

max-width:500px;
width:95%;
height:60px;
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

max-width:500px;
width: 95%;
height:50px;
font-size:30px;

border:3px;
border-style:solid;
background-color:#ffffff;
color: #88CCFF;
text-shadow: 0px 0px 2px #88CCFF;

}

input[type="password"]{

max-width:500px;
width: 95%;
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

<?php
	
	echo $_SESSION["Account"];

?>

	<form name="form" method="post" action="connect.php">

		<input type="text" name="id" /> <br>
		<input type="password" name="pw" /> <br>
		<input type="submit" name="button" value="登入" />

	</form>

</body>

</html>