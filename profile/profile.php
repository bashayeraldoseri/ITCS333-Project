<?php
session_start();
//testing
// print_r($_SESSION);

include("../database/db.php");

$username = $_SESSION['username'];
$id = $_SESSION['user_id'];
$email = $_SESSION['user_email'];
$Dob = '0000-00-00';
$phone = $_SESSION['Phone'];
$department = $_SESSION['Department'];
$role = $_SESSION['role'];

$stmt = $pdo->prepare("SELECT ProfilePic FROM users WHERE ID = :ID");
$stmt->bindParam(':ID', $id);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$profilePicture = $user['ProfilePic'] ?? '../static/user.jpg'; //default

// print_r($profilePicture);

switch ($department) {
  case 'CS':
    $department = "Computer Science";
    break;
  case "CE":
    $department = "Computer Engineering";
    break;
  case "IS":
    $department = "Information Systems";
    break;
  default:
    $department = "Not set";
}

if ($_SESSION['DoB'] != null) {
  $Dob = $_SESSION['DoB'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head> 
  <meta charset="UTF-8" />  
  <link href="../css/profile.css" rel="stylesheet">
  <title>Profile</title>   
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet"> 

</head>
<body>
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
                  <a class="nav-link" aria-current="page" href="../index.php">Home</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link active" href="#">Profile</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="../dashboard.php">Dashboard</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="../AboutUs.html">About Us</a>
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

    <div class="row">
      <div class="col-sm-2 left-box d-flex flex-column justify-content-center align-items-center ">
        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
          <a class="nav-link active" id="v-pills-profile-tab" data-bs-toggle="pill" href="#v-pills-profile" role="tab"
            aria-controls="v-pills-profile" aria-selected="true">Profile</a>
          </a>
          <a class="nav-link" id="v-pills-bookings-tab" data-bs-toggle="pill" href="#v-pills-bookings" role="tab"
            aria-controls="v-pills-bookings" aria-selected="false">Bookings</a>
          </a>
          <a class="nav-link" id="v-pills-settings-tab" data-bs-toggle="pill" href="#v-pills-settings" role="tab"
            aria-controls="v-pills-settings" aria-selected="false">Settings</a>
          </a>
          <a class="nav-link" id="v-pills-help-tab" data-bs-toggle="pill" href="#v-pills-help" role="tab"
            aria-controls="v-pills-help" aria-selected="false">Help</a>
          </a>
        </div>
      </div>
      <div class="col-sm-9 right-box h-100">
        <div class="tab-content" id="v-pills-tabContent">
          <div class="tab-pane fade show active" id="v-pills-profile" role="tabpanel"
            aria-labelledby="v-pills-profile-tab">

            <div class="row d-flex justify-content-center align-items-center m-2 g-3">
              <div class="col-sm-4">
                <div class="card mb-3 border rounded-4 d-flex justify-content-center align-items-center"
                  id="profile-card">
                  <!-- Profile Pictures here -->
                  <img class="card-img-top rounded-circle mx-auto d-block" src="<?php echo $profilePicture?>" alt="pfp"
                    style="width: 100px; height: 100px; object-fit: cover;" />


                  <div class="card-body h-100">
                    <h5 class="card-title d-flex justify-content-center"><?php echo $username; ?></h5>
                    <p class="card-text d-flex justify-content-center">Role: <?php echo $role?></p>
                  </div>
                </div>


              </div>
              <div class="col-sm-8 ">
                <form action="">
                  <fieldset disabled>
                    <div class="row d-flex justify-content-center align-items-center m-3">
                      <div class="col-lg-10 ">
                        <div class="card p-1 d-flex justify-content-center align-items-center m-3 user-info-card">
                          <div class="mb-3">
                            <h5>Department</h5>
                            <p><?php echo $department; ?></p>
                          </div>
                          <div class="row mb-3">
                            <div class="col-lg-7">
                              <h5>Email</h5>
                              <p><?php echo $email ?></p>
                            </div>
                            <div class="col-lg-5">
                              <h5>Phone</h5>
                              <p><?php echo $phone ?></p>
                            </div>
                          </div>
                          <div class="mb-3">
                            <h5>Date of Birth</h5>
                            <input type="date" id="dob" class="form-control" value="<?php echo $Dob; ?>" />
                          </div>
                        </div>
                      </div>
                    </div>
                  </fieldset>


                </form>

              </div>

            </div>

          </div>

          <!-- ---------------------------------Bookings---------------------------------------- -->
          <div class="tab-pane fade" id="v-pills-bookings" role="tabpanel" aria-labelledby="v-pills-bookings-tab">
            <div class="row d-flex justify-content-center align-items-center m-2 g-3">
              <div class="col-sm-5">
                <div class="card mb-3 border rounded-4 d-flex justify-content-center align-items-center">
                  <!-- Profile Pictures here -->
                  <img class="card-img-top rounded-circle mx-auto d-block" src="<?php echo $profilePicture?>" alt="pfp"
                    style="width: 100px; height: 100px; object-fit: cover;" />
                  <div class="card-body">
                    <h5 class="card-title d-flex justify-content-center"><?php echo $username; ?></h5>
                    <p class="card-text d-flex justify-content-center">Role: <?php echo $role?></p>
                    <p class="card-text"><small>Last time booked: 3 months ago</small></p>
                  </div>
                </div>


              </div>
              <div class="col-sm-7">
              <?php

    // Retrieve the username from session
    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
    } else {
        // If the username is not set, redirect to login page
        header('Location: login.php');
        exit();
    }

    include('../database/db.php');

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
                            <a href="../userRoomsUsage.php">View Room Usage Chart</a>
                        </div>
                        <div class="chart" id="most-timing">
                            <a href="../userTimingUsage.php">View Timing Chart</a>
                        </div>
                    </div>
                </div>



              </div>
            </div>
          </div>

          

          <!-- ----------------------------------SETTINGS--------------------------------------- -->
          <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
  <div class="container">
    <form action="settings.php" method="post" enctype="multipart/form-data">
      <div class="row g-3 d-flex justify-content-center align-items-center m-2 g-3">
        <!-- Account Settings -->
        <div class="col-md-4">
          <div class="card h-100">
            <div class="card-header bg-dark text-white">
              Account Settings
            </div>
            <div class="card-body">
              <div class="mb-3">
                <label for="username" class="form-label">Change username</label>
                <input type="text" class="form-control" name="username" id="username"
                  placeholder="Enter new username" value="<?php echo $username; ?>" />
              </div>
              <div class="mb-3">
                <label class="form-label">Edit Profile Picture</label>
                <img id="imagePreview" class="card-img-top rounded-circle mx-auto d-block mb-3"
                  src="<?php echo $profilePicture; ?>" alt="pfp"
                  style="width: 100px; height: 100px; object-fit: cover;" />
                <input type="file" name="fileToUpload" id="fileToUpload" onchange="previewImage(event)">
              </div>
            </div>
          </div>
        </div>

        <!-- Preferences -->
        <div class="col-md-4">
          <div class="card h-100">
            <div class="card-header bg-dark text-white">
              Personal Information
            </div>
            <div class="card-body">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="field" id="CS" value="CS" 
                <?php if ($department === 'Computer Science') echo 'checked'; ?>>
                <label class="form-check-label" for="CS">Computer Science</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="field" id="CE" value="CE"
                <?php if ($department === 'Computer Engineering') echo 'checked'; ?>>
                <label class="form-check-label" for="CE">Computer Engineering</label>
              </div>
              <div class="form-check mb-3">
                <input class="form-check-input" type="radio" name="field" id="IS" value="IS"
                <?php if ($department === 'Information Systems') echo 'checked'; ?>>
                <label class="form-check-label" for="IS">Information Systems</label>
              </div>

              <div class="mb-3">
                <label for="DoB" class="form-label">Choose Date of Birth</label>
                <input type="date" class="form-control" name="DoB" id="DoB" placeholder="Enter new DoB"
                  value="<?php echo $Dob ?>" />
              </div>
              <div class="mb-3">
                <label for="phone" class="form-label">Change Phone number</label>
                <input type="text" class="form-control" name="phone" id="phone"
                  placeholder="Enter new Phone number" value="<?php echo $phone; ?>" />
              </div>
            </div>
          </div>
        </div>

        <!-- Privacy Settings  -->
        <div class="col-md-4" >

        <div class="card h-100" id="VerificationPass">
        <div class="card-header bg-dark text-white">
              Privacy Settings
            </div>
            <div class="mt-3 mb-2">
              <label for="verpassword" class="form-label">Verify Password</label>
              <input type="password" class="form-control" name="verpassword" id="verpassword"
                placeholder="Enter your password" />
            </div>
            <div class="mt-3 mb-2">
            <button type="button" class="btn btn-primary" id="verifyPasswordBtn">Verify</button>
        </div>


        </div>
          <div class="card h-100" id="privacySettings" style="display: none;">
            <div class="card-header bg-dark text-white">
              Privacy Settings
            </div>
            <div class="mt-3 mb-2">
              <label for="email" class="form-label">Change Linked Email</label>
              <input type="email" class="form-control" name="email" id="email" placeholder="Enter new email"
                value="<?php echo $email; ?>" />
            </div>
            <div class="mt-3 mb-2">
              <label for="password" class="form-label">Change Password</label>
              <input type="password" class="form-control" name="password" id="password"
                placeholder="New password" />
            </div>
            <div class="mt-3 mb-2">
              <label for="rp-password" class="form-label">Repeat Password</label>
              <input type="password" class="form-control" name="rp-password" id="rp-password"
                placeholder="Repeated password" />
            </div>
          </div>
        </div>
      </div>

      <!-- Submit Button -->
      <div class="mt-4">
        <button type="submit" class="btn btn-primary">Save Changes</button>
      </div>
    </form>
  </div>
</div>

          <!-- ------------------------------------------------------------------------- --> 



          <div class="tab-pane fade" id="v-pills-help" role="tabpanel" aria-labelledby="v-pills-help-tab">
            <div class="row">
              <div class="col-sm-5">
                <div class="card mb-3 border rounded-4 d-flex justify-content-center align-items-center">
                  <div class="card-body"> 
                   
                  Contact Us at our Emails :
            <ul>
              <li>Help.123123@info.com</li>
              <li>Help.9910@info.com</li>
            </ul> 
            Or directly at our call center :
            <ul>
              <li>+937 1234 5678 </li>
              <li>+937 8765 4321 </li>
            </ul> 

                     </div>
                    </div>
                  </div>
                </div>
              </div>   
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
    <script src="pfpView.js"></script>

</body>

</html>