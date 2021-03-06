<?php
  function isLoggedIn(){
    //if they are logged in outputs a link to loggout
    if(isset($_SESSION['valid']) && isset($_SESSION['userid']) ){
      return true;  
    }
    return false;
  }
  function isAdmin(){
    //if they are logged in outputs a link to loggout
    if($_SESSION['userid'] == "admin@shinystudiosonline.com" or $_SESSION['userid'] == "admin@shiny.com"){
      return true;  
    }
    return false;
  }
  session_start();
  //test to see if logged in
  if(isLoggedIn() == false){
    header('Location: login.php');
    die();
  }
  if(isAdmin() == false){
    header('Location: index.php');
    die();
  }
  $admin = isAdmin();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  
  <!-- start: Meta -->
  <meta charset="utf-8">
  <title>Shiny Studios</title>
  <meta name="description" content="Metro Admin Template.">
  <meta name="author" content="Nicholas Laferriere">
  <meta name="keyword" content="Metro, Metro UI, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
  <!-- end: Meta -->
  
  <!-- start: Mobile Specific -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- end: Mobile Specific -->
  
  <!-- start: CSS -->
  <link id="bootstrap-style" href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/bootstrap-responsive.min.css" rel="stylesheet">
  <link id="base-style" href="css/style.css" rel="stylesheet">
  <link id="base-style-responsive" href="css/style-responsive.css" rel="stylesheet">
  <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&subset=latin,cyrillic-ext,latin-ext' rel='stylesheet' type='text/css'>
  <!-- end: CSS -->
  

  <!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
  <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <link id="ie-style" href="css/ie.css" rel="stylesheet">
  <![endif]-->
  
  <!--[if IE 9]>
    <link id="ie9style" href="css/ie9.css" rel="stylesheet">
  <![endif]-->
    
  <!-- start: Favicon -->
  <link rel="shortcut icon" href="img/favicon.ico">
  <!-- end: Favicon -->
  
    
    
    
</head>

