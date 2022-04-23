<?php
/*--------------------------------------------------------------------------
 | Software: [WillPHP framework]
 | Site: www.113344.com
 |--------------------------------------------------------------------------
 | Author: no-mind <24203741@qq.com>
 | WeChat: www113344
 | Copyright (c) 2020-2022, www.113344.com. All Rights Reserved.
 |-------------------------------------------------------------------------*/
namespace willphp\framework\build;
/**
 * 服务抽象类
 */
abstract class Provider {
	public $defer = false; //延迟加载
	protected $app; //应用实例
	/**
	 * 注册服务
	 */
	abstract function register();
	public function __construct($app) {
		$this->app = $app;
	}
	public function __call($method, $args) {
		if ($method == 'boot') {
			return;
		}
		throw new \BadMethodCallException($method.' does not exist.');
	}
}