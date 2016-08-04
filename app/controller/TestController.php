<?php
/**
 * 测试控制器
 * @author：王雷 loonghere@qq.com
 */
namespace app\controller;

class TestController
{
    public function index($input = [])
    {
        var_dump($input);
    }
}