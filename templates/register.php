<?php 
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $errors = [];

    if (empty($username)) {
        $errors[] = "Username is required.";
    }
    if (empty($password)) {
        $errors[] = "Password is required.";
    }

    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    }

    if (empty($errors)) {
        require_once 'db.php'; 

        $sql = "SELECT ID FROM users WHERE username = ?";
        if ($stmt = $link->prepare($sql)) {
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $errors[] = "Username is already taken.";
            }
            $stmt->close();
        }

        // If no errors, insert new user
        if (empty($errors)) {
            $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
            if ($stmt = $link->prepare($sql)) {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $stmt->bind_param("ss", $username, $hashed_password);

                if ($stmt->execute()) {
                    // Registration successful
                    $_SESSION['message'] = "Registration successful!";
                    header("Location: dashboard.php");
                    exit;
                } else {
                    $errors[] = "Something went wrong. Please try again later.";
                }
                $stmt->close();
            }
        }
        $link->close();
    }
}  
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register</title>
    <link rel="stylesheet" href="../css/registration.css"/>
  </head>
  <body>
    <div class="container">
      <div class="image-container">
        <div>
          <div id="login-image">
            <img src="static/login.jpg" alt="Signup Image">
          </div>
        </div>
      </div>

      <div class="signup-container">
        <h1>Registration Page</h1>
        <form action="register.php" method="post">
          <div class="username">
            <label for="username">Userame</label>
            <input type="text" id="username" name="username" placeholder="Userame" required>
          </div>
          
          <div class="email">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Email" required>
          </div>

          <div class="password">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Password" required>
          </div>

          <div class="confirm-password">
            <label for="confirm-password">Confirm Password</label>
            <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm Password" required>
          </div>

          <div class="submit">
            <button type="submit">Register</button>
            <p>Have an account? <a href="login.html">Login here</a>.</p>
          </div>
        </form>
        
      </div>
    </div>
  </body>
</html>

