<?php
require_once('includes/config.php');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>The Fitness Club</title>
      <!--modal-css--->        
      <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
      
    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Cabin:700' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    
      <!-- Custom styles for this template -->
    <link href="css/grayscale.min.css" rel="stylesheet">
      <link href="css/grayscale.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-1.10.2.js"></script>    
  </head>
  <body id="page-top">
    
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
      <div class="container">
          <a class="navbar-brand js-scroll-trigger" href="#index.phppage-top"><img src="images/logo.png" style="width:150px; margin-bottom:10px;"></a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          Menu
          <i class="fa fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="index.php#page-top"><i class="fa fa-home"></i> Home</a>
            </li> 
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="index.php#about"><i class="fa fa-info"></i> About us</a>
            </li>    
               <li class="nav-item">
                   <a class="nav-link js-scroll-trigger" href="index.php#contact"><i class="fa fa-phone"></i> Contact us</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Intro Header -->
    <header class="masthead">
      <div class="intro-body">
        <div class="container" id='xx'>
          <div class="row">
            <div id="form" class="col-lg-8 mx-auto" style="top:100px;">
                  <center>
                  <div class="container" style="padding-bottom:1%;">
                    <div class="omb_login" id="homepage-form" style="height:360px;">
                        <h3 class="omb_authTitle">Register</h3>
                                <form class="omb_loginForm" action="" autocomplete="off" method="POST">
                                    <div class="register">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                        <input type="text" class="form-control" name="username" placeholder="username" required>
                                    </div>
                                    <br>
                                     <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                        <input  type="text" class="form-control" name="email" placeholder="email" required>
                                        
                                    </div>
                                    <br>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                        <input  type="password" class="form-control" name="password" placeholder="password" required>
                                        
                                    </div>
                                    <br>
                                     <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                        <input  type="password" class="form-control" name="confirm_pass" placeholder="confirm password" required>
                                        
                                    </div>
                                   </div>
                                    <br>
                                    <input  id ="loginbtn" name="submit" class="btn btn-default" type="submit" value="Register">
                              
                                    <br>
                                </form>
                            <?php		
                            
                            if(isset($_POST['submit'])){
                                $usernameAdmin=$_POST['username'];
                                $passwordAdmin=$_POST['password'];
                                $confpassword=$_POST['confirm_pass'];

                                if($passwordAdmin!==$confpassword){
                                    echo '<p class="alert alert-danger" style="font-size:14px;"><i class="material-icons" style="font-size:20px;color:red">error</i>."Confirm password does not match with password"</p>';
                                }

                                else if(strlen($passwordAdmin) < 4){
			                     echo '<p class="alert alert-danger" style="font-size:14px;"><i class="material-icons" style="font-size:20px;color:red">error</i>."Password is too short"</p>';
		                          }
                                else{
                                $stmt = $db->prepare('SELECT usernameAdmin FROM admins WHERE usernameAdmin = :usernameAdmin');
                                $stmt->execute(array(':usernameAdmin' => $usernameAdmin));
                                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                                    
                               if(empty($row['usernameAdmin'])){
                                        //insert into database with a prepared statement
				                    $stmt = $db->prepare('INSERT INTO admins (usernameAdmin,passwordAdmin) VALUES (:usernameAdmin, :passwordAdmin)');
				                    $stmt->execute(array(
					               ':usernameAdmin' => $usernameAdmin,
					               ':passwordAdmin' => $passwordAdmin,));
                                   $id = $db->lastInsertId('adminID');
                                   echo '<p> You have succesfully sign up</p>';
                                   exit;
                                }else {
                                    echo '<p class="alert alert-danger" style="font-size:14px;"><i class="material-icons" style="font-size:20px;color:red">error</i>."Username already exists"</p>'; 
                                   exit;
                                 }
                                }
                            }
								?>
                      
                            </div>
                        </div>
                         <br>
                  </center>
            </div>
          </div>
        </div>                
      </div>    
    </header>

    <!-- About Section -->
    <section id="about" class="about-section  text-center">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 mx-auto about">
            <h2>About The AdServer platform</h2>
            <p>"The Ad Server" is a platform that lets you lafklafkfo</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="contact-section text-center">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 mx-auto" style="color:black">
            <h2>Contact Us</h2>
             <div id="social">
                    <a href="" class="fa fa-facebook"></a>
                    <a href="" class="fa fa-twitter"></a>
                    <a href="" class="fa fa-instagram"></a>	
              </div>
          </div>
        </div>
      </div>
    </section>
      
    <!-- Footer -->
    <footer >
        <center><div id="footer">
            <div style="display:inline">
                <a href="index.php#aboutus">About us</a><br>
                <a href="index.php#contact">Contact us</a><br>
                <div id="social">
                    <a href="" class="fa fa-facebook"></a>
                    <a href="" class="fa fa-twitter"></a>
                    <a href="" class="fa fa-instagram"></a>	
			     </div>
            </div> 
            <div style="display:inline">
                <a href="index.php#page-top">Login</a><br>
                <a href="register.php">Register</a><br>
            </div>
        </div>
        </center>    
        <br>
        <br>
        <div class="container text-center">
            <img src="images/logo.png" style="width:150px;">
            <br>
            <br>
            <p>&copy;The AdServer platform 2018</p>
        </div>
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for this template -->
    <script src="js/grayscale.min.js"></script>

  </body>

</html>