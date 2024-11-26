<?php
session_start();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
  echo'Already logged in';
  header("Location: ../index.php");
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === "POST") {
  $username = $_POST["username"];
  $password = $_POST["password"];
  $errors = [];

  if (empty($username)) {
    $errors[] = "Username is required.";
  }
  if (empty($password)) {
    $errors[] = "Password is required.";
  }

  if (empty($errors)) {
    $user = validate_user($username, $password);
    if ($user) {
      $_SESSION['loggedin'] = true;
      $_SESSION['username'] = $user['name'];
      $_SESSION['user_id'] = $user['ID']; // Save user ID
      $_SESSION['role'] = $user['Role']; // Save user role

      header("Location: ../index.php");
      exit;

    } else {
      echo var_dump($user);
      echo "Invalid username or password";
      $errors[] = "Invalid username or password.";
    }
  }
}

function validate_user($username, $password)
{
    require_once '../database/db.php';
    $sql = "SELECT * FROM users WHERE name = :name";

    if ($stmt = $pdo->prepare($sql)) {
        $stmt->bindParam(":name", $username, PDO::PARAM_STR);

        if ($stmt->execute()) {
            if ($stmt->rowCount() == 1) {

                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                
                $stored_password = $row['password'];

                // if (password_verify($password, $stored_password)) {}

                // For testing Only
                if ($password === $stored_password) {
                    return $row; // Return user data
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

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login</title>
  <link rel="stylesheet" href="../css/registration.css" />
</head>

<body>
  <div class="container">
    <div class="image-container">
      <div>
        <div id="login-image">
          <img src="static/login.jpg" alt="Login Image">
        </div>
      </div>
    </div>

    <div class="login-container">
      <h1>Login Page</h1>

      <form action="login.php" method="post">
        <div class="username">
          <label for="username">Userame</label>
          <input type="text" id="username" name="username" placeholder="Username" required>
        </div>

        <div class="email">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" placeholder="Email" required>
        </div>

        <div class="password">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" placeholder="Password" required>
        </div>

        <div class="submit">
          <button type="submit">Login</button>
          <p>Don't have an account? <a href="register.html">Register here</a>.</p>
        </div>
      </form>

    </div>
  </div>
</body>

</html>