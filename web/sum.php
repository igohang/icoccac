<?php require('dbcon.php');
	$sth_select = $pdo->prepare("SELECT * FROM tb_data WHERE location = 1 and timestamp >= DATE_SUB(NOW(),INTERVAL 1 HOUR); ");
	$sth_select->execute();
	$count = $sth_select->rowCount();
	$rows = $sth_select->fetchAll(PDO::FETCH_ASSOC);
	$sum_pm1 = 0;
	$sum_pm25 = 0;
	$sum_pm10 = 0;
	$location = 1;
	
	foreach ($rows as $row) {
		$sum_pm1 = $sum_pm1 + $row['pm1'];
		$sum_pm25 = $sum_pm25 + $row['pm25'];
		$sum_pm10 = $sum_pm10 + $row['pm10'];
	}
	$sum_pm1 = $sum_pm1/$count;
	$sum_pm25 = $sum_pm25/$count;
	$sum_pm10 = $sum_pm10/$count;
	
	
	$data = [
    'location' => $location,
    'pm1' => $sum_pm1,
    'pm25' => $sum_pm25,
	'pm10' => $sum_pm10
];
	
	$sql = "INSERT INTO tb_sumary (location, pm1, pm25, pm10) VALUES (:location,:pm1,:pm25,:pm10)";
	$stmt= $pdo->prepare($sql);
	$stmt->execute($data);
	
	echo "Finisged";
	?>