<?php
/* 是否开启调试模式 */
$DEBUG = 0;

/* 微信参数 */
$TOKEN = "";					// 微信公众平台开发模式接口TOKEN

/* 人人参数 */
$app_id = "";					// 人人 APP ID
$app_secret = "";				// 人人 APP Secret Key
$my_url = "";	// 人人 Redirect URL
$grant_type = "authorization_code";  							// 支持的授权类型
$access_token = "";	// 人人 Access Token
$renren_api_url = "https://api.renren.com/restserver.do";		// 人人 API 的 URL
//$page_id = "";				// 测试版 pageID
$page_id = "";					// 正式版 pageID

/* 树洞参数 */
$chat_pattern = "/^(\/|／|\\\\|＼)(\/|／|\\\\|＼)\S*/";						// 双斜杠表示和主页君聊天
//$reply_pattern = "/\#\#\S*/";
$minContent = 45;							// 最短信息的长度（一个中文算3个，英文算1个）
$maxContent = 600;							// 最长信息的长度（一个中文算3个，英文算1个）
$timePeriod = 1800;							// 两次发消息的间隔（秒）

/* 人人post和微信回复相关字符串 */
$renren_feet = "--------通过微信号nkutreehole发布";				// 人人post最后加上的东西
$wechat_header = "收到～";					// 微信回复最后加上的东西
$wechat_too_long = "消息太长了～";			// 微信过长的回复
$wechat_too_short = "消息太短了～";		// 微信过短的回复
$wechat_picture = "暂时不支持图片～";
$wechat_location = "暂时不支持地理位置～";
$wechat_link = "暂时不支持链接～";
$wechat_subscribe = "欢迎关注～请在进入树洞前至人人公共主页浏览完整的树洞规则\n聊天请在消息前加上双斜杠(//)\n发送h获取简短帮助，发送hh获取完整帮助，发送rule获取树洞规则";						// 微信关注的回复
$wechat_unsubscribe = "";						// 微信取消关注
$wechat_voice = "暂时不支持语音～";
$wechat_video = "暂时不支持视频～";
$wechat_other = "暂时不支持其他奇奇怪怪的东西～";
$wechat_too_quick = "发太快了，休息一下～请再等%s秒";

/* 微信命令 */
$wechat_command = array ("h" => $wechat_command_h ,"hh" => $wechat_command_hh ,"rule" => $wechat_command_rule);
$wechat_command_h = sprintf("·消息前若有//则此消息不会被同步到人人（注意是英文双斜杠）\n·字数限制为%d个汉字<=消息长度<=%d个汉字，3个英文或数字或英文符号算1个汉字\n·两条消息至少间隔%d秒（双斜杠和h等命令不算在内）\n·暂时不支持微信表情\n\n发送hh获取完整帮助，发送rule获取树洞规则",$minContent/3,$maxContent/3,$timePeriod);
$wechat_command_hh = sprintf("微信帮助\n·微信账号是nkutreehole\n·自动发布状态下，您所发布的内容会实时同步到人人公共主页NKU树洞上。所以，为了不造成不必要的麻烦，在发送前请仔细审查自己的内容是否符合发布内容规则。\n·字数限制为%s-%s字（此处为汉字）。3个英文或数字算作一个汉字，英文标点算作英文，中文标点算作中文。\n·每人每两条状态的发送时间间隔为%s秒。\n·暂时不支持发布语音、图片、视频、位置等。不支持微信表情，但支持人人表情，具体请自行查阅人人表情符号。\n·如果您在发送的内容前加上英文的双斜杠（请注意，必须是英文的），此条状态将不会同步到人人上。（例：//树洞君我喜欢你）。此类状态不受字数与时间的限制。\n·发送h获取简短帮助，发送rule获取树洞规则",$minContent/3,$maxContent/3,$timePeriod);
$wechat_command_rule = "1.禁止针对国家主权与人民的的攻击性主题和内容\n2.禁止淫秽、色情、赌博、诅咒、暴力、凶杀、恐怖或者教唆犯罪的内容\n3.禁止任何基于种族、国家、民族、肤色、宗教、性别、年龄、性取向、身体或精神障碍的歧视性言辞\n4.禁止社团宣传、公共主页宣传、社团活动宣传、寻物启事、明文征友等一切不属于树洞的内容\n5.不得发布任何谩骂、侮辱、诽谤、攻击骚扰他人的内容（包括隐讳暗示以及敏感词汇以及其他未涉及事宜）\n6.不得涉及个人隐私，不经他人同意不得暴露他人的私人信息、联系方式等\n7.不得出现QQ号、QQ群号、手机号和邮箱\n8.不得发布带有重口味，无节操，粗口或脏话的内容\n9.树洞主页君及程序员君拥有对NKU树洞的最终解释权\noo.禁止用sqlmap等奇奇怪怪的东西跑树洞（by 程序员君）\n\n发送h获取简短的帮助，发送hh获取完整帮助";


/* 数据库相关 */
$db_name = "";
$table_name = "";

/* 用户相关 */
$wechat_users = array(
					'' => 'admin',
    				'' => 'blacklist'
					);
?>
