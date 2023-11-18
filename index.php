<?php

@include 'config.php';


// Function to generate a unique token
function generateUniqueToken()
{
   return bin2hex(random_bytes(50));
}

// Check if the user has a valid session
if (isset($_SESSION['admin_name'])) {
   header('location:admin_page.php');
   exit();
} elseif (isset($_SESSION['user_name'])) {
   header('location:user_page.php');
   exit();
}
session_start();

// Check if the user has a valid auth_token cookie
if (isset($_COOKIE['auth_token'])) {
    $auth_token = mysqli_real_escape_string($conn, $_COOKIE['auth_token']);
    $selectUser = "SELECT * FROM user_form WHERE auth_token = '$auth_token'";
    $resultUser = mysqli_query($conn, $selectUser);

    if (mysqli_num_rows($resultUser) > 0) {
        $rowUser = mysqli_fetch_array($resultUser);

        if ($rowUser['user_type'] == 'admin') {
            $_SESSION['admin_name'] = $rowUser['username'];
            header('location:admin_page.php');
            exit();
        } elseif ($rowUser['user_type'] == 'user') {
            $_SESSION['user_name'] = $rowUser['username'];
            header('location:user_page.php');
            exit();
        }
    } else {
        // Remove the invalid auth_token cookie
        setcookie('auth_token', '', 1, '/');
    }
}

// Process login form if submitted
if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = md5($_POST['password']); // Ini disarankan untuk diganti dengan hashing yang lebih aman, seperti password_hash
    $user_type = $_POST['user_type'];

    // Check the value of "Ingat Saya" checkbox
    $remember = isset($_POST['remember']) ? $_POST['remember'] : false;

    $select = " SELECT * FROM user_form WHERE email = '$email' && password = '$pass' ";

    $result = mysqli_query($conn, $select);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);

        if ($remember) {
            // Generate a unique token
            $auth_token = generateUniqueToken();
            // Update the auth_token in the database
            $updateToken = "UPDATE user_form SET auth_token = '$auth_token' WHERE email = '$email'";
            mysqli_query($conn, $updateToken);
            // Set cookie with the auth_token
            setcookie('auth_token', $auth_token, time() + 3600 * 24 * 30, '/');
        } else {
            // Remove the auth_token cookie
            setcookie('auth_token', '', 1, '/');
        }

        if ($row['user_type'] == 'admin') {
            $_SESSION['admin_name'] = $row['username'];
            header('location:admin_page.php');
            exit();
        } elseif ($row['user_type'] == 'user') {
            $_SESSION['user_name'] = $row['username'];
            header('location:user_page.php');
            exit();
        }
    } else {
        $error[] = 'Incorrect email or password!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login form</title>
   <link rel="stylesheet" href="css/style.css">
</head>
<body>
   <div class="form-container">
      <form action="" method="post">
         <h3>login now</h3>
         <?php
         if (isset($error)) {
            foreach ($error as $error) {
               echo '<span class="error-msg">' . $error . '</span>';
            };
         };
         ?>
         <input type="email" name="email" required placeholder="enter your email">
         <input type="password" name="password" required placeholder="enter your password">
         <label for="remember">Remember Me</label>
         <input type="checkbox" name="remember" id="remember">
         <input type="submit" name="submit" value="login now" class="form-btn">
         <p>don't have an account? <a href="register_form.php">register now</a></p>
      </form>
   </div>
</body>
</html>
