<?php require('dbcon.php');
$sth_select = $pdo->prepare("SELECT * FROM tb_data ORDER BY timestamp DESC LIMIT 1");
$sth_select->execute();
$rows = $sth_select->fetchAll(PDO::FETCH_ASSOC);

$sth_g = $pdo->prepare("SELECT * FROM tb_summary WHERE location = 1 ORDER BY timestamp DESC LIMIT 24;"); //SELECT pm1, pm25, pm10, timestamp FROM tb_data ORDER BY timestamp DESC LIMIT 228;
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
    <link href="assets/css/bootstrap4/bootstrap.css" rel="stylesheet" />

    <!-- Animation library for notifications   -->
    <link href="assets/css/animate.min.css" rel="stylesheet"/>

    <!--  Paper Dashboard core CSS    
    <link href="assets/css/paper-dashboard.css" rel="stylesheet"/> -->

    <!--  CSS for Demo Purpose, don't include it in your project     
    <link href="assets/css/demo.css" rel="stylesheet" />-->

    <!--  Fonts and icons     -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" 
    integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
    <link href="assets/css/themify-icons.css" rel="stylesheet">
    <link href="assets/css/weather-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Sarabun" rel="stylesheet">

    <!--  CSS for icoccac things     -->
    <link href="assets/css/icoccac-style.css" rel="stylesheet">

