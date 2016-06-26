<?php
/**
 * 验证码控制器
 * @author：王雷 loonghere@qq.com
 */
class VerifyController
{
	public function index()
	{
		$config = [
		    'fontSize'    =>    16,
		    'length'      =>    4,
		    'useNoise'    =>    false,
		    'imageW'      =>    126,
		    'imageH'      =>    36,
		    'useCurve'    =>    false,
		    'fontttf'     =>    '6.ttf',
		];
		$verify = new Verify($config);
		return $verify->entry();
	}
}