<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>My Catch-Up Buddy</title>
  <!-- Favicon for the website -->
  <link rel="icon" type="image/x-icon" href="favicon.ico">

  <!-- Link to the main stylesheet and Font Awesome icons -->
  <link rel="stylesheet" href="styles/style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" />
</head>

<body>
  <!-- Login form -->
  <form action="includes/login.inc.php" method="post">
    <h1>My Catch-Up Buddy.</h1>
    <!-- PHP block to display error messages if any -->
    <?php
    if (isset($_GET['error'])) {
      if ($_GET['error'] == "wrongpassword") {
        echo '<p style="color: red; margin-left: 8%;">You entered wrong password!</p>';
      } elseif ($_GET['error'] == "wrongcredentials") {
        echo '<p style="color: red; font-size: 20px; margin-left: 8%;">You entered wrong password or username!</p>';
      }
    }
    ?>
    <input type="text" name="username" id="id_username" placeholder="Username" autocomplete="off" value="<?php echo isset($_GET['username']) ? htmlspecialchars($_GET['username']) : ''; ?>" required />
    <input type="password" name="pwd" id="id_password" placeholder="Password" required />
    <i class="far fa-eye" id="togglePassword"></i>
    <br><button type="submit" class="rounded" name="login-submit">Login</button>
    <p>Forgot Password? <a href="forgot.php"> Reset it</a></p>
    <hr />
    <button class="register" onclick="register()">REGISTER</button>
  </form>

  <script>
    // JavaScript to toggle password visibility
    const togglePassword = document.querySelector("#togglePassword");
    const password = document.querySelector("#id_password");

    togglePassword.addEventListener("click", function(e) {
      // Toggle the type attribute between password and text
      const type =
        password.getAttribute("type") === "password" ? "text" : "password";
      password.setAttribute("type", type);
      // Toggle the eye slash icon
      this.classList.toggle("fa-eye-slash");
    });

    // Function to redirect to the registration page
    function register() {
      const newPageUrl = 'Register';
      window.location.href = newPageUrl;
    }

    // Prevent right-click context menu
    document.addEventListener("contextmenu", function(e) {
      e.preventDefault();
    });

    // Prevent certain key combinations for developer tools
    document.onkeydown = function(e) {
      if (event.keyCode == 123) {
        return false;
      }

      if (e.ctrlKey && e.shiftKey && e.keyCode == "I".charCodeAt(0)) {
        return false;
      }

      if (e.ctrlKey && e.shiftKey && e.keyCode == "C".charCodeAt(0)) {
        return false;
      }

      if (e.ctrlKey && e.shiftKey && e.keyCode == "J".charCodeAt(0)) {
        return false;
      }

      if (e.ctrlKey && e.keyCode == "U".charCodeAt(0)) {
        return false;
      }
    }
  </script>
</body>

</html>