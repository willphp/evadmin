<?php
return [
		'providers' => [		
				'Config' => \willphp\config\ConfigProvider::class, //配置处理组件
				'Error' => \willphp\error\ErrorProvider::class, //错误处理组件
				'Session' => \willphp\session\SessionProvider::class, //Session处理组件
				'Request' => \willphp\request\RequestProvider::class, //请求处理组件
				'Middleware' => \willphp\middleware\MiddlewareProvider::class, //中间件处理组件
				'Route' => \willphp\route\RouteProvider::class, //路由处理组件
				'Response' => \willphp\response\ResponseProvider::class, //响应处理组件				
		],		
		'facades' => [
				'App' => \willphp\framework\AppFacade::class,
				'Config' => \willphp\config\ConfigFacade::class,
				'Error' => \willphp\error\ErrorFacade::class,
				'Session' => \willphp\session\SessionFacade::class,
				'Request' => \willphp\request\RequestFacade::class,
				'Middleware' => \willphp\middleware\MiddlewareFacade::class,
				'Route' => \willphp\route\RouteFacade::class,
				'Response' => \willphp\response\ResponseFacade::class,	
		],		
];