<?php

	define('HOST', 'localhost');
	define('USER', 'root');
	define('PASSWORD', '');
	define('DATABASE', 'winstagram');

	$connection = mysql_connect( HOST , USER , PASSWORD ) or die('Could not connect: ' . mysql_error());

	$db = mysql_select_db( DATABASE ) or die('error selecting database' . mysql_error());

?>