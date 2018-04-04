<?php require('includes/config.php'); 

//define page title
$title = 'Memberpage';
$back = 'logout.php';
$textofback = 'Log out';
?>

<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">       
          <link href="css/grayscale.css" rel="stylesheet">
	<title><?php if(isset($title)){ echo $title; }?></title>
</head>
    
<body>

<p><a href="logout.php">Logout?</a><p>
<center><h2>Welcome to AD SERVER</h2></center>

<table style="width:15%">
    <caption>Bits</caption>
    <tr>
        <th>Id</th>
        <th>Category</th>
        <th>Price</th>
        <th>Location</th>
    </tr>
    <tr>
        <td>1</td>
        <td>FOOD</td>
        <td>1,2</td>
        <td>Cy</td>
    </tr>
</table> 

    <center> Choose a policy</center>
        <div id="policyform"> 
            <form action="" method="post">
                <input type="radio" name="policy" value="1" id="1" class="radiobtn"/><label for="1"> Policy 1</label>
                    <p> This policy prefers ads with user interests. The second priority is
                        high price and the third priority is user geography</p>
                    <input type="radio" name="policy" value="2" id="2"  class="radiobtn"/><label for="2"> Policy 2</label>
                    <p> This policy prefers ads with high price. The second priority is
                            user interests and the third priority is user geography</p>
                    <input type="radio" name="policy" value="3" id="3" class="radiobtn"/><label for="3"> Policy 3</label>
                    <p> This policy prefers ads with user interests. The second priority is
                            user geography and the third priority is high price</p>
                    <br>
                        <input class="button" type="submit" name="submit" value="Submit"/>

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
                            $stmt = $db->prepare('SELECT* FROM users WHERE userID = :userID');
                            $stmt->bindParam(':userID', $_SESSION['userID']);
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
                        </form>
                        </div>

</body>
</html>
                       

