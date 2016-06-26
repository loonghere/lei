<?php
/**
 * 初始化项目
 * Lei框架 V1.0
 * 一个简洁的PHP小框架
 * @author 王雷 loonghere@qq.com
 */
require __DIR__ . '/app/function.php';
spl_autoload_register('loader');
doAddslashes();
initSession();