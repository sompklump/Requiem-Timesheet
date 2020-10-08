<?php
session_start();
require("../php/msql.php");

?>
<!DOCTYPE html>
<html>
  <head>
    <title>Login</title>
  </head>
  <body>
    <a href="auth.php?actoin=login">Login with discord</a>
    <?php
    if(isset($_GET['msg'])){
      $msg = urldecode($_GET['msg']);
      echo "<h3>$msg</h3>";
    }
    ?>
  </body>
</html>