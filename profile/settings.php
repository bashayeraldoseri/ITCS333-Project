<?php
session_start();
include("../database/db.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $new_email = $_POST["email"];
    $new_password = $_POST["password"];
    $rep_password = $_POST["rp-password"];
    $new_department = $_POST["field"];
    $new_DoB = $_POST["DoB"];
    $new_phone = $_POST["phone"];
    $new_username = $_POST["username"];



    $username = $_SESSION['username'];
    $email = $_SESSION['user_email'];
    $id = $_SESSION['user_id'];
    $Dob = $_SESSION['DoB'];
    $phone = $_SESSION['Phone'];
    $department = $_SESSION['Department'];



    $Success = false;


    if ($new_username != $username && !empty($new_username)) {
        try {
            $stmt = $pdo->prepare("UPDATE users SET name = :name WHERE ID = :ID");

            $stmt->bindParam(':name', $new_username);
            $stmt->bindParam(':ID', $id);

            if ($stmt->execute()) {
                $_SESSION['username'] = $new_username;
                $Success = true;
                // echo "Username updated successfully!";
            } else {
                echo "Failed to update username.";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    if ($new_email != $email && !empty($new_email)) {
        try {
            $stmt = $pdo->prepare("UPDATE users SET email = :email WHERE ID = :ID");
            $stmt->bindParam(":email", $new_email);
            $stmt->bindParam("ID", $id);

            if ($stmt->execute()) {
                $_SESSION['user_email'] = $new_email;
                $Success = true;
            }
        } catch (PDOException $e) {
            echo 'Error Email' . $e->getMessage();
        }
    }

    if (!empty($new_password) && $new_password == $rep_password) {
        $hashed_pass = password_hash($new_password, PASSWORD_DEFAULT);

        try {
            $stmt = $pdo->prepare("UPDATE users SET password = :password WHERE ID = :ID");

            $stmt->bindParam(":password", $hashed_pass);
            $stmt->bindParam(":ID", $id);

            $stmt->execute();
        } catch (PDOException $e) {
            echo "". $e->getMessage();

        }

    }else {
        echo "Passwords don't match";
    }

    if ($new_DoB != null && $new_DoB != $Dob) {
        try {
            $stmt = $pdo->prepare("UPDATE users SET DoB = :DoB WHERE ID = :ID");
            $stmt->bindParam(":DoB", $new_DoB);
            $stmt->bindParam("ID", $id);

            if ($stmt->execute()) {
                $_SESSION['DoB'] = $new_DoB;
                $Success = true;
            }
        } catch (PDOException $e) {
            echo 'error Dob' . $e->getMessage();
        }

    }

    if (!empty($new_phone) && $new_phone != $phone) {
        try {
            $stmt = $pdo->prepare("UPDATE users SET Phone = :Phone WHERE ID = :ID");
            $stmt->bindParam(":Phone", $new_phone);
            $stmt->bindParam("ID", $id);

            if ($stmt->execute()) {
                $_SESSION['Phone'] = $new_phone;
                $Success = true;
            }
        } catch (PDOException $e) {
            echo 'error Phone' . $e->getMessage();
        }

    }


    if (isset($new_department)) {
        $new_department = $_POST['field'];
        try {
            $stmt = $pdo->prepare("UPDATE users SET Department = :Department WHERE ID = :ID");
            $stmt->bindParam(":Department", $new_department);
            $stmt->bindParam("ID", $id);
    
            if ($stmt->execute()) {
                $_SESSION['Department'] = $new_department;
                $Success = true;
            }
        } catch (PDOException $e) {
            echo 'error Dept' . $e->getMessage();
        }
    } else {
        $new_department = ''; // Default value 
    }


    // Check if a file is uploaded
    if (isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['fileToUpload'];
        
        $uploadDir = '../static/uploads/';
        $fileName = uniqid('', true) . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
        $filePath = $uploadDir . $fileName;

        // Move the uploaded file to the server
        if (move_uploaded_file($file['tmp_name'], $filePath)) {

            $stmt = $pdo->prepare("UPDATE users SET ProfilePic = :ProfilePic WHERE ID = :ID");
            $stmt->bindParam(':ProfilePic', $filePath);
            $stmt->bindParam(':ID', $id);

            if ($stmt->execute()) {
                echo "Profile picture updated successfully!";
                $_SESSION['ProfilePic'] = $filePath;
                $Success = true;
            } else {
                echo "Failed to update profile picture in the database.";
            }
        } else {
            echo "Failed to upload the file.";
        }
    }

    

    if ($Success) {
        header("Location: profile.php");

    }

}

