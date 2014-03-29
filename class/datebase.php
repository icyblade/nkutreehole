<?php
require_once './config/config.php';

/**
  * insert_database 将下面一大堆东西 INSERT 到数据库
  * @param string $toUserName,$fromUserName,$createTime,$msgType,$content,$msgId,$picUrl,$location_x,$location_y,$scale,$lable,$title,$description,$url,$event,$eventkey,$mediaId,$format,$thumbMediaId,$isSentToRenren,$postStr
  * @return void
  *
  */
function insert_database($toUserName,$fromUserName,$createTime,$msgType,$content,$msgId,$picUrl,$location_x,$location_y,$scale,$lable,$title,$description,$url,$event,$eventkey,$mediaId,$format,$thumbMediaId,$isSentToRenren,$postStr) {
	$mysql = new SaeMysql();
	$contentPreInj = addslashes($content);
	$contentPreInj = str_replace("_","\_",$contentPreInj);
	$contentPreInj = str_replace("%","\%",$contentPreInj);
	$sql = "INSERT INTO `".$GLOBALS[db_name]."`.`".$GLOBALS[table_name]."` (`toUserName` ,`fromUserName` ,`createTime` ,`msgType` ,`content` ,`msgId` ,`picUrl` ,`location_x`, `location_y` ,`scale` ,`lable` ,`title` ,`description` ,`url` ,`event` ,`eventKey` ,`mediaId` ,`format` ,`thumbMediaId` ,`isSentToRenren` ,`postStr`) VALUES ('".$toUserName."', '".$fromUserName."', '".$createTime."', '".$msgType."', '".$contentPreInj."', '".$msgId."', '".$picUrl."', '".$location_x."', '".$location_y."', '".$scale."', '".$lable."', '".$title."', '".$description."', '".$url."', '".$event."', '".$eventKey."', '".$mediaId."', '".$format."', '".$thumbMediaId."', '".$isSentToRenren."', '".$postStr."')";
	$mysql->runSql( $sql );
	/*
	if( $mysql->errno() != 0 ) {
		die( "Error:" . $mysql->errmsg() );
	}
	*/
	$mysql->closeDb();
}

/**
  * getLastCreateTime 获取 $openid 上一次发送信息的 $createTime
  * @param string $openid
  * @return $createTime
  *
  */
function getLastCreateTime($openid) {
	$mysql = new SaeMysql();
	$sql = sprintf("SELECT createTime FROM `%s` WHERE `fromUserName` = '%s' AND `isSentToRenren` = '1' ORDER BY `createTime`  DESC LIMIT 0,1",
	$GLOBALS[table_name],$openid);
	$lastCreateTime = $mysql-> getVar($sql);
	/*
	if ( $mysql->errno() != 0 ) {
		die( "Error:" . $mysql->errmsg() )
	}
	*/
	$mysql->closeDb();
	return $lastCreateTime;
}

/**
  * sentToRenren 发送到人人后修改数据库内的 isSentToRenren 为 true
  * @param string $msgId
  * @return void
  *
  */
function sentToRenren($msgId) {
	$mysql = new SaeMysql();
	$sql = sprintf("UPDATE `%s`.`%s` SET `isSentToRenren` = '1' WHERE `msgId` = '%s'",$GLOBALS[db_name],$GLOBALS[table_name],intval($msgId));
	$mysql->runSql($sql);
	$mysql->closeDb();
	return;
}

/**
  * mysqlTrim 转义字符串 $str
  * @param string $str
  * @return 转义后的字符串
  *
  */
function mysqlTrim($str) {
	return str_replace("%","\%",str_replace("_","\_",addslashes($str)));
}
?>