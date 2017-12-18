<?php

	session_start();
	
	if(empty($_SESSION["Account"])){		
		header('Location: login.php');		
	}
	
	if(!empty($_POST['ChooseUser'])){
		$_SESSION['ChooseUser'] = $_POST['ChooseUser'];
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

var HeightTmp;

function AutoRefresh(){
	Change();
	setTimeout("AutoRefresh()", 800);
}

function Change()
{
	var ifr1=document.getElementById("load_message1");
	var ifr2=document.getElementById("load_message2");

	if(ifr1.style.display=='none')  {
		ifr1.src = ifr1.src;
		ifr1.style.display='';
		setIframeHeight(window.top.document.getElementById('load_message1'));
		setTimeout("document.getElementById('load_message2').style.display='none'", 200);
	}else{
		ifr2.src = ifr2.src;
		ifr2.style.display='';
		setIframeHeight(window.top.document.getElementById('load_message2'));
		setTimeout("document.getElementById('load_message1').style.display='none'", 200);
	}

}


function setIframeHeight(ifrm){
	var ifrdiv=document.getElementById("ifrdiv");
	var doc = ifrm.contentDocument? ifrm.contentDocument:
    ifrm.contentWindow.document;
    var RestHeight=ifrm.style.height;
    ifrm.style.height = "10px";
    var NewHeight = getDocHeight(doc) + 10;
    if (NewHeight>20){
		ifrm.style.height=(NewHeight) + "px";
    } else {
		ifrm.style.height=(RestHeight) + "px";
    }
		
	if(HeightTmp != ifrm.style.height){		
		var ifrdiv_scrollTop = ifrdiv.scrollTop;
		movescroll(ifrdiv_scrollTop);
		HeightTmp = ifrm.style.height;
	}

}

function getDocHeight(doc) {
    doc = doc || document;
    var body = doc.body, html = doc.documentElement;
    var height = Math.max( body.scrollHeight, body.offsetHeight, html.clientHeight,html.scrollHeight, html.offsetHeight );
    return height;
}

function movescroll(ifrdiv_scrollTop){
	var ifrdiv=document.getElementById("ifrdiv");
	if((ifrdiv_scrollTop < ifrdiv.scrollHeight) && (ifrdiv.scrollTop==ifrdiv_scrollTop)){
		ifrdiv_scrollTop=ifrdiv_scrollTop+Math.ceil((ifrdiv.scrollHeight-ifrdiv_scrollTop)/25);
		ifrdiv.scrollTop=ifrdiv_scrollTop;
		setTimeout("movescroll("+ifrdiv_scrollTop+")", ifrdiv.scrollTop/100);	
	}
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
