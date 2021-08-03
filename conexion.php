<?php 

	$host = 'localhost';
	$user = 'root';
	$password = '';
	$db = 'tesis';


	$conection = @mysqli_connect($host,$user,$password,$db);

	if (!$conection) {
		echo "error en la conepcion";
	}

 ?>