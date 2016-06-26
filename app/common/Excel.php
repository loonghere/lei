<?php
/**
 * PHPExcel 1.8.0
 * @author：王雷 loonghere@qq.com
 */
require __DIR__ . '/../../vendor/phpexcel/PHPExcel.php';
require __DIR__ . '/../../vendor/phpexcel/PHPExcel/Writer/Excel5.php';
require __DIR__ . '/../../vendor/phpexcel/PHPExcel/Writer/CSV.php';
require __DIR__ . '/../../vendor/phpexcel/PHPExcel/IOFactory.php';
class Excel extends PHPExcel
{
    public function __construct() {
        parent::__construct();
    }
}