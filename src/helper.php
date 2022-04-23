<?php
if (!function_exists('app')) {
	/**
	 * 快速获取容器中的实例
	 * @param string $name		类名或标识 默认获取当前应用实例
	 * @param bool   $force		是否单例模式
	 * @return object|App
	 */
	function app($name = 'App', $force = false) {
		return \willphp\framework\App::make($name, $force);
	}
}
if (!function_exists('dump')) {
	/**
	 * 浏览器友好的变量输出
	 * @param mixed $vars 要输出的变量
	 * @return void
	 */
	function dump(...$vars) {
		ob_start();
		var_dump(...$vars);
		$output = ob_get_clean();
		$output = preg_replace('/\]\=\>\n(\s+)/m', '] => ', $output);
		if (PHP_SAPI == 'cli') {
			$output = PHP_EOL.$output.PHP_EOL;
		} elseif (!extension_loaded('xdebug')) {
			$output = '<pre>'.htmlspecialchars($output, ENT_SUBSTITUTE).'</pre>';
		}
		echo $output;
	}
}
if (!function_exists('print_const')) {
	/**
	 * 输出用户常量
	 * @return string
	 */
	function print_const() {
		$data = get_defined_constants(true);
		dump($data['user']);
	}
}