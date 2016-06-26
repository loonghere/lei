<?php
/**
 * 基础函数库
 * Lei框架
 * @author：王雷 loonghere@qq.com
 */

/**
 * 自定义自动加载函数
 * 需要注册
 */
function loader($class) {
	$find = 0;
	$autoload = require __DIR__ . '/config/autoload.php';
	foreach ($autoload as $key => $val) {
		if (file_exists(__DIR__ . '/' . $val . '/' . $class . '.php')) {
			require __DIR__ . '/' . $val . '/' . $class . '.php';
			$find = 1;
			break;
		}
	}
	if (!$find) die($class . '加载失败');
}
/**
 * 过滤数据
 */
function doAddslashes() {
	if (!get_magic_quotes_gpc()) {
		$_GET = addslashesDeep($_GET);
		$_POST = addslashesDeep($_POST);
		$_COOKIE = addslashesDeep($_COOKIE);
		$_REQUEST = addslashesDeep($_REQUEST);
	}
}
/**
 * 递归去除转义字符
 */
function addslashesDeep($value) {
	return is_array($value) ? array_map('addslashesDeep', $value) : addslashes($value);
}
/**
 * 初始化session，设置session保存路径
 */
function initSession() {
    $path = __DIR__ . '/../storage/sessions';
    if (!createFolder($path)) die('无法生成session存储文件夹');
    ini_set('session.save_path', $path);
    session_start();
}
/**
 * 获取客户端IP
 */
function getIp() {
    if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
        $ip = getenv("HTTP_CLIENT_IP");
    else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
        $ip = getenv("HTTP_X_FORWARDED_FOR");
    else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
        $ip = getenv("REMOTE_ADDR");
    else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
        $ip = $_SERVER['REMOTE_ADDR'];
    else
        $ip = '0.0.0.0';
    return $ip;
}
/**
 * 页面跳转
 */
function reDirect($directUrl) {
	header("Location: $directUrl");
	exit;
}
/**
 * 获取固定长度的随机字符串，可以用于生产用户组合密码、生成短信验证码等
 * type=0 字母+数字
 * type=1 纯数字
 */
function getSalt($length = 4, $type = 0) {
    $chars = !$type ? 'abcdefghijklmnopqrstuvwxyz0123456789' : '0123456789';
    $str = '';
    for ($i = 0; $i < $length; $i++) {
        $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
    }
    return $str;
}
/**
 * 根据限定的字数截取汉字长度，utf8下1个汉字占3个字符
 * 本函数智能截取，防止出现乱码
 */
function getShort($str, $length = null) {
    if (empty($str)) return ''; // 如果字符串为空直接返回空值即可，不需下面运算
    $start = 0;
    // 先正常截取一遍.
    $res = substr($str, $start, $length);
    $strlen = strlen($str);
    // 接着判断头尾各6字节是否完整(不残缺)
    // 如果参数start是正数
    if ($start >= 0) {
        // 往前再截取大约6字节
        $next_start = $start + $length; // 初始位置
        $next_len = $next_start + 6 <= $strlen ? 6 : $strlen - $next_start;
        $next_segm = substr($str, $next_start, $next_len);
        // 如果第1字节就不是 完整字符的首字节, 再往后截取大约6字节
        $prev_start = $start - 6 > 0 ? $start - 6 : 0;
        $prev_segm = substr($str, $prev_start, $start - $prev_start);
    } else {
        // start是负数
        // 往前再截取大约6字节
        $next_start = $strlen + $start + $length; // 初始位置
        $next_len = $next_start + 6 <= $strlen ? 6 : $strlen - $next_start;
        $next_segm = substr($str, $next_start, $next_len);
        // 如果第1字节就不是 完整字符的首字节, 再往后截取大约6字节.
        $start = $strlen + $start;
        $prev_start = $start - 6 > 0 ? $start - 6 : 0;
        $prev_segm = substr($str, $prev_start, $start - $prev_start);
    }
    // 判断前6字节是否符合utf8规则
    if (preg_match('@^([\x80-\xBF]{0,5})[\xC0-\xFD]?@', $next_segm, $bytes)) {
        if (!empty($bytes[1])) {
            $bytes = $bytes[1];
            $res .= $bytes;
        }
    }
    // 判断后6字节是否符合utf8规则
    $ord0 = ord($res[0]);
    if (128 <= $ord0 && 191 >= $ord0) {
        // 往后截取 , 并加在res的前面.
        if ( preg_match('@[\xC0-\xFD][\x80-\xBF]{0,5}$@', $prev_segm, $bytes)) {
            if (!empty($bytes[0])) {
                $bytes = $bytes[0];
                $res = $bytes . $res;
            }
        }
    }
    // 如果被截取了则在后面加上省略号
    if ($res != $str) $res .= '...';
    return $res;
}
/**
 * 当在title显示一个字符串时，把单引号和双引号转换为中文的引号
 */
function getTitle($str) {
    if (empty($str)) return ''; // 如果字符串为空直接返回空值即可，不需下面运算
    return str_replace(["'", '"'], ["‘", '“'], $str);
}
/**
 * 创建文件夹
 */
function createFolder($path) {
    if (!file_exists($path)) {
        mkdir($path, 0777, true);
        return file_exists($path) ? true : false;
    }
    return true;
}
/**
 * 根据ip获取其省市区位置
 * 淘宝ip查询接口地址 http://ip.taobao.com/instructions.php
 * 返回json，其中code的值的含义为，0：成功，1：失败
 */
function getLocation($ip = '') {
    $response = '';
    if (!empty($ip)) {
        $url = 'http://ip.taobao.com//service/getIpInfo.php?ip=' . $ip;
        $content = file_get_contents($url);
        $content = json_decode($content, true);
        if (!$content['code']) {
            $response = $content['data']['country'] . ' ' . $content['data']['region'] . ' ' . $content['data']['city'];
        }
    }
    return $response;
}