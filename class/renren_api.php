<?php
require_once './config/config.php';

/**
 * 人人API类
 * @version $Id$
 * 
 */
class renrenAPI {
	/**
	 * statusSet 将 $content 状态发到人人
	 * @param string $content
	 * @return void
	 *
	 */
	public function statusSet($content) {
		$renrenPost = http_build_query(
						array(
								'v' => '1.0',
								'access_token' => $GLOBALS[access_token],
								'method' => 'status.set',
								'page_id' => $GLOBALS[page_id],
								'status' => $content,
							)
					);
		$postData = stream_context_create(array('http' =>
						array(
							'method'  => 'POST',
							'header'  => 'Content-type: application/x-www-form-urlencoded',
							'content' => $renrenPost
						)
					));
		file_get_contents($GLOBALS[renren_api_url], false, $postData);
	}
	
	/**
	  * addComment 将 $content 添加到 $status_id 状态下
	  * @param string $openid
	  * @return void
	  *
	  */
	public function addComment($status_id,$content) {
		$renrenPost = http_build_query(
						array(
								'v' => '1.0',
								'access_token' => $GLOBALS[access_token],
								'method' => 'status.addComment',
								'page_id' => $GLOBALS[page_id],
								'status_id' => $status_id,
								'status' => $content,
							)
					);
		$postData = stream_context_create(array('http' =>
						array(
							'method'  => 'POST',
							'header'  => 'Content-type: application/x-www-form-urlencoded',
							'content' => $renrenPost
						)
					));
		file_get_contents($GLOBALS[renren_api_url], false, $postData);
	}
	
	/**
	  * statusGets 获取最近的状态列表
	  * @param void
	  * @return SimpleXMLElement
	  *
	  */
	public function statusGets() {
		$renrenPost = http_build_query(
						array(
								'v' => '1.0',
								'access_token' => $GLOBALS[access_token],
								'method' => 'status.gets',
								'page_id' => $GLOBALS[page_id],
							)
					);
		$postData = stream_context_create(array('http' =>
						array(
							'method'  => 'POST',
							'header'  => 'Content-type: application/x-www-form-urlencoded',
							'content' => $renrenPost
						)
					));
		$responseStr = file_get_contents($GLOBALS[renren_api_url], false, $postData);
		return simplexml_load_string($responseStr, 'SimpleXMLElement', LIBXML_NOCDATA);
	}
	
	/**
	  * getStatusId 从 $commentsXML 里获取 $msgId 对应的消息的 status_id
	  * @param SimpleXMLElement $commentsXML
	  * @param string $msgId
	  * @return 成功则返回 status_id，失败返回 -1
	  *
	  */
	public function getStatusId($commentsXML,$msgId) {
		$len = strlen($msgId);
		foreach($commentsXML->status as $status)
			if (substr($status->message,0-$len,$len) == $msgId)
				return $status->status_id;
		return -1;
	}
}
?>