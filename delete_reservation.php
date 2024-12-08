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

        $booking_id = 1;
        if (isset($_GET['booking_id'])) {
            $booking_id = $_GET['booking_id'];
        }

        // Validate if booking_id exists
        $query = "SELECT * FROM bookings WHERE Booking_ID = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$booking_id]);
        $booking = $stmt->fetch();

        if (!$booking) {
            echo "Error: Booking ID not found!";
            exit;
        }

        // Fetch the booking title 
        $query = "SELECT Title FROM bookings WHERE Booking_ID = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$booking_id]);
        $booking = $stmt->fetch();
        $booking_title = $booking['Title'];

        // Fetch the booking Start_Time
        $query = "SELECT Start_Time FROM bookings WHERE Booking_ID = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$booking_id]);
        $booking = $stmt->fetch();
        $booking_StartTime = $booking['Start_Time'];

         // Fetch the booking End_Time
         $query = "SELECT End_Time FROM bookings WHERE Booking_ID = ?";
         $stmt = $pdo->prepare($query);
         $stmt->execute([$booking_id]);
         $booking = $stmt->fetch();
         $booking_EndTime = $booking['End_Time'];

        if (isset($_POST['delete'])) {
            // Delete the booking from the database
            $delete_query = "DELETE FROM bookings WHERE Booking_ID = ? AND user_ID = ?";
            $stmt = $pdo->prepare($delete_query);
            $stmt->execute([$booking_id, $id]);

            // Redirect to the dashboard after successful deletion
            header('Location: profile/profile.php');
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
                <h1>Cancel Reservation</h1>
                <h3> Title: <?php echo $booking_title; ?><br>
                     Start Date/Time: <?php echo $booking_StartTime; ?><br>
                     End Date/Time: <?php echo $booking_EndTime; ?><br>
                </h3>
                <p>Kindly confirm your permission to cancel this reservation</p>

                <form action="delete_reservation.php" method="POST">
                    <button type="submit" name="delete" class="btn btn-danger">Cancel Reservation</button>
                </form>
                <p><a href="profile/profile.php">Back to Bookings</a></p>
            </div>
        </div>

        </body>
        </html>
