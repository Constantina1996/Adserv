<?php require_once('includes/config.php'); 

//define page title
$title = 'Memberpage';
$back = 'logout.php';
$textofback = 'Log out';
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
        <script src='bitSelection.js' type="text/javascript"> </script>
    
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
    <header class="masthead" style="height:1200px">
      <div class="intro-body">
          <center><h3 class="omb_authTitle">Welcome to AD SERVER platform</h3></center> 
            <form action="" method="post">
    <div class="container" style="column-count:2;">
        <div id="policyform" class="container"> 
             <h6 style="font-size:15px;">Choose a policy</h6>
            
            <label for="1"> Policy 1</label><br>
                       <input type="radio" name="policy" value="1" id="1" class="radiobtn"  /><p style="display:inline;"> This policy prefers ads with user interests. The second priority is
                        high price and the third priority is user geography</p><br>
                    <label for="2"> Policy 2</label><br>
                  <input type="radio" name="policy" value="2" id="2"  class="radiobtn"  /><p style="display:inline;"> This policy prefers ads with high price. The second priority is
                            user interests and the third priority is user geography</p><br>
                   <label for="3"> Policy 3</label><br>
                 <input type="radio" name="policy" value="3" id="3" class="radiobtn" /><p style="display:inline;"> This policy prefers ads with user interests. The second priority is
                            user geography and the third priority is high price</p>
                    <br>
            
               </div>
        <div id="user" class="container"> 
            <h6 style="font-size:15px;">User</h6>
            
        </div>
        </div>
        <br>
        <br>
            <form id="editbids" action="" method="post">
            <div id="bitsform" class="container"> 
            <h6 style="font-size:15px;">Bids from advertisers</h6>
                 <a style="float:right; padding:1%;" id="decisionbtn"  href="#deletebid" ><i style="font-size:20px;" class='fa fa-trash' aria-hidden="true"></i></a> 
                <a style="float:right; padding:1%;" id="decisionbtn"  href="#editbid" onclick="document.getElementById('editbid').style.display='block'" ><i style="font-size:20px;" class='fa fa-edit' aria-hidden="true"></i></a> 
                <a style="float:right; padding:1%;" id="decisionbtn" href="#addbid" onclick="document.getElementById('addbid').style.display='block'" ><abbr title="Add a bid"></abbr><i  style="font-size:20px;" class='fa fa-plus' aria-hidden="true"></i></a> 
                       <table id="data">
                          <thead>
                              <tr>
                                <th class="table-header">Id</th>
                                <th class="table-header">Topic</th>
                                <th class="table-header">Price</th>
                                <th class="table-header">Geography</th>
                              </tr>
                          </thead>
                          <tbody>
                          <?php
                              $adminID=$_SESSION['adminID'];
                           
                              $stmt = $db->prepare('SELECT * FROM bids WHERE adminID = :adminID');
                              $stmt->bindParam(':adminID',$adminID);
                              $stmt->execute();		
                        while($result=$stmt->fetch(PDO::FETCH_ASSOC)){
                         ?>  
                              <tr onclick="select(this,'<?php echo $result['bidID'];?>');">    
                                  
                                <th><?php  
                                    echo $result['bidID'];
                                    ?></th>
                                <th><?php  
                                    echo $result['topic'];
                                    ?></th>
                                <th><?php  
                                    echo $result['price'];
                                    ?></th>
                                <th><?php  
                                    echo $result['geography'];
                                    ?></th> 
                              </tr>                              
                        <?php
                             }
                          ?>    
                          </tbody>
                        </table>
                    <script>
                      $("#data tr").click(function() {
                      var selected = $(this).hasClass("highlight");
                      $("#data tr").removeClass("highlight");
                    if(!selected)
                    $(this).addClass("highlight");
                    });
                    </script>
                </div>
                <?php
              
                 if(isset($_POST['deletion'])){
                            if(isset($_POST['bids'])){
                                $bidID=$_POST['bids'];
                                 $stmt = $db->prepare('Delete FROM bids WHERE adminID = :adminID AND bidID=:bidID');               $stmt->bindParam(':adminID',$adminID);
                                $stmt->bindParam(':bidID',$bidID);
                                $stmt->execute();
			                     echo  "<script> window.location.href='memberpage.php';</script>";
                                
                            }
                            else{
                                 echo '<p class="alert alert-danger" style="width:350px; height:auto;font-size:15px;"><i class="material-icons" style="margin-right:1%;font-size:18px;color:red">error</i>&nbsp;You have to select a bid</p>'; 
                            }
                            
                        }
               ?>
                </form>
                <br>
                 <input style="background-color:#C0C0C0; color:black;" id="decisionbtn "class="btn btn-default" type="submit" name="submit" value="Submit"/>
            </form>
                        <?php
                        
                        if (isset($_POST['submit'])) {

                            $stmt = $db->prepare('SELECT keywordsAboutInterests FROM users WHERE userID = :userID');
                            $stmt->bindParam(':userID', $_SESSION['userID']);
                            $stmt->execute();
                            $arr = array();
                            while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $str = $result["keywordsAboutInterests"];
                            }
                            $pieces = explode(" ", $str);
                            $my_file = './gorgias/decisionMaking/predicates.pl';
                            $handle = fopen($my_file, 'w') or die('Cannot open file:' . $my_file);
                            for ($i = 0; $i < count($pieces); $i++) {
                                $fwrite = fwrite($handle, "interests(" . $pieces[$i] . ")");
                                fwrite($handle, ".\n");
                            }
                            $stmt = $db->prepare('SELECT * FROM users WHERE adminID = :adminID');
                            $stmt->bindParam(':adminID', $_adminID);
                            $stmt->execute();
                            $arr = array();
                            while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $age = $result["age"];
                                $geo = $result["geo"];
                                $sex = $result["sex"];
                            }
                            $blockedbypublisher = Array('1' => 0, '2' => 0, '3' => 0, '4' => 0,
                                '5' => 0, '6' => 0, '7' => 0, '8' => 0,
                                '9' => 0, '10' => 0);

                            fwrite($handle, "adList([");
                            for ($i = 1; $i <= 10; $i++) {
                                if (!$blockedbypublisher[$i])
                                    if ($i != 10)
                                        fwrite($handle, $i . ",");
                                    else
                                        fwrite($handle, $i);
                            }
                            fwrite($handle, "]).");
                            fwrite($handle, "\n");
                            fwrite($handle, "age(");
                            $fwrite = fwrite($handle, $age);
                            fwrite($handle, ").\ngeography(");
                            $fwrite = fwrite($handle, $geo);
                            fwrite($handle, ").\n");

                            if (isset($_POST['policy'])) {
                                if ($_POST['policy'] == 1) {
                                    $fwrite = fwrite($handle, "policy(1)");
                                } else if ($_POST['policy'] == 2) {
                                    $fwrite = fwrite($handle, "policy(2)");
                                } else if ($_POST['policy'] == 3) {
                                    $fwrite = fwrite($handle, "policy(3)");
                                }
                                fwrite($handle, ".\n");
                            } else
                                echo '<p class="alert-danger">' . "You have to select a policy" . '</p>';


                            if ($sex == "F")
                                $fwrite = fwrite($handle, "sex(female)");
                            else
                                $fwrite = fwrite($handle, "sex(male)");
                            fwrite($handle, ".\n");


                            // for bits execute 

                            if (isset($_POST['policy'])) {
                                for ($i = 1; $i <= 10; $i++) {
                                    $secfil = 'executeGorgias.pl';
                                    $handle = fopen($secfil, 'w') or die('Cannot open file:' . $secfil);
                                    fwrite($handle, ":-consult('./gorgias/decisionMaking/adDecision.pl').");
                                    fwrite($handle, "\n");
                                    fwrite($handle, "askGorgias:-prove([show(ad,$i)],Delta).");
                                    fwrite($handle, "\n");
                                    fwrite($handle, 'askGorgias:-write("false").');
                                    $cmd = "C:\\xampp\htdocs\AdServ\swipl\bin\swipl.exe -f executeGorgias.pl -g askGorgias,halt";
                                    $output = shell_exec(escapeshellcmd($cmd));
                                    if ($output != "false") {
                                        echo "<p>SHOW AD $i</p>";
                                        echo "</br>";
                                    }
                                }
                            }
                        }
                        ?>
                    </div>
        
                    <div id="addbid"  class="w3-modal"  href="https://www.w3schools.com/w3css/4/w3.css">
                        <div class="w3-modal-content w3-animate-zoom" style="max-width:330px;">
                            <div class="w3-container w3-teal">
                                <span style="height:40px; padding-bottom:1%" onclick="document.getElementById('addbid').style.display='none'" class="w3-button w3-display-topright w3-large">x</span>
                                <h3 style="margin-top:2%;">Add new bid!</h3>
                            </div>
                         
                            <div class="container">                
                                <form method="post" action="" id="add-form" >
                               
                                  <br>
                                      <div id="add"> <label for="topic">Topic</label><span class="error">*</span><input type="text"  style="border-bottom: 2px solid #808080 !important;" name="topic" placeholder="e.g. Food" required></div>
                                    <br>
                                    <div id="add"> <label for="price">Price</label><span class="error">*</span> <input type="text" name="price" placeholder="e.g. 1.8 euro" style="border-bottom: 2px solid #808080 !important;" required> </div>
                                    <br>
                                   <div id="add"> <label for="country" >Geography</label><span class="error">*</span>
                                      <select name='country' class='dropdown' style=" width:200px; color:black;">
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
                                        <option value="Cota D'Ivoire">Cote d'Ivoire</option>
                                        <option value="Croatia">Croatia (Hrvatska)</option>
                                        <option value="Cuba">Cuba</option>
                                        <option value="Cyprus" selected>Cyprus</option>
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
                                        <option value="Democratic People's Republic of Korea">Korea, Democratic People's Republic of</option>
                                        <option value="Korea">Korea, Republic of</option>
                                        <option value="Kuwait">Kuwait</option>
                                        <option value="Kyrgyzstan">Kyrgyzstan</option>
                                        <option value="Lao">Lao People's Democratic Republic</option>
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
                                    $topic=$_POST['topic'];
                                    $price=$_POST['price'];
                                    $geography=$_POST['country'];
                                     $stmt = $db->prepare('INSERT INTO bids(adminID,topic,price,geography)VALUES (:adminID,:topic,:price,:geography)');
                                     $stmt->execute(array(
                                            ':adminID' => $adminID,
                                            ':topic' => $topic,
                                            ':price' => $price,
                                            ':geography' =>$geography
                                        ));
                                    echo "<script>
                                        window.location.href='memberpage.php';</script>";
                                    }
                                    ?>
                                    <script>
											function displayVals() {
											  var singleValues = $( "#username" ).val();
											  if(singleValues=="mchatz05") 
												  alert("Username already exists");
											}
											$("div #addbid input").change(displayVals);

											displayVals();
											</script>
                                </form>
                              </div>
                            </div>
                        </div>
                   
    </header>
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
                       

