<?php

	function _request($str) {
		if(isset($_REQUEST[$str])) {
			return $_REQUEST[$str];
		}
	}
	
	function _get($str) {
		if(isset($_GET[$str])) {
			return $_GET[$str];
		}
	}
	
	function _post($str) {
		if(isset($_POST[$str])) {
			return $_POST[$str];
		}
	}
	
	function session($session) {
		if(isset($_SESSION[$session])) {
			return $_SESSION[$session];
		}
	}
	
	function getIP() {
		if(isset($_SERVER["REMOTE_ADDR"])) { 
			return ''.$_SERVER["REMOTE_ADDR"].''; 
		} 
		elseif(isset($_SERVER["HTTP_X_FORWARDED_FOR"])) { 
			return ''.$_SERVER["HTTP_X_FORWARDED_FOR"].''; 
		}
		elseif(isset($_SERVER["HTTP_CLIENT_IP"])) { 
			return ''.$_SERVER["HTTP_CLIENT_IP"].''; 
		} 
	}
	
	function refresh() {
		mysqlclose();
		header("Location: ".$_SERVER["REQUEST_URI"]);
		die();
	}
	
	function index($add=".") {
		mysqlclose();
		header("Location: ".$add);
		die();
	}
	
?>