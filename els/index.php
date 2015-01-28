<?php

	// Calculate Time
	$time = microtime();
	$time = explode(' ', $time);
	$time = $time[1] + $time[0];
	$start = $time;
	
	// Load Files
	require('config.php');
	require('include/functions/_require.php');
	
	// Connect to MySql
	mysqlconnect();
	
	//phpinfo();
	
	// Start Sessions
	/*session_cache_limiter("private");
	session_cache_expire(30); // Minuten
	session_start();*/
	
	// API
	function booltostr($bool) {
		if($bool===true) { return "TRUE"; }
		elseif($bool===false) { return "FALSE"; }
		return $bool;
	}
	
	$action = _get("a");
	if($action) {
		$key = _get("key");
		$hwid = _get("hwid");
        $date =  _get("date");
        $expiredate = _get("expiredate");
        $product = _get("product");
		switch($action) {
			case "canuse":
				echo booltostr(canUse($hwid, $product));
				break;
			case "register":
				echo booltostr(registerKey($key, $hwid, $product, $config));
				break;
                case "checkdate":
                       dateCheck($hwid, $config); 
                    break;
			default:
				echo "error: wrong action";
				break;
		}
		mysqlclose();
		//exit;
	}
	
	// No Cache
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") ." GMT");
	header("Cache-Control: no-cache");
	header("Pragma: no-cache");
	header("Cache-Control: post-check=0, pre-check=0", FALSE);
	
	// Get Page
	$s = $config['sites_standart'];
	$_s = _get('s');
	if(array_key_exists($_s, $config['sites'])) { $s = $_s; }
	$pageTitle = $config['sites'][$s]['title'];
	$pageFile = $config['sites'][$s]['include'];

	// Load Scripts
	$action = _post("action");
	if($action) {
		$id = _post("id");
		switch($action) {
			case "login":
				login(_post("username"), _post("password"));
				break;
			case "logout":
				logout();
				break;
			case "delete":
				deleteKey($id);
				break;
			case "reset":
				resetKey($id);
				break;
			case "addkey":
				addKey();
				break;
		}
		refresh();
	}

	// Protection
	define("LOGGED_IN", isLoggedIn());
	function canAccessPage($page = "") {
		global $s, $config;
		if(!$page) { $page = $s; }
		return $config['sites'][$page]['showLoggedIn']==true&&LOGGED_IN==true||$config['sites'][$page]['showLoggedOut']==true&&LOGGED_IN==false;
	}
	
	if(!canAccessPage()) {
		if(LOGGED_IN) {
			index("?s=users");
		}
		index();
	}
	
	// Load Page
	$users = getUsers();
	$keys = getKeys();
	
$doc = '<!DOCTYPE html>
<html>
<head>
	<title>_#title#_</title>

	<link rel="icon" href="grafik/images/epvp.png" type="image/x-icon" />
	<link href="grafik/css/standart.css" rel="stylesheet" type="text/css" media="screen" />
	
	'; if(true==false) { $doc.='
	<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
	'; } else { $doc.='
	<script src="jquery_1.8.3.js" type="text/javascript"></script>
	'; } $doc.='
	
	<meta charset="ISO-8859-1">
</head>
<body>
	
	<div id="fullWrapper">
		<div id="headerWrapper">
			<a href=".">
				<div id="header">
					<div id="title">
						<span>ELS</span>  - <span>E</span>asy <span>L</span>icense <span>S</span>ystem
					</div>
					<div id="version">
						'.$config['page']['version'].'
					</span>
				</div>
			</a>
		</div>
		<div id="naviWrapper">
			'; foreach($config['sites'] as $site=>$value) { if(canAccessPage($site)) { $doc.='
				<a href="?s='.$site.'" class="left '.(($s==$site) ? "active" : "").'">'.$value['title'].' '.(strtolower($value['title'])=="users" ? "(".count($users).")" : "").''.(strtolower($value['title'])=="keys" ? "(".count($keys).")" : "").'</a>
			'; } }; $doc.= '
			
			'; if(LOGGED_IN) { $doc.='
				<form action="." method="post">
					<input type="text" style="display: none;" name="action" value="logout"></input>
					<input type="submit" class="right pointer" value="Logout"></input>
				</form>
			'; } $doc.='
			<div class="clear"></div>
		</div>
		<div id="contentWrapper">
			'; include($config['sites'][$s]['include']); $doc.='
		</div>
		<div id="footerWrapper">
			<div class="left" style="padding: 5px;">
				Entwickelt und designt von: <a href="http://www.elitepvpers.com/forum/members/2342603-shawak.html">Shawak</a> & <a href="http://www.elitepvpers.com/forum/members/4790379-kusatsu.html">Kusatsu</a><br/>
				Schaue dir <a href="?s=about">about</a> an f&uuml;r Informationen.<br/>
			</div>
		
			<div class="clear"></div>
		</div>
	</div>
	
	<script>

		// Inputs
		function onFocus(elem, color) {if(elem.value == elem.alt){elem.value = \'\';elem.style.color = color;}}
		function onBlur(elem, color) {if(elem.value == \'\'){elem.value = elem.alt;elem.style.color = color;}}
		var inputs = $("input:text, input:password");
		$(inputs).each(function() {
			if($(this).attr("alt")) {
				$(this).attr("value", $(this).attr("alt"));
				$(this).attr("onfocus", "onFocus(this, \'rgb(10, 10, 10)\')");
				$(this).attr("onblur", "onBlur(this, \'rgb(150, 150, 150)\')");
				$(this).css("color", \'rgb(150, 150, 150)\');
			}
		});
		
		$(".submitFormDelete").click(function() {
			$("[name=\"id\"]").attr("value", $(this).attr("alt"));
			$("[name=\"action\"]").attr("value", "delete");
			$("#form").submit();
		});
		
		$(".submitFormReset").click(function() {
			$("[name=\"id\"]").attr("value", $(this).attr("alt"));
			$("[name=\"action\"]").attr("value", "reset");
			$("#form").submit();
		});

	</script>
	
</body>
</html>';
	
	// Generate Page title
	$title = $pageTitle.' - '.$config['page']['title'];
	$doc = str_replace('_#title#_', $title, $doc);
	
	// Disconnect from MySql
	mysqlclose();
	
	// Calculate Time
	$time = microtime();
	$time = explode(' ', $time);
	$time = $time[1] + $time[0];
	$finish = $time;
	$total_time = round(($finish - $start), 4);
	$doc = str_replace('_#totalTime#_', $total_time, $doc);
		
	// Show website
	echo $doc;
	
?>