 <?php 
  function isLoggedIn()
  {
    //if they are logged in outputs a link to loggout
    if(isset($_SESSION['valid']) && isset($_SESSION['userid']) ){
      return true;  
    }
    return false;
  }
  session_start();
  //test to see if logged in
  if(!isLoggedIn() ){
    header('Location: login.php');
    die();
  }
  include("config.inc.php");
  $dbname = $config['db'];
  $user = $config['user'];
  $pass = $config['pass'];
  $conn = new PDO('mysql:host=localhost;dbname='.$dbname, $user, $pass);
  //now check for different things





?>