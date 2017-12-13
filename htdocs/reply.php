<?php

error_reporting(0);

/* 輸入申請的Line Developers 資料  */
	$channel_id = "1549672834";
	$channel_secret = "3f330e05765e49b96f1a25a787252779";
	$channel_access_token = "bxFwr3Y8HcIg2vkudiwGpjVy7bIXcJQqtH0fYIcaTyFD1TFIV3CC8SSDDNkFWql3dDuwpWUwjSV4SqnwEFNMkvkJixqkTajgOR/w9mziLCq0auUlLDOq2cbu42CLBaPG8Z9imBTsNX6A05Kq2cpOvAdB04t89/1O/w1cDnyilFU=";

	$myURL = "https://hrjasn.asuscomm.com/upload/";


//  當有人發送訊息給bot時 我們會收到的json
// 	{
// 	  "events": 
// 	  [
// 		  {
// 			"replyToken": "nHuyWiB7yP5Zw52FIkcQobQuGDXCTA",
// 			"type": "message",
// 			"timestamp": 1462629479859,
// 			"source": {
// 				 "type": "user",
// 				 "userId": "U206d25c2ea6bd87c17655609a1c37cb8"
// 			 },
// 			 "message": {
// 				 "id": "325708",
// 				 "type": "text",
// 				 "text": "Hello, world"
// 			  }
// 		  }
// 	  ]
// 	}

// if( !get_magic_quotes_gpc() )
// {
    // if( is_array($_GET) )
    // {
        // while( list($k, $v) = each($_GET) )
        // {
            // if( is_array($_GET[$k]) )
            // {
                // while( list($k2, $v2) = each($_GET[$k]) )
                // {
                    // $_GET[$k][$k2] = addslashes($v2);
                // }
                // @reset($_GET[$k]);
            // }
            // else
            // {
                // $_GET[$k] = addslashes($v);
            // }
        // }
        // @reset($_GET);
    // }
 
    // if( is_array($_POST) )
    // {
        // while( list($k, $v) = each($_POST) )
        // {
            // if( is_array($_POST[$k]) )
            // {
                // while( list($k2, $v2) = each($_POST[$k]) )
                // {
                    // $_POST[$k][$k2] = addslashes($v2);
                // }
                // @reset($_POST[$k]);
            // }
            // else
            // {
                // $_POST[$k] = addslashes($v);
            // }
        // }
        // @reset($_POST);
    // }
 
    // if( is_array($_COOKIE) )
    // {
        // while( list($k, $v) = each($_COOKIE) )
        // {
            // if( is_array($_COOKIE[$k]) )
            // {
                // while( list($k2, $v2) = each($_COOKIE[$k]) )
                // {
                    // $_COOKIE[$k][$k2] = addslashes($v2);
                // }
                // @reset($_COOKIE[$k]);
            // }
            // else
            // {
                // $_COOKIE[$k] = addslashes($v);
            // }
        // }
        // @reset($_COOKIE);
    // }
// }
	 
if(!empty(file_get_contents("php://input"))){ 

	include("db_include.php");
	include("line.php");

	$db = mysqli_connect($DB_Server,$DB_User,$DB_Passwd);
	mysqli_select_db($db,"line");
	mysqli_query($db,"SET NAMES 'utf8'");

	if(!empty($_SERVER['HTTP_CLIENT_IP'])){
	   $myip = $_SERVER['HTTP_CLIENT_IP'];
	}else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
	   $myip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	}else{
	   $myip = $_SERVER['REMOTE_ADDR'];
	}

	// 將收到的資料整理至變數
	$receive = json_decode(file_get_contents("php://input"));
	
	// 讀取收到的訊息內容
	$text = $receive->events[0]->message->text;
	
	// 讀取訊息來源的類型 	[user, group, room]
	$type = $receive->events[0]->source->type;
	
	// 由於新版的Messaging Api可以讓Bot帳號加入多人聊天和群組當中
	// 所以在這裡先判斷訊息的來源
	if ($type == "room")
	{
		// 多人聊天 讀取房間id
		$from = $receive->events[0]->source->roomId;
	} 
	else if ($type == "group")
	{
		// 群組 讀取群組id
		$from = $receive->events[0]->source->groupId;
	}
	else
	{
		// 一對一聊天 讀取使用者id
		$from = $receive->events[0]->source->userId;
		mysqli_query($db,"INSERT INTO users (UserID) VALUES ('".$from."')");
	}
	
	// 讀取訊息的型態 [Text, Image, Video, Audio, Location, Sticker]
	$content_type = $receive->events[0]->message->type;
	
	// 準備Post回Line伺服器的資料 
	$header = ["Content-Type: application/json", "Authorization: Bearer {" . $channel_access_token . "}"];
	
	// 回覆訊息
	reply($content_type, $text);
	
//$text = mysqli_real_escape_string($db,$text);

mysqli_query($db,"INSERT INTO message (src,IP,Cnt_Type,Cnt_ID,Msg,MsgType,MsgText) 
VALUES ('receive','".$myip."','".$type."','".$from."','".file_get_contents("php://input")."','".$content_type."','".$text."')");
mysqli_close($db);

}
			
header('Location: index.php');

?>