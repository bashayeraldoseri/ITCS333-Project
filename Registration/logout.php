<?php
session_start();

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == 1) {
    session_unset();
    $_SESSION['logout_message_shown'] = true; 
    header("Location: ../index.php");
    exit();
} else {
    echo "User not logged in";
}