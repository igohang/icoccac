<?php require('dbcon.php');
	$sth_select = $pdo->prepare("SELECT * FROM tb_data ORDER BY timestamp DESC LIMIT 1");
	$sth_select->execute();
	$rows = $sth_select->fetchAll(PDO::FETCH_ASSOC);
	
	$sth_g = $pdo->prepare("SELECT pm1, pm25, pm10, timestamp FROM tb_data ORDER BY timestamp DESC LIMIT 228;");
	$sth_g->execute();
	$resulta = $sth_g->fetchAll(\PDO::FETCH_ASSOC);
	$result = json_encode($resulta);


?>
<!doctype html>
<html lang="en">
<head>

	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-97240271-2"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'UA-97240271-2');
	</script>

	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="assets/img/icons/favicon.ico">
	<link rel="icon" type="image/png" sizes="96x96" href="assets/img/icons/favicon.ico">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>iCocCac - Air Quality Index (AQI)</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


    <!-- Bootstrap core CSS     -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Animation library for notifications   -->
    <link href="assets/css/animate.min.css" rel="stylesheet"/>

    <!--  Paper Dashboard core CSS    -->
    <link href="assets/css/paper-dashboard.css" rel="stylesheet"/>

    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="assets/css/demo.css" rel="stylesheet" />

    <!--  Fonts and icons     -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
    <link href="assets/css/themify-icons.css" rel="stylesheet">
    <link href="assets/css/weather-icons.css" rel="stylesheet">

    <!--  CSS for icoccac things     -->
    <link href="assets/css/icoccac-style.css" rel="stylesheet">

</head>
<body>

