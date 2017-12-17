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
	Change();
	setTimeout("AutoRefresh()", 800);
}

function Change()
{
	var ifr1=document.getElementById("load_message1");
	var ifr2=document.getElementById("load_message2");
	var ifrdiv=document.getElementById("ifrdiv");
	
	var scrollTop_tmp;
	
	if(document.body.scrollTop){
		scrollTop_tmp = document.body.scrollTop;
	}else{
		scrollTop_tmp = document.documentElement.scrollTop;
	}

	if( ifr1.style.display == 'none' )  {
		ifr1.src = ifr1.src;
		ifr1.style.display='';
		setIframeHeight(window.top.document.getElementById('load_message1'),scrollTop_tmp);
		setTimeout("document.getElementById('load_message2').style.display='none'", 200);
	}else{
		ifr2.src = ifr2.src;
		ifr2.style.display='';
		setIframeHeight(window.top.document.getElementById('load_message2'),scrollTop_tmp);
		setTimeout("document.getElementById('load_message1').style.display='none'", 200);
	}
}


function setIframeHeight(ifrm,scrollTop_tmp){
	var ifrdiv=document.getElementById("ifrdiv");
	var doc = ifrm.contentDocument? ifrm.contentDocument:
    ifrm.contentWindow.document;
    var RestHeight=ifrm.style.height;
    ifrdiv.style.height = "10px";
    var NewHeight = getDocHeight(doc) + 10;
    if (NewHeight>20){
		ifrdiv.style.height=(NewHeight+120) + "px";
		document.body.scrollTop = scrollTop_tmp;
		document.documentElement.scrollTop = scrollTop_tmp;
		var HeightTmp = NewHeight;
    } else {
		ifrdiv.style.height=(RestHeight+120) + "px";
		document.body.scrollTop = scrollTop_tmp;
		document.documentElement.scrollTop = scrollTop_tmp;
		var HeightTmp = RestHeight;
    }

}

function getDocHeight(doc) {
    doc = doc || document;
    var body = doc.body, html = doc.documentElement;
    var height = Math.max( body.scrollHeight, body.offsetHeight, html.clientHeight,html.scrollHeight, html.offsetHeight );
    return height;
}

</script>

</head>

<body style="height:100%;" onload="JavaScript:AutoRefresh();">

<div id="ifrdiv" class="iframe-out-div">
	<iframe id="load_message1" class="iframe" src="load_message.php" frameborder="0" scrolling="no"></iframe>
	<iframe id="load_message2" class="iframe" src="load_message.php" frameborder="0" scrolling="no" style="display:none;"></iframe>
	<div style="width:100%;height:100px;clear:both;"></div>
</div>

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
	<input class="sdtext" type="text" name="send_text" placeholder="輸入訊息" onfocus="this.placeholder = ''" onblur="this.placeholder = '輸入公告'" ><input class="sdbtn" type="submit" name="pushText" value="發送">
	<script>document.getElementsByName("send_text")[0].focus();</script>
</form>

</body>

</html>
