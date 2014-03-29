<?php
require_once './config/config.php';

/**
 * ����API��
 * @version $Id$
 * 
 */
class renrenAPI {
	/**
	 * statusSet �� $content ״̬��������
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
	  * addComment �� $content ��ӵ� $status_id ״̬��
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
	  * statusGets ��ȡ�����״̬�б�
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
	  * getStatusId �� $commentsXML ���ȡ $msgId ��Ӧ����Ϣ�� status_id
	  * @param SimpleXMLElement $commentsXML
	  * @param string $msgId
	  * @return �ɹ��򷵻� status_id��ʧ�ܷ��� -1
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