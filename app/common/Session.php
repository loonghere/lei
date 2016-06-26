<?php
/**
 * Session操作类
 * @author：王雷 loonghere@qq.com
 */
class Session
{
    /**
     * 判断指定session是否设置
     */
    public static function has($key)
    {
        return isset($_SESSION[$key]) ? 1 : 0;
    }

    /**
     * 设置session
     */
    public static function put($key, $val)
    {
        if (is_null($val))
            unset($_SESSION[$key]);
        else
            $_SESSION[$key] = $val;
        return true;
    }

    /**
     * 取出session
     */
    public static function get($key)
    {
        return self::has($key) ? $_SESSION[$key] : '';
    }

    /**
     * 销毁session
     */
    public static function destory()
    {
        session_destroy();
        return true;
    }
}