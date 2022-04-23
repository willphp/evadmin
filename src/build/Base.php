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
class Base extends \willphp\container\build\Base {
	use Bootstrap, Version;	
	protected $booted = false; //应用是否已启动
	protected $deferProviders = []; //延迟加载服务
	protected $serviceProviders = []; //已加载服务
	protected $providers = []; //系统服务	
	protected $facades = []; //外观别名
	/**
	 * 框架启动
	 */
	public function bootstrap() {
		self::version(); //框架版本定义
		$this->services(); //载入服务 
		spl_autoload_register([$this, 'autoload']); //外观类文件自动加载
		$this->instance('App', $this); //设置app单例		
		Facade::setFacadeApplication($this); //设置外观类APP属性
		$this->bindServiceProvider(); //绑定核心服务提供者
		$this->boot(); //执行服务启动程序
		$this->runApp(); //运行项目应用
	}
	/**
	 * 载入服务(组件)
	 */
	public function services() {				
		$servers = require __DIR__.'/../service/service.php'; //框架组件		
		$users = require WIPHP_URI.'/system/service.php'; //用户组件		
		$this->providers = array_merge($servers['providers'], $users['providers']);
		$this->facades = array_merge($servers['facades'], $users['facades']);
	}
	/**
	 * 外观类文件自动加载
	 * @param $class
	 * @return mixed
	 */
	public function autoload($class) {
		$facade = str_replace('\\', '/', $class);
		if (isset($this->facades[$facade])) {
			class_alias($this->facades[$facade], $class); //, false
		}
	}
	/**
	 * 服务加载处理
	 */
	protected function bindServiceProvider() {
		foreach ($this->providers as $provider) {
			$reflectionClass = new \ReflectionClass($provider);
			$properties = $reflectionClass->getDefaultProperties();
			if (isset($properties['defer']) && $properties['defer'] === false) {
				$this->register(new $provider($this));
			} else {
				$alias = substr($reflectionClass->getShortName(), 0, -8);
				$this->deferProviders[$alias] = $provider;
			}
		}
	}
	/**
	 * 注册服务
	 * @param $provider 服务名
	 * @return object
	 */
	protected function register($provider) {
		$registered = $this->getProvider($provider);
		if ($registered) {
			return $registered;
		}
		if (is_string($provider)) {
			$provider = new $provider($this);
		}
		$provider->register($this);
		$this->serviceProviders[] = $provider;
		if ($this->booted) {
			$this->bootProvider($provider);
		}
	}
	/**
	 * 获取已经注册的服务
	 * @param $provider 服务名
	 * @return mixed
	 */
	protected function getProvider($provider) {
		$class = is_object($provider) ? get_class($provider) : $provider;
		foreach ($this->serviceProviders as $value) {
			if ($value instanceof $class) {
				return $value;
			}
		}
	}
	/**
	 * 系统启动
	 */
	protected function boot() {
		if ($this->booted) {
			return;
		}
		foreach ($this->serviceProviders as $provider) {
			$this->bootProvider($provider);
		}
		$this->booted = true;
	}
	/**
	 * 运行服务提供者的boot方法
	 * @param $provider
	 */
	protected function bootProvider($provider) {
		if (method_exists($provider, 'boot')) {
			$provider->boot($this);
		}
	}
	/**
	 * 获取服务对象
	 * @param 服务名  $name  服务名
	 * @param bool $force 是否单例
	 * @return Object
	 */
	public function make($name, $force = false)	{
		$name = ucfirst($name);
		if (isset($this->deferProviders[$name])) {
			$this->register(new $this->deferProviders[$name]($this));
			unset($this->deferProviders[$name]);
		}
		return parent::make($name, $force);
	}
}