</head>
<body>
    <div id="cloud" class="container-fluid">
        <!--NAVIGATION-->
        <nav class="navbar navbar-light navbar-expand-md bg-faded justify-content-center">
            <a href="/" class="navbar-brand d-flex w-50 mr-auto"> iCocCac - <span style="font-size:0.5em"> Air Quality Index (AQI) </span></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsingNavbar3">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="navbar-collapse collapse w-100" id="collapsingNavbar3">
                <ul class="navbar-nav w-100 justify-content-center">
                    <li class="nav-item active">
                        <div class="text-center">
                            <span class="badge badge-dark badge-pill">
                                iConnex by iGohang
                            </span>
                        </div>
                    </li>
                </ul>
                <ul class="nav navbar-nav ml-auto w-100 justify-content-end">
                    <li class="nav-item">
                        <a class="nav-link" href="#">A<span class="sup">2</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">CPE</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">KMUTT</a>
                    </li>
                </ul>
            </div>
        </nav>
        <!--/ NAVIGATION-->

        <!--CONTENT 0 - Location <p>Location</p>-->
        <div class="row mb-3">
            <div class="col-12 text-center">
                <i class="ti-location-pin icon-topic"></i>
                
                <div class="mt-2">
                    <h4>
                    10th Floor 
                    Witsawa Watthana Building @KMUTT.
                    </h4>
                </div>
            </div>
            <div class="col-12 text-center mt-1">
                <i class="ti-reload"></i>  Last Update

                <div id=timestamp></div>
                <!-- current datetime - timestamp -->
            </div>
        </div>
        <!--/ CONTENT 0-->
        <div class="row">
            <!--CONTENT 1 - PM2.5-->
            <div class="col-12 col-md">
                <!-- card-healthy , card-good , card-moderate , card-unhealthyfor , card-unhealthy -->
                <div class="card p-2 m-2 card-good">
                    <div class="row justify-content-center mt-3">
                        <div class="col-4 col-sm-4 d-block align-self-center">
                            <!-- Picture -->
                            <div class="row justify-content-center">
                                <!-- fa-smile-beam , fa-smile , fa-meh , fa-sad-tear , fa-sad-cry-->
                                <i class="far fa-smile d-none d-lg-block" style="font-size:8vw;line-height: normal;"></i>
                                <i class="far fa-smile d-block d-lg-none" style="font-size:18vw;line-height: normal;"></i>

                                <!--<img src="assets/img/ic-face-2-yellow.png" class="img-fluid">-->
                            </div>
                        </div>
                        <div class="col-5 col-sm-3">
                            <div class="row justify-content-center">
                                <h2> PM2.5 </h2>
                            </div>
                            <!-- AQI -->
                            <div class="row justify-content-center md-2">
                                <h1 id="pm25" class="mb-0" style="font-size:5em">-</h1>
                            </div>
                            <div class="row justify-content-center mb-2">
                                <h6>( Density <small><i class="wi wi-sandstorm rain"></i></small> µg/m<sup>3</sup> ) 
                                <sup><a data-toggle="collapse" href="#collapseTable" role="button" aria-expanded="false" aria-controls="collapseTable">
                                    <i data-toggle="tooltip" data-placement="bottom" title="เทียบคุณภาพอากาศมาตราฐานกรมควบคุมมลพิษ"class="far fa-question-circle whale"></i>
                                    </a></sup> </h6>
                            </div>
                        </div>  

                        <div class="col-10 col-sm-4 d-flex align-items-center">
                            <!-- Level and Density -->
                            <!-- คุณภาพอากาศดีมาก , คุณภาพอากาศดี , ปานกลาง , เริ่มมีผลกระทบต่อสุขภาพ , มีผลกระทบต่อสุขภาพ -->
                            <div class="row d-block  w-100 text-center mb-2 thai">
                                <h3>คุณภาพอากาศดี</h3>
                                <h5></h5>
                            </div>     
                        </div>                 
                    </div>
                    
                    <div class="row justify-content-center mb-2">
                    </div>
                    
                        <!-- Description - ENGLISH -->
                        <!--
                        <div class="row justify-content-center mb-2">
                            <div class="col-10 text-center">
                                
                            </div>
                        </div>
                        -->

                    <!-- Description - THAI -->
                    <!-- Very Good -->
                    <!--
                    <div class="row justify-content-center mb-2">
                        <div class="col-10 text-center thai">
                            <h5>คุณภาพอากาศดีมาก เหมาะสำหรับกิจกรรมกลางแจ้ง และ การท่องเที่ยว </h5>
                        </div>
                    </div>
                    -->
                    <!-- Good -->
                    <div class="row justify-content-center mb-2">
                        <div class="col-10 text-center thai">
                            <h5> คุณภาพอากาศดี สามารถทำกิจกรรมกลางแจ้ง และ <br> การท่องเที่ยวได้ตามปกติ </h5>
                        </div>
                    </div>
                    <!-- Moderate -->
                    <!--
                    <div class="row justify-content-center mb-2">
                        <div class="col-10 text-center thai">
                            <h5><strong>ประชาชนทั่วไป</strong> : สามารถทำกิจกรรมกลางแจ้งได้ตามปกติ <br>
                                <strong>ผู้ที่ต้องดูแลสุขภาพเป็นพิเศษ</strong> : หากมีอาการเบื้องต้น เช่น ไอ หายใจลำบาก ระคายเคืองตา ควรลดระยะเวลาการทำกิจกรรมกลางแจ้ง </h5>
                        </div>
                    </div>
                    -->
                    <!-- Unhealthy for sensitive -->
                    <!--
                    <div class="row justify-content-center mb-2">
                        <div class="col-10 text-center thai">
                            <h5><strong>ประชาชนทั่วไป</strong> : ควรเฝ้าระวังสุขภาพ ถ้ามีอาการเบื้องต้น เช่น ไอ หายใจลำบาก ระคายเคืองตา ควรลดระยะเวลาการทำกิจกรรมกลางแจ้ง หรือใช้อุปกรณ์ป้องกันตนเองหากมีความจำเป็น <br><br>
                                <strong>ผู้ที่ต้องดูแลสุขภาพเป็นพิเศษ</strong> : ควรลดระยะเวลาการทำกิจกรรมกลางแจ้ง หรือใช้อุปกรณ์ป้องกันตนเองหากมีความจำเป็น <br>
                                ถ้ามีอาการทางสุขภาพ เช่น ไอ หายใจลำบาก ตาอักเสบ แน่นหน้าอก ปวดศีรษะ หัวใจเต้นไม่เป็นปกติ คลื่นไส้ อ่อนเพลีย ควรปรึกษาแพทย์</h5>
                        </div>
                    </div>
                    -->
                    <!-- Unhealthy -->
                    <!--
                    <div class="row justify-content-center mb-2">
                        <div class="col-10 text-center thai">
                            <h5> <strong>ทุกคนควรหลีกเลี่ยง</strong>กิจกรรมกลางแจ้งทุกชนิด หลีกเลี่ยงพื้นที่ที่มีมลพิษทางอากาศสูง <br>
                            หรือใช้อุปกรณ์ป้องกันตนเองหากมีความจำเป็น หากมีอาการทางสุขภาพควรปรึกษาแพทย์ </h5>
                        </div>
                    </div>
                    -->

                </div>

                <div class="collapse" id="collapseTable">
                    <div class="card card-body p-3 m-2 mt-3 thai">
                        <h4>เกณฑ์ของดัชนีคุณภาพอากาศของประเทศไทย</h4>
                        <h6>ข้อมูลอ้างอิงจาก <a href="http://air4thai.pcd.go.th/webV2/aqi_info.php">กองจัดการคุณภาพของอากาศและเสียง กรมควบคุมมลพิษ</a></h6>
                        <table class="table table-responsive-sm table-hover">
                            <thead>
                                <tr class="text-center">
                                <th scope="col" width="15%">AQI</th>
                                <th scope="col" width="20%">ความหมาย</th>
                                <th scope="col" width="15%">PM<sub><small>2.5</small></sub></th>
                                <th scope="col" width="50%">ข้อความแจ้งเตือน</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="bg-sky text-coal text-center">0 - 25</td>
                                    <td class="text-center">คุณภาพอากาศดีมาก</td>
                                    <td class="text-center">0 - 25</td>
                                    <td align="left">คุณภาพอากาศดีมาก เหมาะสำหรับกิจกรรมกลางแจ้งและการท่องเที่ยว</td>
                                </tr>
                                <tr>
                                    <td class="bg-leaf text-coal text-center">26 - 50</td>
                                    <td class="text-center">คุณภาพอากาศดี</td>
                                    <td class="text-center">26 - 37</td>
                                    <td align="left">คุณภาพอากาศดี สามารถทำกิจกรรมกลางแจ้งและการท่องเที่ยวได้ตามปกติ</td>   
                                </tr>
                                <tr>
                                    <td class="bg-star text-coal text-center">51 - 100</td>
                                    <td class="text-center">ปานกลาง</td>
                                    <td class="text-center">38 - 50</td>
                                    <td align="left"><u>ประชาชนทั่วไป :</u> สามารถทำกิจกรรมกลางแจ้งได้ตามปกติ<br />
                                        <u>ผู้ที่ต้องดูแลสุขภาพเป็นพิเศษ :</u> หากมีอาการเบื้องต้น เช่น ไอ หายใจลำบาก ระคายเคืองตา ควรลดระยะเวลาการทำกิจกรรมกลางแจ้ง
                                    </td>
                                </tr>
                                <tr>
                                    <td class="bg-sohot text-cloud text-center">101 - 200</td>
                                    <td class="text-center">เริ่มมีผลกระทบต่อสุขภาพ</td>
                                    <td class="text-center">51 - 90</td>
                                    <td align="left">
                                        <u>ประชาชนทั่วไป :</u> ควรเฝ้าระวังสุขภาพ ถ้ามีอาการเบื้องต้น เช่น ไอ หายใจลำบาก ระคายเคืองตา 
                                        ควรลดระยะเวลาการทำกิจกรรมกลางแจ้ง หรือใช้อุปกรณ์ป้องกันตนเองหากมีความจำเป็น<br />
                                        <u>ผู้ที่ต้องดูแลสุขภาพเป็นพิเศษ :</u> 
                                        ควรลดระยะเวลาการทำกิจกรรมกลางแจ้ง หรือใช้อุปกรณ์ป้องกันตนเองหากมีความจำเป็น ถ้ามีอาการทางสุขภาพ เช่น 
                                        ไอ หายใจลำบาก ตาอักเสบ แน่นหน้าอก ปวดศีรษะ หัวใจเต้นไม่เป็นปกติ คลื่นไส้ อ่อนเพลีย ควรปรึกษาแพทย์
                                    </td>
                                </tr>
                                <tr>
                                    <td class="bg-ruby text-cloud text-center">201 ขึ้นไป </td>
                                    <td class="text-center">มีผลกระทบต่อสุขภาพ</td>
                                    <td class="text-center">91 ขึ้นไป</td>
                                    <td align="left">
                                        ทุกคนควรหลีกเลี่ยงกิจกรรมกลางแจ้งทุก หลีกเลี่ยงพื้นที่ที่มีมลพิษทางอากาศสูง 
                                        หรือใช้อุปกรณ์ป้องกันตนเองหากมีความจำเป็น หากมีอาการทางสุขภาพควรปรึกษาแพทย์
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            <!--/ CONTENT 1-->
            
            <div class="col-12 col-md pr-5">
                <!--CONTENT 2 - Factors-->
                <div class="row m-2 mb-3">
                    <!-- PM10 -->
                    <div class="col-6 col-md-3 px-1 my-1">
                        <!-- Status as Color
                             lleb-good , lleb-moderate , lleb-unhealthyfor , lleb-unhealthy , lleb-veryunhealthy , lleb-hazardous
                        -->
                        <div class="lleb-veryunhealthy">
                            <div class="row left-status"><h4> PM10 <sup class="smaller"><i class="far fa-question-circle summer"></i></sup> </h4></div>
                            <div class="row left-status"><h2 class="mb-1"> <strong id="pm10">-</strong> </h2></div>
                            <div class="row left-status"><span>µg/m<sup>3</sup></span></div>
                        </div>
                    </div>
                    <!-- PM1 -->
                    <div class="col-6 col-md-3 px-1 my-1">
                        <div class="lleb-moderate">
                            <div class="row left-status"><h4> PM1 <sup class="smaller"><i class="far fa-question-circle summer"></i></sup> </h4></div>
                            <div class="row left-status"><h2 class="mb-1"> <strong id="pm1">-</strong> </h2></div>
                            <div class="row left-status"><span>µg/m<sup>3</sup></span></div>
                        </div>
                    </div>
                    <!-- Temperature -->
                    <div class="col-6 col-md-3 px-1 my-1">
                        <div class="lleb-temperature">
                            <div class="row left-status"><h5> <small><i class="fas fa-temperature-high sky"></i></small> Temperature  </h5></div>
                            <div class="row left-status"><h2><div id="temp">-</div><sup>o</sup>c</h2></div>
                            <div class="row left-status"> </div>
                        </div>
                    </div>
                    <!-- Humidity -->
                    <div class="col-6 col-md-3 px-1 my-1">
                        <div class="lleb-humidity">
                            <div class="row left-status"><h5> <i class="wi wi-raindrop tree"></i> Humidity </h5></div>
                            <div class="row left-status"><h2><div id="humi">-</div><small>%</small></h2></div>
                            <div class="row left-status"> </div>
                        </div>
                    </div>
                </div>
                <!--/ CONTENT 2-->

                <!--CONTENT 3 - Graph Information-->
                <div class="row">
                    <div class="col-12">
                        <div class="card p-3 vh-20">
                            <div class="header">
                                <h4 class="title">24-Hour</h4>
                            </div>
                            <div class="content">
                                <canvas id="myChart" width="100%" height="40vh"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ CONTENT 3-->
            </div>
            
        </div>
        

        
        
        <!--FOOTER-->
        <footer class="line-gra footer row">
            <div class="col-12 copyright">
                    &copy; <script>document.write(new Date().getFullYear())</script> by iconnex.in.th x menn.me x megawish.in.th
					<i class="fas fa-heart heart"></i> CPE@KMUTT
            </div>
        </footer>
        <!--/ FOOTER-->

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js">></script>
    <script type="text/javascript">

        var ctx = document.getElementById("myChart").getContext("2d");
        var width = window.innerWidth || document.body.clientWidth;
        var gradientStroke = ctx.createLinearGradient(500, 0, 100, 0);
        gradientStroke.addColorStop(0, "#555555");
        gradientStroke.addColorStop(1, "#cccccc");
        /*gradientStroke.addColorStop(0, "#80b6f4");
        gradientStroke.addColorStop(0.2, "#94d973");
        gradientStroke.addColorStop(0.5, "#fad874");
        gradientStroke.addColorStop(1, "#f49080");*/

        var gradientFill = ctx.createLinearGradient(500, 0, 100, 0);
        gradientFill.addColorStop(0, "#80b6f4");
        gradientFill.addColorStop(0.2, "#94d973");
        gradientFill.addColorStop(0.5, "#fad874");
        gradientFill.addColorStop(1, "#f49080");

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
                    label: "PM 2.5",
                    borderColor: gradientStroke,
                    pointBorderColor: gradientStroke,
                    pointBackgroundColor: gradientStroke,
                    pointHoverBackgroundColor: gradientStroke,
                    pointHoverBorderColor: gradientStroke,
                    pointBorderWidth: 8,
                    pointHoverRadius: 8,
                    pointHoverBorderWidth: 1,
                    pointRadius: 3,
                    fill: false,
                    borderWidth: 4,
                    data: y25
                    //backgroundColor: '#84b5ff',
                    //borderColor: 'rgba(242, 100, 25, 1)'
                }
                /*,{
                    type: 'line',
                    label: 'PM 1.0',
                    data: y1,
                    backgroundColor: [
                        'rgba(85, 221, 228, 0.5)', 
                    ],
                    borderColor: [
                        'rgba(85, 166, 203, 1)',
                    ],
                    borderWidth: 2
                    
                }*/
                /*,
                {
                    type: 'line',
                    label: 'PM 10.0',
                    data: y10,
                    backgroundColor: [
                        'rgba(50, 54, 66, 0.2)',
                    ],
                    borderColor: [
                        'rgba(50, 54, 66, 1)',
                    ],
                    borderWidth: 2
                }*/
                ]
            },
            options: {
                legend: {
                    position: "top"
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:false
                        },
                        scaleLabel: {
                            display: true,
                            labelString: 'µg/m3'
                        },
                        gridLines: {
                            drawTicks: false,
                            display: false,
                            drawBorder: false
                        }
                    }],
                    xAxes: [{
                        gridLines: {
                            zeroLineColor: "transparent"
                        },
                        scaleLabel: {
                            display: true,
                            labelString: 'Time (hour)'
                        },
                        ticks: {
                            padding: 20,
                            fontColor: "rgba(0,0,0,0.5)",
                            fontStyle: "bold"
                        }
                    }]
                    
                }
            }


        });
    </script>

</body>

    <!--   Core JS Files   -->
    <script src="assets/js/jquery.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
	<script src="assets/js/bootstrap4/bootstrap.min.js" type="text/javascript"></script>

    <script type="text/javascript">
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>

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

    <script>
    var i = 0;
        $(document).ready(air_data());

        function get_air_date(){
            $.ajax({
                type:'GET',
                url:'db.php',
                dataType: "json",
                success:function(data){
                    if(data.status == 'ok'){
                        pm25 = data.result.pm25;
                        $('#pm25').text(data.result.pm25);
                        $('#pm1').text(data.result.pm1);
                        $('#pm10').text(data.result.pm10);
                        $('#temp').text(data.result.temp);
                        $('#humi').text(data.result.humi);
                        $('#aqi_pm25').text(data.result.aqi_pm25);
                        $('#aqi_pm10').text(data.result.aqi_pm10);
                        $('#location').text(data.result.location);
                        $('#timestamp').text(data.result.timestamp);
                        i = i + 1;
                        console.log(i)
                    }else{
                        alert("not found...");
                    } 
                }
            });
        }
        
        
        function air_data(){
            get_air_date();
            setInterval(function(){
                get_air_date();
            },60*1000);
        }
        
    </script>

</html>
