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

    <title>Ad Server platform</title>
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
   
  </head>
  <body id="page-top">   
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
      <div class="container">
          <a class="navbar-brand js-scroll-trigger" href="#page-top"><img src="images/logo.png" style="width:150px; margin-bottom:10px;"></a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          Menu
          <i class="fa fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#page-top"><i class="fa fa-home"></i> Home</a>
            </li> 
              
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#about"><i class="fa fa-info"></i> About us</a>
            </li>    
               <li class="nav-item">
                   <a class="nav-link js-scroll-trigger" href="#contact"><i class="fa fa-phone"></i> Contact us</a>
            </li>
               <li class="nav-item">
                   <a class="nav-link js-scroll-trigger" href="register.php">Register</a>
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
                    <div class="omb_login" id="homepage-form">
                        <h3 class="omb_authTitle">Login</h3>
                        <div class="row omb_row-sm-offset-3 omb_socialButtons" style="text-align:center;display:inline">
                        </div>
                                <form class="omb_loginForm" action="" autocomplete="off" method="POST">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                        <input type="text" class="form-control" name="username" placeholder="Username" required>
                                    </div>
                                    <br>
                                    <span class="help-block"></span>

                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                        <input  type="password" class="form-control" name="password" placeholder="Password" required>
                                        
                                    </div>
                                    <br>
                                    <button  id ="loginbtn" class="btn btn-default" name="submit" type="submit">Login</button>
                                    <br>
                                    <br>
                                </form>
                         <?php		
                            
                            if(isset($_POST['submit'])){
                                $usernameAdmin=$_POST['username'];
                                $passwordAdmin=$_POST['password'];
                                $stmt = $db->prepare('SELECT usernameAdmin FROM admins WHERE usernameAdmin = :usernameAdmin');
                                $stmt->execute(array(':usernameAdmin' => $usernameAdmin));
                                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                               if(!empty($row['usernameAdmin'])){
                                $stmt = $db->prepare('SELECT passwordAdmin FROM admins WHERE passwordAdmin = :passwordAdmin');
                                $stmt->execute(array(':passwordAdmin' => $passwordAdmin));
                                $row = $stmt->fetch(PDO::FETCH_ASSOC);  
                                   if(!empty($row['passwordAdmin'])){
                                       $stmt = $db->prepare('SELECT adminID FROM admins WHERE usernameAdmin = :usernameAdmin');
                                       $stmt->bindParam(':usernameAdmin',$usernameAdmin);
                                       $stmt->execute();				 
				                        while($result=$stmt->fetch(PDO::FETCH_ASSOC)){
                                            $_SESSION['adminID']=$result["adminID"];
                                        }
                                  	header('Location: memberpage.php');
                                   }
                                   else{
                                        echo '<p class="alert alert-danger" style="width:350px; height:auto;font-size:15px;"><i class="material-icons" style="margin-right:1%;font-size:18px;color:red">error</i>&nbsp;You are username or password is incorrect</p>'; 
                                      
                                   }
                                }else {
                                    echo '<p class="alert alert-danger" style="width:350px; height:auto;font-size:15px;"><i class="material-icons" style="margin-right:1%;font-size:18px;color:red">error</i>&nbsp;You are username or password is incorrect</p>'; 
                               
                                 }
                             }
                            
								?>

                         <br>
                        <div class="row omb_row-sm-offset-3" style="text-align:center;display:inline;">
                                <input type="checkbox" value="remember-me">Remember Me     
                            <a href="#" style="padding-left:50px;">Forgot password?</a>  
                        </div>	    	
                    </div>
                </div>
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
  </body>

</html>
