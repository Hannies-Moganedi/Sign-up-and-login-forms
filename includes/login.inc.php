<?php
// Check if the login form is submitted
if (isset($_POST['login-submit'])) {
    
    // Include the database connection file
    require 'dbh.inc.php';

    // Retrieve the username and password from the form
    $mailuid = $_POST['username'];
    $password = $_POST['pwd'];

    // Encode the username for use in query parameters
    $queryParams = "username=" . urlencode($mailuid);

    // Prepare SQL statement to select the user by email or username
    $sql = "SELECT * FROM users WHERE EmailAddress=? OR typeUser=?;";
    $stmt = mysqli_stmt_init($conn);
    
    // Check if the SQL statement preparation fails
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        // Redirect to the login page with an SQL error
        header("Location: ../INDEX?error=sqlerror&" . $queryParams);
        exit();
    }
    else {       
        // Bind parameters to the SQL statement and execute it
        mysqli_stmt_bind_param($stmt, "ss", $mailuid, $mailuid);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        // Check if a user is found
        if ($row = mysqli_fetch_assoc($result)) {
            // Verify the password
            $pwdCheck = password_verify($password, $row['pwdUsers']);
            
            // If the password is incorrect
            if ($pwdCheck == false) {
                // Redirect to the login page with a wrong password error
                header("Location: ../INDEX?error=wrongpassword&" . $queryParams);
                exit();
            } elseif ($pwdCheck == true) {
                // Start a new session and set session variables
                session_start();
                $_SESSION['userName'] = $row['EmailAddress'];
                $_SESSION['pupil'] = $row['FirstName'];                    
                $_SESSION['last_login_timestamp'] = time();

                // Redirect to the grade page
                header("Location: ../Grade");
                exit();
            } else {
                // Redirect to the login page with a wrong password error
                header("Location: ../INDEX?error=wrongpasswd&" . $queryParams);
                exit();
            }
        } else {
            // Redirect to the login page with wrong credentials error
            header("Location: ../INDEX?error=wrongcredentials&" . $queryParams);
            exit();
        }

    }
} else {
    // Redirect to the login page if the form is not submitted
    header("Location: ../INDEX");
    exit();
}
?>