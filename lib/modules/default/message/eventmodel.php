<?php 
	namespace Message;

	class EventModel extends \MysqlTableRow {

		static function __table_name() { return 'messages_events'; }
	}
?>