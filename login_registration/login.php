<?php 
session_start();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("Location: dashboard.php");
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
            header("Location: dashboard.php");
            exit;
        } else {
            $errors[] = "Invalid username or password.";
        }
    }
}

function validate_user($username, $password): bool {
    require_once 'db.php'; 
    $sql = "SELECT password FROM users WHERE username = ?";
    
    if ($stmt = $link->prepare($sql)) {
        $stmt->bind_param("s", $username);

        if ($stmt->execute()) {
            $stmt->store_result();

            if ($stmt->num_rows === 1) {
                $stmt->bind_result($hashed_password);

                if ($stmt->fetch() && password_verify($password, $hashed_password)) {
                    return true;
                }
            }
        }
        $stmt->close();
    }
    $link->close();
    return false;
}
?>
