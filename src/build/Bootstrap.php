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
trait Bootstrap {	
	protected function runApp() {		
		if (RUN_MODE == 'http') {					
			$this->Middleware->globals(); //执行公共中间件			
			$this->withPostData();  //分配post闪存
			$res = $this->Route->bootstrap()->executeControllerMethod(); //路由启动执行控制器方式	
			$this->Response->output($res); //输出响应内容	
		}
	}		
	/**
	 * 分配post闪存
	 */	
	protected function withPostData()	{		
		$post = $this->Request->post();
		if (!empty($post)) {
			$this->Session->flash('oldFormData', $post);
		}
	}	
}