<div class="wrapper">

    <div class="main-panel">
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand " href="#">iCocCac <small> - Air Quality Index (AQI)</small></a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <!--<li>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="ti-panel"></i>
								<p>Stats</p>
                            </a>
                        </li>
                        <li class="dropdown">
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="ti-bell"></i>
                                    <p class="notification">5</p>
									<p>Notifications</p>
									<b class="caret"></b>
                              </a>
                              <ul class="dropdown-menu">
                                <li><a href="#">Notification 1</a></li>
                                <li><a href="#">Notification 2</a></li>
                                <li><a href="#">Notification 3</a></li>
                                <li><a href="#">Notification 4</a></li>
                                <li><a href="#">Another notification</a></li>
                              </ul>
                        </li>
						<li>
                            <a href="#">
								<i class="ti-settings"></i>
								<p>Settings</p>
                            </a>
                        </li>
						-->
                    </ul>

                </div>
            </div>
        </nav>

        <div class="content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                        <div class="card card">
                            <div class="content">
                                <div class="row">
                                    <div class="col-xs-5">
                                        <div class="icon-status-big text-center">
                                            <i class="wi wi-strong-wind"></i>
                                        </div>
                                    </div>
                                    <div class="col-xs-7">
                                        <div class="index-number">
                                            <p class="m-0">PM 1.0</p>
                                            <?php
												foreach ($rows as $row) {
													echo "".$row['pm1']."";
												}
                                            ?>
                                            <p class="m-0">
                                                <i class="ti-dashboard icon-status"></i><small> µg/m3 </small>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="footer">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                        <div class="card card-<?php
								if($row['aqi_pm10'] <50)
									echo "good";
								else if($row['aqi_pm10'] <100)
									echo "moderate";
								else if($row['aqi_pm10'] <150)
									echo "unhealthyfor";
								else if($row['aqi_pm10'] <200)
									echo "unhealthy";
								else if($row['aqi_pm10'] <300)
									echo "veryunhealthy";
								else 
									echo "hazardous";
							?>">
                            <div class="content">
                                <div class="row">
                                    <div class="col-xs-5">
                                        <div class="icon-status-big text-center">
                                            <i class="wi wi-sandstorm"></i>
                                        </div>
                                    </div>
                                    <div class="col-xs-7">
                                        <div class="index-number">
                                            <p class="m-0">PM 10.0</p>
                                            <?php
												foreach ($rows as $row) {
													echo "".$row['aqi_pm10']."";
												}
                                            ?>
                                            <p class="m-0">
                                                <i class="ti-dashboard icon-status"></i><small> <?php
												foreach ($rows as $row) {
													echo "".$row['pm10']."";
												}
                                            ?> µg/m3 </small>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="footer">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                        <div class="card">
                            <div class="content">
                                <div class="row">
                                    <div class="col-xs-5">
                                        <div class="icon-status-big text-center sky">
                                            <i class="wi wi-thermometer"></i>
                                        </div>
                                    </div>
                                    <div class="col-xs-7">
                                        <div class="index-number">
                                            <p class="m-0">Temperature</p>
                                            <?php
												foreach ($rows as $row) {
													echo "".$row['temp']."";
												}
                                            ?>
                                            <p class="m-0">
                                                <i class="ti-dashboard icon-status"></i><small> °C </small>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="footer">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                        <div class="card">
                            <div class="content">
                                <div class="row">
                                    <div class="col-xs-6">
                                        <div class="icon-status-big text-center sea">
                                            <i class="wi wi-humidity"></i>
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="index-number">
                                            <p class="m-0">Humidity</p>
                                            <?php
												foreach ($rows as $row) {
													echo "".$row['humi']."";
												}
                                            ?>
                                            <p class="m-0">
                                                <i class="ti-dashboard icon-status"></i><small> % </small>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="footer">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
					<div class="col-lg-3 col-md-3 col-xs-12">
                        <div class="card card-<?php
							$pm25status = " ";
								if($row['aqi_pm25'] <50){
									echo "good";
									$pm25status = "Good";
								}
								else if($row['aqi_pm25'] <100){
									echo "moderate";
									$pm25status = "Moderate";
								}
								else if($row['aqi_pm25'] <150){
									echo "unhealthyfor";
									$pm25status = "Unhealthy for Sensitive Groups";
								}
								else if($row['aqi_pm25'] <200){
									echo "unhealthy";
									$pm25status = "Unhealthy";
								}
								else if($row['aqi_pm25'] <300){
									echo "veryunhealthy";
									$pm25status = "Very Unhealthy";
								}
								else {
									echo "hazardous";
									$pm25status = "Hazardous";
								}
							?>">
                            <div class="content">
                                <div class="row">
                                    <div class="col-xs-12 text-center">
                                        <i class="wi wi-smoke icon-topic"></i>
                                        <p class="text-center m-0">PM 2.5</p>
                                        <div class="fontbig">
											<?php
												foreach ($rows as $row) {
													echo "".$row['aqi_pm25']."";
												}
											?>
                                        </div>
                                        <p class="m-0">
                                            <i class="ti-dashboard icon-status"></i><small> <?php
												foreach ($rows as $row) {
													echo "".$row['pm25']."";
												}
											?> µg/m3 </small></br>
											<?php echo $pm25status ;?>
                                        </p>
                                    </div>
                                </div>
                                <div class="footer">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-9 col-md-9 col-xs-12">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Graph</h4>
                                <p class="category">24 Hours</p>
                            </div>
                            <div class="content">
                                <canvas id="myChart" width="100" height="30vh"></canvas>
                                <div class="footer">
                                    <hr>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-xs-12 text-center">
                        <i class="ti-location-pin icon-topic"></i>
                        <p>Location</p>
                        <div class="fontbig-2">
                            10th Floor</be>
                            Witsawa Watthana Building @KMUTT.
                        </div>
                    </div>
                    <div class="col-xs-12 text-center" style="margin-top:10px;">
                        <i class="ti-reload"></i> 
                            Last Update
                        <?php
                                foreach ($rows as $row) {
                                	echo "".$row['timestamp']."";
                                }
                            ?></br></br>
							Air Quality Index (AQI) calculated in <a href="https://en.wikipedia.org/wiki/Air_quality_index#United_States">United States Environmental Protection Agency standard.</a>
                    </div>
                </div>

               <!-- <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Email Statistics</h4>
                                <p class="category">Last Campaign Performance</p>
                            </div>
                            <div class="content">
                                <div id="chartPreferences" class="ct-chart ct-perfect-fourth"></div>

                                <div class="footer">
                                    <div class="chart-legend">
                                        <i class="fa fa-circle text-info"></i> Open
                                        <i class="fa fa-circle text-danger"></i> Bounce
                                        <i class="fa fa-circle text-warning"></i> Unsubscribe
                                    </div>
                                    <hr>
                                    <div class="stats">
                                        <i class="ti-timer"></i> Campaign sent 2 days ago
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card ">
                            <div class="header">
                                <h4 class="title">2015 Sales</h4>
                                <p class="category">All products including Taxes</p>
                            </div>
                            <div class="content">
                                <div id="chartActivity" class="ct-chart"></div>

                                <div class="footer">
                                    <div class="chart-legend">
                                        <i class="fa fa-circle text-info"></i> Tesla Model S
                                        <i class="fa fa-circle text-warning"></i> BMW 5 Series
                                    </div>
                                    <hr>
                                    <div class="stats">
                                        <i class="ti-check"></i> Data information certified
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				-->
            </div>
        </div>

        <footer class="footer">
            <div class="container-fluid">
                <nav class="pull-left">
                    <ul>
