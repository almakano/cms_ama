<?php 
	namespace Account;

	class Model extends \MysqlTableRow {

		static $__account;

		static function __table_name() { return 'accounts'; }

		static function __logined() {

			if(empty(static::$__account)) {
				if(!empty(\Session::self()->data['account_id'][0])) {
					static::$__account = static::findOne(['filter' => ['id' => Session::self()->data['account_id'][0]]]);
				}
			}

			return static::$__account;
		}
	}
?>