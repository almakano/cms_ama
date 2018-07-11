<?php 
	namespace Order;

	class Model extends \MysqlTableRow {

		static function __table_name() { return 'orders'; }
	}
?>