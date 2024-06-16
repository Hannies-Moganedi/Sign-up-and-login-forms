<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Registration</title>
  <link rel="icon" type="image/x-icon" href="favicon.ico">

  <!-- Link to custom stylesheet and Font Awesome icons -->
  <link rel="stylesheet" href="styles/register.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" />
</head>

<body>
  <!-- Registration form -->
  <form action="includes/signup.inc.php" method="post">
    <h1>REGISTER.</h1>
    <!-- PHP block to display error/success messages -->
    <h4>Fill all the details:
      <?php
      // Display error messages based on GET parameters
      if (isset($_GET['error'])) {
        if ($_GET['error'] == "invalidfirstname") {
          echo '<p style="color: red;">Invalid first name!</p>';
        } elseif ($_GET['error'] == "invalidlastname") {
          echo '<p style="color: red;">Invalid last name!</p>';
        } elseif ($_GET['error'] == "invalidemail") {
          echo '<p style="color: red;">Invalid email address!</p>';
        } elseif ($_GET['error'] == "emailexist") {
          echo '<p style="color: red;">Email address already registered!</p>';
        } elseif ($_GET['error'] == "passwordnotstrong") {
          echo '<p style="color: red;">Your password is not strong!</p>';
        }
      }
      // Display success message upon successful registration
      if (isset($_GET['register'])) {
        if ($_GET['register'] == "success") {
          echo '<p style="color: green;">Successfully Signed up</p>';
        }
      }
      ?>
    </h4>
    <!-- Input fields for user details -->
    <input type="text" name="firstname" placeholder="First Name" autocomplete="off" value="<?php echo isset($_GET['firstname']) ? htmlspecialchars($_GET['firstname']) : ''; ?>" required />
    <input type="text" name="lastname" placeholder="Last Name" autocomplete="off" value="<?php echo isset($_GET['lastname']) ? htmlspecialchars($_GET['lastname']) : ''; ?>" required />
    <input type="email" name="mail" id="email" placeholder="Email Address" autocomplete="off" value="<?php echo isset($_GET['mail']) ? htmlspecialchars($_GET['mail']) : ''; ?>" required />
    <input type="password" name="pwd" id="password" placeholder="Create Password" onkeyup="return validate()" required />
    <!-- Error messages for password criteria -->
    <div class="errors">
      <ul>
        <li id="length">Must be at least 8 characters long</li>
        <li id="uppercase">Must have at least one uppercase letter</li>
        <li id="lowercase">Must have at least one lowercase letter</li>
        <li id="special_char">Must have a special character</li>
        <li id="number">Must have a digit</li>
      </ul>
    </div>
    <input type="password" name="pwd-repeat" placeholder="Confirm Password" required />
    <br />
    <!-- Display password mismatch error -->
    <?php if (isset($_GET['error'])) {
      if ($_GET['error'] == "passwordcheck") {
        echo '<p style="color: red;">Your Passwords do not match!</p>';
      }
    } ?>
    <button class="rounded" name="signup-submit">SIGN UP</button><br><br>
    <p>Already have an account?<a onclick="login()"> Log in</a></p>
  </form>

  <!-- JavaScript section for password validation and redirection -->
  <script>
    // Function to validate password strength
    function validate() {
      var pass = document.getElementById("password");
      var upper = document.getElementById("uppercase");
      var lower = document.getElementById("lowercase");
      var num = document.getElementById("number");
      var len = document.getElementById("length");
      var sp_char = document.getElementById("special_char");

      // Check if password contains a number
      if (pass.value.match(/[0-9]/)) {
        num.style.color = "green";
      } else {
        num.style.color = "red";
      }

      // Check if password contains uppercase letters
      if (pass.value.match(/[A-Z]/)) {
        upper.style.color = "green";
      } else {
        upper.style.color = "red";
      }

      // Check if password contains lowercase letters
      if (pass.value.match(/[a-z]/)) {
        lower.style.color = "green";
      } else {
        lower.style.color = "red";
      }

      // Check if password contains a special character
      if (pass.value.match(/[!\@\#\$\%\^\&\*\(\)\-\+\=\?\<\,\.\{\}\[\]\|]/)) {
        sp_char.style.color = "green";
      } else {
        sp_char.style.color = "red";
      }

      // Check if password length is at least 8 characters
      if (pass.value.length < 8) {
        len.style.color = "red";
      } else {
        len.style.color = "green";
      }
    }

    // Function to redirect to login page
    function login() {
      const newPageUrl = 'INDEX';
      // Redirect to the new page
      window.location.href = newPageUrl;
    }
  </script>
</body>

</html>