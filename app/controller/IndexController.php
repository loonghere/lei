<?php
/**
 * 首页控制器
 * @author：王雷 loonghere@qq.com
 */
class IndexController extends Controller
{
    public function index($input = [])
    {
        $data = [
            'username' => 'Lei',
        ];
        $this->view('index.index', $data);
    }

    /**
     * 退出登陆
     */
    public function logout()
    {
        Session::destory();
        reDirect('/');
    }
}