<?php

require_once 'config.php';
class gmaps{
	public function get($q) {
		try {
	$connection_url="http://maps.google.com/maps/suggest?cp=999&hl=en-US&gl=en-US&v=2&json=b&num=10&q=".$q;
	$userAgent =  "Mozilla/5.0 (Windows NT 5.1) AppleWebKit/536.5 (KHTML, like Gecko) Chrome/19.0.1084.52 Safari/536.5"; 
	$cookie = "";
	$header[] = "Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8";
	$header[] = "Accept-Charset:ISO-8859-1,utf-8;q=0.7,*;q=0.3";
	$header[] = "Accept-Encoding:gzip,deflate";
	$header[] = "Cache-Control:max-age=0";
	$header[] = "Connection: keep-alive";
	$header[] = "Accept-Language:en-US,en;q=0.8";
	$ch = curl_init('maps.google.com');
	curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	curl_setopt($ch, CURLOPT_URL, $connection_url);
	curl_setopt($ch, CURLOPT_COOKIE, $cookie);
	curl_setopt($ch, CURLOPT_FAILONERROR, true);
	curl_setopt($ch,CURLOPT_ENCODING, 1);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_AUTOREFERER, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
	curl_setopt($ch, CURLOPT_TIMEOUT, 30);
	$data = curl_exec($ch);
		if(empty($data)) {
			throw new Exception("[\"error\"]");
		}
	return $data;
	
	  } catch (Exception $e) {
		die($e->getMessage());
	  }
	}

	public function getData ($lati , $long) {
	try {
		$url = "https://api.instagram.com/v1/media/search?lat=". $lati ."&lng=". $long ."&access_token=". ACCESS_TOKEN;
		$data = file_get_contents($url);
		if (empty($data)) {
			throw new Exception("[\"empty id\"]");
		}
	} catch (Exception $e) {
		die($e->getMessage());
	  }
		return $data;
	}
}
	
header('Content-type: application/json');
if (isset($_REQUEST['address'])) {
	$term = trim(strtolower($_REQUEST['address'])); // trim the query
	$term = str_replace( " ", "+", $term);
	$url = "http://where.yahooapis.com/geocode?appid=yNb0oJ4q&flags=J&q=". $term;
	try {
		$content = file_get_contents($url);
		if (empty($content)) {
			throw new Exception("[\"code error\"]");
		}
		$data = json_decode($content , true);
	} catch (Exception $e) {
		die($e->getMessage());
	}
	foreach ($data as $item) {
		//echo "<pre>"; print_r ($data); echo "</pre>";
		try {
			if (empty($item)) {
				throw new Exception("[\"lat not found\"]");
			}
			$lati = $item['Results'][0]['latitude'];
			$long = $item['Results'][0]['longitude'];
		}  catch (Exception $e) {
			die($e->getMessage());
		}
	}
	$gmaps = new gmaps();
	try {
		$data = $gmaps->getData($lati, $long);
		if (empty($data)) {
			throw new Exception("[\"data not found\"]");
		}
		print($data);
	} catch (Exception $e) {
		die($e->getMessage());
	}
} else {
	
}

?>