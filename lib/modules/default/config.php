<?php 
	class Config extends Singleton {

		function after_create() { 
			if(empty($this->data))
				$this->data = require DIR_SITE.'/lib/config/config.php';
		}
	}
?>