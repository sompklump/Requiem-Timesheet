<?php
session_start();
$user_creds = $_SESSION['discord_userArr'];

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

$times_taken = ["00:00","01:00","02:00","08:00","09:00","14:00","15:00","16:00","17:00","18:00"];
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
    <div class="pos-f-t">
        <div class="collapse" id="navbarToggleExternalContent">
          <div class="bg-dark p-4">
            <button id="openSettings_btn" class="btn btn-primary">Settings</button>
            <br>
          </div>
        </div>
        <nav class="navbar navbar-dark bg-dark">
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
             <span class="navbar-toggler-icon"></span>
          </button>
          <nav class="navbar-expand-sm">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link active" href="./">Interpol</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?php if($user_rank >= 8){echo "inactivity";}else{echo "#";} ?>">Inactivty</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Removals</a>
              </li>
            </ul>
          </nav>
          <div>
            <br>
            <?php
            if(!isset($_SESSION['discord_userId'])){
              echo '<a href="login/auth.php">Login <i class="fas fa-sign-in-alt"></i></a>';
            }
            else{
              echo '<a href="login/auth.php?action=logout">Logout <i class="fas fa-sign-out-alt"></i></a>';
            }
            ?>
          </div>
        </nav>
        <div>
          <img class="user-creds-avatar" src="https://cdn.discordapp.com/avatars/<?= $user_creds->id ?>/<?= $user_creds->avatar ?>.png" alt="profile avatar">
          <span class="user-creds-username"><p><?= $user_creds->username."#".$user_creds->discriminator ?></p></span>
        </div>
    </div>
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