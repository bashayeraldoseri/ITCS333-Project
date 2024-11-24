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
</head>

<body>


  <div class="container-fluid p-4">
    <div class="row">
      <div class="col-sm-2 left-box">
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

            <div class="row">
              <div class="col-sm-3">
                <div class="card mb-3 border rounded-4 d-flex justify-content-center align-items-center">
                  <!-- Profile Pictures here -->
                  <img class="card-img-top rounded-circle mx-auto d-block" src="../static/user.jpg" alt="pfp"
                    style="width: 100px; height: 100px; object-fit: cover;" />
                  <div class="card-body">
                    <h5 class="card-title d-flex justify-content-center">Name</h5>
                    <p class="card-text d-flex justify-content-center">Role: Student</p>
                  </div>
                </div>


              </div>
              <div class="col-sm-5">
                <form action="">
                  <fieldset disabled>
                    <div class="row d-flex justify-content-center align-items-center m-3" >
                      <div class="col-lg-10">
                        <div class="form-group ">
                          <input type="text" id="Department: " class="form-control" placeholder="Department" />
                          <input type="text" id="email: " class="form-control" placeholder="Email" />


                        </div>
                      </div>
                    </div>
                  </fieldset>
                </form>
              </div>

            </div>

          </div>

          <!-- ------------------------------------------------------------------------- -->
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

          <!-- ------------------------------------------------------------------------- -->
          <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
            jj
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