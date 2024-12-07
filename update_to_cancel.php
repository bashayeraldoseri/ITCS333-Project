<!-- update_to_cancel.php -->

<?php
include('database/db.php');
session_start();

        // Retrieve the username from session
        if (isset($_SESSION['username'])) {
            $username = $_SESSION['username'];
        } else {
            // If the username is not set, redirect to login page
            header('Location: login.php');
            exit();
        }

        $room_id=1;
        if (isset($_GET['room_id'])) {
            $room_id = $_GET['room_id'];
        } 

        // Validate if Room_ID exists
        $query = "SELECT * FROM rooms WHERE Room_ID = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$room_id]);
        $room = $stmt->fetch();

        if (!$room) {
            echo "Error: Room ID not found !";
                    exit;
        }

        // Fetch the room number
        $query = "SELECT number FROM rooms WHERE Room_ID = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$room_id]);
        $room = $stmt->fetch();
        $room_number = $room['number'];

        // Fetch the room's Description
        $query = "SELECT Description FROM rooms WHERE Room_ID = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$room_id]);
        $room = $stmt->fetch();
        $room_Description = $room['Description'];



        if (isset($_POST['update'])) {

        // Update the status of the room to 'Inactive'
        $update_query = "UPDATE bookings SET Status = ? WHERE Room_ID = ?";
        $stmt = $pdo->prepare($update_query);
        $stmt->execute(['Inactive', $room_id]);

        // Redirect to the bookings after successful update
        header('Location: userDashboard.php'); 
            
           }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancel Reservation</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    
</head>
<body>

<div class="container">
    <div class="jumbotron text-center">
        <h1>Cancel Room Reservation <?php echo $room_number; ?></h1>
        <h3><?php echo $room_Description; ?></h3>
        <p>Kindly this cancellation need your permission</p>

        <form action="update_to_cancel.php" method="POST">
        <input type="hidden" name="room_id" value="<?php echo $room_id; ?>">
        
        <button type="submit" name="update" class="btn btn-primary">Permission</button>
    </form>
    <p><a href="userDashboard.php">Back to Bookings</a></p>
    </div>
</div>

</body>
</html>
