<?php
/**
 * Lei框架 V1.0
 * 入口文件
 * @author 王雷 loonghere@qq.com
 */
require 'start.php';
class Lei
{
	private static $_instance;

	private function __construct() {}

	public function __clone() {}

	public static function getInstance() {
		if (!self::$_instance instanceof self) {
			self::$_instance = new self;
		}
		return self::$_instance;
	}

	public function getInput()
	{
		return array_merge($_GET, $_POST);
	}

	public function run() {
		$input = $this->getInput();
		$module = isset($input['module']) ? $input['module'] : 'Index';
		$module = 'app\controller\\' . $module . 'Controller';
		if (file_exists($module . '.php')) {
			$action = isset($input['action']) ? $input['action'] : 'index';
			$controller = new $module;
			if (!method_exists($controller, $action)) {
				$controller = new app\controller\PublicController;
				$controller->takeover();
			} else {
				$controller->$action($input);
			}
		} else {
			$controller = new app\controller\PublicController;
			$controller->takeover();
		}
	}
}

Lei::getInstance()->run();