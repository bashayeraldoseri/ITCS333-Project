<?php 
session_start();
$host = 'localhost';
$user = 'root';
$dbpassword = '';
$dbname = 'booking_system';
$port = 3306;
$dsn = "mysql:host=$host;dbname=$dbname;port=$port";
$pdo = new PDO($dsn, $user, $dbpassword);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username = trim($_POST['username']);
  $password = $_POST['dbpassword'];
  $confirm_password = $_POST['confirm-password'];
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
    //Validate whether email is in uob format and check if email already exists
    $email = trim($_POST['email']);
    if (!preg_match('/^[a-zA-Z0-9._%+-]+@(uob\.edu\.bh|stu\.uob\.edu\.bh)$/', $email)) {
      $errors[] = "Invalid email format. Only UoB emails are allowed.";
    } 
    if (preg_match('/^[a-zA-Z0-9._%+-]+@(stu\.uob\.edu\.bh)$/', $email)) {
      $role="Student";
    }else {
      $role="Instructor";
    }
    $sql = "SELECT ID FROM users WHERE email = ?";
    if ($stmt = $pdo->prepare($sql)) {
      $stmt->bindParam(1, $email, PDO::PARAM_STR);
      $stmt->execute();

      if ($stmt->rowCount() > 0) {
        $errors[] = "Email is already taken.";
      }
    }

    foreach($errors as $error){
      echo $error;
    }
    
    // If no errors, insert new user
    if (empty($errors)) {
      $sql = "INSERT INTO users (name, email, password, Role) VALUES (?, ?, ?, ?)";
      if ($stmt = $pdo->prepare($sql)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt->bindParam(1, $username, PDO::PARAM_STR);
        $stmt->bindParam(2, $email, PDO::PARAM_STR);
        $stmt->bindParam(3, $hashed_password, PDO::PARAM_STR);
        $stmt->bindParam(4, $role, PDO::PARAM_STR);

        if ($stmt->execute()) {
          // Registration FINALLY successful
          $_SESSION['message'] = "Registration successful!";
          header("Location: ../index.php");
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

