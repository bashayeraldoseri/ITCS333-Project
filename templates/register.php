<?php 
session_start();
$host = 'localhost';
$user = 'root'; // default username for XAMPP/MAMP
$password = ''; // your password for the database
$dbname = 'booking_system';
$port = 3306; // Default MySQL port is 3306, use 8080 if it's a non-standard port for your database server
  // Create PDO connection
  $dsn = "mysql:host=$host;dbname=$dbname;port=$port";
  $pdo = new PDO($dsn, $user, $password);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username = trim($_POST['username']);
  $password = $_POST['password'];
  $confirm_password = $_POST['password'];
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
    require_once '../database/db.php'; 
    
    // Check if username is already taken
    $sql = "SELECT ID FROM users WHERE name = ?";
    if ($stmt = $pdo->prepare($sql)) {
      $stmt->bindParam(1, $username, PDO::PARAM_STR);
      $stmt->execute();

      if ($stmt->rowCount() > 0) {
        $errors[] = "Username is already taken.";
      }
    }

    // Check if email already exists
    $email = trim($_POST['email']);
    $sql = "SELECT ID FROM users WHERE email = ?";
    if ($stmt = $pdo->prepare($sql)) {
      $stmt->bindParam(1, $email, PDO::PARAM_STR);
      $stmt->execute();

      if ($stmt->rowCount() > 0) {
        $errors[] = "Email is already taken.";
      }
    }

    // If no errors, insert new user
    if (empty($errors)) {
      $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
      if ($stmt = $pdo->prepare($sql)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt->bindParam(1, $username, PDO::PARAM_STR);
        $stmt->bindParam(2, $email, PDO::PARAM_STR);
        $stmt->bindParam(3, $hashed_password, PDO::PARAM_STR);

        if ($stmt->execute()) {
          // Registration successful
          $_SESSION['message'] = "Registration successful!";
          header("Location: index.php");
          exit;
      } else {
          $errors[] = "Something went wrong. Please try again later.";
        }
      }
    }
  }
}  
$pdo = null;
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
