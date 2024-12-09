    <!-- process-new_reservation.php -->

    <?php

    // Include database connection
    include('../database/db.php');

    // Start the session 
    session_start();

        // Retrieve the username from session
            if (isset($_SESSION['username'])) {
                $username = $_SESSION['username'];
            } else {
                // If the username is not set, redirect to login page
                header('Location: ../Registration/login.html');
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

     
           
            // Set the default room ID to 1
            $room_id = 1;

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

                // Fetch the room's Available_From
                $query = "SELECT Available_From FROM rooms WHERE Room_ID = ?";
                $stmt = $pdo->prepare($query);
                $stmt->execute([$room_id]);
                $room = $stmt->fetch();
                $room_Available_From = $room['Available_From'];

                // Fetch the room's Available_To
                $query = "SELECT Available_To FROM rooms WHERE Room_ID = ?";
                $stmt = $pdo->prepare($query);
                $stmt->execute([$room_id]);
                $room = $stmt->fetch();
                $room_Available_To = $room['Available_To'];




        // Check if the form is submitted
        if(isset($_POST['submit'])){
            // echo $room_id;

        // Re-include the database connection for form processing   
        include('../database/db.php');

     
            
            // Handle form submission
            $Title = $_POST['Title']; 
            $Start_time = $_POST['start_time'];
            $End_time = $_POST['end_time'];
            $capacity = $_POST['capacity'];

            
                // Function to convert the datetime to MySQL format (YYYY-MM-DD HH:MM:SS)
                function convertToMySQLFormat($dateTime) {
                    // The input format is 'YYYY-MM-DDTHH:MM'
                    $dateTime = str_replace('T', ' ', $dateTime); // Replace 'T' with a space
                    return $dateTime . ':00';  // Add seconds to match MySQL format (YYYY-MM-DD HH:MM:SS)
                
                }
                // Convert the datetime to MySQL format
                $mysqlDateTime = convertToMySQLFormat($Start_time);
                $mysqlDateTime2 = convertToMySQLFormat($End_time);

                 // Get current date and time
                $currentDate = date('Y-m-d H:i:s');

                // Validate the input dates and times


                $error_messages = [];  // Initialize an array to collect error messages

                // 1. Check if the start date is not in the past
                if (strtotime($mysqlDateTime) < strtotime($currentDate)) {
                    $error_messages[] = "Error Start Date: You cannot reserve a room for a past date. Please choose today or a future date !";
                }

                // 2. Check if the end date is not in the past
                if (strtotime($mysqlDateTime2) < strtotime($currentDate)) {
                    $error_messages[] = "Error End Date: You cannot reserve a room for a past date. Please choose today or a future date !";
                }

                // 3. Check if the start time is within university allowed times (8 AM to 8 PM)
                $startHour = date('H', strtotime($mysqlDateTime));
                $endHour = date('H', strtotime($mysqlDateTime2)); 
                $Available_From = date('H', strtotime($room_Available_From));
                $Available_To = date('H', strtotime($room_Available_To));

                if ($startHour < $Available_From || $startHour >= $Available_To) {
                    $error_messages[] = "Error Start Time: This room is not available at this time !";
                }

                // 4. Check if the end time is within university allowed times (8 AM to 8 PM)
                if ($endHour < $Available_From || $endHour >= $Available_To) {
                    $error_messages[] = "Error End Time: This room is not available at this time !";
                }

                // 5. Check if the end time is not before the start time or at the same time
                if (strtotime($mysqlDateTime2) <= strtotime($mysqlDateTime)) {
                    $error_messages[] = "Error Start and End Time: The end time must be after the start time. Please ensure the event has a valid duration !";
                }

                // 6. Check that start and end times are not the same if the dates are the same
                if (date('Y-m-d', strtotime($mysqlDateTime)) === date('Y-m-d', strtotime($mysqlDateTime2))) {
                    if (strtotime($mysqlDateTime) === strtotime($mysqlDateTime2)) {
                        $error_messages[] = "Error: Start time and end time cannot be the same if they are on the same day.";
                    }
                }

                // 7. Check for conflicts with existing reservations

                $query = "
                            SELECT * 
                            FROM bookings 
                            WHERE Room_ID = ? 
                            AND (
                                (Start_Time < ? AND End_Time > ?) 
                                OR 
                                (Start_Time < ? AND End_Time > ?)
                            )
                        ";
                        $stmt = $pdo->prepare($query);
                        $stmt->execute([$room_id, $mysqlDateTime, $mysqlDateTime, $mysqlDateTime2, $mysqlDateTime]);

                        $conflict = $stmt->fetch();

                        if ($conflict) {
                            $error_messages[] = "Error Conflicts: Error: The room is already reserved during the selected time ! Please choose a different time slot.";
                        }

             

                    // If there are errors, display them
                    if (!empty($error_messages)) {
                        // Display error messages if validation fails
                        echo "<div class='error-container' style='border: 1px solid red; background-color: #f8d7da; padding: 20px;'>";
                        echo "<h3 style='color: red;'>There were some errors with your reservation:</h3>";
                        echo "<ul style='color: red;'>"; 
                        foreach ($error_messages as $error_message) {
                            echo "<li>" . htmlspecialchars($error_message) . "</li>"; 
                        }
                        echo "</ul>";
                        echo "</div>";
                    } else {        
                            // If no errors, insert the reservation into the database
                             $stmt = $pdo->prepare("INSERT INTO bookings ( user_ID, Room_ID, Title, Start_Time, End_Time) VALUES (?,?,?,?,?)");
                             $stmt->execute([$id, $room_id, $Title, $mysqlDateTime, $mysqlDateTime2]);
                             $_SESSION['successful_booking'] = true;
                             header('Location: ../index.php'); 
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
    <link rel="stylesheet" href="../css/new_reservation_style.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <script>

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
        <form action="new_reservation.php?room_id=<?php echo $room_id;?>" method="POST">

            <div>
            <p>*The university system does not permit reservations for past dates.</p>
            <p>*This room is Available from <?php echo $room_Available_From; ?> to <?php echo $room_Available_To; ?></p>
            </div>

            <!-- Event Title -->
            <div class="form-group">
                <label for="title">Event Title:</label>
                <input type="text" class="form-control" name="Title" placeholder="Enter Title"  maxlength="80" required >
            </div>

            <!-- Event Start Date -->
            <div class="form-group">
            <label for="start_time">Event Start Time/Date:</label>
            <input type="datetime-local" class="form-control" name="start_time"  placeholder="Enter Start Time/Date" required>
            </div>

            <!-- Event End Date -->
            <div class="form-group">
            <label for="end_time">Event End Date/Time:</label>
            <input type="datetime-local" class="form-control" name="end_time"  placeholder="Enter End Time/Date" required>
            </div>


             <!-- Event Capacity -->
            <div class="form-group">
                <label for="capacity">Event Capacity:</label>
                <input type="number" oninput="maxLengthCheck(this)" class="form-control" name="capacity"  id="capacity"  min="5" max="<?php echo $room_capacity; ?>"    maxlength="<?php echo $capacity_length; ?>" placeholder="Enter Capacity"  required> 
                <p>*The minimum number that the university allows to request a room reservation is 5 <br> *The maximum capacity for this room is <?php echo $room_capacity; ?></p>
            </div>

            <!-- Submit Button -->
            <button type="submit" name='submit' class="btn btn-primary" onclick="return validateCapacity(document.getElementById('capacity'));">Submit Reservation</button>


            
            
        </form>
        <p><a href="../index.php">Back to Room Browsing</a></p>
        <form>

        </div>


    </body>
    </html>
