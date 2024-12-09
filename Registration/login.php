<?php
session_start();
$host = 'localhost';
$user = 'root';
$dbpassword = '';
$dbname = 'booking_system';
$port = 3306;
$dsn = "mysql:host=$host;dbname=$dbname;port=$port";
$pdo = new PDO($dsn, $user, $dbpassword);

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
  echo'Already logged in';
  header("Location: ../index.php");
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === "POST") {
  $username = $_POST["username"];
  $password = $_POST["password"];
  $email = $_POST["email"];

  $errors = [];

  if (empty($username)) {
    $errors[] = "Username is required.";
  }
  if (empty($password)) {
    $errors[] = "Password is required.";
  }
  if(empty($email)) {
    $errors[] = "Email is required.";
  }

  if (empty($errors)) {
    $user = validate_user($username, $password, $email);
    if ($user) {
      $_SESSION['loggedin'] = true;
      $_SESSION['username'] = $user['name'];
      $_SESSION['user_id'] = $user['ID']; 
      $_SESSION['role'] = $user['Role'];
      $_SESSION['user_email'] = $user['email'];
      $_SESSION['Phone'] = $user['Phone'];
      $_SESSION['DoB'] = $user['DoB'];
      $_SESSION['Department'] = $user['Department'];
      $_SESSION['ProfilePic'] = $user['ProfilePic'];

      header("Location: ../index.php");
      exit;

    } else {
      $errors[] = "Invalid username or password.";
    }
  }
}

function validate_user($username, $password, $email)
{
  global $pdo;
  require_once '../database/db.php';
  $sql = "SELECT * FROM users WHERE name = :name";

  if ($stmt = $pdo->prepare($sql)) {
    $stmt->bindParam(":name", $username, PDO::PARAM_STR);

    if ($stmt->execute()) {
        if ($stmt->rowCount() == 1) {
          $user = $stmt->fetch(PDO::FETCH_ASSOC);
          $stored_password = $user['password'];

          if ($email == $user['email']){
            if (password_verify($password,$stored_password)) {
              return $user; // Return user data
            } else {
              echo "Invalid username, email or password.";
            }
          } else {
            echo "Invalid username, email or password.";
          }
        } else {
          echo "No matching user found.";
        }
    } else {
      echo "Query execution failed.";
    }
  } else {
    echo "Failed to prepare SQL statement.";
  }

  return false;
}
?>
