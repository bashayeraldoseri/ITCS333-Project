<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
    <!-- Optional: Add your custom styles -->
    <style>
        /* Ensure that the body and html take full height */
        html,
        body {
            height: 100%;
            margin: 0;
        }

        /* Set the height of the container to fill the screen */
        .container {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Header Styles */
        .dashboard-header {
            display: flex;
            align-items: center;
            margin-top: 20px;
        }

        .profile-pic {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 50%;
            margin-right: 15px;
        }

        .card-container {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .card {
            margin-bottom: 20px;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .card-body {
            overflow-y: auto;
            flex-grow: 1;
        }

        .card-header {
            flex-shrink: 0;
        }

        /* New CSS for the dashboard layout */
        .dashnoard-container {
            display: flex;
            /* Use Flexbox for horizontal layout */
            justify-content: space-between;
            /* Add space between the elements */
            gap: 20px;
            /* Optional: space between boxes */
            flex-wrap: wrap;
            /* Allow wrapping on smaller screens */
            margin-top: 20px;
        }

        .box {
            background-color: #f4f4f4;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            flex: 1 1 30%;
            /* Flex: grow, shrink, and basis */
            min-width: 250px;
            /* Set a minimum width */
        }

        .charts {
            display: flex;
            flex: 1 1 60%;
            /* Charts take 60% of the space */
            flex-wrap: wrap;
            gap: 20px;
        }

        .chart {
            background-color: #f4f4f4;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            flex: 1 1 45%;
            /* Each chart box takes up 45% of the width */
            min-width: 300px;
            /* Minimum width for each chart box */
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .dashnoard-container {
                flex-direction: column;
                /* Stack the boxes vertically on smaller screens */
            }

            .box,
            .charts {
                flex: 1 1 100%;
                /* Full width on small screens */
            }
        }

        @media (max-width: 576px) {
            .dashboard-header h2 {
                font-size: 16px;
                /* Smaller font size for smaller screens */
            }
        }
    </style>
</head>

<body>

    <?php
    session_start();  // Start the session
    
    // Check if the user is logged in
    /*if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        header('Location: templates/login.html');  // Redirect to login if not logged in
        exit();
    }*/

    // Access session data
    //$username = $_SESSION['username'];  // Retrieve the username from session
    $username = "Instructor Name";
    include('database/db.php');
    $sql = "SELECT ID FROM users WHERE name = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$username]);
    $userID = $stmt->fetch();

    if ($userID === false) {
        // Handle case when no user is found (e.g., redirect or show an error message)
        echo "User not found.";
        exit;
    }

    $sql = "SELECT Room_ID, Start_Time, End_Time FROM bookings WHERE user_ID = ? AND Start_Time > NOW()";
    $stmt = $pdo->prepare($sql);  // Prepare the query
    $stmt->execute([$userID['ID']]);  // Execute the query
    $comingbookings = $stmt->fetchAll();

    $sql = "SELECT Room_ID, Start_Time, End_Time FROM bookings WHERE user_ID = ? AND Start_Time < NOW()";
    $stmt = $pdo->prepare($sql);  // Prepare the query
    $stmt->execute([$userID['ID']]);  // Execute the query
    $pastbookings = $stmt->fetchAll();
    ?>

    <header>
        <div class="container">
            <!-- Dashboard Header -->
            <div class="dashboard-header" style="margin-bottom: 15px;">
                <img src="https://via.placeholder.com/100" alt="User Picture" class="profile-pic">
                <h2><?php echo $username; ?> Dashboard</h2>
            </div>

            <div class="dashnoard-container">
                <div class="box" id="upcoming-bookings">
                    <h2>Upcoming Bookings</h2>
                    <div class="scrollable-container">
                        <?php
                        // Assuming $bookings is an array of booking data from the database
                        foreach ($comingbookings as $booking) {
                            $room = $booking['Room_ID'];  // Get the room ID from the booking record
                            $start = $booking['Start_Time'];  // Get the start time
                            $end = $booking['End_Time'];  // Get the end time
                            echo "<li>{$room} - {$start} to {$end}</li>";  // Display the booking info
                        }
                        ?>
                    </div>

                </div>

                <!-- Past Bookings -->
                <div class="box" id="past-bookings">
                    <h2>Past Bookings</h2>
                    <div class="scrollable-container">
                        <?php
                        // Assuming $bookings is an array of booking data from the database
                        foreach ($pastbookings as $booking) {
                            $room = $booking['Room_ID'];  // Get the room ID from the booking record
                            $start = $booking['Start_Time'];  // Get the start time
                            $end = $booking['End_Time'];  // Get the end time
                            echo "<li>{$room} - {$start} to {$end}</li>";  // Display the booking info
                        }
                        ?>
                    </div>
                </div>

                <!-- Charts -->
                <div class="charts">
                    <div class="chart" id="most used">
                        <div class="chart-container">
                            <?php include('userRoomsUsage.php'); ?>
                        </div>
                    </div>

                    <div class="chart" id="most timing">
                        <div class="chart-container">
                            <?php include('userTimingUsage.php'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
</body>

</html>