<?php 
	class Debug extends Singleton {
		static $data = [];

		static function add($arg = NULL) {
			if(in_array($_SERVER['REMOTE_ADDR'], Config::self()->data['ip_debug'])) {
				$a = debug_backtrace();
				static::$data[] = [$arg, str_replace(DIR_SITE, '', $a[0]['file']), $a[0]['line']];
			}
		}

		static function show() {

			foreach (static::$data as $i) {
				echo '<div class="debug">Debug at ', $i[1], ' (<b>', $i[2], '</b>)<br>';
				if(is_array($i[0]) || is_object($i[0])) {
					echo '<xmp>'; print_r($i[0]); echo '</xmp>'; 
				} else {
					var_dump($i[0]);
				}
				echo '</div>';
			}

		}
	}
?>