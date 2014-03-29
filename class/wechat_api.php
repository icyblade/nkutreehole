<?php
require_once './config/config.php';
require_once './class/database.php';
/**
 * 微信API类
 * @version $Id$
 * 
 */
class wechatAPI {
	/**
	 * valid	验证微信接口
	 * @param null 
	 * @return 验证成功时返回 $echoStr，失败时返回 null
	 *
	 */
	public function valid() {
		$echoStr = $_GET["echostr"];

		//valid signature , option
		if ($this->checkSignature()) {
			echo $echoStr;
		} else {
			//exit;
		}
	}
	
	/**
	 * getResponse 获取微信服务器POST过来的XML
	 * @param null
	 * @return array 成功时返回 array ($toUserName,$fromUserName,$createTime,$msgType,$content,$msgId,$picUrl,
	 *								$location_x,$location_y,$scale,$lable,$title,$description,$url,$event,$eventkey)
	 *
	 */
	public function getResponse() {
		//get post data, May be due to the different environments
        $postStr = file_get_contents("php://input");	// might be GET!

		//extract post data
		if (!empty($postStr)) {
			$postXML = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
			
			$toUserName = $postXML->ToUserName;
			$fromUserName = $postXML->FromUserName;
			$createTime = $postXML->CreateTime;
			$msgType = $postXML->MsgType;
			$content = trim($postXML->Content);
			$msgId = $postXML->MsgId;
			$picUrl = $postXML->PicUrl;
			$location_x = $postXML->Location_X;
			$location_y = $postXML->Location_Y;
			$scale = $postXML->Scale;
			$lable = $postXML->Lable;
			$title = $postXML->Title;
			$description = $postXML->Description;
			$url = $postXML->Url;
			$event = $postXML->Event;
			$eventKey = $postXML->EventKey;
			$mediaId = $postXML->MediaId;
			$format = $postXML->Format;
			$thumbMediaId = $postXML->ThumbMediaId;
			
			insert_database($toUserName,$fromUserName,$createTime,$msgType,$content,$msgId,$picUrl,$location_x,$location_y,$scale,$lable,$title,$description,$url,$event,$eventKey,$mediaId,$format,$thumbMediaId,"0",$postStr);
			
			return array ($toUserName,$fromUserName,$createTime,$msgType,$content,$msgId,$picUrl,$location_x,$location_y,$scale,$lable,$title,$description,$url,$event,$eventKey,$mediaId,$format,$thumbMediaId);
		} else {
			return;
		}
	}
	
	/**
	 * replyText 向用户发送Text
	 * @param string $toUserName
	 * @param string $fromUserName
	 * @param string $content
	 * @return null
	 *
	 */
	public function replyText($toUserName,$fromUserName,$content) {
		$textTpl = "<xml>
					<ToUserName><![CDATA[%s]]></ToUserName>
					<FromUserName><![CDATA[%s]]></FromUserName>
					<CreateTime>%s</CreateTime>
					<MsgType><![CDATA[%s]]></MsgType>
					<Content><![CDATA[%s]]></Content>
					<FuncFlag>0</FuncFlag>
					</xml>";
		$time = time();
		$resultStr = sprintf($textTpl, $fromUserName, $toUserName, $time, "text", $content);		// inverse toUserName & fromUserName
		echo $resultStr;
	}
	
	/*
	public function acceptedContent($content) {
		if  (
				(mb_strlen($content)<=$GLOBALS[maxContent]) &&
				(mb_strlen($content)>= $GLOBALS[minContent])
			)
				return true;		
		return false;
	}
	*/
	
	/**
	 * checkSignature	验证微信接口
	 * @param null 
	 * @return bool
	 *
	 */
	private function checkSignature() {
		$signature = $_GET["signature"];
		$timestamp = $_GET["timestamp"];
		$nonce = $_GET["nonce"];

		$token = $TOKEN;
		$joinedArr = array($token, $timestamp, $nonce);
		sort($joinedArr);
		$joinedStr = implode($joinedArr);
		$joinedStr = sha1($joinedStr);

		if($joinedStr == $signature){
			return true;
		} else {
			return false;
		}
	}
}
?>