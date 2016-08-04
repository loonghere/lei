<?php
/**
 * Lei框架 V1.0
 * 路由组
 * @author 王雷 loonghere@qq.com
 */
$r->addRoute('GET', '/', 'app\controller\IndexController');
$r->addRoute('GET', '/test', 'app\controller\TestController@index');
$r->addRoute('GET', '/verify', 'app\controller\VerifyController');
// $r->addRoute('GET', '/users', 'get_all_users_handler');
// $r->addRoute('GET', '/user/{id:\d+}', 'get_user_handler');
// $r->addRoute('GET', '/articles/{id:\d+}[/{title}]', 'get_article_handler');