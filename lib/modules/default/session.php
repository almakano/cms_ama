<?php 
	class Session extends Singleton {

		function after_create() {

			if(!session_id()) session_start();
			if(!isset($this->data)) $this->data = $_SESSION;
		}

		function before_destroy() {

			if(isset($this->data)) {
				$_SESSION = $this->data;
			}

		}
	}
?>