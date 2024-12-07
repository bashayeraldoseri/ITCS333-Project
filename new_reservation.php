    <!-- process-new_reservation.php -->

    <?php

    // Include database connection
    include('database/db.php');

    // Start the session 
    session_start();
            
        // Ensure the user is logged in before proceeding
        if (!isset($_SESSION['user_id'])) {
            header('Location: login.php');
            exit();
        }
           
            // Set the default room ID to 1
            $room_id=1;

            // Check if a specific room ID is passed 
            if(isset($_GET["room_id"])) {
                $room_id=$_GET["room_id"];
            }

                // Query to check if the room exists in the database
                $query = "SELECT Room_ID FROM rooms WHERE Room_ID = ?";
                $stmt = $pdo->prepare($query);
                $stmt->execute([$room_id]);
                $room = $stmt->fetch();

                // If no room is found, display an error and stop script execution
                if (!$room) {
                    echo "Error: Room ID not found !";
                    exit;
                }


            // Fetch room details such as capacity, room number, and description
                // Fetch the room capacity
                $query = "SELECT Capacity FROM rooms WHERE Room_ID = ?";
                $stmt = $pdo->prepare($query);
                $stmt->execute([$room_id]);
                $room = $stmt->fetch();
                $room_capacity = $room['Capacity'];

                // Calculate the length of the room capacity (number of digits)
                $capacity_length = strlen((string)$room_capacity);

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




        // Check if the form is submitted
        if(isset($_POST['submit'])){

        // Re-include the database connection for form processing   
        include('database/db.php');

     
            
            // Handle form submission
            $id = $_SESSION['user_id'];  // User ID from the session
            $Status = $_POST['status'];
            $Title = $_POST['Title']; 
            $Start_Date = $_POST['start_date'];
            $End_Date = $_POST['end_date'];
            $Start_Time = $_POST['start_time'];
            $Duration = $_POST['duration'];
            $End_Time = $_POST['start_time'] + $_POST['duration']; 
            $capacity = $_POST['capacity'];


             // Validate the input dates and times
                // Convert to DateTime objects to compare
                $currentDate = new DateTime(); // Get the current date and time
                $startDate = new DateTime($Start_Date);
                $endDate = new DateTime($End_Date);

                $error_messages = [];  // Initialize an array to collect error messages

                // Validate start and end dates
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
                    $error_messages[] = "Error: You can't reserve the room after 19 PM, out of university times!";
                }

                // Check for conflicting reservations in the database
                $query = "SELECT * FROM bookings WHERE Room_ID = ? AND (
                                (Start_Date = ? AND Start_Time < ? AND End_Time > ?) OR 
                                (End_Date = ? AND Start_Time < ? AND End_Time > ?) )";
                $stmt = $pdo->prepare($query);
                $stmt->execute([$room_id, $Start_Date, $End_Time, $Start_Time, $End_Date, $End_Time, $Start_Time]);
                $conflict = $stmt->fetch();

                // If there's a conflict, add an error message
                if ($conflict) {
                    $error_messages[] = "Error: There is a conflict with another reservation for this room during the selected dates and times!";
                }


                // If no errors, insert the booking into the database
                if (empty($error_messages)) {
                    $stmt = $pdo->prepare("INSERT INTO bookings (user_ID, Status, Title, Start_Date, Start_Time, End_Date, Duration, End_Time) VALUES 
                    (?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->execute([$id, $Status, $Title, $Start_Date, $Start_Time, $End_Date, $Duration, $End_Time]);
                                
                    // Redirect to the homepage after successful booking
                    header('Location: index.php'); 

                } else {
                    // Display error messages if validation fails
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

    // Initialize date pickers for the start and end date inputs with date format yy-mm-dd
    $( function() {

        $( "#datepicker1" ).datepicker({dateFormat: "yy-mm-dd"});
        $( "#datepicker2" ).datepicker({dateFormat: "yy-mm-dd"});

    } );

    // Function to control the maximum length of the event capacity input
    function maxLengthCheck(object){
            
        if (object.value.length > object.maxLength)
        object.value = object.value.slice(0, object.maxLength)

            }

        // Validate the event capacity (ensuring it's within the allowed range)
        function validateCapacity(capacityInput) {
        const roomCapacity = <?php echo $room_capacity; ?>;
        const enteredCapacity = parseInt(capacityInput.value);

        if (enteredCapacity < 5 || enteredCapacity > roomCapacity) {
            alert("Invalid capacity! Please enter a value between 5 and " + roomCapacity);
            capacityInput.value = ""; // Clear the input if it's invalid
            return false; // Prevent form submission if validation fails
        }
        return true; // Allow form submission if valid
        }

    </script>

    </head>
    <body>
    <div class="jumbotron text-center">
        <h1>Reserve Room <?php echo $room_number; ?></h1>
        <h3><?php echo $room_Description; ?></h3>
        <p>Kindly fill this form required to ensure your reservation!</p> 
        </div>

        <!-- Reservation form -->
        <div class="container">
        <form action="new_reservation.php" method="POST">
            <input type="hidden" name="Room_ID" value="<?php echo $room_id; ?>">
            <input type="hidden" name="status" value="Active">

            <!-- Event Title -->
            <div class="form-group">
                <label for="title">Event Title:</label>
                <input type="text" class="form-control" name="Title" id="Title" placeholder="Enter Title"  maxlength="80" required >
            </div>

            <!-- Event Start Date -->
            <div class="form-group">
            <label for="start_date">Event Start Date:</label>
            <input type="text" class="form-control" name="start_date" id="datepicker1" placeholder="Enter Start Date" required>
            <p><strong>*The university system not allwed to reserve with old date <br> *University only allwed to reserve with today date or new date</strong></p>
            </div>

            <!-- Event End Date -->
            <div class="form-group">
            <label for="end_date">Event End Date:</label>
            <input type="text" class="form-control" name="end_date" id="datepicker2" placeholder="Enter End Date" required>
            <p><strong>*The university system not allwed to reserve with old date <br> *University only allwed to reserve with today date or new date</strong></p>
            </div>

            <!-- Event Start Time -->
            <div class="form-group">
            <label for="start_time">Start Time of the event:</label>
            <select name="start_time" class="form-control" id="start_time" required>
            <option value="" disabled selected>Select Time</option> <!-- Placeholder option -->
            <!-- Available start times -->
            <option value="8">8 AM</option>
            <option value="9">9 AM</option>
            <option value="10">10 AM</option>
            <option value="11">11 AM</option>
            <option value="12">12 PM</option>
            <option value="13">13 PM</option>
            <option value="14">14 PM</option>
            <option value="15">15 PM</option>
            <option value="16">16 PM</option>
            <option value="17">17 PM</option>
            <option value="18">18 PM</option>
            </select>
            <p><strong>*The time allowed to reserve is based on university times <br>*University times start from 8 am to 18 pm <br> *Not allowed to reserve at 19 pm or after
            </strong></p>
            </div>

            <!-- Event Duration -->
            <div class="form-group">
            <label for="duration">Event Duration:</label>
            <select name="duration" class="form-control" id="duration" required>
            <option value="" disabled selected>Select Duration</option> <!-- Placeholder option -->
            <!-- Duration options -->
            <option value="1">1 hour</option>
            <option value="2">2 hours</option>
            <option value="3">3 hours</option>
            <option value="4">4 hours</option>
            <option value="5">5 hours</option>
            </select>
            <p><strong>*Duration of the event that takes  <br> *The university allows 1 to 5 maximum hours duration for one event</strong></p>
            </div>

             <!-- Event Capacity -->
            <div class="form-group">
                <label for="capacity">Event Capacity:</label>
                <input type="number" oninput="maxLengthCheck(this)" class="form-control" name="capacity"  id="capacity"  min="5" max="<?php echo $room_capacity; ?>"    maxlength="<?php echo $capacity_length; ?>" placeholder="Enter Capacity"  required> 
                <p><strong>*The minimum number that the university allows to request a room reservation is 5 <br> *The maximum capacity for this room is <?php echo $room_capacity; ?></strong></p>
            </div>

            <!-- Submit Button -->
            <button type="submit" name='submit' class="btn btn-primary" onclick="return validateCapacity(document.getElementById('capacity'));">Submit Reservation</button>


            
            
        </form>
        <p><a href="index.php">Back to Room Browsing</a></p>
        <form>

        </div>


    </body>
    </html>
