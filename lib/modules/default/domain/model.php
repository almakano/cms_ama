<?php 
	namespace Domain;

	class Model extends \MysqlTableRow {

		static function __table_name() { return 'domains'; }
	}
?>