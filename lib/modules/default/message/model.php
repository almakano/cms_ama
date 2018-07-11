<?php 
	namespace Message;

	class Model extends \MysqlTableRow {

		static function __table_name() { return 'messages'; }

		function getSender() {
			return \Account::findOne(['filter' => ['id' => $this->sender_id]]);
		}

		function getReceiver() {
			switch($this->view) {
				case 'account':
					return \Account\Model::findOne(['filter' => ['id' => $this->receiver_id]]);
				case 'content':
					return \Content\Model::findOne(['filter' => ['id' => $this->receiver_id]]);
				case 'media':
					return \Media\Model::findOne(['filter' => ['id' => $this->receiver_id]]);
			}
		}

	}
?>