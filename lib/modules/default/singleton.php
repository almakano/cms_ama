<?php 
	class Singleton {
		static $instances = [];

		static function self() {

			if(empty(static::$instances[$classname = static::class])) {
				static::$instances[$classname] = new $classname();
				if(method_exists(static::$instances[$classname], 'after_create')) {
					static::$instances[$classname]->after_create();
				}
			}

			return static::$instances[$classname];
		}

		function __destruct() {
			if(method_exists($this, 'before_destroy')) {
				$this->before_destroy();
			}
		}
	}
?>