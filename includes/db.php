<?php

	ob_start(); 
	//much more secure way by using intiating connection with constant
	$db['db_host'] = "localhost";
	$db['db_user'] = "root";
	$db['db_pass'] = "";
	$db['db_name'] = "cms";

	//change info of a db to uppercase
	foreach ($db as $key => $value) {
		define(strtoupper($key), $value); //change variable to uppercase
	}

	$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

	if ($connection) {
		// echo "We're connected!";
	}


 ?>