<!--
                        <li>
                            <a href="http://www.creative-tim.com">
                                Creative Tim
                            </a>
                        </li>
                        <li>
                            <a href="http://blog.creative-tim.com">
                               Blog
                            </a>
                        </li>
                        <li>
                            <a href="http://www.creative-tim.com/license">
                                Licenses
                            </a>
                        </li>
						-->
                    </ul>
                </nav>
                <div class="copyright set-center">
                    &copy; <script>document.write(new Date().getFullYear())</script> by iconnex.in.th x menn.me x megawish.in.th</br>
					CPE@KMUTT
                    <br>Template with <i class="fa fa-heart heart"></i> by <a href="http://www.creative-tim.com">Creative Tim</a>
                </div>
            </div>
        </footer>

    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
<script>
    var ctx = document.getElementById("myChart");
	
	var labelss = <?php echo $result; ?>;
	var x = [];
	var y1 = [];
	var y25 = [];
	var y10 = [];
	for(let i = 0 ; i < labelss.length ; i++)
	{
		x[i] = labelss[i].timestamp.substring(10,16);;
		y1[i] = labelss[i].pm1;
		y25[i] = labelss[i].pm25;
		y10[i] = labelss[i].pm10;
	}
	x = x.reverse();
	y1 = y1.reverse();
	y25 = y25.reverse();
	y10 = y10.reverse();
	
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: x,
            datasets: [
			{
                label: 'PM 1.0',
                data: y1,
                backgroundColor: [
                    'rgba(85, 221, 228, 0.5)', 
                ],
                borderColor: [
                    'rgba(85, 166, 203, 1)',
                ],
                borderWidth: 2,
                radius: 2
            },
			{
                label: 'PM 2.5',
                data: y25,
                backgroundColor: [
                    'rgba(242, 100, 25, 0.5)',
                ],
                borderColor: [
                    'rgba(242, 100, 25, 1)',
                ],
                borderWidth: 2,
                radius: 2
            },
			{
                label: 'PM 10.0',
                data: y10,
                backgroundColor: [
                    'rgba(50, 54, 66, 0.2)',
                ],
                borderColor: [
                    'rgba(50, 54, 66, 1)',
                ],
                borderWidth: 2,
                radius: 2
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:false
                    }
                }]
            }
        }
    });
</script>

</body>

    <!--   Core JS Files   -->
    <script src="assets/js/jquery.min.js" type="text/javascript"></script>
	<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>

	<!--  Checkbox, Radio & Switch Plugins -->
	<script src="assets/js/bootstrap-checkbox-radio.js"></script>

	<!--  Charts Plugin -->
	

    <!--  Notifications Plugin    -->
    <script src="assets/js/bootstrap-notify.js"></script>

    <!--  Google Maps Plugin    -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>

    <!-- Paper Dashboard Core javascript and methods for Demo purpose -->
	<script src="assets/js/paper-dashboard.js"></script>

	<!-- Paper Dashboard DEMO methods, don't include it in your project! -->
	<script src="assets/js/demo.js"></script>



</html>
