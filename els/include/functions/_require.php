<?php

	$handle = opendir(dirname(__FILE__)); 
    while (false !== ($file = readdir($handle))) { 
		if (preg_match("=^\.{1,2}$=", $file)) { 
			continue; 
		}
		if($file!="_require.php") {
			require ($file);
		}
	}
	closedir($handle); 
	
?>