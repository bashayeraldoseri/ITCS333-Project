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

  // exit(var_dump($_POST));
  $errors = [];

  if (empty($username)) {
    $errors[] = "Username is required.";
  }
  if (empty($password)) {
    $errors[] = "Password is required.";
  }

  if (empty($errors)) {
    // exit(var_dump($password) . " TEST " . var_dump($username));
    $user = validate_user($username, $password);
    // exit(var_dump($user));

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
      // echo var_dump($user);
      echo "Invalid username or password";
      $errors[] = "Invalid username or password.";
    }
  }
}

function validate_user($username, $password)
{
  // exit("This is the password: ". $password);
  global $pdo;
  require_once '../database/db.php';
  $sql = "SELECT * FROM users WHERE name = :name";

  if ($stmt = $pdo->prepare($sql)) {
    $stmt->bindParam(":name", $username, PDO::PARAM_STR);

    if ($stmt->execute()) {
        if ($stmt->rowCount() == 1) {
          $row = $stmt->fetch(PDO::FETCH_ASSOC);
          $stored_password = $row['password'];
          // exit(var_dump($row));

          // Use password_verify to check the password
          exit($password);
          if (password_verify($password, $stored_password)) {
            exit($password);
            return $row; // Return user data
          } else {
            echo "Invalid password.";
          }
        } else {
          echo "No matching user found.";
        }
    } else {
      echo "Query execution failed.";
    }
  } else {
    exit("FAild");
    echo "Failed to prepare SQL statement.";
  }

  return false;
}

?>
