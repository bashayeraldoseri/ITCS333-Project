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

        $sql = "SELECT id FROM users WHERE username = ?";
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
