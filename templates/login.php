<?php 
session_start();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("Location: ../index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $username = trim($_POST["username"]);
    $password = $_POST["password"];
    $errors = [];

    if (empty($username)) {
        $errors[] = "Username is required.";
    }
    if (empty($password)) {
        $errors[] = "Password is required.";
    }

    if (empty($errors)) {
        if (validate_user($username, $password)) {
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
            header("Location: ../index.php");
            exit;
        } else {
            echo "Invalid username or password";
            $errors[] = "Invalid username or password.";
        }
    }
}

function validate_user($username, $password): bool {
    require_once '../database/db.php'; 
    $sql = "SELECT password FROM users WHERE name = :username";
    
    if ($stmt = $pdo->prepare($sql)) {
        $stmt->bindParam(":username", $username, PDO::PARAM_STR);

        if ($stmt->execute()) {

            if ($stmt->rowCount() === 1) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $hashed_password = $row['password'];

                if ($stmt->fetch() && password_verify($password, $hashed_password)) {
                    return true;
                }
            }
        }
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
