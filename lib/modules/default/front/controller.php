<?php 
	namespace Front;

	class Controller extends \Controller {

		public $title = '';
		public $metas = [];
		public $styles = [];
		public $links = [];
		public $scripts = [];
		public $scripts_header = [];
		public $scripts_inline = [];
		public $dirs = [];

		function _head() {

			foreach ($this->dirs as $k => $dir) {

				$url = '/u/c/'.\Config::self()->data['site']['theme'].'/'.basename($dir);

				if(is_dir($dir)) {
					if(!is_dir($newdir = DIR_SITE.$url)) {
						mkdir($newdir, 0755, true);
						copy($dir, $newdir);
					}
				} else {
					unset($this->dirs[$k]);
				}
			}

			foreach ($this->links as $k => $file) {

				$url = '/u/c/'.\Config::self()->data['site']['theme'].'/'.basename($file);

				if(file_exists($file)) {
					if(!file_exists($newfile = DIR_SITE.$url) || filemtime($newfile) < filemtime($file)) {
						if(file_exists($newfile)) unlink($newfile);
						if(!is_dir($dir = dirname($newfile))) mkdir($dir, 0755, true);
						copy($file, $newfile);
					}
					$this->links[$k] = '<link rel="stylesheet" href="'.$url.'?'.md5(filemtime($newfile)).'">';
				} else {
					unset($this->links[$k]);
				}
			}

			foreach ($this->scripts_header as $k => $file) {

				$url = '/u/c/'.\Config::self()->data['site']['theme'].'/'.basename($file);

				if(file_exists($file)) {
					if(!file_exists($newfile = DIR_SITE.$url) || filemtime($newfile) < filemtime($file)) {
						if(file_exists($newfile)) unlink($newfile);
						if(!is_dir($dir = dirname($newfile))) mkdir($dir, 0755, true);
						copy($file, $newfile);
					}
					$this->scripts_header[$k] = '<script src="'.$url.'?'.md5(ilemtime($newfile)).'"></script>';
				} else {
					unset($this->scripts_header[$k]);
				}
			}

			$res = implode("\r\n\t", $this->links).PHP_EOL.implode("\r\n\t", $this->styles).PHP_EOL.implode("\r\n\t", $this->scripts_header);
			return $res;
		}

		function _foot() {

			foreach ($this->scripts as $k => $file) {

				$url = '/u/c/'.\Config::self()->data['site']['theme'].'/'.basename($file);

				if(file_exists($file)) {
					if(!file_exists($newfile = DIR_SITE.$url) || filemtime($newfile) < filemtime($file)) {
						if(file_exists($newfile)) unlink($newfile);
						if(!is_dir($dir = dirname($newfile))) mkdir($dir, 0755, true);
						copy($file, $newfile);
					}
					$this->scripts[$k] = '<script src="'.$url.'?'.md5(filemtime($newfile)).'"></script>';
				} else {
					unset($this->scripts[$k]);
				}
			}

			$res = implode("\r\n\t", $this->scripts).PHP_EOL.implode("\r\n\t", $this->scripts_inline);
			return $res;
		}

		function index($arg = []) {

			$item = \Content\Model::findOne([
				'filter' => [
					'url' => !empty($arg['url'])?trim($arg['url'], '/'):'',
				],
			]);

			if(empty($item->is_published)) return $this->error_404();

			return $this->_view(!empty($item->template)?$item->template:'page', ['item' => $item]);
		}

		function error_403($arg = []) {
			header('HTTP/1.0 403 Forbidden');
			return $this->_view('403');
		}

		function error_404($arg = []) {
			header('HTTP/1.0 404 Not Found');
			return $this->_view('404');
		}

		function slider($arg = []) {

			if(empty($arg['id'])) return $this->error_404();
			$list = \Slider\Model::find([
				'filter' => [
					'parent_id' => $arg['id'],
					'is_published' => 1,
				],
				'orderby' => 'sort_id'
			]);

			if(empty($list)) return $this->error_404();

			return $this->_view('slider', ['list' => $list]);
		}

		function account_menu($arg = []) {
			return $this->_view('account-menu');
		}

		function account_profile($arg = []) {
			if(!empty($arg['user_id'])) {
				$account = \Account\Model::findOne(['filter' => ['id' => $arg['user_id']]]);
			} else {
				$account = \Account\Model::getLogined();
			}

			if(empty($account->id)) return $this->error_403();

			return $this->_view('account-profile', []);
		}

		function account_orders($arg = []) {
			return $this->_view('account-orders');
		}

		function account_messages($arg = []) {

			if(!empty($arg['user_id'])) {
				$account = \Account\Model::findOne(['filter' => ['id' => $arg['user_id']]]);
			} else {
				$account = \Account\Model::getLogined();
			}

			if(empty($account->id)) return $this->error_403();

			$lastid = (!empty($arg['lastid'])?$arg['lastid']:0);
			$messages = \Messages\Model::find([
				'filter' => [
					'or' => [
						'sender_id' => $account->id,
						'receiver_id' => $account->id,
					],
					['id', '>', $lastid],
				],
				'orderby' => 'inserted_date desc',
				'limit' => 30,
			]);

			return $this->_view('account-messages', [
				'account' => $account,
				'messages' => $messages,
			]);
		}

		function account_medias($arg = []) {
			return $this->_view('account-medias');
		}

		function account_auth($arg = []) {
			return $this->_view('account-auth');
		}

		function account_login($arg = []) {

			if(!empty($arg['email'])) $email = $arg['email'];
			else if(!empty(\Session::self()->data['login_email'])) $email = Session::self()->data['login_email'];

			if(!empty($arg['pass'])) $pass = $arg['pass'];
			else if(!empty(\Session::self()->data['login_pass'])) $email = Session::self()->data['login_pass'];

			if(!empty($arg['captcha'])) $captcha_user = $arg['captcha'];
			else $captcha_user = '';

			if(!empty(\Session::self()->data['login_tries'])) $tries = \Session::self()->data['login_tries'];
			else $tries = 0;

			\Session::self()->data['login_tries'] = ++$tries;

			if(empty($pass)) \Notify::warning('Password is required');
			if(empty($email)) \Notify::warning('Email is required');
			if(empty($captcha_user) && $tries > 1) \Notify::warning('Captcha is required');

			$captcha = '';
			$symbols = explode("", 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ');
			$required_count = 6;
			$symbols_count = count($symbols);
			for($i = 0; $i < $required_count; $i++) {
				$captcha .= $symbols[rand(0, $symbols_count)];
			}

			if(!empty($email) && !empty($pass)) {
				$account = \Account\Model::findOne(['filter' => ['email' => $email]]);
				if(empty($account->id)) {
					\Notify::warning('Account is not registered');
				} else if($account->pass != $pass) {
					\Notify::warning('Password is incorrect');
				} else {
					if(isset(\Session::self()->data['login_tries'])) unset(\Session::self()->data['login_tries']);
					if(isset(\Session::self()->data['login_pass'])) unset(\Session::self()->data['login_pass']);
					if(isset(\Session::self()->data['login_email'])) unset(\Session::self()->data['login_email']);

					if(empty(\Session::self()->data['account_id'])) \Session::self()->data['account_id'] = [];
					array_unshift(\Session::self()->data['account_id'], $account->id);
				}
			}

			return $this->_view('account-login', [
				'email' => $email,
				'pass' => $pass,
				'captcha' => $captcha,
			]);
		}

		function account_logout($arg = []) {
			if(!empty(\Session::self()->data['account'])) $email = Session::self()->data['login_pass'];

			return $this->_view('account-logout');
		}

		function account_register($arg = []) {
			return $this->_view('account-register');
		}

		function account_resetpass($arg = []) {
			return $this->_view('account-resetpass');
		}

		function products_best($arg = []) {

			$ids = [];

			$best = \Order\ProductModel::find([
				'cols' => 'product_id',
				'filter' => [],
				'groupby' => 'product_id',
			]);

			return $this->_view('shop-product-list', [
				'list' => \Content\Model::find([
					'filter' => [
						'id' => $ids
					],
					'orderby' => '',
					'limit' => 4,
				]),
			]);
		}

	}
?>