<body>
    <!-- start: Header -->
  <div class="navbar">
    <div class="navbar-inner">
      <div class="container-fluid">
        <a class="btn btn-navbar" data-toggle="collapse" data-target=".top-nav.nav-collapse,.sidebar-nav.nav-collapse">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </a>
        <a class="brand" href="index.php"><span>Shiny Studios</span></a>
                
        <!-- start: Header Menu -->
        <div class="nav-no-collapse header-nav">
          <ul class="nav pull-right">
            <li class="dropdown hidden-phone">
              <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="halflings-icon white warning-sign"></i>
              </a>
            </li>
            <!-- start: User Dropdown -->
            <li class="dropdown">
              <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="halflings-icon white user"></i>Logout
                <span class="caret"></span>
              </a>
              <ul class="dropdown-menu">
                <li class="dropdown-menu-title">
                  <span>Account Settings</span>
                </li>
                <li><a href="logout.php"><i class="halflings-icon off"></i> Logout</a></li>
              </ul>
            </li>
            <!-- end: User Dropdown -->
          </ul>
        </div>
        <!-- end: Header Menu -->
        
      </div>
    </div>
  </div>
  <!-- start: Header -->
  
    <div class="container-fluid-full">
    <div class="row-fluid">
        
      <!-- start: Main Menu -->
      <div id="sidebar-left" class="span2">
        <div class="nav-collapse sidebar-nav">
          <ul class="nav nav-tabs nav-stacked main-menu">
            <li><a href="index.php"><i class="icon-bar-chart"></i><span class="hidden-tablet"> Dashboard</span></a></li>  
            <li><a href="tasks.php"><i class="icon-tasks"></i><span class="hidden-tablet"> Tasks</span></a></li>
            <li><a href="form.php"><i class="icon-edit"></i><span class="hidden-tablet"> Forms</span></a></li>
            <li><a href="table.php"><i class="icon-align-justify"></i><span class="hidden-tablet"> Tables</span></a></li>
            <li><a href="calendar.php"><i class="icon-calendar"></i><span class="hidden-tablet"> Calendar</span></a></li>
            <?php
              if( $admin == true){
                echo '<li><a href="register.php"><i class="icon-lock"></i><span class="hidden-tablet"> Register</span></a></li>';
              }
            ?>
            <li><a href="logout.php"><i class="icon-lock"></i><span class="hidden-tablet"> Logout</span></a></li>
          </ul>
        </div>
      </div>
      <!-- end: Main Menu -->
      
      <noscript>
        <div class="alert alert-block span10">
          <h4 class="alert-heading">Warning!</h4>
          <p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> enabled to use this site.</p>
        </div>
      </noscript>
      
      <!-- start: Content -->
      <div id="content" class="span10">
      
      
      <ul class="breadcrumb">
        <li>
          <i class="icon-home"></i>
          <a href="index.php">Home</a> 
          <i class="icon-angle-right"></i>
        </li>
        <li><a href="#">Register</a></li>
      </ul>
      <div>
      <?php
            
            //seeing if thier was a post back to this
            //page for creating a new user
            if (isset($_POST['submitted']) ) {
              $email = $_POST['email'];
              $pass1 = $_POST['pass1'];
              $pass2 = $_POST['pass2'];
              //this is a boolan that if set to 
              //false won't create the new user
              $run = true;
              if($pass1 != $pass2){
                echo "<p>password mismatch</p>";
                $run = false;
              }
              //creates a 3 character sequence
              //for the salt
              function createSalt()
              {   
                $string = md5(uniqid(rand(), true));
                return substr($string, 0, 3);
              }
              $salt = createSalt();
              $hash = sha1($salt.$pass1);
              //conencted to database
              include("config.inc.php");
              $dbname = $config['db'];
              $user = $config['user'];
              $pass = $config['pass'];
              $conn = new PDO('mysql:host=localhost;dbname='.$dbname, $user, $pass);
              ///checking to see if user name is already userd
              $sql = "SELECT * FROM users WHERE email = '$email';";
              $stmt = $conn->query($sql) or die("failed!");
              $rows = $stmt->fetchAll();
              $n = count($rows);
              if($n >= 1) //user exists already exist
              {   
                echo "<p>this email is already in use</p>";
                $run = false;
              }
              if($run){
                $sql = "INSERT INTO users ( email, password, salt ) VALUES ( :email , :hash , :salt );";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':hash', $hash);
                $stmt->bindParam(':salt', $salt);
                $stmt->execute();
              }
              //now inserting additional info if any provided
              //into varibles
              $first;
              if( isset($_POST['first'])  ){
                $first = $_POST['first'];
              }
              if( isset($_POST['last']) ){
                $last = $_POST['last'];
              }
              if( isset($_POST['phone']) ){
                $phone = $_POST['phone'];
              }
              if($run){
                $sql = "INSERT INTO info ( first, last, email, phone ) VALUES ( :first, :last, :email, :phone );";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':first', $first);
                $stmt->bindParam(':last', $last);
                $stmt->bindParam(':phone', $phone);
                $stmt->execute();
              }
              header('Location: login.php');
            }
          ?>
          
          <p class="register_info">
              Only Email and Password fields are required, but we encourage you to fill out all fields in order to allow us to reach out to you later
          </p>
          <form name="register" action="register.php" id="register" method="post">
              *Email: <input type="email" name="email" maxlength="50"  required/><br />
              *Password: <input type="password" name="pass1" required/><br />
              *Password Again: <input type="password" name="pass2" required/><br />
              First Name: <input type="text" name="first" maxlength="30" /><br />
              Last Name: <input type="text" name="last" maxlength="30"/><br />
              Phone Number: <input type="text" name="phone" maxlength="12"/><br />

              <input type='submit' name='Submit' value='Submit' /><br />
              <input type='hidden' name='submitted' id='submitted' value='1'/><br />
          </form>
      </div>

  
      <!-- end: Content -->
    </div><!--/#content.span10-->
    </div><!--/fluid-row-->
    
  <div class="modal hide fade" id="myModal">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">×</button>
      <h3>Settings</h3>
    </div>
    <div class="modal-body">
      <p>Here settings can be configured...</p>
    </div>
    <div class="modal-footer">
      <a href="#" class="btn" data-dismiss="modal">Close</a>
      <a href="#" class="btn btn-primary">Save changes</a>
    </div>
  </div>
  
  <div class="clearfix"></div>
  
  <footer>
    <p>
      <span style="text-align:left;float:left">&copy; <a href="" target="_blank">creativeLabs</a> 2013</span>
      <span class="hidden-phone" style="text-align:right;float:right">Powered by: <a href="#">Metro</a></span>
    </p>

  </footer>
  
  <!-- start: JavaScript-->

    <script src="js/jquery-1.9.1.min.js"></script>
  <script src="js/jquery-migrate-1.0.0.min.js"></script>
  
    <script src="js/jquery-ui-1.10.0.custom.min.js"></script>
  
    <script src="js/jquery.ui.touch-punch.js"></script>
  
    <script src="js/modernizr.js"></script>
  
    <script src="js/bootstrap.min.js"></script>
  
    <script src="js/jquery.cookie.js"></script>
  
    <script src='js/fullcalendar.min.js'></script>
  
    <script src='js/jquery.dataTables.min.js'></script>

    <script src="js/excanvas.js"></script>
  <script src="js/jquery.flot.js"></script>
  <script src="js/jquery.flot.pie.js"></script>
  <script src="js/jquery.flot.stack.js"></script>
  <script src="js/jquery.flot.resize.min.js"></script>
  
    <script src="js/jquery.chosen.min.js"></script>
  
    <script src="js/jquery.uniform.min.js"></script>
    
    <script src="js/jquery.cleditor.min.js"></script>
  
    <script src="js/jquery.noty.js"></script>
  
    <script src="js/jquery.elfinder.min.js"></script>
  
    <script src="js/jquery.raty.min.js"></script>
  
    <script src="js/jquery.iphone.toggle.js"></script>
  
    <script src="js/jquery.uploadify-3.1.min.js"></script>
  
    <script src="js/jquery.gritter.min.js"></script>
  
    <script src="js/jquery.imagesloaded.js"></script>
  
    <script src="js/jquery.masonry.min.js"></script>
  
    <script src="js/jquery.knob.modified.js"></script>
  
    <script src="js/jquery.sparkline.min.js"></script>
  
    <script src="js/counter.js"></script>
  
    <script src="js/retina.js"></script>

    <script src="js/custom.js"></script>
  <!-- end: JavaScript-->
  
</body>
</html>




































