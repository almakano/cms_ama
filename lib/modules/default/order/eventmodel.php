<?php 
	namespace Order;

	class EventModel extends \MysqlTableRow {

		static function __table_name() { return 'orders_events'; }
	}
?>