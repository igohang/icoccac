<?php
	echo "Start >> ";
	
	$dbhost='202.44.12.253';
	$dbuser='dbcon';
	$dbpass='NYc9BVJsK1a8knMM';
    $dbname='icoccac';
	try {
	$pdo = new PDO('mysql:host='.$dbhost.';dbname='.$dbname, $dbuser, $dbpass,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
	} catch (PDOException $e) {
	print "Error!: " . $e->getMessage() . "<br/>";
	die();
	}
	
	//$temp = 10;
	$location = $_GET['location'];
	$pm1 = $_GET['pm1'];
	$pm25 = $_GET['pm25'];
	$pm10 = $_GET['pm10'];
	$temp = $_GET['temp'];
	$humi = $_GET['humi'];

	$sql = "INSERT INTO tb_data (location, pm1, pm25, pm10, temp, humi) VALUES ('$location', '$pm1', '$pm25', '$pm10', '$temp', '$humi')";
	$stmt= $pdo->prepare($sql);
	$stmt->execute([$name, $surname, $sex]);
	;
	echo " Success!!!";