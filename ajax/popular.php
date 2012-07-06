<?php

require 'config.php';
require 'connect.php';
require 'util.php';

class popular {

	public function checkIt($obj) {
		$pid = $obj['pid'];
		$query = mysql_query("SELECT * FROM `popular` WHERE pid = '$pid'") or die(mysql_error());
		$result = mysql_fetch_array($query);
		if (empty($result)) {
			// not present in the DB, need to insert 
			//$query = mysql_query("INSERT INTO `popular` ( attribution, type, latitude, longitude, comments, filter, created_time, link, likes, low_resolution, thumbnail, standard_resolution, pid, username, website, bio, profile_picture, full_name, uid ) VALUES ('$obj['attribution']','$obj['type']','$obj['latitude']','$obj['longitude']','$obj['comments']','$obj['filter']','$obj['created_time']','$obj['link']','$obj['likes']','$obj['low_resolution']','$obj['thumbnail']','$obj['standard_resolution']','$obj['pid']','$obj['username']','$obj['website']','$obj['bio']','$obj['profile_picture']','$obj['full_name']','$obj['uid']')") or die(mysql_error());
			$query = mysql_query("INSERT INTO `popular` ( attribution, type, latitude, longitude, comments, filter, created_time, link, likes, low_resolution, thumbnail, standard_resolution, pid, username, website, bio, profile_picture, full_name, uid ) VALUES ('".$obj['attribution']."','".$obj['type']."','".$obj['latitude']."','".$obj['longitude']."','".$obj['comments']."','".$obj['filter']."','".$obj['created_time']."','".$obj['link']."','".$obj['likes']."','".$obj['low_resolution']."','".$obj['thumbnail']."','".$obj['standard_resolution']."','".$obj['pid']."','".$obj['username']."','".$obj['website']."','".$obj['bio']."','".$obj['profile_picture']."','".$obj['full_name']."','".$obj['uid']."')") or die(mysql_error());
			$getR = mysql_query("SELECT * FROM `popular` WHERE pid = '$pid'");
			$result = mysql_fetch_array($getR);
            return $result;
		} else {
			// already present in the DB, just return the array
			return $result;
		}
		return $result;
	}

	public function getLatest() {
		$url = "https://api.instagram.com/v1/media/popular?access_token=". ACCESS_TOKEN;
		//$url = "http://localhost/instagram/pop.json";
		$data = file_get_contents($url);
		return $data;
	}

	public function storeIt() {
		$data = $this->getLatest();
		$content = json_decode($data);
		foreach($content->data as $item) {
			$obj['attribution'] = $item->attribution;
			$obj['type'] = $item->type;
			if (isset($item->location)) {
				$obj['latitude'] = $item->location->latitude;
				$obj['longitude'] = $item->location->longitude;
			} else {
				$obj['latitude'] = '';
				$obj['longitude'] = '';
			}
			$obj['comments'] = $item->comments->count;
			$obj['filter'] = $item->filter;
			$obj['created_time'] = $item->created_time;
			$obj['link'] = $item->link;
			$obj['likes'] = $item->likes->count;
			$obj['low_resolution'] = $item->images->low_resolution->url;
			$obj['thumbnail'] = $item->images->thumbnail->url;
			$obj['standard_resolution'] = $item->images->standard_resolution->url;
			$obj['pid'] = $item->id;
			$obj['username'] = $item->user->username;
			$obj['website'] = $item->user->website;
			$obj['bio'] = $item->user->bio;
			$obj['bio'] = str_replace("'", " ", $obj['bio']);
			$obj['profile_picture'] = $item->user->profile_picture;
			$obj['full_name'] = $item->user->full_name;
			$obj['full_name'] = str_replace("'", " ", $obj['full_name']);
			$obj['uid'] = $item->user->id;
			
			$check = $this->checkIt($obj);
			//echo "<pre>"; print_r($check); echo "</pre>";
		}
		return $content;
	}
	
	public function fetchLatest() {
		$query = mysql_query("SELECT * FROM `popular` ORDER BY id DESC LIMIT 10") or die(mysql_error());
		while ($result = mysql_fetch_assoc($query)) {
			$rows[] = $result;
		}
		return $rows;
	}
	
}

	if (isset($_REQUEST['popular'])) {
		$popular = new popular();
		header('Content-type: application/json');
		$rows = $popular->fetchLatest();
		if (isset($_GET['callback'])) {
			echo $_GET['callback'] . ' (' . indent(json_encode( $rows )) . ');';  
		} else {
			echo indent(json_encode( $rows ));
		}
	} else if (isset($_REQUEST['update'])) {
		$popular = new popular();
		$data = $popular->storeIt();
	}

?>