<?php
	$dbhost='202.44.12.253';
	$dbuser='dbcon';
	$dbpass='NYc9BVJsK1a8knMM';
    $dbname='icoccac';
    $data = array();
	
//////// Do not Edit below /////////
// 	try {
// 	$pdo = new PDO('mysql:host='.$dbhost.';dbname='.$dbname, $dbuser, $dbpass,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
// 	} catch (PDOException $e) {
// 	print "Error!: " . $e->getMessage() . "<br/>";
// 	die();
// }
//     $sth_select = $pdo->prepare("SELECT * FROM tb_data ORDER BY timestamp DESC LIMIT 1");
// 	$sth_select->execute();
//     $rows = $sth_select->fetchAll(PDO::FETCH_ASSOC);

    $db = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

    if($db->connect_error){
        die("Unable to connect database: " . $db->connect_error);
    }

    //get user data from the database
    $query = $db->query("SELECT * FROM tb_data ORDER BY timestamp DESC LIMIT 1");

    if($query->num_rows > 0){
        $data['status'] = 'ok';
        $data['result'] = $query->fetch_assoc();
    }else{
        $data['status'] = 'err';
        $data['result'] = '';
    }
    
    //returns data as JSON format
    echo json_encode($data);