<?php
	$dbhost='localhost';
	$dbuser='dbcon';
	$dbpass='NYc9BVJsK1a8knMM';
    $dbname='icoccac';
    $data = array();
	
    $db = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

    if($db->connect_error){
        die("Unable to connect database: " . $db->connect_error);
    }

    //get user data from the database
    $query = $db->query("SELECT * FROM tb_data ORDER BY timestamp DESC LIMIT 2");
    $query1 = $db->query("SELECT * FROM tb_data WHERE location=1 ORDER BY timestamp DESC LIMIT 2");
    $query2 = $db->query("SELECT * FROM tb_data WHERE location=2 ORDER BY timestamp DESC LIMIT 2");
    $query3 = $db->query("SELECT * FROM tb_data WHERE location=3 ORDER BY timestamp DESC LIMIT 2");
    // $query4 = $db->query("SELECT * FROM tb_data WHERE location=4 ORDER BY timestamp DESC LIMIT 2");

    if($query->num_rows > 0){
        $data['status'] = 'ok';
        $data['result_01'] = $query1->fetch_assoc();
        $data['result_02'] = $query2->fetch_assoc();
        $data['result_03'] = $query3->fetch_assoc();
    }else{
        $data['status'] = 'err';
        $data['result_01'] = "";
        $data['result_02'] = "";
        $data['result_03'] = "";
    }
    
    //returns data as JSON format
    echo json_encode($data);