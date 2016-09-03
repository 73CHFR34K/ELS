<?php

	function login($username, $password) {
		global $config;
		$username = _hash($username.$config['account']['salt']);
		$password = _hash($password.$config['account']['salt']);
		$userHash = _hash($config['account']['user'].$config['account']['salt']);
		$passHash = _hash($config['account']['pass'].$config['account']['salt']);
		if($username==$userHash&&$password==$passHash) {
			_setcookie("username", $userHash, $config['account']['time']);
			_setcookie("password", $passHash, $config['account']['time']);
			return true;
		}
		return false;
	}
	
	function logout() {
		_deletecookie("username");
		_deletecookie("password");
	}

	function isLoggedIn() {
		global $config;
		$userHash = _hash($config['account']['user'].$config['account']['salt']);
		$passHash = _hash($config['account']['pass'].$config['account']['salt']);
		$userHashCookie = _cookie("username");
		$passHashCookie = _cookie("password");
		if($userHash==$userHashCookie&&$passHash==$passHashCookie) {
			return true;
		}
		return false;
	}
	
	function generateKey() {
		global $config;
		$letters = "0123456789";
		$letters2 = "abcdefghijklmnopqrstuvwxyz1234567890";
		$code = "";
		for($i=0; $i<strlen($config['key']['shema']); $i++) {
			switch($config['key']['shema'][$i]) {
				case "D":
					$code.= $letters[rand(0, strlen($letters)-1)];
					break;
				case "E":
					$code.= $letters2[rand(0, strlen($letters)-1)];
					break;
				default:
					$code.=$config['key']['shema'][$i];
			}
		}
		return strtoupper($code);
	}
	
	function getUsers() {
		$result = mysql_query("SELECT * FROM `keys` WHERE NOT hwid='' ORDER BY created DESC");
		echo mysql_error();
		$return = array("id", "hwid", "registered", "expiredate", "product");
		$arr = array();
		for($i=0; $i<mysql_num_rows($result); $i++) {
			foreach($return as $k=>$v) {
				$arr[$i][$v] = mysql_result($result, $i, $v);
			}
		}
		return $arr;
	}
	
	function getKeys() {
		$result = mysql_query("SELECT * FROM `keys` WHERE hwid='' ORDER BY created DESC");
		echo mysql_error();
        
		$return = array("id", "key", "created", "date");
		$arr = array();
		for($i=0; $i<mysql_num_rows($result); $i++) {
			foreach($return as $k=>$v) {
				$arr[$i][$v] = mysql_result($result, $i, $v);
			}
		}
		return $arr;
	}

	function addKey() {
		mysql_query("INSERT INTO `keys` (`key`, `Date`) VALUES ('".generateKey()."', '".$_POST['txtDate']."')");
		
	}
	
	function deleteKey($id) {
		mysql_query("DELETE FROM `keys` WHERE id = ".$id);
	}

	function resetKey($id) {
		mysql_query("UPDATE `keys` SET hwid = '' WHERE id = ".$id);
	}

	/* API */
	function canUse($hwid, $product) { 
		if(!$hwid) { return false; }
		$result = mysql_query("SELECT * FROM `keys` WHERE `hwid` = '".$hwid."' AND product = '".$product."'"); 
		return mysql_num_rows($result)>0;
	}

    function dateCheck($hwid, $config) {
        $db = new PDO('mysql:host='.$config['mysql']['host'].';dbname='.$config['mysql']['datb'].'', $config['mysql']['user'], $config['mysql']['pass']);  

        $stmt = $db->prepare("SELECT * FROM `keys` where hwid = :hwid");

        $stmt->bindParam(":hwid", $hwid);
        $stmt->execute();
        
        $result = $stmt->fetchAll();
        if($result != null) {
         foreach($result as $row) {
           echo $row['product']. $row['expireDate'].":" .$row['product']."<br />"; 
         }
        } else {
        echo "Database returned null";
        }  
         
    }

    
	function isFree($key) {
		if(!$key) { return false; }
		$result = mysql_query("SELECT * FROM `keys` WHERE `key` = '".$key."' AND `hwid` = ''");
		return mysql_num_rows($result)>0;
	}
	
	function isKey($key) {
		$result = mysql_query("SELECT * FROM `keys` WHERE `key` = '".$key."'");
		return mysql_num_rows($result)>0;
	}
	
	function registerKey($key, $hwid, $product, $config) {
		if(!$hwid) { return "error: wrong hwid"; }
		if(!$key) { return "error: wrong key"; }
		if(!isKey($key)) { return "error: wrong key"; }
		if(!isFree($key)) { return "error: key is already in use"; }  
        $db = new PDO('mysql:host='.$config['mysql']['host'].';dbname='.$config['mysql']['datb'].'', $config['mysql']['user'], $config['mysql']['pass']); 
        $stmt = $db->prepare("SELECT * FROM `keys` where `key` = :key");
        $stmt->bindParam(":key", $key);
        $stmt->execute();

        // Result holen
        $result = $stmt->fetchAll();
        if($result != null) {
         foreach($result as $row) {
            $timestamp = strtotime($row['Date']. "days"); 
         }
        } else {
        echo "Database returned null";
        }  
		mysql_query("UPDATE `keys` SET `hwid` = '".$hwid."',  `expireDate` = '".date("Y-m-d", $timestamp)."', `product` = '".$product."', `registered` = '".date("Y-m-d H:i:s", time())."' WHERE `key` = '".$key."'");
		return canUse($hwid);
	}

?>
