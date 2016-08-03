<?php
/**
 * 日志类
 * @author：王雷 loonghere@qq.com
 */
namespace app\common;

class Log
{
    public static function write($event)
    {
        $ip = getIp();
        $logDir = __DIR__ . '/../../storage/logs/';
        if (is_array($event)) $event = json_encode($event, JSON_UNESCAPED_UNICODE);
        $fd = fopen ($logDir . date("YmdH") . '.log', 'a');
        $log = $ip . '  ' . date("Y-m-d H:i:s") . "\r\n$event\r\n";
        fwrite($fd, $log);
        fclose($fd);
        return true;
    }
}