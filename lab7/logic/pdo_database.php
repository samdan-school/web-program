<?php
	$username = "root";
	$password = "";

	try {
		$pdo_connection = new PDO('mysql:host=localhost;dbname=student_app_04', $username, $password);
	} catch (PDOException $e) {
		print "Error!: " . $e->getMessage() . "<br/>";
		die();
	}
?>