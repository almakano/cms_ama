<?php 
	class EventManager {

		static $handlers = [];

		static function init() {

			$dir = DIR_SITE.'/lib/modules/';
			$files = scandir($dir);
			foreach ($files as $file) {
				if($file == 'init.php') include $dir.$file;
			}
		}

		static function add($eventname, $methodname) {
			if(!isset(static::$handlers[$eventname]))
				static::$handlers[$eventname] = [];
			static::$handlers[$eventname][] = $methodname;
		}

		static function call($eventname, &$arg1 = null, &$arg2 = null, &$arg3 = null) {
			if(!empty(static::$handlers[$eventname])) {
				$argc = func_num_args();
				$args = [];
				for($i = 1; $i < $argc; $i++) {
					$var = 'arg'.$i;
					if($$var !== null) $args[] = &$$var;
				}

				foreach (static::$handlers[$eventname] as $methodname) {
					call_user_func_array($methodname, $args);
				}
			}
		}
	}
?>