<?php 
	namespace Account;

	class Controller extends \Controller {

		public $self;

		function __self($arg = []) {

		}

		function error_403($arg = []) {
			header('HTTP/1.0 403 Forbidden');
			return json_encode(['status' => 403, 'messages' => ['Access denied']], JSON_UNESCAPED_UNICODE);
		}

		function error_404($arg = []) {
			header('HTTP/1.0 404 Not found');
			return json_encode(['status' => 404, 'messages' => ['User not found']], JSON_UNESCAPED_UNICODE);
		}

		function index($arg = []) {

			if(empty($this->__self()->id)) return $this->error_403();
			return json_encode($self, JSON_UNESCAPED_UNICODE);
		}

		function find($arg = []) {

			$status = 200;
			$messages = [];

			$limit_max = 500;
			$start_id = (!empty($arg['start_id'])?(int)$arg['start_id']:0);
			$limit = (!empty($arg['limit'])?(int)$arg['limit']:20);

			$list = Model::find([
				'filter' => [
					(!empty($this->self->id)?['id', '!', $this->self->id]:''),
					($start_id?['id', '>', $start_id]:''),
				],
				'orderby' => 'id',
				'limit' => $limit > $limit_max?$limit_max:$limit,
			]);

			return json_encode(['status' => $status, 'messages' => $messages, 'list' => $list], JSON_UNESCAPED_UNICODE);
		}

		function login($arg = []) {

			$status = 200;
			$messages = [];

			if(empty(\Session::self()->data['account'])) {
				\Session::self()->data['account'] = [];
			}

			if(empty($arg['login'])) {
				\Notify::add('Login is required');
			}

			if(empty($arg['pass'])) {
				\Notify::add('Pass is required');
			}

			$messages = \Notify::show();

			return json_encode(['status' => $status, 'messages' => $messages], JSON_UNESCAPED_UNICODE);
		}

		function logout($arg = []) {

			return json_encode(['status' => $status, 'messages' => $messages], JSON_UNESCAPED_UNICODE);
		}

		function register($arg = []) {

		}

		function remove($arg = []) {

		}

		function edit($arg = []) {

		}

		function save($arg = []) {

		}
	}
?>