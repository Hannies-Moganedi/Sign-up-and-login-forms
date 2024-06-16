<?php

  $error = NULL;

  if (isset($_POST['submit'])) {

    //get form data
    $u = $_POST['u'];
    $p = $_POST['p'];
    $p2 = $_POST['p2'];
    $e = $_POST['e'];

    if (strlen($u) < 8) {
      $error = "<p>Your username must be atleast 8 characters long</p>";
    } elseif ($p2 != $p) {
      $error .= "<p>Your passwords don't match</p>";
    } else {
      //connect database
      $mysqli = NEW MySQLi('localhost','root','','test');

      //Strip characters that can be used for sql injection
      $u = $mysqli->real_escape_string($u);
      $p = $mysqli->real_escape_string($p);
      $p2 = $mysqli->real_escape_string($p2);
      $e = $mysqli->real_escape_string($e);

      //Generate vkey
      $vkey = md5(time().$u);

      //Insert data into database
      //encrypt password
      $p = md5($p);

      $insert = $mysqli->query("INSERT INTO accounts(username,password,email,vkey) VALUES('$u','$p','$e','$vkey')");

      if ($insert) {
        //send email
        $to = $e;
        $subject = "Email Verification";
        $message = "<a href='http://localhost/registration/verify.php?vkey=$vkey'>Register account</a>";
        $headers = "From: nazarethahsm@mycatchup-buddy.webhostingfree.io \r\n";
        $headers .= "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        mail($to,$subject,$message,$headers);

        header("location: login.php");

      }else {
        $msqli->error;
      }
    }

  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <form action="" method="POST">
    <input type="text" name="u" placeholder="username" required>
    <input type="password" name="p" placeholder="password" required>
    <input type="password" name="p2" placeholder="repeat password" required>
    <input type="email" name="e" placeholder="email" required>
    <input type="submit" name="submit" value="Register" required>
  </form>
  <center>
    <?php
     echo $error; 
    ?>
  </center>
</body>
</html>