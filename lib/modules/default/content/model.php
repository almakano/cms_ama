<?php 
	namespace Content;

	class Model extends \MysqlTableRow {

		static function __table_name() { return 'content'; }

		function get_property($name = '') {
			return PropertyModel::findOne(['filter' => ['content_id' => $this->id, 'url' => $name]]);
		}
	}
?>