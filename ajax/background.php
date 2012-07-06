<?php

	require 'connect.php';

	class background {
		
		public function getBackground($id) {
			$query = mysql_query("SELECT * FROM `background` WHERE id = '$id'") or die(mysql_error());
			$result = mysql_fetch_array($query);
			if (!empty($result)) {
				return $result['url'];
			} else {
				$result = "http://distilleryimage6.s3.amazonaws.com/ea81c858c1c811e192e91231381b3d7a_7.jpg";
				return $result;
			}
			
		}
		
		public function insertBG($url) {
			$url = trim($url);
			$query = mysql_query("INSERT INTO `background`(`url`) VALUES ('$url')") or die(mysql_error());
			$query = mysql_query("SELECT * FROM `background` WHERE url = '$url'") or die(mysql_error());
			$result = mysql_fetch_array($query);
			if (!empty($result)) {
				return $result['url'];
			} else {
				echo 'error';
			}
		}
	
	}

?>