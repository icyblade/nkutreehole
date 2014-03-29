<?php
require_once './config/config.php';
require_once './class/renren_api.php';
require_once './class/wechat_api.php';
require_once './class/treehole_api.php';
require_once './class/database.php';

$wechatObj = new wechatAPI();
$renrenObj = new renrenAPI();
$treeholeObj = new treeholeCommand();

$wechatObj->valid();

list($toUserName,$fromUserName,$createTime,$msgType,$content,$msgId,$picUrl,$location_x,$location_y,$scale,$lable,$title,$description,$url,$event,$eventkey,$mediaId,$format,$thumbMediaId) = $wechatObj->getResponse();

foreach($GLOBALS[wechat_users] as $fromUser=>$privilege) {
	if ($fromUser == $fromUserName) {
		switch ($privilege) {
			case 'blacklist':
				exit;
				break;
			case 'admin':
				// put ADMIN test message here
				//$renrenObj->statusSet($content);
				//exit;
				break;
		}
		break;
	}
	if ($GLOBALS[DEBUG]) {
		$wechatObj->replyText($toUserName,$fromUserName,"系统正在维护中 Zzzz");exit;
	}
}

if ($msgType == "text") {
	list($renrenResponse,$wechatResponse) = $treeholeObj->textResponse($fromUserName,$createTime,$content,$msgId);
	if ($renrenResponse) {
		$renrenObj->statusSet($renrenResponse);
		sentToRenren($msgId);
	}
	if ($wechatResponse) {
		$wechatObj->replyText($toUserName,$fromUserName,$wechatResponse);
	}
} else if ($msgType == "image") {
	$wechatObj->replyText($toUserName,$fromUserName,$GLOBALS[wechat_picture]);
} else if ($msgType == "location") {
	$wechatObj->replyText($toUserName,$fromUserName,$GLOBALS[wechat_location]);
} else if ($msgType == "link") {
	$wechatObj->replyText($toUserName,$fromUserName,$GLOBALS[wechat_link]);	
} else if ($msgType == "event"){
	if ($event == "subscribe")
		$wechatObj->replyText($toUserName,$fromUserName,$GLOBALS[wechat_subscribe]);
} else if ($msgType == "voice"){
	$wechatObj->replyText($toUserName,$fromUserName,$GLOBALS[wechat_voice]);
} else if ($msgType == "video") {
	$wechatObj->replyText($toUserName,$fromUserName,$GLOBALS[wechat_video]);
} else if ($msgType){
	$wechatObj->replyText($toUserName,$fromUserName,$GLOBALS[wechat_other]);
} else {
	exit;
}
?>

