<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <div id="pm25"></div>
    <div id="pm1"></div>
    <div id="pm10"></div>
    <div id="temp"></div>
    <div id="humi"></div>
    <div id="aqi_pm25"></div>
    <div id="aqi_pm10"></div>
    <div id="location"></div>
    <div id="timestamp"></div>
    <script src="assets/js/jquery.min.js" type="text/javascript"></script>
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
            //     $.ajax({
            //     type:'GET',
            //     url:'db.php',
            //     dataType: "json",
            //     success:function(data){
            //         if(data.status == 'ok'){
            //             pm25 = data.result.pm25;
            //             $('#pm25').text(data.result.pm25);
            //             $('#pm1').text(data.result.pm1);
            //             $('#pm10').text(data.result.pm10);
            //             $('#temp').text(data.result.temp);
            //             $('#humi').text(data.result.humi);
            //             $('#aqi_pm25').text(data.result.aqi_pm25);
            //             $('#aqi_pm10').text(data.result.aqi_pm10);
            //             $('#location').text(data.result.location);
            //             $('#timestamp').text(data.result.timestamp);
            //             i = i + 1;
            //             console.log(i)
            //         }else{
            //             alert("not found...");
            //         } 
            //     }
            // });
            },60*1000);
        }
        // ;
        
    </script>
</body>
</html>