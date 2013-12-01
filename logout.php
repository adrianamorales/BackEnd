<?php
  session_start();
  $_SESSION = array(); //destroy all of the session variables
  $_SESSION['userid'] = NULL;
  session_destroy();
  header('Location: login.php');
?>
