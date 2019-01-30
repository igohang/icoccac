<?php
	$dbhost='localhost';
	$dbuser='dbcon';
	$dbpass='NYc9BVJsK1a8knMM';
	$dbname='icoccac';
	
//////// Do not Edit below /////////
	try {
	$pdo = new PDO('mysql:host='.$dbhost.';dbname='.$dbname, $dbuser, $dbpass,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
	} catch (PDOException $e) {
	print "Error!: " . $e->getMessage() . "<br/>";
	die();
}

