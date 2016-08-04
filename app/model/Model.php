<?php
/**
 * 系统基础model
 * @author：王雷 loonghere@qq.com
 */
namespace app\model;
use app\common\Mysql;

class Model
{
	public $db;
	public $table = '';

	function __construct()
	{
		$config = require __DIR__ . '/../config/database.php';
		$this->db = Mysql::getInstance($config['DB_HOST'], $config['DB_USER'], $config['DB_PASS'], $config['DB_NAME']);
	}
}