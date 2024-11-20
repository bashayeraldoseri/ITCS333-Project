<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
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
            /* Vertically center the content */
            margin-top: 20px;
        }

        .profile-pic {
            width: 60px;
            /* Smaller image for compact layout */
            height: 60px;
            object-fit: cover;
            border-radius: 50%;
            margin-right: 15px;
            /* Space between image and title */
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

        /* Adjustments for small screens: picture and title next to each other */
        @media (max-width: 576px) {
            .dashboard-header {
                justify-content: flex-start;
                /* Align to the left */
            }

            .dashboard-header h2 {
                font-size: 16px;
                /* Smaller font size for small screens */
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
    $username = $_SESSION['username'];  // Retrieve the username from session
    ?>

    <header>
        <div class="container">
            <!-- Dashboard Header -->
            <div class="dashboard-header" style="margin-bottom: 15px;">
                <img src="https://via.placeholder.com/100" alt="User Picture" class="profile-pic">
                <h2><?php echo $username; ?> Dashboard</h2>
            </div>
        </div>
    </header>

</body>

</html>