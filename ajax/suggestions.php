<?php
require_once 'config.php';
class autosuggestions {
	public function users($q) {
		$q = trim($q);
		$url = "https://api.instagram.com/v1/users/search?q=".$q."&count=5&access_token=". ACCESS_TOKEN;
		try {
			$contents = file_get_contents($url);
			if (empty($contents)) {
				throw new Exception("[\"empty\"]");
			}
			return $contents;
		} catch (Exception $e) {
			die($e->getMessage());
		}
	}

	public function tags($q) {
		$q = trim($q);
		$url = "https://plus.google.com/complete/search?hjson=t&client=es-hashtags&q=". $q;
		try {
			$contents = file_get_contents($url);
			if (empty($contents)) {
				throw new Exception("[\"empty\"]");
			}
			return $contents;
		} catch (Exception $e) {
			die($e->getMessage());
		}
	}
}

header('Content-type: application/json');
if (isset($_REQUEST['users'])) {
	$q = $_REQUEST['users'];
	$autosuggestions = new autosuggestions();
	$contents = $autosuggestions->users($q);
	$data = json_decode($contents);
	$i = 1;
	try{
		echo "[\"$q\",[";
		$c = count($data->data);
		if (empty($c)) {
			throw new Exception("[\"error occured\"]");
		}
		foreach($data->data as $item) {
			echo "\"".$item->username."\"";
			if ($i < $c) {
				echo ",";
			}
			$i++;
		}
	} catch (Exception $e) {
		die($e->getMessage());
	}
	echo "]]";
	} else if (isset($_REQUEST['tags'])) {
		$q = $_REQUEST['tags'];
		$autosuggestions = new autosuggestions();
		$data = $autosuggestions->tags($q);
		echo $data;
	} else if (isset($_REQUEST['location'])) {
		require_once 'location.php';
		$term = trim(strtolower($_REQUEST['location'])); // trim the query
		$url = str_replace(array(" ", "(", ")"), array("", "", ""), $term);
		$gmaps = new gmaps();
		$data = $gmaps->get($url);
		$arr = json_decode($data);
		$i = 1;
		try{
		echo "[\"$url\",[";
		$c = count($arr->suggestion);
		if (empty($c)) {
			throw new Exception("[\"error occured\"]");
		}

		foreach($arr->suggestion as $item) {
			echo "\"".$item->query."\"";
			if ($i < $c) {
				echo ",";
			}
				$i++;
			}
		} catch (Exception $e) {
			die($e->getMessage());
		}
		echo "]]";
	} else {

}

?>