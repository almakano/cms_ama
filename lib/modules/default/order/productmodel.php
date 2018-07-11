<?php 
	namespace Order;

	class ProductModel extends \MysqlTableRow {

		static function __table_name() { return 'orders_products'; }
	}
?>