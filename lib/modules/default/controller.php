<?php 
	class Controller extends Singleton {

		function _view($__name = '', $__params = []) {

			$__res = '';
			$__reflector = new ReflectionClass(static::class);
			$__path = dirname($__reflector->getFileName());

			if(file_exists($__file = $__path.'/templates/'.$__name.'.php')) {
				ob_start();
				if(!empty($__params)) extract($__params);
				include $__file;
				$__res = ob_get_clean();
			} else {
				Debug::add('<span style="color: brown">Template '.$__name.' not found at '.$__file.'</span>');
			}

			return $__res;
		}

		function index($arg = []) {
			return $this->_view('index');
		}

	}
?>