<?php 
	class Notify extends Singleton {
		static $data = [];

		static function add($str = '', $params = []) {
			if(empty($params['class'])) $params['class'] = 'default';
			static::$data[] = '<div class="'.$params['class'].'">'.$str.'</div>';
		}

		static function warning($str = '') {
			static::add($str, 'warning');
		}

		static function error($str = '') {
			static::add($str, 'error');
		}

		static function success($str = '') {
			static::add($str, 'success');
		}

		static function show() {

			if(empty(static::$data)) return;
			$data = static::$data;
			static::$data = [];
			return $data;
		}
	}
?>