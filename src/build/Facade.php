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
abstract class Facade {
	protected static $app;
	public static $resolvedInstance = [];
	public static function getFacadeRoot() {
		return self::resolveFacadeInstance(static::getFacadeAccessor());
	}	
	protected static function getFacadeAccessor() {
		throw new \RuntimeException('Facade does not implement getFacadeAccessor method.');
	}	
	protected static function resolveFacadeInstance($name) {
		if (is_object($name)) {
			return $name;
		}		
		return static::$resolvedInstance[$name] = static::$app[$name];
	}	
	public static function setFacadeApplication($app) {
		static::$app = $app;
	}	
	public static function __callStatic($method, $args)	{
		$instance = static::getFacadeRoot();		
		return call_user_func_array([$instance, $method], $args);
	}
}