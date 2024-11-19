<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ITCS333 Project</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
  <link rel="stylesheet" href="css/styles.css">
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
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="templates/profile.php">Profile</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="templates/dashboard.html">Dashboard</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="templates/login.html">Login</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="templates/register.html">Register</a>
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


    <main>
      <div class="row g-50">
        <div class="col-lg-3">
          <!-- Collapsible Search Menu -->
          <div class="accordion" id="searchAccordion">
            <div class="accordion-item">
              <h2 class="accordion-header" id="searchHeading">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#searchArea"
                  aria-expanded="true" aria-controls="searchArea">
                  Search
                </button>
              </h2>
              <div id="searchArea" class="accordion-collapse collapse show" aria-labelledby="searchHeading"
                data-bs-parent="#searchAccordion">
                <div class="accordion-body p-3">
                  <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" />
                    <button class="btn btn-outline-success" type="submit">
                      Search
                    </button>
                  </form>
                </div>

                <div class="according-body p-2">
                  <label> Choose a department: </label>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1" />
                    <label class="form-check-label" for="inlineCheckbox1">IS</label>
                  </div>

                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="option2" />
                    <label class="form-check-label" for="inlineCheckbox2">CS</label>
                  </div>

                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox3" value="option3" />
                    <label class="form-check-label" for="inlineCheckbox3">CE</label>
                  </div>
                </div>

                <div class="according-body p-3">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1"
                      value="option1" checked>
                    <label class="form-check-label" for="exampleRadios1">
                      Second Floor
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2"
                      value="option2">
                    <label class="form-check-label" for="exampleRadios2">
                      First Floor
                    </label>
                  </div>
                  <div class="form-check disabled">
                    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios3"
                      value="option3">
                    <label class="form-check-label" for="exampleRadios3">
                      Ground Floor
                    </label>
                  </div>
                </div>

                <div class="according-body p-2">
                  <form class="form-inline" role="form">
                    <div class="form-group">
                      <label class="filter-col" style="margin-right:0;" for="pref-perpage">Capacity</label>
                      <select id="pref-perpage" class="form-control">
                        <option selected="selected" value="10">10</option>
                        <option value="15">15</option>
                        <option value="20">20</option>
                        <option value="30">30</option>
                        <option value="40">40</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                      </select>
                    </div> <!-- form group [rows] -->
                </div>
              </div>
            </div>
          </div>
        </div>


        <div class="col-lg-3">
          <div class="card" style="width: 18rem">
            <div class="card-body">
              <h5 class="card-title">IS Class</h5>
              <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
              <p class="card-text">
                Some quick example text to build on the card title and make up
                the bulk of the card's content.
              </p>
              <a href="#" class="card-link">View</a>
              <a href="#" class="card-link">Book</a>
            </div>
          </div>
        </div>
        <div class="col-lg-3">
          <div class="card" style="width: 18rem">
            <div class="card-body">
              <h5 class="card-title">CS Class</h5>
              <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
              <p class="card-text">
                Some quick example text to build on the card title and make up
                the bulk of the card's content.
              </p>
              <a href="#" class="card-link">View</a>
              <a href="#" class="card-link">Book</a>
            </div>
          </div>
        </div>
        <div class="col-lg-3">
          <div class="card" style="width: 18rem">
            <div class="card-body">
              <h5 class="card-title">CE Class</h5>
              <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
              <p class="card-text">
                Some quick example text to build on the card title and make up
                the bulk of the card's content.
              </p>
              <a href="#" class="card-link">View</a>
              <a href="#" class="card-link">Book</a>
            </div>
          </div>
        </div>
      </div>
    </main>

    <footer></footer>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
</body>

</html>