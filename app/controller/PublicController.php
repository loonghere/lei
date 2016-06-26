<?php
/**
 * 公共控制器，404、跳转等方法
 * @author：王雷 loonghere@qq.com
 */
class PublicController extends Controller
{
	/**
	 * 访问方法不存在的接管方法，打开404
	 */
	public function takeover()
	{
		$this->view('public.404');
	}
}