<?php

	function mysqlconnect() {
		global $config;
		mysql_connect($config['mysql']['host'], $config['mysql']['user'], $config['mysql']['pass']) or die("MySql: Can not connect."); 
		mysql_select_db($config['mysql']['datb']) or die("MySql: Can not select database.");
	}
	
	function mysqlclose() {
		mysql_close();
	}

?>