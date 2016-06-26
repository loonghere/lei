<?php
/**
 * Cookie操作类
 * @author：王雷 loonghere@qq.com
 */
class Cookie
{
    public static function has($key = '')
    {
        if ($key == '') return 0;
        return isset($_COOKIE[$key]) ? 1 : 0;
    }

    public static function put($key, $val, $expirtime = 604800)
    {
        setcookie($key, $val, time()+$expirtime);
        return true;
    }

    public static function get($key)
    {
        return self::has($key) ? $_COOKIE[$key] : '';
    }
}