<?php
/**
 * 操作配置文件类
 * @author：王雷 loonghere@qq.com
 */
class Common
{
	public static function read_config_file($file)
    {
    	$result = [];
    	$file = file($file); // file()函数把文件读入数组，如果读取失败返回false
    	if ($file) {
    		$line = '';
    		$currentKey = '';
    		foreach ($file as $key => $val) {
    			$line = trim($val);
    			// 空行跳过
    			if ($line) {
    				if (substr($line, 0, 1) == '[' && substr($line, -1, 1) == ']') {
    					$currentKey = substr($line , 1, strlen($line) - 2);
    				} else {
    					$line = explode('=', $line);
    					$result[$currentKey][trim($line[0])] = trim($line[1]);
    				}
    			}
    		}
    	}
    	return $result;
    }

    public static function write_config_file($file, $data = [])
    {
    	$content = '';
    	foreach ($data as $key => $val) {
    		$content .= '[' . $key . "]\r\n";
    		foreach ($val as $k => $v) {
    			$content .= $k . '=' . $v . "\r\n";
    		}
    		$content .= "\r\n";
    	}
    	$byte = file_put_contents($file, $content);
    	return $byte;
    }
}