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
