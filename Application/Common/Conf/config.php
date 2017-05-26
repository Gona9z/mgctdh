<?php
//'配置项'=>'配置值'
// ini_set("display_errors", "Off");
// ini_set("magic_quotes_gpc","NO");
// date_default_timezone_set("PRC");
$sysArr = array(
    // 设置禁止访问的模块列表
    'MODULE_DENY_LIST'      =>  array('Common','Runtime'),
    // 设置允许访问的模块列表
    'MODULE_ALLOW_LIST'    =>    array('Home','Admin','public','Api'),
    'DEFAULT_MODULE'       =>    'Home',
    'URL_CASE_INSENSITIVE'  =>    true,     // URL地址是否不区分大小写
    'URL_MODEL'             =>    2,        // URL访问模式
    'LANG_SWITCH_ON'        =>    false,     // 默认关闭多语言包功能
    'LANG_AUTO_DETECT'      =>    false,    // 自动侦测语言 开启多语言功能后有效
    'TMPL_DETECT_THEME'     =>    false,    // 自动侦测模板主题
    'DATA_CACHE_TIME'	    =>    600,      // 数据缓存有效期
    'DATA_CACHE_TYPE'		=>    'File',   // 数据缓存类型
    'TMPL_CACHE_ON'         =>    true,    // 默认开启模板编译缓存 false 的话每次都重新编译模板
    'ACTION_CACHE_ON'       =>    true,    // 默认关闭Action 缓存
    'HTML_CACHE_ON'         =>    true,    // 默认关闭静态缓存
    'TMPL_STRIP_SPACE'      =>    false,   // 是否去除模板文件里面的html空格与换行
    //页面Trace调试工具
    'SHOW_PAGE_TRACE'	=>	false,
);

$databaseArr = array(
	/* 数据库设置 */
	'DB_TYPE'               =>  'mysql',     // 数据库类型
	'DB_HOST'               =>  '127.0.0.1', // 服务器地址
	'DB_NAME'               =>  'db_axd',          // 数据库名
	'DB_USER'               =>  'root',      // 用户名
	'DB_PWD'                =>  '',          // 密码
	'DB_PORT'               =>  '3306',        // 端口
	'DB_PREFIX'             =>  'axd_',    // 数据库表前缀
);


$otherArr = array(
//    'PRO_NAME'  =>  'Ueditor测试',
    'PRO_NAME'  =>  'A梦校园',
	/* 模板相关配置 */
	'TMPL_PARSE_STRING' => array (
			'__IMG__' => __ROOT__.'/Public/img',
			'__CSS__' => __ROOT__.'/Public/css',
			'__JS__' => __ROOT__.'/Public/js',
	),
	//网站路径返回//C('BASE_URL')
//	'WEB_URL'	=>	'http://localhost:8088/axd/',
//	'WEB_URL'	=>	'http://192.168.0.187:8088/axd/',
// 	'WEB_URL'	=>	'http://'.$_SERVER['SERVER_NAME'].'/axd/',
 	'WEB_URL'	=>	'http://demo.itwukai.com/',
    //助通短信-请求链接
    'VCODE_URL' => 'http://www.ztsms.cn/sendNSms.do',
    //助通短信-用户名
    'ZT_SMS_USERNAME'   =>  'qirun666',
    //助通短信-密码
    'ZT_SMS_PASSWORD'   =>  '6x9Rc9pY',
    //===========================微信相关
    //微信refresh_token
    'WX_GET_INFO'  =>   'https://api.weixin.qq.com/sns/userinfo',
    //===========================微信相关
    //QQ
    'QQ_GET_INFO'  =>   'http://openapi.sparta.html5.qq.com/v3/user/get_info ',
//    'QQ_GET_INFO'  =>   'http://openapi.tencentyun.com/v3/user/get_info ',
    //===========================微博相关
    'WB_GET_INFO'  => 'https://api.weibo.com/2/users/show.json',
    //==================极光推送相关
    'JG_APP_KEY'   =>  'c32cb6d465f0ae8a7eb4c8f3',
    'JG_MASTER_SECRET'   =>  '4a7c33631f5e8739ea9a1130',
    //-=======应用宝下载地址
    'TC_YYB'    =>  'http://a.app.qq.com/o/simple.jsp?pkgname=com.tencent.mm',
);

$language = include APP_PATH.'Message/Language.php';

return array_merge($sysArr, $databaseArr, $otherArr);
?>