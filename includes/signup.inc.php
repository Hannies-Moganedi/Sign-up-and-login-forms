<?php
// Check if the signup form has been submitted
if (isset($_POST['signup-submit'])) {
    // Include the database connection file
    require 'dbh.inc.php';

    // Retrieve form data
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['mail'];
    $password = $_POST['pwd'];
    $passwordRepeat = $_POST['pwd-repeat'];
    // Check password requirements
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number = preg_match('@[0-9]@', $password);
    $specialChars = preg_match('@[^\w]@', $password);

    // Prepare query parameters for URL redirection
    $queryParams = "firstname=" . urlencode($firstname) . "&lastname=" . urlencode($lastname) . "&mail=" . urlencode($email);

    // Validate email and names
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z]*$/", $firstname) && !preg_match("/^[a-zA-Z]*$/", $lastname)) {
        header("Location: ../Register?error=invalidmailfirst" . $queryParams);
        exit();
    } elseif (!preg_match("/^[a-zA-Z]*$/", $firstname)) {
        header("Location: ../Register?error=invalidfirstname&" . $queryParams);
        exit();
    } elseif (!preg_match("/^[a-zA-Z]*$/", $lastname)) {
        header("Location: ../Register?error=invalidlastname&" . $queryParams);
        exit();
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../Register?error=invalidemail&" . $queryParams);
        exit();
    } elseif ($password !== $passwordRepeat) {
        header("Location: ../Register?error=passwordcheck&" . $queryParams);
        exit();
    } elseif (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
        header("Location: ../Register?error=passwordnotstrong&" . $queryParams);
        exit();
    } else {
        // Check if the email already exists in the database
        $sql = "SELECT EmailAddress FROM users WHERE EmailAddress= ?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../Register?error=sqlerror&" . $queryParams);
            exit(); 
        } else {
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $resultCheck = mysqli_stmt_num_rows($stmt);
            $firstfile = ucwords(strtolower($firstname));
            $lastfile = ucwords(strtolower($lastname));

            // If email exists, show an error
            if ($resultCheck > 0) {
                mysqli_stmt_close($stmt); // Close statement
                mysqli_close($conn); // Close connection
                header("Location: ../Register?error=usertaken&mail=" . $email);
                exit(); 
            } else {
                // Insert new user into the database
                $sql = "INSERT INTO users (LastName, FirstName, EmailAddress, pwdUsers) VALUES (?, ?, ?, ?)";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    mysqli_stmt_close($stmt);
                    mysqli_close($conn);
                    header("Location: ../Register?error=sqlerror");
                    exit(); 
                } else {
                    $hashed = password_hash($password, PASSWORD_DEFAULT);

                    mysqli_stmt_bind_param($stmt, "ssss", $lastfile, $firstfile, $email, $hashed);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_close($stmt);
                    mysqli_close($conn); 
                    header("Location: ../Register?register=success");
                    exit();
                }
            }
        }
    }
} else {
    // Redirect to the registration page if the form was not submitted
    header("Location: ../Register");
    exit();
}
