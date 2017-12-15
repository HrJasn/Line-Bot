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

<link rel=stylesheet type="text/css" href="css\line-template.css"> 

</head>

<body>

<div class="recieve-msg">
<textarea id="rcv-msg" class="recieve-msg-box" readonly="readonly">
<?php
	
	include("db_include.php");

	$db = mysqli_connect($DB_Server,$DB_User,$DB_Passwd);
	mysqli_select_db($db,"line");
	mysqli_query($db,"SET NAMES 'utf8'");
	
	$db_res = mysqli_query($db,"SELECT users.Account,message.MsgText FROM message,users WHERE src='receive' AND Cnt_Type='user' AND MsgType='text' AND message.Cnt_ID=users.UserID ORDER BY TimeStamp ASC");
	
	while ($row=mysqli_fetch_array($db_res,MYSQLI_NUM)) {
		if ($row[0]!=null && $row[1]!=null){
			echo "\n\n".$row[0]."：".$row[1];
		}
	}
	
	mysqli_free_result($db_res);
	mysqli_close($db);

?>
</textarea>
</div>

<div class="send-msg">
<textarea id="send-msg" class="send-msg-box" readonly="readonly">
<?php
	
	include("db_include.php");

	$db = mysqli_connect($DB_Server,$DB_User,$DB_Passwd);
	mysqli_select_db($db,"line");
	mysqli_query($db,"SET NAMES 'utf8'");
	
	$db_res = mysqli_query($db,"SELECT message.From_User,users.Account,message.MsgText FROM message,users WHERE src='send' AND Cnt_Type='user' AND MsgType='text' AND message.Cnt_ID=users.UserID ORDER BY TimeStamp ASC");
	
	while ($row=mysqli_fetch_array($db_res,MYSQLI_NUM)) {
		if ($row[0]!=null && $row[1]!=null){
			echo "\n\n".$row[0]."對".$row[1]."說：".$row[2];
		}
	}
	
	mysqli_free_result($db_res);
	mysqli_close($db);

?>
</textarea>
</div>

<script>

var textarea = document.getElementById("rcv-msg");
textarea.scrollTop = textarea.scrollHeight;

textarea = document.getElementById("send-msg");
textarea.scrollTop = textarea.scrollHeight;

</script>

</body>

</html>