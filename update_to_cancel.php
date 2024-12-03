<!-- update_to_cancel.php -->

<?php

// Start session for user validation 
session_start();

// Ensure the user is logged in or handle accordingly
 if (!isset($_SESSION['user_id'])) {
     header('Location: login.php');
     exit();
 }

if (isset($_GET['room_id'])) {
    $room_id = $_GET['room_id'];
} else {
    die("Error: Room ID not specified.");
}

if (isset($_POST['update'])) {

    // Database connection variables
    $host = 'localhost';
    $user = 'root'; // default username for XAMPP/MAMP
    $password = ''; // your password for the database
    $dbname = 'booking_system';
    $port = 3306; // Default MySQL port

    try {
        // Create PDO connection
        $dsn = "mysql:host=$host;dbname=$dbname;port=$port";
        $pdo = new PDO($dsn, $user, $password);

        // Set PDO error mode to exception for better error handling
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Validate if Room_ID exists
        $query = "SELECT * FROM rooms WHERE Room_ID = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$room_id]);
        $room = $stmt->fetch();

        if (!$room) {
            die("Error: Room ID does not exist in the database!");
        }

        // Update the status of the room to 'Inactive'
        $update_query = "UPDATE rooms SET Status = ? WHERE Room_ID = ?";
        $stmt = $pdo->prepare($update_query);
        $stmt->execute(['Inactive', $room_id]);

        // Success message
        $message = "Room status updated to 'Inactive' successfully.";
    } catch (PDOException $e) {
        // Handle connection failure
        die("Connection failed: " . $e->getMessage());
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Room Status</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
    <div class="jumbotron text-center">
        <h1>Update Room Status</h1>
        <p>Change the status of the room to "Inactive".</p>
    </div>

    <?php if (isset($message)) { echo "<p class='alert alert-success'>$message</p>"; } ?>

    <form action="update_to_cancel.php" method="POST">
        <input type="hidden" name="room_id" value="<?php echo $room_id; ?>">

        <div class="form-group">
            <label for="room_id">Room ID:</label>
            <input type="text" class="form-control" name="room_id" id="room_id" value="<?php echo $room_id; ?>" readonly>  <!--readonly: The user can view the content but cannot change it. It allows the field’s value to be submitted with the form-->
        </div>

        <div class="form-group">
            <label for="status">Status:</label>
            <input type="text" class="form-control" name="status" id="status" value="Inactive" readonly> <!--readonly: The user can view the content but cannot change it. It allows the field’s value to be submitted with the form-->
        </div>

        <button type="submit" name="update" class="btn btn-primary">Update Status to Inactive</button>
    </form>

    <p><a href="index.php">Back to Room List</a></p>
</div>

</body>
</html>
