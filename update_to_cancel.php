<!-- update_to_cancel.php -->

<?php
include('database/db.php');
session_start();

        // Ensure the user is logged in or handle accordingly
        if (!isset($_SESSION['user_id'])) {
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



        if (isset($_POST['update'])) {

        // Update the status of the room to 'Inactive'
        $update_query = "UPDATE rooms SET Status = ? WHERE Room_ID = ?";
        $stmt = $pdo->prepare($update_query);
        $stmt->execute(['Inactive', $room_id]);

        // Success message
        header('Location: ?????.php'); // Redirect to ...... page
    
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
        <h1>Cancel Room Reservation ID: <?php echo $room_id; ?></h1>
        <p>Kindly for complete the cancellation process you need permission</p>

        <form action="update_to_cancel.php" method="POST">
        <input type="hidden" name="room_id" value="<?php echo $room_id; ?>">

        <input type="hidden" name="status"  value="Inactive" > 
        
        <button type="submit" name="update" class="btn btn-primary">Permission</button>
    </form>
    <p><a href="???????.php">Back to Bookings</a></p>
    </div>
</div>

</body>
</html>
