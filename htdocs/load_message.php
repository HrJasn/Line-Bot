<?php

	session_start();
	
	if(empty($_SESSION["Account"])){		
		exit;	
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

<div id="load-msg" class="load-msg">
<?php
	
	include("db_include.php");

	$db = mysqli_connect($DB_Server,$DB_User,$DB_Passwd);
	mysqli_select_db($db,"line");
	mysqli_query($db,"SET NAMES 'utf8'");

	if(!empty($_SESSION['ChooseUser'])){		
		$ChooseUser = $_SESSION['ChooseUser'];
	}else{
		$ChooseUser = '%';
	}

	$db_res = mysqli_query($db,"SELECT message.src,message.From_User,users.Account,message.MsgText FROM message,users WHERE Cnt_Type='user' AND MsgType='text' AND message.Cnt_ID=users.UserID AND users.Account LIKE '".$ChooseUser."' ORDER BY TimeStamp ASC");
	
	while ($row=mysqli_fetch_array($db_res,MYSQLI_NUM)) {
		if ($row[0]!=null && $row[2]!=null && $row[3]!=null){
			if($row[0]=='send'){
				echo "<div class='send-msg'>".$row[1]."對".$row[2]."說：".$row[3]."</div>";
			}elseif($row[0]=='receive'){
				echo "<div class='receive-msg'>".$row[2]."說：".$row[3]."</div>";
			}
		}
	}

	mysqli_free_result($db_res);
	mysqli_close($db);

?>

</div>

</body>

</html>