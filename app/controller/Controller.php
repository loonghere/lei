<?php
/**
 * 根控制器
 * @author：王雷 loonghere@qq.com
 */
class Controller
{
	/**
	 * 打开模板视图
	 * @param  string $view 视图路径 admin.admin = view下的admin/admin.php
	 * @param  array  $data 视图需要绑定的数据
	 */
	public function view($view = '', $data = [])
	{
		$view = str_replace('.', '/', $view);
		extract($data); // 数组中的每个元素，键名用于变量名，键值用于变量值
		include __DIR__ . '/../view/' . $view . '.php';
		exit;
	}
}