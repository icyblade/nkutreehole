<?php
require_once './config/config.php';
require_once './class/database.php';

/**
  * ����������
  * @version $Id$
  */
class treeholeCommand {
	/**
	  * textResponse �����û�������������
	  * @param string $fromUserName
	  * @param string $createTime
	  * @param string $content
	  * @return array (����Ҫ���͵���Ϣ, ΢��Ҫ���͵���Ϣ)
	  */
	public function textResponse($fromUserName,$createTime,$content,$msgId) {
		if (preg_match($GLOBALS[chat_pattern],$content)) {
			return array (null ,null);
		}
		if ($content == "h") {
			return array (null ,$GLOBALS[wechat_command_h]);
		}
		if ($content == "hh") {
			return array (null ,$GLOBALS[wechat_command_hh]);
		}
		if ($content == "rule") {
			return array (null ,$GLOBALS[wechat_command_rule]);
		}
		/*
		if (preg_match($GLOBALS[reply_pattern],$content)) {
			return array (null ,null);
		}
		*/
		/*
		foreach ($GLOBALS[wechat_command] as $k=>$v) {
			if ($k == $content)
				return array (null ,$v);
		}
		*/
		if ($createTime-getLastCreateTime($fromUserName)<$GLOBALS[timePeriod]) {
			return array (null ,sprintf($GLOBALS[wechat_too_quick],$GLOBALS[timePeriod]-$createTime+getLastCreateTime($fromUserName)));
		}
		if (mb_strlen($content)>$GLOBALS[maxContent]) {
			return array (null ,$GLOBALS[wechat_header].$GLOBALS[wechat_too_long]);
		} else if (mb_strlen($content)<$GLOBALS[minContent]) {
			return array (null ,$GLOBALS[wechat_header].$GLOBALS[wechat_too_short]);
		} else {
			return array ($content.$GLOBALS[renren_feet]/*.base_convert($msgId,10,36)*/ ,$GLOBALS[wechat_header]/*."����ϢIDΪ".base_convert($msgId,10,36)*/);
		}
	}
}

?>