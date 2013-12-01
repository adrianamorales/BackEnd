<?php

	function isLoggedIn(){
    //if they are logged in outputs a link to loggout
    if(isset($_SESSION['valid']) && isset($_SESSION['userid']) ){
      return true;  
    }
    return false;
  }
  session_start();
  //test to see if logged in
  if(isLoggedIn()){
    header('Location: index.php');
    die();
  }
  if (isset($_POST['username']) ) {
    include("config.inc.php");
    $dbname = $config['db'];
    $user = $config['user'];
    $pass = $config['pass'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $conn = new PDO('mysql:host=localhost;dbname='.$dbname, $user, $pass);
    //connect to the database here
    $sql = "SELECT * FROM users WHERE email = '$username';";
    $stmt = $conn->query($sql) or die("failed!");
    $rows = $stmt->fetchAll();
    $n = count($rows);
    if($n < 1) //no such user exists
    {   
        header('Location: login.php?err=failed');
        die();
    }
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $userData = $stmt->fetch(PDO::FETCH_ASSOC);
    $hash = sha1($userData["salt"].$password);
    $salt = $userData['salt'];
    function validateUser() {
      session_regenerate_id (); //this is a security measure
      $_SESSION['valid'] = 1;
      $_SESSION['userid'] = $_POST['username'];
      $_SESSION['userid'] = $_POST['username'];
    }
    if($hash != $userData['password']){
        header('Location: login.php?err=failed');
    }
    else{
      validateUser();
      $sql = "UPDATE info set lastSignOn = NOW() where email = :userid";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':userid',  $_SESSION['userid']);
      $stmt->execute();
      header('Location: index.php');
      die();
    }
  }


?>
<!DOCTYPE html>
<html lang="en">
<head>
	
	<!-- start: Meta -->
	<meta charset="utf-8">
	<title>Shiny Studios</title>
	<meta name="description" content="Metro Admin Template.">
	<meta name="author" content="Nicholas Laferriere">
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
	
			<style type="text/css">
			body { background: url(img/bg-login.jpg) !important; }
		</style>
		
		
		
</head>

<body>
		<div class="container-fluid-full">
		<div class="row-fluid">
					
			<div class="row-fluid">
				<div class="login-box">
					<div class="icons">
						<a href="/ShinyStudios/"><i class="halflings-icon home"></i></a>
						<a href="#"><i class="halflings-icon cog"></i></a>
					</div>
					<h2>Login to your account</h2>
					<?php
						if (isset($_GET['err']) ) {
							echo "<p class=\"text-error\">Invalid Username or Password!</p>";
						}
					?>
					<form class="form-horizontal" action="login.php" method="post">
						<fieldset>
							
							<div class="input-prepend" title="Username">
								<span class="add-on"><i class="halflings-icon user"></i></span>
								<input class="input-large span10" name="username" id="username" type="text" placeholder="type username"/>
							</div>
							<div class="clearfix"></div>

							<div class="input-prepend" title="Password">
								<span class="add-on"><i class="halflings-icon lock"></i></span>
								<input class="input-large span10" name="password" id="password" type="password" placeholder="type password"/>
							</div>
							<div class="clearfix"></div>

							<div class="button-login">	
								<button type="submit" class="btn btn-primary">Login</button>
							</div>
							<div class="clearfix"></div>
					</form>
					<hr>
					<h3>Forgot Password?</h3>
					<p>
						No problem, <a href="mailto:laferriere.nick@gmail.com">eMail the admin</a> to get a new password.
					</p>	
				</div><!--/span-->
			</div><!--/row-->
			

	</div><!--/.fluid-container-->
	
		</div><!--/fluid-row-->
	
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
