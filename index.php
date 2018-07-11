<?php 
	function on_classload($name) {

		if(!class_exists('Config')) {
			$theme = 'default';
		} else {
			$theme = (!empty(Config::self()->data['site']['theme'])?Config::self()->data['site']['theme']:'default');
		}

		if(!file_exists($file = DIR_SITE.'/lib/modules/'.$theme.'/'.strtolower(trim(strtr($name, '\\', '/'), '/')).'.php')) {
			if($theme == 'default' || !file_exists($file = DIR_SITE.'/lib/modules/default/'.strtolower(trim(strtr($name, '\\', '/'), '/')).'.php')) {
				Debug::add('<span style="color: red">Class '.$name.' not found</span>');
				header('HTTP/1.0 500 Internal Server Error');
				exit;
			}
		}

		include $file;
	}

	function on_error($errno, $errstr, $errfile, $errline) {
		if (!(error_reporting() & $errno)) { return false; }

		error_log($errstr.' at '.str_replace(DIR_SITE, '', $errfile).' ('.$errline.')');
		Debug::add('<span style="color: red">'.$errstr.' at '.str_replace(DIR_SITE, '', $errfile).' ('.$errline.')'.'</span>');
		return true; 
	}

	function on_shutdown() {
		// Debug::add(['mysql' => \Mysql::$queries]);
		// Debug::add(['files' => get_included_files()]);
		Debug::show();

		$error = error_get_last();
		if($error['type'] === E_ERROR) {
			header('HTTP/1.0 500 Internal server error');
			exit;
		}
	}

	error_reporting(E_ALL);
	ini_set('display_errors', 'on');

	spl_autoload_register('on_classload');
	set_error_handler('on_error');
	register_shutdown_function('on_shutdown');

	define('DIR_SITE', dirname(__FILE__));

	// Mysql::sql('master', 'set profiling = 1');
	echo Request::execute($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI'], ($_SERVER['REQUEST_METHOD'] == 'POST'?$_POST:[]), (!empty($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:''));
	// Debug::add(['mysql' => Mysql::sql('master', 'show profiles')]);
?>