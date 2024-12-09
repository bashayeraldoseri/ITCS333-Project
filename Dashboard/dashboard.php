<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        /* General Styles */
        html,
        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background-color: #f9f9f9;
            color: #333;
            height: 100%;
            padding: 0;
            /* Removed padding to prevent margin before the header */
        }

        /* Header Styles */
        header {
            position: fixed;
            /* Fix the header to the top */
            top: 0;
            left: 0;
            width: 100%;
            z-index: 9999;
            /* Ensure the header is above other elements */
            background-color: #fff;
            /* Optional: To ensure header has a white background */
        }

        .container-fluid {
            padding: 0;
        }

        .navbar {
            padding: 0.5rem 1rem;
            /* Adjust padding for better appearance */
        }

        /* Adjust main content for the fixed header */
        main {
            padding-top: 80px;
            /* Add space so content doesn't hide behind header */
            padding-right: 5vw;
            padding-left: 5vw;
        }

        /* Header text and navbar */
        h1 {
            margin-top: 20px;
            color: #333;
            font-weight: 600;
            text-align: center;
        }

        /* Statistics Section */
        .Statistics {
            display: flex;
            justify-content: space-around;
            gap: 30px;
            padding: 40px 0;
            margin-top: 20px;
        }

        .Statistics>div {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            padding: 30px;
            text-align: center;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            flex: 1;
        }

        .Statistics>div:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .Statistics h2 {
            color: #a0b8cf;
            font-size: 24px;
        }

        .Statistics h4 {
            color: #a0b8cf;
            font-size: 36px;
            font-weight: 700;
            margin-top: 10px;
        }

        /* Link Section for charts */
        .ChartsContainer {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            justify-content: center;
            padding-top: 50px;
        }

        .ChartsContainer div {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            width: 250px;
            text-align: center;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .ChartsContainer div:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .ChartsContainer a {
            text-decoration: none;
            color: #a0b8cf;
            font-weight: 600;
            font-size: 16px;
            transition: color 0.3s;
        }

        .ChartsContainer a:hover {
            color: #4caf50;
        }

        /* Responsive Layout for small screens */
        @media (max-width: 768px) {
            .Statistics {
                flex-direction: column;
                align-items: center;
            }

            .ChartsContainer {
                flex-direction: column;
            }

            .ChartsContainer div {
                width: 100%;
                margin-bottom: 20px;
            }
        }
    </style>

</head>

<body>
    <?php
    include('../database/db.php');
    $query = "SELECT COUNT(*) FROM bookings";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $total = $stmt->fetchColumn();

    $query = "SELECT COUNT(*) FROM bookings WHERE Start_Time > NOW()";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $totalUp = $stmt->fetchColumn();

    $query = "SELECT COUNT(*) FROM bookings WHERE Start_Time < NOW()";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $totalPast = $stmt->fetchColumn();
    ?>

    <header>
        <div class="container-fluid p-2">
            <nav class="navbar navbar-expand-lg bg-body-tertiary">
                <div class="container-fluid">
                    <img src="../static\UOBLogo.png" alt="UOB" id="UOBLogo"
                        style="height: 80px; width: auto; vertical-align: middle;" />
                    <h2
                        style="font-family: Comic Sans MS, Comic Sans, cursive; margin-left: 10px; display: inline-block;">
                        UOB Booking System
                    </h2>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <div class="me-auto"></div>
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="../index.php">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../profile/profile.php">Profile</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="#">Dashboard</a>
                            </li>
                            <?php if (isset($_SESSION['role']) && $_SESSION['role'] == "Admin"): ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="../admin/adminDash.php">Admin</a>
                                </li>
                            <?php endif; ?>
                            <li class="nav-item">
                                <a class="nav-link" href="../AboutUs.php">About Us</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../Registration/logout.php">logout</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <main>
        <h1 class="mt-5"> Reports Dashboard </h1>
        <div class="Statistics">
            <div id="total">
                <h2>Total No. Bookings</h2>
                <hr>
                <h4><?php echo $total; ?></h4>
            </div>

            <div id="totalUp">
                <h2>No. Upcoming Bookings</h2>
                <hr>
                <h4><?php echo $totalUp; ?></h4>
            </div>

            <div id="totalPast">
                <h2>No. Past Bookings</h2>
                <hr>
                <h4><?php echo $totalPast; ?></h4>
            </div>
        </div>
        <div class="ChartsContainer">
            <div id="Popularity">
                <a href="popularity.php">View Popularity Chart</a>
            </div>

            <div id="Status">
                <a href="status.php">View Room Status Chart</a>
            </div>

            <div id="Usage">
                <a href="usage.php">View Room Usage Chart</a>
            </div>

            <div id="booking-trends">
                <a href="bookingtrends.php">View Booking Trends Chart</a>
            </div>
        </div>
    </main>
</body>

</html>