<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/style.css" rel="stylesheet">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <link rel="stylesheet" href="css/styles.css" />
    <style>
        body {
            background-color: #edebeb;
        }

        h1 {
            margin-left: 10vw;
            margin-top: 5vh;
        }

        .Statistics {
            padding-top: 7vh;
            padding-bottom: 7vh;
            padding-right: 7vw;
            padding-left: 7vw;

            display: flex;
            /* Enables flexbox */
            justify-content: space-around;
            /* Distributes space evenly between items */
            align-items: center;
            /* Aligns items vertically in the center */
            gap: 30px;
            /* Optional: Adds space between the items */
        }

        .Statistics>div {
            text-align: center;
            padding-top: 2vh;
            padding-bottom: 1vh;
            padding-right: 2vw;
            padding-left: 2vw;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .ChartsContainer {
            /* border: 0.25vw, solid, black ;*/
        }

        form {
            margin-left: 10vw;
            margin-right: 10vw;
            padding: 2vh;
            text-align: left;
            background-color: white;
        }
    </style>

    <script>
        // JavaScript to update the output value dynamically as the user interacts with the slider
        const rangeInput = document.getElementById('range');
        const rangeOutput = document.getElementById('range-output');

        rangeInput.addEventListener('input', function () {
            rangeOutput.textContent = 'Value: ' + rangeInput.value;
        });
    </script>
</head>

<body>
    <?php
    include('database/db.php');
    $query = "SELECT COUNT(*) FROM bookings";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $total = $stmt->fetchColumn();

    $query = "SELECT COUNT(*) FROM bookings WHERE  Start_Time > NOW()";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $totalUp = $stmt->fetchColumn();

    $query = "SELECT COUNT(*) FROM bookings WHERE  Start_Time < NOW()";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $totalPast = $stmt->fetchColumn();
    ?>

    <header>
        <div class="container-fluid p-2">
            <nav class="navbar navbar-expand-lg bg-body-tertiary">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">UOB Booking System</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <div class="me-auto"></div>
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="index.php">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="/templates/profile.php">Profile</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">About Us</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="templates/logout.php">logout</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>


        <h1> Reports Dashboard </h1>
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

            <div id="totalpast">
                <h2>No. Past Bookings</h2>
                <hr>
                <h4><?php echo $totalPast; ?></h4>
            </div>
        </div>
    </header>

    <main>

        <form method = "POST" action = "popularity.php">
            <label for="sdate">Choose a starting date: </label>
            <input type="date" id="date" name="sdate"> <br>

            <label for="edate">Choose an ending date: </label>
            <input type="date" id="date" name="edate"> <br> <br>

            <!-- checkbox input-->
            <input type="checkbox" id="checkbox">
            <label for="checkbox">Upcoming</label>

            <input type="checkbox" id="checkbox">
            <label for="checkbox">Past</label> <br> <br>

            <!-- Range Input -->
            <label for="range">Select the number of records to consider:</label> <br>
            <input type="range" id="range" name="range" min="0" max=<?php echo $total ?> value=<?php echo $total ?>
                oninput="this.nextElementSibling.value = this.value">
            <output><?php echo $total ?></output> <br> <br> <br>

            <!-- Submit Button -->
            <button type="submit">Apply Filters</button>
        </form>

        <div class="ChartsContainer">
            <div class="Popularity">
                <?php include("popularity.php") ?>
            </div>

            <div id="Usage">
                <!-- Show the status of each room at the current time (Occupied or not) -->
            </div>

            <div id="cancelation rate">
                <!-- Show the cancelation rate of each room -->
            </div>

            <div id="booking trends">
                <!-- Show booking numbers in a period of time for each room -->
            </div>
        </div>
    </main>
</body>

</html>