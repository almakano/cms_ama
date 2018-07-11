<?php 
	namespace Account;

	class EventModel extends \MysqlTableRow {

		static function __table_name() { return 'accounts_events'; }
	}
?>