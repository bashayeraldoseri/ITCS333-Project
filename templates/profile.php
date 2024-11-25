<?php
session_start();
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Profile</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
  <link rel="stylesheet" href="../css/styles.css" />
  <link rel="stylesheet" href="../css/profile.css">
</head>

<body>


  <div class="container-fluid">
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
                    <a class="nav-link" href="#">Dashboard</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="login.html">Login</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="register.html">Register</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#">About Us</a>
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
      <div class="col-sm-10 right-box">
        <div class="tab-content" id="v-pills-tabContent">
          <div class="tab-pane fade show active" id="v-pills-profile" role="tabpanel"
            aria-labelledby="v-pills-profile-tab">

            <div class="row d-flex justify-content-center align-items-center m-2">
              <div class="col-sm-4">
                <div class="card mb-3 border rounded-4 d-flex justify-content-center align-items-center"
                  id="profile-card">
                  <!-- Profile Pictures here -->
                  <img class="card-img-top rounded-circle mx-auto d-block" src="../static/user.jpg" alt="pfp"
                    style="width: 100px; height: 100px; object-fit: cover;" />
                  <div class="card-body">
                    <h5 class="card-title d-flex justify-content-center">Name</h5>
                    <p class="card-text d-flex justify-content-center">Role: Student</p>
                  </div>
                </div>


              </div>
              <div class="col-sm-7 ">
                <form action="">
                  <fieldset disabled>
                    <div class="row d-flex justify-content-center align-items-center m-3">
                      <div class="col-lg-10">
                        <div class="card p-3 d-flex justify-content-center align-items-center">
                          <div class="mb-3">
                            <h5>Department</h5>
                            <p>Computer Science</p>
                          </div>
                          <div class="row mb-3">
                            <div class="col-md-6">
                              <h5>Email</h5>
                              <p>user@example.com</p>
                            </div>
                            <div class="col-md-6">
                              <h5>Phone</h5>
                              <p>+123456789</p>
                            </div>
                          </div>
                          <div class="mb-3">
                            <h5>Date of Birth</h5>
                            <input type="date" id="dob" class="form-control" value="1995-01-01" />
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
            <div class="row">
              <div class="col-sm-5">
                <div class="card mb-3 border rounded-4 d-flex justify-content-center align-items-center">
                  <!-- Profile Pictures here -->
                  <img class="card-img-top rounded-circle mx-auto d-block" src="../static/user.jpg" alt="pfp"
                    style="width: 100px; height: 100px; object-fit: cover;" />
                  <div class="card-body">
                    <h5 class="card-title d-flex justify-content-center">Name</h5>
                    <p class="card-text d-flex justify-content-center">Role: Student</p>
                    <p class="card-text"><small>Last time booked: 3 months ago</small></p>
                  </div>
                </div>


              </div>
            </div>
          </div>

          <!-- ----------------------------------SETTINGS--------------------------------------- -->
          <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
            <div class="container">
              <form>
                <div class="row g-3">
                  <!-- Account Settings -->
                  <div class="col-md-4">
                    <div class="card h-100">
                      <div class="card-header bg-dark text-white">
                        Account Settings
                      </div>
                      <div class="card-body">
                        <div class="mb-3">
                          <label for="username" class="form-label">Change username</label>
                          <input type="text" class="form-control" id="username" placeholder="Enter new username"
                            value="current_user" />
                        </div>
                        <div class="mb-3">
                          <label for="email" class="form-label">Change Linked Email</label>
                          <input type="email" class="form-control" id="email" placeholder="Enter new email"
                            value="user@example.com" />
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Preferences -->
                  <div class="col-md-4">
                    <div class="card h-100">
                      <div class="card-header bg-dark text-white">
                        Edit Personal Information
                      </div>
                      <div class="card-body">
                      <div class="mb-3">
                          <label for="Dob" class="form-label">Choose Date of Birth</label>
                          <input type="date" class="form-control" id="DoB" placeholder="Enter new DoB"
                            value="user@example.com" />
                        </div>

                        <div class="mb-3">
                          <label for="Phone" class="form-label">Change Phone number</label>
                          <input type="number" class="form-control" id="username" placeholder="Enter new Phone number"
                            value="current_user" />
                        </div>
                      </div>
                    
                    </div>
                  </div>

                  <!-- Privacy Settings -->
                  <div class="col-md-4">
                    <div class="card h-100">
                      <div class="card-header bg-dark text-white">
                        Privacy Settings
                      </div>
                      <div class="mt-3">
                          <label for="password" class="form-label">Change Password</label>
                          <input type="password" class="form-control" id="password"
                            placeholder="Change your password" />
                        </div>
                        <div class="mt-3 mb-3">
                          <label for="rp-password" class="form-label">Repeat Password</label>
                          <input type="Password" class="form-control" id="rp-password"
                            placeholder="Change your password" />
                        </div>
                        <div class="form-check mb-3">
                          <input class="form-check-input" type="checkbox" id="trackActivity" checked />
                          <label class="form-check-label" for="trackActivity">
                            Allow tracking of my activity
                          </label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Save Changes Button -->
                <div class="d-flex justify-content-center mt-4">
                  <button type="submit" class="btn btn-success">Save Changes</button>
                </div>
              </form>
            </div>
          </div>

          <!-- ------------------------------------------------------------------------- -->
          <div class="tab-pane fade" id="v-pills-help" role="tabpanel" aria-labelledby="v-pills-help-tab">
            pn
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
</body>

</html>

<?php
include('../database/db.php');
?>