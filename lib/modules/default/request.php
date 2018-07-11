<?php
	class Request {

		static function execute($method = 'GET', $url = '', $post = [], $referer = '') {

			$rules		= Config::self()->data['rules'];
			$parsed_url	= parse_url($url);
			$route		= (!empty($parsed_url['path'])?trim($parsed_url['path'], '/'):'');
			$host		= (!empty($parsed_url['host'])?$parsed_url['host']:$_SERVER['HTTP_HOST']);
			$active_rule = [];

			if(!empty($parsed_url['query'])) parse_str($parsed_url['query'], $get);
			else $get = [];

			if($host == $_SERVER['HTTP_HOST']) {

				if(!empty($get['route'])) {
					$active_rule['route'] = $get['route'];
					unset($get['route']);
				} else {
					foreach ($rules as $pattern => $rule) {
						if(preg_match('~^'.$pattern.'$~', $route, $matches)) {

							if($count = count($matches)) {

								$replaces = [];
								$rule = json_encode($rule, JSON_UNESCAPED_UNICODE);

								for($k = 0; $k < $count; $k++) {
									$replaces[] = '$'.$k;
								}
								$rule = str_replace($replaces, $matches, $rule);
								$active_rule = json_decode($rule, 1);
							}
							break;
						}
					}
				}

				$get = array_merge($get, !empty($active_rule['get'])?$active_rule['get']:[]);

				if(!empty($active_rule['is_logined']) || !empty($active_rule['is_admin'])) {
					if(empty(\Account\Model::__logined())) {
						$active_rule['route'] = 'front/error_403';
					}
				}

				if(empty($active_rule['route'])) {
					$active_rule['route'] = 'front/index';
				}

				list($controller, $action) = explode('/', $active_rule['route']);

				if(empty($action)) $action = 'index';

				$controller .= '\Controller';
				$controller = $controller::self();

				if(method_exists($controller, $action)) {
					$res = $controller->$action(preg_match('~^get$~i', $method)?$get:$post);
				} else {
					Debug::add('<span style="color: red">Action '.$active_rule['route'].' not exist</span>');
					return;
				}

				if($method == 'POST') {
					header('Location: '.$referer, true, 302);
					exit;
				}
			} else {
				$res = file_get_contents($url, false, stream_context_create(array(
					'http' => array(
						'method' => $method,
						'header' => 'Content-Type: application/x-www-form-urlencoded' . PHP_EOL,
						'content' => http_build_query($post),
					),
				)));
			}

			return $res;
		}
	}
?>