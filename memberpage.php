<?php require_once('includes/config.php'); 

//define page title
$title = 'Memberpage';
$back = 'logout.php';
$textofback = 'Log out';
$adminID=$_SESSION['adminID'];
if(!isset($_SESSION['adminID'])){
    header('Location: index.php');
}                       
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
      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    
	<title> <?php if(isset($title)){ echo $title; }?></title>
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
              <a class="nav-link js-scroll-trigger" href="memberpage.php#page-top"><i class="fa fa-home"></i> Home</a>
            </li> 
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#memberpage.php#about"><i class="fa fa-info"></i> About us</a>
            </li>    
               <li class="nav-item">
                   <a class="nav-link js-scroll-trigger" href="memberpage.php#contact"><i class="fa fa-phone"></i> Contact us</a>
            </li>
              <li class="nav-item">
                   <a class="nav-link js-scroll-trigger" href="logout.php">Logout</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

<!-- Intro Header -->
    <header class="masthead" style="height:1400px">
      <div class="intro-body">
          <center><h3 class="omb_authTitle">Welcome to AD SERVER platform</h3></center> 
      
         <div id="bitsform" class="container">    
          <form action="" method="post">
            <h6 style="padding-top:15px;font-size:15px;">Bids from advertisers</h6>
              <button style="float:right; padding:1%;" type="submit" name="deletebid" href="#deletebid"> <i style="font-size:20px;" class='fa fa-trash' aria-hidden="true"></i></button>
                <a style="float:right; padding:1%;" id="decisionbtn" href="#addbid" onclick="document.getElementById('addbid').style.display='block'" ><i  style="font-size:20px;" class='fa fa-plus' aria-hidden="true"></i></a> 
                       <table id="data">
                          <thead>
                              <tr>
                                
                                <th class="table-header">&nbsp;&nbsp;&nbsp;Id</th>
                                <th class="table-header">Topic</th>
                                <th class="table-header">Price</th>
                                <th class="table-header">Geography</th>
                                <th class="table-header">Blocked by publisher</th>
                              </tr>
                          </thead>
                          <tbody>
                          <?php
                            
                              $stmt = $db->prepare('SELECT * FROM bids WHERE adminID = :adminID');
                              $stmt->bindParam(':adminID',$adminID);
                              $stmt->execute();		
                        while($result=$stmt->fetch(PDO::FETCH_ASSOC)){
                         ?>  
                              <tr id="bid">    
                                  
                                
                                
                                <td id="bidID">
                                    <input type="radio" name="bid" id="bid" value="<?php echo $result['bidID'];
                                    ?>" required>
                                    <?php
                                    echo $result['bidID'];
                                    ?>
                                </td>
                                <td id="topic"><?php  
                                    echo $result['topic'];
                                    ?></td>
                                <td id="price"><?php  
                                    echo $result['price'];
                                    ?></td>
                                <td id="geography"><?php  
                                    echo $result['geography'];
                                    ?></td> 
                                <td id="blocked"><?php 
                                    if($result['blockedbypublisher']==true)
                                    echo "true";
                                    else
                                          echo "false";
                                    ?>
                                </td> 
                              </tr>                              
                        <?php
                             }
                          ?>    
                          </tbody>
                        </table>
                    <script>
                      $("#data tbody tr").click(function() {
                      var selected = $(this).hasClass("highlight");
                      $("#data tbody tr").removeClass("highlight");
                    if(!selected)
                    $(this).addClass("highlight");
                    });
                    </script>
            
                <br>
                <center> <p id="errorbid" class="alert alert-danger" style="display:none; width:250px; height:auto;font-size:15px;">You have to add a new bid</p></center> <br>
             </form>   
             </div>
                
                <?php
                  if(isset($_POST['deletebid'])){
                       $stmt = $db->prepare('SELECT * FROM bids WHERE adminID = :adminID');
                       $stmt->bindParam(':adminID',$adminID);
                       $stmt->execute();	                      
                       $row = $stmt->fetch(PDO::FETCH_ASSOC);  	
                      if(!$row)
                          echo "<script>document.getElementById('errorbid').style.display='block';</script>";
                      else{
                                 $bidID=$_POST['bid'];
                                 $stmt = $db->prepare('Delete FROM bids WHERE adminID = :adminID AND bidID=:bidID');               $stmt->bindParam(':adminID',$adminID);
                                 $stmt->bindParam(':bidID',$bidID);
                                 $stmt->execute();
                                 $stmt = $db->prepare('SELECT bidcount FROM admins WHERE adminID=:adminID;');
                                 $stmt->bindParam(':adminID', $adminID);
                                 $stmt->execute();
                                 $result = $stmt->fetch(PDO::FETCH_ASSOC);
                                 $bidcount=$result['bidcount'];
                                 $bidcount--;
                                 $stmt = $db->prepare('UPDATE admins SET bidcount=:bidcount WHERE adminID=:adminID;');
                                 $stmt->bindParam(':adminID', $adminID);
                                 $stmt->bindParam(':bidcount', $bidcount);
                                 $stmt->execute();
			                     echo  "<script> window.location.href='memberpage.php';</script>";
                      }
                }
                ?>
               <br>
                <br>
       <div id="user" class="container"> 
            <form id="userform" action="" method="post">
            
                        <h6 style="padding-top:15px;font-size:15px;font-size:15px; text-align:center;">User</h6>
                         <button style="float:right; padding:1%;" name="deleteuser" id="deleteuser" href="#deleteuser"><i  style="font-size:20px;" class='fa fa-trash' aria-hidden="true"></i></button>  
                     <?php 
                      $stmt = $db->prepare('SELECT * FROM users WHERE adminID = :adminID');
                      $stmt->bindParam(':adminID',$adminID);
                      $stmt->execute();	                      
                      $row = $stmt->fetch(PDO::FETCH_ASSOC);  	
                      if(!$row){
                        ?>
                        <a style="float:right; padding:1%;" id="decisionbtn" href="#adduser" onclick="document.getElementById('adduser').style.display='block'" ><i  style="font-size:20px;" class='fa fa-plus' aria-hidden="true"></i></a>
                        <?php 
                        }
                        ?>
                     <table id="data">
                          <thead>
                              <tr>
                                <th class="table-header">User ID</th>
                                <th class="table-header">Gender</th>
                                <th class="table-header">Category of user</th>
                                <th class="table-header">Age</th>
                                <th class="table-header">Geography</th>
                              </tr>
                          </thead>
                          <tbody>
                          <?php
                              $stmt = $db->prepare('SELECT * FROM users WHERE adminID = :adminID');
                              $stmt->bindParam(':adminID',$adminID);
                              $stmt->execute();		
                        while($result=$stmt->fetch(PDO::FETCH_ASSOC)){
                         ?>  
                    
                              
                        <tr id="users">    
                           
                                <td id="userID">
                                   <?php
                            if($result['userID']!=null)
                                    echo $result['userID'];
                            else
                                  echo "--";
                                   ?>
                                </td>
                                <td id="gender"><?php  
                                    if($result['sex']=="O")
                                    echo "Other";
                                    else if($result['sex']=="M")
                                    echo "Male";
                                    else if($result['sex']=="F")
                                    echo "Female";
                                    else 
                                        echo "--";
                                    
                                    ?></td>
                                <td id="keywordsAboutInterests"><?php  
                                    if($result['keywordsAboutInterests']!=null){
                                    $keywords=$result['keywordsAboutInterests'];
                                    $keywords[strlen($keywords)-1]=null;
                                    echo $keywords;}
                                    else
                                        echo "--";
                                    ?></td>
                                <td id="age"><?php  
                                    if($result['age']!=0)
                                    echo $result['age'];
                                    else
                                        echo "--";
                                    ?></td>
                                  <td id="geography"><?php  
                            if($result['geo']!=null)
                                    echo $result['geo'];
                            else
                                 echo "--";
                                 ?></td> 
                              </tr>                              
                        <?php
                             }
                          ?>    
                          </tbody>
                        </table><br>
                 <center> <p id="erroruser" class="alert alert-danger" style="display:none; width:250px; height:auto;font-size:15px;">You have to add a new user</p></center> <br>
            
                    </form>
               </div>
                <br>
                <br>
                  <?php
              
                  if(isset($_POST['deleteuser'])){
                      $stmt = $db->prepare('SELECT * FROM users WHERE adminID = :adminID');
                      $stmt->bindParam(':adminID',$adminID);
                      $stmt->execute();	                      
                      $row = $stmt->fetch(PDO::FETCH_ASSOC);  	
                      if(!$row){
                         echo "<script>document.getElementById('erroruser').style.display='block';</script>";
                        } else {
                       $stmt = $db->prepare('Delete FROM users WHERE adminID = :adminID');              
                       $stmt->bindParam(':adminID',$adminID);
                       $stmt->execute();
                        echo  "<script> window.location.href='memberpage.php';</script>";
                        }
                  }
                ?>
             <div id="policyform" class="container"> 
                 <form action="" method="post">
                             <h6  style="padding-top:15px;font-size:15px;text-align:center;font-size:15px;">Choose a policy</h6>

                            <label for="1"> Policy 1</label><br>
                                       <input type="radio" name="policy" value="1" id="1" class="radiobtn"  /><p style="display:inline;font-size:15px;"> This policy prefers ads on user interests and high price</p><br><br>
                                    <label for="2"> Policy 2</label><br>
                                  <input type="radio" name="policy" value="2" id="2"  class="radiobtn"  /><p style="display:inline;font-size:15px;"> This policy prefers ads with high price</p><br><br>
                                   <label for="3"> Policy 3</label><br>
                                 <input type="radio" name="policy" value="3" id="3" class="radiobtn" /><p style="font-size:15px;display:inline;"> This policy prefers ads on user interests and user geography</p>
                  <br>
                    <br>
             <center> <p id="errorpolicy" class="alert alert-danger" style="display:none; width:250px; height:auto;font-size:15px;">You have to select a policy</p></center> <br>
                      <center> <p id="errorpolicy" class="alert alert-danger" style="display:none; width:250px; height:auto;font-size:15px;">You have to add at least one bid </p></center> <br>
              <center>  <input style="background-color:#C0C0C0; color:black;" id="decisionbtn "class="btn btn-default" type="submit" name="submit" value="submit"/></center><br> 
            </form>
           </div>    
              <?php 
                 if(isset($_POST['submit'])) {
                    if(isset($_POST['policy'])){
                              $stmt = $db->prepare('SELECT * FROM bids WHERE adminID = :adminID');
                               $stmt->bindParam(':adminID',$adminID);
                               $stmt->execute();	                      
                               $row = $stmt->fetch(PDO::FETCH_ASSOC);  	
                              if(!$row)
                                  echo "<script>document.getElementById('errorbid1').style.display='block';</script>";
                             else{
                            $stmt = $db->prepare('SELECT * FROM users WHERE adminID = :adminID');
                            $stmt->bindParam(':adminID', $adminID);
                            $stmt->execute();
                            $age=null;
                            $geo=null;
                            $sex=null;
                            $keywords=null;
                            while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $age = $result["age"];
                                $geo = $result["geo"];
                                $sex = $result["sex"];
                                $keywords=$result["keywordsAboutInterests"];
                            }
                            //write interests in predicates.pl
                            $my_file = './gorgias/decisionMaking/predicates.pl';
                            $handle = fopen($my_file, 'w') or die('Cannot open file:' . $my_file);
                            
                            if($keywords!=null){
                            $pieces = explode(",", $keywords);
                            for ($i = 0; $i < count($pieces)-1; $i++) {
                                $pi=strtolower($pieces[$i]);
                                $fwrite = fwrite($handle, "interests(" . $pi . ")");
                                fwrite($handle, ".\n");
                            }}
                            else{
                                 $fwrite = fwrite($handle, "interests(undefined)");
                                fwrite($handle, ".\n");
                            }
                           // write age and geography in predicates.pl
                            if($age!=0){
                            fwrite($handle, "age(".$age.").");
                            $fwrite = fwrite($handle, "\n");}
                            else{
                               fwrite($handle, "age(undefined).");
                            $fwrite = fwrite($handle, "\n");
                            } 
                            
                            if($geo!=null){
                           $geo=strtolower($geo);
                            
                            $fwrite = fwrite($handle,"geography(".$geo.").");
                            fwrite($handle, "\n");}
                            else{
                               $fwrite = fwrite($handle,"geography(undefined).");
                            fwrite($handle, "\n");  
                                
                            }

                           //write policy in predicates.pl
                                if ($_POST['policy'] == 1) 
                                    $fwrite = fwrite($handle, "policy(1)");
                                 else if ($_POST['policy'] == 2) 
                                    $fwrite = fwrite($handle, "policy(2)");
                                 else if ($_POST['policy'] == 3) 
                                    $fwrite = fwrite($handle, "policy(3)");
                                
                                fwrite($handle, ".\n");
                         


                            if ($sex == "F"){
                                $fwrite = fwrite($handle, "sex(f)");
                                   fwrite($handle, ".\n");}
                            else if($sex == "M"){
                                $fwrite = fwrite($handle, "sex(m)");
                                   fwrite($handle, ".\n");}
                            else if($sex=="O"){
                                  $fwrite = fwrite($handle, "sex(o)");
                                   fwrite($handle, ".\n");}
                            else{
                                 $fwrite = fwrite($handle, "sex(undefined)");
                                   fwrite($handle, ".\n");}
                                      
                          
                               $stmt = $db->prepare('SELECT bidcount FROM admins WHERE adminID = :adminID');
                               $stmt->bindParam(':adminID',$adminID);
                               $stmt->execute();	                      
                                 $result = $stmt->fetch(PDO::FETCH_ASSOC);
                                 $bidcount=$result['bidcount'];
                                 
                               $stmt = $db->prepare('SELECT bidID,blockedbypublisher FROM bids WHERE adminID = :adminID');
                               $stmt->bindParam(':adminID',$adminID);
                               $stmt->execute();	                      
                                $i=1;
                        fwrite($handle, "adList([");
                            while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                if($result['blockedbypublisher']==false){
                                    if($i!=$bidcount)
                                        fwrite($handle, $result['bidID'] . ",");
                                    else
                                         fwrite($handle, $result['bidID']);
                                    }
                                $i++;
                               
                            }
                        fwrite($handle,"");
                        fwrite($handle,"]).");
                                 
                                    fwrite($handle,"\n");
                             
                            $my_file2 = './gorgias/decisionMaking/bids.pl';
                            $handle2 = fopen($my_file2, 'w') or die('Cannot open file:' . $my_file2);
                               $stmt = $db->prepare('SELECT * FROM bids WHERE adminID = :adminID');
                               $stmt->bindParam(':adminID',$adminID);
                               $stmt->execute();	
                              
                               while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    $geography=strtolower($result['geography']); 
                                    $topic=strtolower($result['topic']); 
                                   $fwrite = fwrite($handle2, "ad(".$result["bidID"].",".$topic.",".$result['price'].",".$geography.").");
                                    $fwrite = fwrite($handle2, "\n");
                               }

                            $stmt = $db->prepare('SELECT * FROM bids WHERE adminID = :adminID');
                               $stmt->bindParam(':adminID',$adminID);
                               $stmt->execute();	                      
                               $i=0;
                               $arrayx[]=null;
                               while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    $secfil = 'executeGorgias.pl';
                                    $handle = fopen($secfil, 'w') or die('Cannot open file:' . $secfil);
                                    fwrite($handle, ":-consult('./gorgias/decisionMaking/adDecision.pl').");
                                    fwrite($handle, "\n");
                                    fwrite($handle, "askGorgias:-prove([show(ad,".$result['bidID'].")],Delta),write(1).");
                                    fwrite($handle, "\n");
                                    fwrite($handle, 'askGorgias:-write("false").');
                                    $cmd = "C:\\xampp\htdocs\AdServer\swipl\bin\swipl.exe -f executeGorgias.pl -g askGorgias,halt";
                                    $output = shell_exec(escapeshellcmd($cmd));
                                    if ($output == 1) {
                                        $arrayx[$i]=$result['bidID'];
                                        $i++;
                                    }
                                }
                                 ?>
                            <div id="winner"  class="w3-modal"  href="https://www.w3schools.com/w3css/4/w3.css">
                                <div class="w3-modal-content w3-animate-zoom" style="max-width:330px;height:300px;">
                                    <div class="w3-container w3-teal">
                                        <span style="height:40px; padding-bottom:1%" onclick="document.getElementById('winner').style.display='none'" class="w3-button w3-display-topright w3-large">x</span>
                                        <h3 style="margin-top:2%;">Winners bids are!</h3>
                                        <div class="container">    
                                           
                                        <?php
                                 
                                            for($i=0; $i<sizeof($arrayx);$i++){
                                              $stmt = $db->prepare('SELECT * FROM bids WHERE adminID = :adminID AND bidID = :bidID');
                                           $stmt->bindParam(':adminID',$adminID);
                                         $stmt->bindParam(':bidID',$arrayx[$i]);
                                       $stmt->execute();	
                                          $result = $stmt->fetch(PDO::FETCH_ASSOC);
                                          if(!$result)
                                               echo "<p style='color:black;'>Νone of these bits won because they were blocked by publisher!!";
                                        else
                                          echo "<p style='color:black;'><label>Bit ".$arrayx[$i]." with topic ".$result['topic'].", price ".$result['price']."euro and geography ".$result['geography']."</p>";
                                      }
                                    ?>
                                </div>                                   
                                </div>
                              </div>
                            </div>      
                          <?php
                               echo "<script>document.getElementById('winner').style.display='block';</script>";
           
                           }
                        }
                else{
                    echo "<script>document.getElementById('errorpolicy').style.display='block';</script>";
                    
                }
            }
            ?>
        
         </div>     
        <div id="adduser"  class="w3-modal"  href="https://www.w3schools.com/w3css/4/w3.css">
                        <div class="w3-modal-content w3-animate-zoom" style="max-width:450px; height:740px;">
                            <div class="w3-container w3-teal">
                                <span style="height:40px; padding-bottom:1%" onclick="document.getElementById('adduser').style.display='none'" class="w3-button w3-display-topright w3-large">x</span>
                                <h3 style="margin-top:2%;">Add a user!</h3>
                            </div>
                         
                            <div class="container">                
                                <form method="post" action="" id="add-form" >
                               
                                  <br>
                                 
                                    <div id="add"><label for="gender">Gender</label>
                                        <div style="float:right;padding-left:3%;"><input name="gender" type="radio" value="F"><label  style="padding-left:2%">Female</label></div><div style="float:right;padding-left:3%;"><input  name="gender" type="radio" value="M"><label  style="padding-left:2%"> Male </label></div><div style="float:right;padding-left:3%;"><input name="gender" type="radio" value="O"><label  style="padding-left:2%"> Other </label></div></div>
                                    <br>
                                   <div id="add"> <label for="keywords" >Category of user</label><span class="error">*</span>
                                    <div id="checkboxx"> <input type="checkbox" name="Food" value="Food"/>Food lover</div><br>
                                       <div id="checkboxx"> <input  type="checkbox" name="News" value="News" />News lover</div><br>
                                       <div id="checkboxx"> <input  type="checkbox" name="Entertainment" value="Entertainment"/>Entertainment lover</div><br>
                                       <div id="checkboxx">   <input  type="checkbox" name="Beauty" value="Beauty"/>Beauty lover</div><br>
                                       <div id="checkboxx"><input  type="checkbox" name="Personal" value="Personal Care"/>Personal Care lover</div><br>
                                       <div id="checkboxx"> <input  type="checkbox" name="Travel" value="Travel"/>Travel lover</div><br>
                                       <div id="checkboxx">  <input  type="checkbox" name="Health" value="Health"/>Health lover </div><br>
                                       <div id="checkboxx"> <input  type="checkbox" name="Fitness" value="Fitness"/>Fitness lover</div><br>
                                           <div id="checkboxx">    <input  type="checkbox" name="Sports" value="Sports"/>Sports lover</div><br>
                                       <div id="checkboxx"> <input  type="checkbox" name="Pets" value="Pets"/>Pets lover</div><br>
                                           <div id="checkboxx">  <input  type="checkbox" name="Art" value="Art"/>Art lover</div><br>
                                          <div id="checkboxx">   <input  type="checkbox" name="Cars" value="Cars"/>Cars lover</div><br>
                                         <div id="checkboxx">  <input  type="checkbox" name="Motorcycles" value="Motorcycles"/>Motorcycles lover</div><br>
                                          <div id="checkboxx">   <input  type="checkbox" name="Family" value="Family and Parenting"/>Family lover</div><br>
                                         <div id="checkboxx">   <input  type="checkbox" name="Drinks" value="Drinks"/>Drinks lover</div><br>
                                         <div id="checkboxx">     <input  type="checkbox" name="Home" value="Home and Garden"/>Home &amp; Garden lover</div><br>
                                       <div id="checkboxx">     <input  type="checkbox" name="wedding" value="Weddings"/>Weddings lover</div><br>
                                       <div id="checkboxx">    <input  type="checkbox" name="business" value="Business"/>Marketing lover</div><br>
                                        <div id="checkboxx">    <input  type="checkbox" name="com" value="Computers and Technology"/>Computers &amp; Technology lover</div><br>
                                        <div id="checkboxx">     <input  type="checkbox" name="sc" value="Science"/>Science lover</div><br>
                                       <div id="checkboxx">    <input  type="checkbox" name="video" value="Video games"/>Video Games lover</div>
                                        <div id="checkboxx">    <input  type="checkbox" name="fashion" value="Fashion and Style"/>Fashion &amp; Style lover</div> 
                                       <div id="checkboxx">    <input  type="checkbox" name="education" value="Education"/>Education</div>
                                     </div>  
                                    <br>
                                    <div id="add"><label for="age">Age</label>
                                      <input type="text" name="age" placeholder="e.g 20" style="border-bottom: 2px solid #808080 !important;" ></div>
                                    <br>
                                   <div id="add"> <label for="geography" >Geography</label>
                                      <select name='country' class='dropdown' style="width:182px; height:25px; color:black;">
                                        <option disabled selected value> -- one option -- </option>
                                        <option value="Afghanistan">Afghanistan</option>
                                        <option value="Albania">Albania</option>
                                        <option value="Algeria">Algeria</option>
                                        <option value="American Samoa">American Samoa</option>
                                        <option value="Andorra">Andorra</option>
                                        <option value="Angola">Angola</option>
                                        <option value="Anguilla">Anguilla</option>
                                        <option value="Antartica">Antarctica</option>
                                        <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                                        <option value="Argentina">Argentina</option>
                                        <option value="Armenia">Armenia</option>
                                        <option value="Aruba">Aruba</option>
                                        <option value="Australia">Australia</option>
                                        <option value="Austria">Austria</option>
                                        <option value="Azerbaijan">Azerbaijan</option>
                                        <option value="Bahamas">Bahamas</option>
                                        <option value="Bahrain">Bahrain</option>
                                        <option value="Bangladesh">Bangladesh</option>
                                        <option value="Barbados">Barbados</option>
                                        <option value="Belarus">Belarus</option>
                                        <option value="Belgium">Belgium</option>
                                        <option value="Belize">Belize</option>
                                        <option value="Benin">Benin</option>
                                        <option value="Bermuda">Bermuda</option>
                                        <option value="Bhutan">Bhutan</option>
                                        <option value="Bolivia">Bolivia</option>
                                        <option value="Bosnia and Herzegowina">Bosnia and Herzegowina</option>
                                        <option value="Botswana">Botswana</option>
                                        <option value="Bouvet Island">Bouvet Island</option>
                                        <option value="Brazil">Brazil</option>
                                        <option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
                                        <option value="Brunei Darussalam">Brunei Darussalam</option>
                                        <option value="Bulgaria">Bulgaria</option>
                                        <option value="Burkina Faso">Burkina Faso</option>
                                        <option value="Burundi">Burundi</option>
                                        <option value="Cambodia">Cambodia</option>
                                        <option value="Cameroon">Cameroon</option>
                                        <option value="Canada">Canada</option>
                                        <option value="Cape Verde">Cape Verde</option>
                                        <option value="Cayman Islands">Cayman Islands</option>
                                        <option value="Central African Republic">Central African Republic</option>
                                        <option value="Chad">Chad</option>
                                        <option value="Chile">Chile</option>
                                        <option value="China">China</option>
                                        <option value="Christmas Island">Christmas Island</option>
                                        <option value="Cocos Islands">Cocos (Keeling) Islands</option>
                                        <option value="Colombia">Colombia</option>
                                        <option value="Comoros">Comoros</option>
                                        <option value="Congo">Congo</option>
                                        <option value="Congo">Congo, the Democratic Republic of the</option>
                                        <option value="Cook Islands">Cook Islands</option>
                                        <option value="Costa Rica">Costa Rica</option>
                                        <option value="Cota DIvoire">Cote dIvoire</option>
                                        <option value="Croatia">Croatia (Hrvatska)</option>
                                        <option value="Cuba">Cuba</option>
                                        <option value="Cyprus">Cyprus</option>
                                        <option value="Czech Republic">Czech Republic</option>
                                        <option value="Denmark">Denmark</option>
                                        <option value="Djibouti">Djibouti</option>
                                        <option value="Dominica">Dominica</option>
                                        <option value="Dominican Republic">Dominican Republic</option>
                                        <option value="East Timor">East Timor</option>
                                        <option value="Ecuador">Ecuador</option>
                                        <option value="Egypt">Egypt</option>
                                        <option value="El Salvador">El Salvador</option>
                                        <option value="Equatorial Guinea">Equatorial Guinea</option>
                                        <option value="Eritrea">Eritrea</option>
                                        <option value="Estonia">Estonia</option>
                                        <option value="Ethiopia">Ethiopia</option>
                                        <option value="Falkland Islands">Falkland Islands (Malvinas)</option>
                                        <option value="Faroe Islands">Faroe Islands</option>
                                        <option value="Fiji">Fiji</option>
                                        <option value="Finland">Finland</option>
                                        <option value="France">France</option>
                                        <option value="France Metropolitan">France, Metropolitan</option>
                                        <option value="French Guiana">French Guiana</option>
                                        <option value="French Polynesia">French Polynesia</option>
                                        <option value="French Southern Territories">French Southern Territories</option>
                                        <option value="Gabon">Gabon</option>
                                        <option value="Gambia">Gambia</option>
                                        <option value="Georgia">Georgia</option>
                                        <option value="Germany">Germany</option>
                                        <option value="Ghana">Ghana</option>
                                        <option value="Gibraltar">Gibraltar</option>
                                        <option value="Greece">Greece</option>
                                        <option value="Greenland">Greenland</option>
                                        <option value="Grenada">Grenada</option>
                                        <option value="Guadeloupe">Guadeloupe</option>
                                        <option value="Guam">Guam</option>
                                        <option value="Guatemala">Guatemala</option>
                                        <option value="Guinea">Guinea</option>
                                        <option value="Guinea-Bissau">Guinea-Bissau</option>
                                        <option value="Guyana">Guyana</option>
                                        <option value="Haiti">Haiti</option>
                                        <option value="Heard and McDonald Islands">Heard and Mc Donald Islands</option>
                                        <option value="Holy See">Holy See (Vatican City State)</option>
                                        <option value="Honduras">Honduras</option>
                                        <option value="Hong Kong">Hong Kong</option>
                                        <option value="Hungary">Hungary</option>
                                        <option value="Iceland">Iceland</option>
                                        <option value="India">India</option>
                                        <option value="Indonesia">Indonesia</option>
                                        <option value="Iran">Iran (Islamic Republic of)</option>
                                        <option value="Iraq">Iraq</option>
                                        <option value="Ireland">Ireland</option>
                                        <option value="Israel">Israel</option>
                                        <option value="Italy">Italy</option>
                                        <option value="Jamaica">Jamaica</option>
                                        <option value="Japan">Japan</option>
                                        <option value="Jordan">Jordan</option>
                                        <option value="Kazakhstan">Kazakhstan</option>
                                        <option value="Kenya">Kenya</option>
                                        <option value="Kiribati">Kiribati</option>
                                        <option value="Democratic Peoples Republic of Korea">Korea, Democratic People Republic of</option>
                                        <option value="Korea">Korea, Republic of</option>
                                        <option value="Kuwait">Kuwait</option>
                                        <option value="Kyrgyzstan">Kyrgyzstan</option>
                                        <option value="Lao">Lao People Democratic Republic</option>
                                        <option value="Latvia">Latvia</option>
                                        <option value="Lebanon">Lebanon</option>
                                        <option value="Lesotho">Lesotho</option>
                                        <option value="Liberia">Liberia</option>
                                        <option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option>
                                        <option value="Liechtenstein">Liechtenstein</option>
                                        <option value="Lithuania">Lithuania</option>
                                        <option value="Luxembourg">Luxembourg</option>
                                        <option value="Macau">Macau</option>
                                        <option value="Macedonia">Macedonia, The Former Yugoslav Republic of</option>
                                        <option value="Madagascar">Madagascar</option>
                                        <option value="Malawi">Malawi</option>
                                        <option value="Malaysia">Malaysia</option>
                                        <option value="Maldives">Maldives</option>
                                        <option value="Mali">Mali</option>
                                        <option value="Malta">Malta</option>
                                        <option value="Marshall Islands">Marshall Islands</option>
                                        <option value="Martinique">Martinique</option>
                                        <option value="Mauritania">Mauritania</option>
                                        <option value="Mauritius">Mauritius</option>
                                        <option value="Mayotte">Mayotte</option>
                                        <option value="Mexico">Mexico</option>
                                        <option value="Micronesia">Micronesia, Federated States of</option>
                                        <option value="Moldova">Moldova, Republic of</option>
                                        <option value="Monaco">Monaco</option>
                                        <option value="Mongolia">Mongolia</option>
                                        <option value="Montserrat">Montserrat</option>
                                        <option value="Morocco">Morocco</option>
                                        <option value="Mozambique">Mozambique</option>
                                        <option value="Myanmar">Myanmar</option>
                                        <option value="Namibia">Namibia</option>
                                        <option value="Nauru">Nauru</option>
                                        <option value="Nepal">Nepal</option>
                                        <option value="Netherlands">Netherlands</option>
                                        <option value="Netherlands Antilles">Netherlands Antilles</option>
                                        <option value="New Caledonia">New Caledonia</option>
                                        <option value="New Zealand">New Zealand</option>
                                        <option value="Nicaragua">Nicaragua</option>
                                        <option value="Niger">Niger</option>
                                        <option value="Nigeria">Nigeria</option>
                                        <option value="Niue">Niue</option>
                                        <option value="Norfolk Island">Norfolk Island</option>
                                        <option value="Northern Mariana Islands">Northern Mariana Islands</option>
                                        <option value="Norway">Norway</option>
                                        <option value="Oman">Oman</option>
                                        <option value="Pakistan">Pakistan</option>
                                        <option value="Palau">Palau</option>
                                        <option value="Panama">Panama</option>
                                        <option value="Papua New Guinea">Papua New Guinea</option>
                                        <option value="Paraguay">Paraguay</option>
                                        <option value="Peru">Peru</option>
                                        <option value="Philippines">Philippines</option>
                                        <option value="Pitcairn">Pitcairn</option>
                                        <option value="Poland">Poland</option>
                                        <option value="Portugal">Portugal</option>
                                        <option value="Puerto Rico">Puerto Rico</option>
                                        <option value="Qatar">Qatar</option>
                                        <option value="Reunion">Reunion</option>
                                        <option value="Romania">Romania</option>
                                        <option value="Russia">Russian Federation</option>
                                        <option value="Rwanda">Rwanda</option>
                                        <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option> 
                                        <option value="Saint LUCIA">Saint LUCIA</option>
                                        <option value="Saint Vincent">Saint Vincent and the Grenadines</option>
                                        <option value="Samoa">Samoa</option>
                                        <option value="San Marino">San Marino</option>
                                        <option value="Sao Tome and Principe">Sao Tome and Principe</option> 
                                        <option value="Saudi Arabia">Saudi Arabia</option>
                                        <option value="Senegal">Senegal</option>
                                        <option value="Seychelles">Seychelles</option>
                                        <option value="Sierra">Sierra Leone</option>
                                        <option value="Singapore">Singapore</option>
                                        <option value="Slovakia">Slovakia (Slovak Republic)</option>
                                        <option value="Slovenia">Slovenia</option>
                                        <option value="Solomon Islands">Solomon Islands</option>
                                        <option value="Somalia">Somalia</option>
                                        <option value="South Africa">South Africa</option>
                                        <option value="South Georgia">South Georgia and the South Sandwich Islands</option>
                                        <option value="Span">Spain</option>
                                        <option value="SriLanka">Sri Lanka</option>
                                        <option value="St. Helena">St. Helena</option>
                                        <option value="St. Pierre and Miguelon">St. Pierre and Miquelon</option>
                                        <option value="Sudan">Sudan</option>
                                        <option value="Suriname">Suriname</option>
                                        <option value="Svalbard">Svalbard and Jan Mayen Islands</option>
                                        <option value="Swaziland">Swaziland</option>
                                        <option value="Sweden">Sweden</option>
                                        <option value="Switzerland">Switzerland</option>
                                        <option value="Syria">Syrian Arab Republic</option>
                                        <option value="Taiwan">Taiwan, Province of China</option>
                                        <option value="Tajikistan">Tajikistan</option>
                                        <option value="Tanzania">Tanzania, United Republic of</option>
                                        <option value="Thailand">Thailand</option>
                                        <option value="Togo">Togo</option>
                                        <option value="Tokelau">Tokelau</option>
                                        <option value="Tonga">Tonga</option>
                                        <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                                        <option value="Tunisia">Tunisia</option>
                                        <option value="Turkey">Turkey</option>
                                        <option value="Turkmenistan">Turkmenistan</option>
                                        <option value="Turks and Caicos">Turks and Caicos Islands</option>
                                        <option value="Tuvalu">Tuvalu</option>
                                        <option value="Uganda">Uganda</option>
                                        <option value="Ukraine">Ukraine</option>
                                        <option value="United Arab Emirates">United Arab Emirates</option>
                                        <option value="United Kingdom">United Kingdom</option>
                                        <option value="United States">United States</option>
                                        <option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option>
                                        <option value="Uruguay">Uruguay</option>
                                        <option value="Uzbekistan">Uzbekistan</option>
                                        <option value="Vanuatu">Vanuatu</option>
                                        <option value="Venezuela">Venezuela</option>
                                        <option value="Vietnam">Viet Nam</option>
                                        <option value="Virgin Islands (British)">Virgin Islands (British)</option>
                                        <option value="Virgin Islands (U.S)">Virgin Islands (U.S.)</option>
                                        <option value="Wallis and Futana Islands">Wallis and Futuna Islands</option>
                                        <option value="Western Sahara">Western Sahara</option>
                                        <option value="Yemen">Yemen</option>
                                        <option value="Yugoslavia">Yugoslavia</option>
                                        <option value="Zambia">Zambia</option>
                                        <option value="Zimbabwe">Zimbabwe</option>
                                          
                                    </select>
                                       
                                   </div>
                                    <br>
                                    <center><input style="background-color: #0e2f44;" class="btn btn-default" name="addButton" id="loginbtn" type="submit" value="Add"></center>
                                    <?php
                                    
                                    if(isset($_POST['addButton'])){
                                      if(isset($_POST['News']))
                                        $keywords.=$_POST['News'].",";
                                    if(isset($_POST['Food']))
                                        $keywords.=$_POST['Food'].","; 
                                    if(isset($_POST['Entertainment']))
                                        $keywords.=$_POST['Entertainment'].",";
                                    if(isset($_POST['Personal']))
                                        $keywords.=$_POST['Personal'].",";
                                    if(isset($_POST['Travel']))
                                        $keywords.=$_POST['Travel'].","; 
                                    if(isset($_POST['Beauty']))
                                        $keywords.=$_POST['Beauty'].","; 
                                    if(isset($_POST['Health']))
                                        $keywords.=$_POST['Health'].","; 
                                    if(isset($_POST['Fitness']))
                                        $keywords.=$_POST['Fitness'].",";
                                    if(isset($_POST['Sports']))
                                        $keywords.=$_POST['Sports'].","; 
                                    if(isset($_POST['Pets']))
                                        $keywords.=$_POST['Pets'].","; 
                                    if(isset($_POST['Art']))
                                        $keywords.=$_POST['Art'].","; 
									if(isset($_POST['Cars']))
                                        $keywords.=$_POST['Cars'].","; 
									if(isset($_POST['Motorcycles']))
                                        $keywords.=$_POST['Motorcycles'].","; 
									if(isset($_POST['Family']))
                                        $keywords.=$_POST['Family'].","; 
									if(isset($_POST['Drinks']))
                                        $keywords.=$_POST['Drinks'].",";
									if(isset($_POST['Home']))
                                        $keywords.=$_POST['Home'].",";
									if(isset($_POST['wedding']))
                                        $keywords.=$_POST['wedding'].",";
									if(isset($_POST['business']))
                                        $keywords.=$_POST['business'].",";
									if(isset($_POST['com']))
                                        $keywords.=$_POST['com'].",";
									if(isset($_POST['sc']))
                                        $keywords.=$_POST['sc'].",";
									if(isset($_POST['video']))
                                        $keywords.=$_POST['video'].",";
                                    if(isset($_POST['fashion']))
                                        $keywords.=$_POST['fashion'].",";
                                    if(isset($_POST['education']))
                                        $keywords.=$_POST['fashion'].",";
                                  
                                  
                                
                                  
                                    $age=$_POST['age'];
                                    $sex=$_POST['gender'];
                                    $geo=$_POST['country'];
                                     $stmt = $db->prepare('INSERT INTO users(adminID,keywordsAboutInterests,age,sex,geo)VALUES (:adminID,:keywordsAboutInterests,:age,:sex,:geo)');
                                     $stmt->execute(array(
                                            ':adminID' => $adminID,
                                            ':keywordsAboutInterests' =>$keywords,
                                            ':age' => $age,
                                            ':sex' => $sex,
                                            ':geo' => $geo
                                        ));
                                    echo "<script>
                                        window.location.href='memberpage.php';</script>";
                                    }
                                    ?>
                                </form>
                              </div>
                            </div>
        </div>
 
                         
        <div id="addbid"  class="w3-modal"  href="https://www.w3schools.com/w3css/4/w3.css">
                        <div class="w3-modal-content w3-animate-zoom" style="max-width:330px;">
                            <div class="w3-container w3-teal">
                                <span style="height:40px; padding-bottom:1%" onclick="document.getElementById('addbid').style.display='none'" class="w3-button w3-display-topright w3-large">x</span>
                                <h3 style="margin-top:2%;">Add a new bid!</h3>
                            </div>
                         
                            <div class="container">                
                                <form method="post" action="" id="add-form" >
                               
                                  <br>
                                       <div id="add"> <label for="topic" >Topic</label><span class="error">*</span>
                                      <select name='topic' class='dropdown' style=" width:200px; color:black;" required>
                                       <option disabled selected value> -- one option -- </option>
                                        <option value="Food">Food</option>
                                        <option value="News">News</option>
                                        <option value="Entertainment">Entertainment</option>
                                        <option value="Beauty">Beauty</option>  
                                        <option value="Personal Care">Personal Care</option>
                                        <option value="Travel">Travel</option>
                                        <option value="Health">Health</option> 
                                        <option value="Fitness">Fitness</option>
                                        <option value="Sports">Sports</option>
                                        <option value="Pets">Pets</option>
                                        <option value="Art">Art</option>
                                        <option value="Cars">Cars</option>
                                        <option value="Motorcycles">Motorcycles</option>
                                        <option value="Family and Parenting">Family &amp; Parenting</option>
                                        <option value="Drinks">Drinks</option>
                                        <option value="Home and Garden">Home &amp; Garden</option>
                                        <option value="Weddings">Weddings</option>
                                        <option value="Business">Business</option>
                                        <option value="Computers and Technology">Computers &amp; Technology</option>
                                        <option value="Science">Science</option>
                                        <option value="Video games">Video Games</option>
                                        <option value="Fashion and Style">Fashion &amp; Style</option> 
                                        <option value="Education">Education</option>
                                   
                                           </select>
                                            
                                    </div>
                                        
                                        
                                    <br>
                                    
                                      <div id="add"><label for="blocked">Blocked by publisher</label>
                                          <div style="float:right;padding-left:3%;"><input name="blocked" type="radio" value="F" ><label  style="padding-left:2%" >False</label></div><div style="float:right;padding-left:3%;"><input  name="blocked" type="radio" value="T" required><label  style="padding-left:2%">True</label></div></div>
                                    <br>
                                    <div id="add"> <label for="price">Price</label><span class="error">*</span> <input type="text" name="price" placeholder="e.g. 1.8 euro" style="border-bottom: 2px solid #808080 !important;" required> </div>
                                    <br>
                                   <div id="add"> <label for="country" >Geography</label><span class="error">*</span>
                                      <select name='country' class='dropdown' style=" width:200px; color:black;" required>
                                          
                                        <option disabled selected value> -- select an option -- </option>
                                        <option value="Afghanistan">Afghanistan</option>
                                        <option value="Albania">Albania</option>
                                        <option value="Algeria">Algeria</option>
                                        <option value="American Samoa">American Samoa</option>
                                        <option value="Andorra">Andorra</option>
                                        <option value="Angola">Angola</option>
                                        <option value="Anguilla">Anguilla</option>
                                        <option value="Antartica">Antarctica</option>
                                        <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                                        <option value="Argentina">Argentina</option>
                                        <option value="Armenia">Armenia</option>
                                        <option value="Aruba">Aruba</option>
                                        <option value="Australia">Australia</option>
                                        <option value="Austria">Austria</option>
                                        <option value="Azerbaijan">Azerbaijan</option>
                                        <option value="Bahamas">Bahamas</option>
                                        <option value="Bahrain">Bahrain</option>
                                        <option value="Bangladesh">Bangladesh</option>
                                        <option value="Barbados">Barbados</option>
                                        <option value="Belarus">Belarus</option>
                                        <option value="Belgium">Belgium</option>
                                        <option value="Belize">Belize</option>
                                        <option value="Benin">Benin</option>
                                        <option value="Bermuda">Bermuda</option>
                                        <option value="Bhutan">Bhutan</option>
                                        <option value="Bolivia">Bolivia</option>
                                        <option value="Bosnia and Herzegowina">Bosnia and Herzegowina</option>
                                        <option value="Botswana">Botswana</option>
                                        <option value="Bouvet Island">Bouvet Island</option>
                                        <option value="Brazil">Brazil</option>
                                        <option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
                                        <option value="Brunei Darussalam">Brunei Darussalam</option>
                                        <option value="Bulgaria">Bulgaria</option>
                                        <option value="Burkina Faso">Burkina Faso</option>
                                        <option value="Burundi">Burundi</option>
                                        <option value="Cambodia">Cambodia</option>
                                        <option value="Cameroon">Cameroon</option>
                                        <option value="Canada">Canada</option>
                                        <option value="Cape Verde">Cape Verde</option>
                                        <option value="Cayman Islands">Cayman Islands</option>
                                        <option value="Central African Republic">Central African Republic</option>
                                        <option value="Chad">Chad</option>
                                        <option value="Chile">Chile</option>
                                        <option value="China">China</option>
                                        <option value="Christmas Island">Christmas Island</option>
                                        <option value="Cocos Islands">Cocos (Keeling) Islands</option>
                                        <option value="Colombia">Colombia</option>
                                        <option value="Comoros">Comoros</option>
                                        <option value="Congo">Congo</option>
                                        <option value="Congo">Congo, the Democratic Republic of the</option>
                                        <option value="Cook Islands">Cook Islands</option>
                                        <option value="Costa Rica">Costa Rica</option>
                                        <option value="Cota DIvoire">Cote dIvoire</option>
                                        <option value="Croatia">Croatia (Hrvatska)</option>
                                        <option value="Cuba">Cuba</option>
                                        <option value="Cyprus" >Cyprus</option>
                                        <option value="Czech Republic">Czech Republic</option>
                                        <option value="Denmark">Denmark</option>
                                        <option value="Djibouti">Djibouti</option>
                                        <option value="Dominica">Dominica</option>
                                        <option value="Dominican Republic">Dominican Republic</option>
                                        <option value="East Timor">East Timor</option>
                                        <option value="Ecuador">Ecuador</option>
                                        <option value="Egypt">Egypt</option>
                                        <option value="El Salvador">El Salvador</option>
                                        <option value="Equatorial Guinea">Equatorial Guinea</option>
                                        <option value="Eritrea">Eritrea</option>
                                        <option value="Estonia">Estonia</option>
                                        <option value="Ethiopia">Ethiopia</option>
                                        <option value="Falkland Islands">Falkland Islands (Malvinas)</option>
                                        <option value="Faroe Islands">Faroe Islands</option>
                                        <option value="Fiji">Fiji</option>
                                        <option value="Finland">Finland</option>
                                        <option value="France">France</option>
                                        <option value="France Metropolitan">France, Metropolitan</option>
                                        <option value="French Guiana">French Guiana</option>
                                        <option value="French Polynesia">French Polynesia</option>
                                        <option value="French Southern Territories">French Southern Territories</option>
                                        <option value="Gabon">Gabon</option>
                                        <option value="Gambia">Gambia</option>
                                        <option value="Georgia">Georgia</option>
                                        <option value="Germany">Germany</option>
                                        <option value="Ghana">Ghana</option>
                                        <option value="Gibraltar">Gibraltar</option>
                                        <option value="Greece">Greece</option>
                                        <option value="Greenland">Greenland</option>
                                        <option value="Grenada">Grenada</option>
                                        <option value="Guadeloupe">Guadeloupe</option>
                                        <option value="Guam">Guam</option>
                                        <option value="Guatemala">Guatemala</option>
                                        <option value="Guinea">Guinea</option>
                                        <option value="Guinea-Bissau">Guinea-Bissau</option>
                                        <option value="Guyana">Guyana</option>
                                        <option value="Haiti">Haiti</option>
                                        <option value="Heard and McDonald Islands">Heard and Mc Donald Islands</option>
                                        <option value="Holy See">Holy See (Vatican City State)</option>
                                        <option value="Honduras">Honduras</option>
                                        <option value="Hong Kong">Hong Kong</option>
                                        <option value="Hungary">Hungary</option>
                                        <option value="Iceland">Iceland</option>
                                        <option value="India">India</option>
                                        <option value="Indonesia">Indonesia</option>
                                        <option value="Iran">Iran (Islamic Republic of)</option>
                                        <option value="Iraq">Iraq</option>
                                        <option value="Ireland">Ireland</option>
                                        <option value="Israel">Israel</option>
                                        <option value="Italy">Italy</option>
                                        <option value="Jamaica">Jamaica</option>
                                        <option value="Japan">Japan</option>
                                        <option value="Jordan">Jordan</option>
                                        <option value="Kazakhstan">Kazakhstan</option>
                                        <option value="Kenya">Kenya</option>
                                        <option value="Kiribati">Kiribati</option>
                                        <option value="Democratic Peoples Republic of Korea">Korea, Democratic People Republic of</option>
                                        <option value="Korea">Korea, Republic of</option>
                                        <option value="Kuwait">Kuwait</option>
                                        <option value="Kyrgyzstan">Kyrgyzstan</option>
                                        <option value="Lao">Lao People Democratic Republic</option>
                                        <option value="Latvia">Latvia</option>
                                        <option value="Lebanon">Lebanon</option>
                                        <option value="Lesotho">Lesotho</option>
                                        <option value="Liberia">Liberia</option>
                                        <option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option>
                                        <option value="Liechtenstein">Liechtenstein</option>
                                        <option value="Lithuania">Lithuania</option>
                                        <option value="Luxembourg">Luxembourg</option>
                                        <option value="Macau">Macau</option>
                                        <option value="Macedonia">Macedonia, The Former Yugoslav Republic of</option>
                                        <option value="Madagascar">Madagascar</option>
                                        <option value="Malawi">Malawi</option>
                                        <option value="Malaysia">Malaysia</option>
                                        <option value="Maldives">Maldives</option>
                                        <option value="Mali">Mali</option>
                                        <option value="Malta">Malta</option>
                                        <option value="Marshall Islands">Marshall Islands</option>
                                        <option value="Martinique">Martinique</option>
                                        <option value="Mauritania">Mauritania</option>
                                        <option value="Mauritius">Mauritius</option>
                                        <option value="Mayotte">Mayotte</option>
                                        <option value="Mexico">Mexico</option>
                                        <option value="Micronesia">Micronesia, Federated States of</option>
                                        <option value="Moldova">Moldova, Republic of</option>
                                        <option value="Monaco">Monaco</option>
                                        <option value="Mongolia">Mongolia</option>
                                        <option value="Montserrat">Montserrat</option>
                                        <option value="Morocco">Morocco</option>
                                        <option value="Mozambique">Mozambique</option>
                                        <option value="Myanmar">Myanmar</option>
                                        <option value="Namibia">Namibia</option>
                                        <option value="Nauru">Nauru</option>
                                        <option value="Nepal">Nepal</option>
                                        <option value="Netherlands">Netherlands</option>
                                        <option value="Netherlands Antilles">Netherlands Antilles</option>
                                        <option value="New Caledonia">New Caledonia</option>
                                        <option value="New Zealand">New Zealand</option>
                                        <option value="Nicaragua">Nicaragua</option>
                                        <option value="Niger">Niger</option>
                                        <option value="Nigeria">Nigeria</option>
                                        <option value="Niue">Niue</option>
                                        <option value="Norfolk Island">Norfolk Island</option>
                                        <option value="Northern Mariana Islands">Northern Mariana Islands</option>
                                        <option value="Norway">Norway</option>
                                        <option value="Oman">Oman</option>
                                        <option value="Pakistan">Pakistan</option>
                                        <option value="Palau">Palau</option>
                                        <option value="Panama">Panama</option>
                                        <option value="Papua New Guinea">Papua New Guinea</option>
                                        <option value="Paraguay">Paraguay</option>
                                        <option value="Peru">Peru</option>
                                        <option value="Philippines">Philippines</option>
                                        <option value="Pitcairn">Pitcairn</option>
                                        <option value="Poland">Poland</option>
                                        <option value="Portugal">Portugal</option>
                                        <option value="Puerto Rico">Puerto Rico</option>
                                        <option value="Qatar">Qatar</option>
                                        <option value="Reunion">Reunion</option>
                                        <option value="Romania">Romania</option>
                                        <option value="Russia">Russian Federation</option>
                                        <option value="Rwanda">Rwanda</option>
                                        <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option> 
                                        <option value="Saint LUCIA">Saint LUCIA</option>
                                        <option value="Saint Vincent">Saint Vincent and the Grenadines</option>
                                        <option value="Samoa">Samoa</option>
                                        <option value="San Marino">San Marino</option>
                                        <option value="Sao Tome and Principe">Sao Tome and Principe</option> 
                                        <option value="Saudi Arabia">Saudi Arabia</option>
                                        <option value="Senegal">Senegal</option>
                                        <option value="Seychelles">Seychelles</option>
                                        <option value="Sierra">Sierra Leone</option>
                                        <option value="Singapore">Singapore</option>
                                        <option value="Slovakia">Slovakia (Slovak Republic)</option>
                                        <option value="Slovenia">Slovenia</option>
                                        <option value="Solomon Islands">Solomon Islands</option>
                                        <option value="Somalia">Somalia</option>
                                        <option value="South Africa">South Africa</option>
                                        <option value="South Georgia">South Georgia and the South Sandwich Islands</option>
                                        <option value="Span">Spain</option>
                                        <option value="SriLanka">Sri Lanka</option>
                                        <option value="St. Helena">St. Helena</option>
                                        <option value="St. Pierre and Miguelon">St. Pierre and Miquelon</option>
                                        <option value="Sudan">Sudan</option>
                                        <option value="Suriname">Suriname</option>
                                        <option value="Svalbard">Svalbard and Jan Mayen Islands</option>
                                        <option value="Swaziland">Swaziland</option>
                                        <option value="Sweden">Sweden</option>
                                        <option value="Switzerland">Switzerland</option>
                                        <option value="Syria">Syrian Arab Republic</option>
                                        <option value="Taiwan">Taiwan, Province of China</option>
                                        <option value="Tajikistan">Tajikistan</option>
                                        <option value="Tanzania">Tanzania, United Republic of</option>
                                        <option value="Thailand">Thailand</option>
                                        <option value="Togo">Togo</option>
                                        <option value="Tokelau">Tokelau</option>
                                        <option value="Tonga">Tonga</option>
                                        <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                                        <option value="Tunisia">Tunisia</option>
                                        <option value="Turkey">Turkey</option>
                                        <option value="Turkmenistan">Turkmenistan</option>
                                        <option value="Turks and Caicos">Turks and Caicos Islands</option>
                                        <option value="Tuvalu">Tuvalu</option>
                                        <option value="Uganda">Uganda</option>
                                        <option value="Ukraine">Ukraine</option>
                                        <option value="United Arab Emirates">United Arab Emirates</option>
                                        <option value="United Kingdom">United Kingdom</option>
                                        <option value="United States">United States</option>
                                        <option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option>
                                        <option value="Uruguay">Uruguay</option>
                                        <option value="Uzbekistan">Uzbekistan</option>
                                        <option value="Vanuatu">Vanuatu</option>
                                        <option value="Venezuela">Venezuela</option>
                                        <option value="Vietnam">Viet Nam</option>
                                        <option value="Virgin Islands (British)">Virgin Islands (British)</option>
                                        <option value="Virgin Islands (U.S)">Virgin Islands (U.S.)</option>
                                        <option value="Wallis and Futana Islands">Wallis and Futuna Islands</option>
                                        <option value="Western Sahara">Western Sahara</option>
                                        <option value="Yemen">Yemen</option>
                                        <option value="Yugoslavia">Yugoslavia</option>
                                        <option value="Zambia">Zambia</option>
                                        <option value="Zimbabwe">Zimbabwe</option>
                                          
                                    </select>
                                       
                                   </div>
                                    <br>
                                    <center><input style="background-color: #0e2f44;" class="btn btn-default" name="add" id="loginbtn" type="submit" value="Add"></center>
                                    <?php
                                    if(isset($_POST['add'])){
                                    $topic=$_POST['topic'];
                                    $blockedbypublisher=$_POST['blocked'];
                                    if($blockedbypublisher=="T")
                                        $blockedbypublisher=true;
                                    elseif ($blockedbypublisher=="F")
                                         $blockedbypublisher=false;

                                    $price=$_POST['price'];
                                    $geography=$_POST['country'];
                                     $stmt = $db->prepare('INSERT INTO bids(adminID,topic,price,geography,blockedbypublisher)VALUES (:adminID,:topic,:price,:geography,:blockedbypublisher)');
                                     $stmt->execute(array(
                                            ':adminID' => $adminID,
                                            ':topic' => $topic,
                                            ':price' => $price,
                                            ':geography' =>$geography,
                                            ':blockedbypublisher' => $blockedbypublisher
                                        ));
                                       $stmt = $db->prepare('SELECT bidcount FROM admins WHERE adminID=:adminID;');
                                       $stmt->bindParam(':adminID', $adminID);
                                       $stmt->execute();
                                       $result = $stmt->fetch(PDO::FETCH_ASSOC);
                                       $bidcount=$result['bidcount'];
                                       $bidcount++;
                                        $stmt = $db->prepare('UPDATE admins SET bidcount=:bidcount WHERE adminID=:adminID;');
                                        $stmt->bindParam(':adminID', $adminID);
                                        $stmt->bindParam(':bidcount', $bidcount);
                                        $stmt->execute();
                                        echo "<script>
                                        window.location.href='memberpage.php';</script>";
                                    }
                                    ?>
                                </form>
                              </div>
                            </div>
                        </div>
    </header>
        
     <!-- Footer -->
    <footer>
        <center><div id="footer">
            <div style="display:inline">
                <a href="index.php#aboutus">About us</a><br>
                <div id="social">
                    <h3 style="font-size:12px;color:black;">Contact us</h3>
                    <a href="https://www.facebook.com/kwtcCia" class="fa fa-facebook"></a>
                    <a href="" class="fa fa-twitter"></a>
                    <a href="https://www.instagram.com/kwnstantina_tseriwtou/?hl=en" class="fa fa-instagram"></a>	
			     </div>
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
                       

