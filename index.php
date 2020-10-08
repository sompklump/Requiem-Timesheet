<?php
session_start();

$timezone = null;
$weekDays = ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"];
$dayAndDate = array();

if(!isset($_COOKIE['userLocalTimeZone'])){
  echo "<script type='text/javascript'>
      var clientDateTimezone = new Date();
      document.cookie= 'userLocalTimeZone='+clientDateTimezone;
    </script>";
  echo "<script>location.replace('./');</script>";
}
else{
  $timeCookie = $_COOKIE['userLocalTimeZone'];
  $time = explode(" ", $timeCookie);
  if(strpos($time[5], "-") !== false){
    $timezone = explode("-", $timezone[5]);
    $timezone = "-".$timezone[1];
    $timezone = intval($timezone)/100;
  }
  else{
    $timezone = intval($timezone[6])/100;
  }
}

$times_taken = ["00:30","01:00","01:30","08:30","09:00","14:30","15:00","15:30","17:00","17:30"];
?>
<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    <link href="https://getbootstrap.com/docs/4.0/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    
    <link href="<?= "assets/css/style.css?" . filemtime("assets/css/style.css") ?>" rel="stylesheet" type="text/css">
    <title>Requiem - Staff Time Sheet</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="assets/imgs/favico.ico">
  </head>
  <body>
    <table class="table table-bordered table-striped table-dark">
      <tr>
        <th>Time</th>
        <?php
        $date = strtotime(date("Y-m-d"));
        //Get the day of the week using PHP's date function.
        $today_day = date("l", $date);
        for($i = 0; $i < count($weekDays);$i++){
          if($today_day == $weekDays[$i]){
            $today_day = $i;
            echo "<script>alert('$today_day');</script>";
          }
        }
          
        $i = 0;
        foreach($weekDays as $day){
          // Set all variables
          $date = date("Y-m-d");
          
          // Get the sum of the numbers divided so they add uip to the weekdays.
          $days = (intval($i) - intval($today_day));
          $date = strtotime($date."+$days days");
          $date_str = date("d/m/Y", $date);
          echo "<th>$day ($date_str)</th>\r\n";
          $dayAndDate[$day] = $date;
          $i++;
        }
        print_r($dayAndDate);
        ?>
      </tr>
      <style type="text/css">
        table, th, td {
          table-layout: table-cell;
          text-align: center;
          vertical-align: middle;
          border: 1px solid black;
          border-collapse: collapse;
          border-spacing: 0 15px;
          padding:0 5px;
          white-space: nowrap;
        }
      </style>
      <?php
      for($hour = 0; $hour < 24; $hour++){
        $hour_dis = null;
        if($hour < 10){
          $hour_dis = "0$hour";
        }
        else{
          $hour_dis = $hour;
        }
        $min = "00";
        echo "<tr>";
        echo "<td style='background-color:#1f242b;'>$hour_dis:$min</td>";
        if(in_array("$hour_dis:$min", $times_taken)){
          echo "<td style='background-color:#5bba5d;'></td>";
        }
        else{
          echo "<td style='background-color:#963d3d;'></td>";
        }
        echo "</tr>";
      }
      ?>
    </table>
  </body>
</html>