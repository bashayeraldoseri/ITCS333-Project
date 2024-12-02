    <!-- process-new_reservation.php -->

    <?php

    session_start();

    $room_id=1;
    if(isset($_GET["room_id"])) {
        $room_id=$_GET["room_id"];
    }

    if(isset($_POST['submit'])){

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

                    // Validate if Room_ID exists
                        $query = "SELECT * FROM rooms WHERE Room_ID = ?";
                        $stmt = $pdo->prepare($query);
                        $stmt->execute([$room_id]);
                        $room = $stmt->fetch();

                        // If no room found with the provided Room_ID, die with an error message
                        if (!$room) {
                            die("Error: Room ID does not exist in the database!");
                        }
            
            // Handle form submission
            $id = $_SESSION['user_id'];
            $Status = $_POST['status'];
            $Title = $_POST['Title']; 
            $Start_Date = $_POST['start_date'];
            $End_Date = $_POST['end_date'];
            $Start_Time = $_POST['start_time'];
            $Duration = $_POST['duration'];
            $End_Time = $_POST['start_time'] + $_POST['duration']; 
            $capacity = $_POST['capacity'];


            // Validate input 

                // Convert to DateTime objects to compare
                $currentDate = new DateTime(); // Current date and time
                $startDate = new DateTime($Start_Date);
                $endDate = new DateTime($End_Date);

                // Check dates
                if ($startDate < $currentDate) {
                    $error_message_old_date = "Error: Start date must be today or in the future!";
                } elseif ($endDate < $currentDate) {
                    $error_message_end_date = "Error: End date must be today or in the future!";
                } elseif ($startDate > $endDate) {
                    $error_message_start_date = "Error: Start date must not be later than end date!";
                } elseif ($End_Time > 19) {
                    $error_message_end_time = "Error: You can't reserve the room after 19 pm, out of university times!";
                }
                else { 
                        // Check for conflicts 
                         $query = "SELECT * FROM bookings WHERE Room_ID = ? AND (
                                (Start_Date = ? AND Start_Time < ? AND End_Time > ?) OR 
                                (End_Date = ? AND Start_Time < ? AND End_Time > ?) )";
                            $stmt = $pdo->prepare($query);
                            $stmt->execute([$room_id, $Start_Date, $End_Time, $Start_Time, $End_Date, $End_Time, $Start_Time]);
                            $conflict = $stmt->fetch();

                            // If there's a conflict, show an error message
                            if ($conflict) {
                                $error_message_conflict = "Error: There is a conflict with another reservation for this room during the selected dates and times.";
                            } 
                            else {
             
                                            // Check end_time
                                            if($End_Time > 19){
                                                $error_message_end_time = "Error: You can't reserve the room after 19 pm, out of university times ! ";
                                                }
                                            else{

                                                            // Check capacity 
                                                                // the user should input 5 or more as a capacity
                                                            if ($capacity < 5){
                                                                $error_message_capacity_less_than = "Error: The minimum number that the university allows to request a room reservation is 5 ! ";
                                                                }

                                                            else{
                                                                    $query = "SELECT capacity FROM rooms WHERE Room_ID = ?";
                                                                    $stmt = $pdo->prepare($query);
                                                                    $stmt->execute([$room_id]);
                                                                    $roomData = $stmt->fetch();
                                                                // the user should input number <= room capacity 
                                                                    if ($roomData && $capacity > $roomData['capacity']){
                                                                            $error_message_capacity_exceeds = "Error: Capacity exceeds the room's capacity of ! " . $roomData['capacity'];
                                                                        }

                                                                    else{
                                                                                // Insert booking

                                                                                // Prepare and execute the SQL query
                                                                                $stmt = $pdo->prepare("INSERT INTO bookings (user_ID, Status, Title, Start_Date, Start_Time, End_Date, Duration, End_Time) VALUES 
                                                                                (?, ?, ?, ?, ?, ?, ?, ?)");
                                                                                $stmt->execute([$id, $Status, $Title, $Start_Date, $End_Date, $Start_Time, $Duration, $End_Time]);
                                                                                
                                                                                // Successful insertion
                                                                                header('Location: index.php'); // Redirect to items list page
                                                                                    
                                                                        }
                                                              }
                                                            }
                                                        }
                }
                                                    
             
            }  
            
         catch (PDOException $e) {
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
        <link rel="stylesheet" href="css/new_reservation_style.css">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <script>

    // control the formated of date in html to accurate the sql formated        
    $( function() {

        $( "#datepicker1" ).datepicker({dateFormat: "yy-mm-dd"});
        $( "#datepicker2" ).datepicker({dateFormat: "yy-mm-dd"});

    } );

    // control the length of capacity 
    function maxLengthCheck(object){
        
        if (object.value.length > object.maxLength)
       object.value = object.value.slice(0, object.maxLength)

        }


    </script>

    </head>
    <body>
    <div class="jumbotron text-center">
        <h1>Reserve Room ID: <?php echo $room_id; ?></h1>
        <p>Kindly fill this form required to ensure your reservation!</p> 
        </div>

        <div class="container">
        <form action="new_reservation.php" method="POST">
            <input type="hidden" name="Room_ID" value="<?php echo $room_id; ?>">
            <input type="hidden" name="status" value="Active">

            <div class="form-group">
                <label for="title">Event Title:</label>
                <input type="text" class="form-control" name="Title" id="Title" maxlength="80" >
            </div>

            <div class="form-group">
            <label for="start_date">Start Date of the event:</label>
            <input type="text" class="form-control" name="start_date" id="datepicker1">
            <p>*The university system not allwed to reserve with old date <br> *University only allwed to reserve with today date or new date</p>
            </div>

            <div class="form-group">
            <label for="end_date">End Date of the event:</label>
            <input type="text" class="form-control" name="end_date" id="datepicker2">
            <p>*The university system not allwed to reserve with old date <br> *University only allwed to reserve with today date or new date</p>
            </div>


            <div class="form-group">
            <label for="start_time">Start Time of the event:</label>
            <select name="start_time" class="form-control" id="start_time">
            <option value="8">8 am</option>
            <option value="9">9 am</option>
            <option value="10">10 am</option>
            <option value="11">11 am</option>
            <option value="12">12 pm</option>
            <option value="13">13 pm</option>
            <option value="14">14 pm</option>
            <option value="15">15 pm</option>
            <option value="16">16 pm</option>
            <option value="17">17 pm</option>
            <option value="18">18 pm</option>
            </select>
            <p>*The time allowed to reserve is based on university times <br>*University times start from 8 am to 18 pm <br> *Not allowed to reserve at 19 pm or after
            </p>
            </div>

            
            <div class="form-group">
            <label for="duration">Duration of the event:</label>
            <select name="duration" class="form-control" id="duration">
            <option value="1">1 hour</option>
            <option value="2">2 hours</option>
            <option value="3">3 hours</option>
            <option value="4">4 hours</option>
            <option value="5">5 hours</option>
            </select>
            <p>*Duration of the event that takes  <br> *The university allows 1 to 5 maximum hours duration for one event</p>
            </div>


            <div class="form-group">
                <label for="capacity">Capacity:</label>
                <input type="number" oninput="maxLengthCheck(this)" class="form-control" name="capacity"  id="capacity"  min="1" max = "999" maxlength = "3" > 
                <!-- assume that the max capacity can hold in the biggest university room is 999 --> 
                <!-- allows the user to input any integer number and the feature will be more specific in php part, that the user should not input less than 5 as a capacity --> 

                <p>*The minimum number that the university allows to request a room reservation is 5</p>
            </div>

            <button type="submit" name='submit' class="btn btn-primary">Submit Reservation</button>


        
            <p style="color: red;">
            <?php if (isset($error_message)) echo $error_message; ?>
            <?php if (isset($error_message_capacity_less_than)) echo $error_message_capacity_less_than; ?>
            <?php if (isset($error_message_capacity_exceeds)) echo $error_message_capacity_exceeds; ?> 
            <?php if (isset($error_message_end_time)) echo $error_message_end_time; ?> 
            <?php if (isset($error_message_conflict)) echo $error_message_conflict; ?>
            <?php if (isset($error_message_old_date)) echo $error_message_old_date; ?> 
            <?php if (isset($error_message_end_date)) echo $error_message_end_date; ?> 
            <?php if (isset($error_message_start_date)) echo $error_message_start_date; ?> 


            
            
        </form>
        <p><a href="index.php">Back to Room Browsing</a></p>
        <form>

        </div>


    </body>
    </html>
