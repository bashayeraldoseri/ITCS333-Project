    <!-- process-new_reservation.php -->

    <?php

    session_start();

    $room_id=0;
    if(isset($_GET["room_id"])) {
        $room_id=$_GET["room_id"];
    }

    if(isset($_POST['submit'])){
        //code for insert

        $host = 'localhost';
        $user = 'root'; // default username for XAMPP/MAMP
        $password = ''; // your password for the database
        $dbname = 'booking_system';
        $port = 3306; // Default MySQL port is 3306, use 8080 if it's a non-standard port for your database server

        try {
            // Create PDO connection
            $dsn = "mysql:host=$host;dbname=$dbname;port=$port";
            $pdo = new PDO($dsn, $user, $password);

            // Set PDO error mode to exception for better error handling
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Handle form submission
            $id = $_SESSION['user_id'];
            $Title = $_POST['Title'];
            $Start_Time = $_POST['start_date'];
            $End_Time = $_POST['end_date'];



            // Validate input (basic example)
            // Check capacity
                $query = "SELECT capacity FROM rooms WHERE Room_ID = ?";
                $stmt = $pdo->prepare($query);
                $stmt->execute([$room_id]);
                $roomData = $stmt->fetch();
                $capacity = $roomData['capacity'];







            // Prepare and execute the SQL query
            $stmt = $pdo->prepare("INSERT INTO bookings (user_ID, Title, Start_Time, End_Time) VALUES 
            (?, ?, ?, ?)");
            $stmt->execute([$id ,$Title, $Start_Time, $End_Time]);
            
            // Successful insertion
            header('Location: index.php'); // Redirect to items list page


            
        } catch (PDOException $e) {
            // Handle connection failure
            die("Connection failed: " . $e->getMessage());
        }

    
    }

    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <title>New Reservation</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <script>
    $( function() {
        //your code is here
        
        $( "#datepicker1" ).datepicker({dateFormat: "yy-mm-dd"});


    } );
    </script>

    </head>
    <body>
    <div class="jumbotron text-center">
        <h1>Reserve Room: <?php echo $room_id; ?></h1>
        <p>Kindly fill this form required to ensure your reservation!</p> 
        </div>

        <div class="container">
        <form action="new_reservation.php" method="POST">
            <input type="hidden" name="Room_ID" value="<?php echo $room_id; ?>">
            <input type="hidden" name="status" value="Active">

            <div class="form-group">
                <label for="title">Event Title:</label>
                <input type="text" class="form-control" name="Title" id="Title" >
            </div>

            <div class="form-group">
            <label for="start_date">Start Date:</label>
            <input type="text" class="form-control" name="start_date" id="datepicker1">
            </div>


            <div class="form-group">
            <label for="time">Start Time of the event:</label>
            <select name="time" class="form-control" id="time">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            </select>
            <p>*The time allowed to reserve based on university times <br>*University times start from 8am to 18pm <br> *Not allowed to reserve at 19pm or after
            </p>
            </div>

            <!--assuming each hour = 50 min-->
            <div class="form-group">
            <label for="duration">Duration of the event:</label>
            <select name="duration" class="form-control" id="duration">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            </select>
            <p>*Duration of the event that take  <br> *The university allowed 1 to 5 maximum hours duration for one event</p>
            </div>

           

            <div class="form-group">
                <label for="capacity">Capacity:</label>
                <input type="number" class="form-control" name="capacity"  id="capacity"  min="5" max="<?php $capacity; ?>" >
            </div>

            <button type="submit" name='submit' class="btn btn-primary">Submit Reservation</button>


        
            <p style="color: red;">
            <?php if (isset($error_message)) echo $error_message; ?>
            </p>
            
        </form>
        <p><a href="index.php">Back to Room Browsing</a></p>
        <form>

        </div>


    </body>
    </html>
