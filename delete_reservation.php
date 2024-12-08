<!-- delete_reservation.php -->

<?php
include('database/db.php');
session_start();

        // Retrieve the username from session
        if (isset($_SESSION['username'])) {
            $username = $_SESSION['username'];
        } else {
            // If the username is not set, redirect to login page
            header('Location: Registration/login.html');
            exit();
        }

        // Get the user ID from the database using the username
        $sql = "SELECT ID FROM users WHERE name = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user === false) {
            echo "User not found.";
            exit;
        }

        $id = $user['ID'];

        $room_id = 1;
        if (isset($_GET['room_id'])) {
            $room_id = $_GET['room_id'];
        }

        // Validate if Room_ID exists
        $query = "SELECT * FROM rooms WHERE Room_ID = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$room_id]);
        $room = $stmt->fetch();

        if (!$room) {
            echo "Error: Room ID not found!";
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

        if (isset($_POST['delete'])) {
            // Delete the booking from the database
            $delete_query = "DELETE FROM bookings WHERE Room_ID = ? AND user_ID = ?";
            $stmt = $pdo->prepare($delete_query);
            $stmt->execute([$room_id, $id]);

            // Redirect to the dashboard after successful deletion
            header('Location: userDashboard.php');
            exit();
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
                <p>Kindly confirm your permission to cancel this reservation</p>

                <form action="delete_reservation.php" method="POST">
                    <button type="submit" name="delete" class="btn btn-danger">Cancel Reservation</button>
                </form>
                <p><a href="userDashboard.php">Back to Bookings</a></p>
            </div>
        </div>

        </body>
        </html>
