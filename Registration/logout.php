<?php

session_start();

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == 1) {
    $_SESSION = array();

    session_destroy();

    header("Location: ../index.php");
} else {
    echo "User not logged in";
}



