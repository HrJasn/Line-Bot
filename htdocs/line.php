<?php

function push($channel_access_token,$user_id,$content_type,$message) {

	$header = ["Content-Type: application/json", "Authorization: Bearer {" . $channel_access_token . "}"];
	 	
	$url = "https://api.line.me/v2/bot/message/push";
	
	$data = ["to" => $user_id, "messages" => array(["type" => "text", "text" => $message])];
	
	$context = stream_context_create(array(
	"http" => array("method" => "POST", "header" => implode(PHP_EOL, $header), "content" => json_encode($data), "ignore_errors" => true)
	));
	file_get_contents($url, false, $context);
	
	return header('Location: admin.php');
		
}

function reply($content_type, $message) {
	 
	 	global $header, $from, $receive;
	 	
		$url = "https://api.line.me/v2/bot/message/push";
		
		$data = ["to" => $from, "messages" => array(["type" => "text", "text" => $message])];
		
		switch($content_type) {
		
			case "text" :
				$content_type = "文字訊息";
				$data = ["to" => $from, "messages" => array(["type" => "text", "text" => $message])];
				break;
				
			case "image" :
				$content_type = "圖片訊息";
				$message = getObjContent("jpeg");   // 讀取圖片內容
				$data = ["to" => $from, "messages" => array(["type" => "image", "originalContentUrl" => $message, "previewImageUrl" => $message])];
				break;
				
			case "video" :
				$content_type = "影片訊息";
				$message = getObjContent("mp4");   // 讀取影片內容
				$data = ["to" => $from, "messages" => array(["type" => "video", "originalContentUrl" => $message, "previewImageUrl" => $message])];
				break;
				
			case "audio" :
				$content_type = "語音訊息";
				$message = getObjContent("mp3");   // 讀取聲音內容
				$data = ["to" => $from, "messages" => array(["type" => "audio", "originalContentUrl" => $message[0], "duration" => $message[1]])];
				break;
				
			case "location" :
				$content_type = "位置訊息";
				$title = $receive->events[0]->message->title;
				$address = $receive->events[0]->message->address;
				$latitude = $receive->events[0]->message->latitude;
				$longitude = $receive->events[0]->message->longitude;
				$data = ["to" => $from, "messages" => array(["type" => "location", "title" => $title, "address" => $address, "latitude" => $latitude, "longitude" => $longitude])];
				break;
				
			case "sticker" :
				$content_type = "貼圖訊息";
				$packageId = $receive->events[0]->message->packageId;
				$stickerId = $receive->events[0]->message->stickerId;
				$data = ["to" => $from, "messages" => array(["type" => "sticker", "packageId" => $packageId, "stickerId" => $stickerId])];
				break;
				
			default:
				$content_type = "未知訊息";
				break;
	   	}
		
		$context = stream_context_create(array(
		"http" => array("method" => "POST", "header" => implode(PHP_EOL, $header), "content" => json_encode($data), "ignore_errors" => true)
		));
		file_get_contents($url, false, $context);

}

function getObjContent($filenameExtension){
		
	global $channel_access_token, $receive;
	
	$objID = $receive->events[0]->message->id;
	$url = 'https://api.line.me/v2/bot/message/'.$objID.'/content';
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Authorization: Bearer {' . $channel_access_token . '}',
	));
	
	$json_content = curl_exec($ch);
	curl_close($ch);

	if (!$json_content) {
		return false;
	}
	
	$fileURL = './update/'.$objID.'.'.$filenameExtension;
	$fp = fopen($fileURL, 'w');
	fwrite($fp, $json_content);
	fclose($fp);
		
	if ($filenameExtension=="mp3"){
	    //使用getID3套件分析mp3資訊
		require_once("getID3/getid3/getid3.php");
		$getID3 = new getID3;
		$fileData = $getID3->analyze($fileURL);
		//$audioInfo = var_dump($fileData);
		$playSec = floor($fileData["playtime_seconds"]);
		$re = array($myURL.$objID.'.'.$filenameExtension, $playSec*1000);
		return $re;
	}
	return $myURL.$objID.'.'.$filenameExtension;
}

//header('Location: index.php');

?>