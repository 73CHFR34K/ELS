<?php

	function _setcookie($cookie, $value, $expire) {
		setcookie($cookie, $value,  time() + $expire);
	}
	
	function _deletecookie($cookie) {
		setcookie($cookie, "",  time() - 3600);
	}
	
	function _cookie($cookie) {
		if(isset($_COOKIE[$cookie])) {
			return $_COOKIE[$cookie];
		}
	}
	
?>