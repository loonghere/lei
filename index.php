<?php
/**
 * Lei框架 V1.0
 * 入口文件
 * @author 王雷 loonghere@qq.com
 */
require '/start.php';
require '/vendor/FastRoute/bootstrap.php';
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

    public function getRoute($r)
    {
        require '/app/route.php';
    }

    public function takeover()
    {
        $controller = new app\controller\PublicController;
        $controller->takeover();
    }

	public function run() {
		$input = $this->getInput();
        $dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
            $this->getRoute($r);
        });

        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];

        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        $uri = rawurldecode($uri);

        $routeInfo = $dispatcher->dispatch($httpMethod, $uri);
        spl_autoload_register('loader'); // 注册自动加载
        switch ($routeInfo[0]) {
            case FastRoute\Dispatcher::FOUND:
                $handler = explode('@', $routeInfo[1]);
                $vars = array_merge($input, $routeInfo[2]);
                $module = $handler[0];
                if (file_exists($module . '.php')) {
                	$action = isset($handler[1]) ? $handler[1] : 'index';
                	$controller = new $module;
                	if (!method_exists($controller, $action)) {
                		$this->takeover();
                	} else {
                		$controller->$action($vars);
                	}
                } else {
                	$this->takeover();
                }
                break;
            default:
                $this->takeover();
                break;
        }
	}
}

Lei::getInstance()->run();