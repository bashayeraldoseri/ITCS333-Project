    <!-- process-new_reservation.php -->

    <?php
    include('database/db.php');
    session_start();

            $room_id=1;
            if(isset($_GET["room_id"])) {
                $room_id=$_GET["room_id"];
            }
                // Validate if Room_ID exists
                $query = "SELECT Room_ID FROM rooms WHERE Room_ID = ?";
                $stmt = $pdo->prepare($query);
                $stmt->execute([$room_id]);
                $room = $stmt->fetch();

                // If room not found with the provided room_id
                if (!$room) {
                    echo "Error: Room ID not found !";
                    exit;
                }


        if(isset($_POST['submit'])){
        include('database/db.php');

     
            
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

                $error_messages = [];  // Initialize an array to collect error messages

                // Check for various conditions and store error messages
                if ($startDate < $currentDate) {
                    $error_messages[] = "Error: Start date must be today or in the future!";
                }

                if ($endDate < $currentDate) {
                    $error_messages[] = "Error: End date must be today or in the future!";
                }

                if ($startDate > $endDate) {
                    $error_messages[] = "Error: Start date must not be later than end date!";
                }

                if ($End_Time > 19) {  // Ensure that the End Time is within the allowed range
                    $error_messages[] = "Error: You can't reserve the room after 19 pm, out of university times!";
                }

                // Check for conflicts
                $query = "SELECT * FROM bookings WHERE Room_ID = ? AND (
                                (Start_Date = ? AND Start_Time < ? AND End_Time > ?) OR 
                                (End_Date = ? AND Start_Time < ? AND End_Time > ?) )";
                $stmt = $pdo->prepare($query);
                $stmt->execute([$room_id, $Start_Date, $End_Time, $Start_Time, $End_Date, $End_Time, $Start_Time]);
                $conflict = $stmt->fetch();

                // If there's a conflict
                if ($conflict) {
                    $error_messages[] = "Error: There is a conflict with another reservation for this room during the selected dates and times!";
                }


                // Check the capacity for the reservation
                    // Check room capacity
                    $query = "SELECT capacity FROM rooms WHERE Room_ID = ?";
                    $stmt = $pdo->prepare($query);
                    $stmt->execute([$room_id]);
                    $roomData = $stmt->fetch();
                    
                    // Check if the requested capacity exceeds the room's capacity
                    if ($roomData && $capacity > $roomData['capacity']) {
                        $error_messages[] = "Error: Capacity exceeds the room's capacity of " . $roomData['capacity'] . "!";
                    }


                // If no errors, proceed to insert the booking
                if (empty($error_messages)) {
                    $stmt = $pdo->prepare("INSERT INTO bookings (user_ID, Status, Title, Start_Date, Start_Time, End_Date, Duration, End_Time) VALUES 
                    (?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->execute([$id, $Status, $Title, $Start_Date, $Start_Time, $End_Date, $Duration, $End_Time]);
                    
                    // Successful insertion
                    header('Location: index.php'); // Redirect to items list page
                } else {
                    // Display all errors 
                    echo "<div class='error-container' style='border: 1px solid red; background-color: #f8d7da; padding: 20px;'>";
                    echo "<h3 style='color: red;'>There were some errors with your reservation:</h3>";
                    echo "<ul style='color: red;'>"; 
                    foreach ($error_messages as $error_message) {
                        echo "<li>" . htmlspecialchars($error_message) . "</li>"; 
                    }
                    echo "</ul>";
                    echo "</div>";
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
    <link rel="stylesheet" href="css/new_reservation_style.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <script>

    // control the format of date in html to fit the database format       
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
                <input type="number" oninput="maxLengthCheck(this)" class="form-control" name="capacity"  id="capacity"  min="5" max = "999" maxlength = "3" > 
                <!-- assume that the max capacity can hold in the biggest university room is 999 --> 

                <p>*The minimum number that the university allows to request a room reservation is 5</p>
            </div>

            <button type="submit" name='submit' class="btn btn-primary">Submit Reservation</button>


            
            
        </form>
        <p><a href="index.php">Back to Room Browsing</a></p>
        <form>

        </div>


    </body>
    </html>
