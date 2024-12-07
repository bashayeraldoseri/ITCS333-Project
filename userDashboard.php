<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        /* General Styles */
        html,
        body {
            height: 100%;
            margin: 0;
            font-family: 'Inter', sans-serif;
            background-color: #f9f9f9;
            color: #333;
        }

        .container {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            padding: 20px;
        }

        /* Header Styles */
        .dashboard-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 30px;
            border-bottom: 2px solid #ddd;
            padding-bottom: 10px;
        }

        .profile-pic {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid #4caf50;
        }

        h2 {
            font-weight: 700;
            color: #333;
        }

        /* Dashboard Layout */
        .dashnoard-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .box {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            flex: 1 1 30%;
            min-width: 250px;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .box:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
        }

        .box h2 {
            margin-bottom: 15px;
            font-size: 18px;
            color: #4caf50;
        }

        .scrollable-container {
            max-height: 150px;
            overflow-y: auto;
            padding-right: 10px;
            scrollbar-width: thin;
        }

        .scrollable-container li {
            margin-bottom: 10px;
            font-size: 14px;
        }

        /* Chart Styles */
        .charts {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            flex: 1 1 60%;
        }

        .chart {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            flex: 1 1 45%;
            min-width: 300px;
            text-align: center;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .chart:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
        }

        .chart a {
            font-size: 16px;
            font-weight: 600;
            color: #4caf50;
            text-decoration: none;
            transition: color 0.2s;
        }

        .chart a:hover {
            color: #388e3c;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .dashnoard-container {
                flex-direction: column;
            }

            .box,
            .charts {
                flex: 1 1 100%;
            }
        }
    </style>
</head>

<body>
    <?php
    session_start();

    // Retrieve the username from session
    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
    } else {
        // If the username is not set, redirect to login page
        header('Location: login.php');
        exit();
    }

    include('database/db.php');

    // Get the user ID from the database using the username
    $sql = "SELECT ID, ProfilePic FROM users WHERE name = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user === false) {
        echo "User not found.";
        exit;
    }

    $userID = $user['ID'];
    $profileImage = $user['ProfilePic']; // Get the profile image path from the database
    
    // Fetch the upcoming bookings
    $sql = "SELECT Room_ID, Start_Time, End_Time FROM bookings WHERE user_ID = ? AND End_Time > NOW()";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$userID]);
    $comingbookings = $stmt->fetchAll();

    // Fetch the past bookings
    $sql = "SELECT Room_ID, Start_Time, End_Time FROM bookings WHERE user_ID = ? AND End_Time < NOW()";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$userID]);
    $pastbookings = $stmt->fetchAll();
    ?>


    <header>
        <header>
            <div class="container-fluid p-2">
                <nav class="navbar navbar-expand-lg bg-body-tertiary">
                    <div class="container-fluid">
                        <a class="navbar-brand" href="#">UOB Booking System</a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                            aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarNav">
                            <div class="me-auto"></div>
                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <a class="nav-link" aria-current="page" href="index.php">Home</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="profile/profile.php">Profile</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" href="#">Dashboard</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">About Us</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="Registration/logout.php">logout</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </header>

        <main>
            <div class="container">
                <div class="dashboard-header">
                    <?php
                    // Check if the profile image exists in the database
                    if (!empty($profileImage)) {
                        // Display the user's profile image if it exists
                        echo "<img src='$profileImage' alt='User Picture' class='profile-pic'>";
                    } else {
                        // Display the placeholder image if no profile image exists
                        echo "<img src='https://via.placeholder.com/100' alt='User Picture' class='profile-pic'>";
                    }
                    ?>
                    <h2><?php echo $username; ?> Dashboard</h2>
                </div>


                <div class="dashnoard-container">
                    <!-- Upcoming Bookings -->
                    <div class="box" id="upcoming-bookings">
                        <h2>Upcoming Bookings</h2>
                        <ul class="scrollable-container">
                            <?php
                            foreach ($comingbookings as $booking) {
                                echo "<li>Room {$booking['Room_ID']} - {$booking['Start_Time']} to {$booking['End_Time']}</li>";
                            }
                            ?>
                        </ul>
                    </div>

                    <!-- Past Bookings -->
                    <div class="box" id="past-bookings">
                        <h2>Past Bookings</h2>
                        <ul class="scrollable-container">
                            <?php
                            foreach ($pastbookings as $booking) {
                                echo "<li>Room {$booking['Room_ID']} - {$booking['Start_Time']} to {$booking['End_Time']}</li>";
                            }
                            ?>
                        </ul>
                    </div>

                    <!-- Charts -->
                    <div class="charts">
                        <div class="chart" id="most-used">
                            <a href="userRoomsUsage.php">View Room Usage Chart</a>
                        </div>
                        <div class="chart" id="most-timing">
                            <a href="userTimingUsage.php">View Timing Chart</a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
</body>

</html>