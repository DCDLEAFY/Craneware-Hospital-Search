<!DOCTYPE html>
<html lang="en">

<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
$servername="silva.computing.dundee.ac.uk";
$username="19agileteam12";
$password="2437.at12.7342";

/* Attempt to connect to MySQL database */
$con = mysqli_connect($servername, $username, $password);

// Check connection
if($con === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

?>


<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Craneware Maps</title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top">
    <div class="container">
      <a class="navbar-brand" href="#">Craneware</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <a class="nav-link" href="#">Home
              <span class="sr-only">(current)</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Services</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Contact</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Page Content -->
  <div class="container">
    <div class="row">
      <div class="col-lg-12 text-center">
        <h1 class="mt-5"> Map navigation </h1>
        <!-- Form to view/list hospitals -->
        <form>
        <!-- Procedures(Unique) to be selected by the user will be filled out by the database via php -->
          What procedure do you need?<br>
          <select name="procedureList">
            <option value=""> Select a procedure </option>
            <?php
             $sql = 'SELECT DISTINCT procedures FROM 19agileteam12db.data ORDER BY procedures ASC';
             $result = $con->query($sql);
             foreach ($result as $procedure){
               echo '<option value="'.$procedure["procedures"].'">'.$procedure["procedures"].' </option>';
             }
            ?>
          </select>
          <br>
          <!-- States(Unique) will be selected via php from the database so the user can select it-->
          Which State code are you in?<br>
          <select name="stateList">
            <option value=""> Select state </option>
            <?php
             $sql = 'SELECT DISTINCT providerState FROM 19agileteam12db.data ORDER BY providerState ASC';
             $result = $con->query($sql);
             foreach ($result as $state){
               echo '<option value="'.$state["providerState"].'">'.$state["providerState"].' </option>';
             }
            ?>
          </select>
        </form>

        <ul class="list-unstyled">
          <li>Bootstrap 4.3.1</li>
          <li>jQuery 3.4.1</li>
        </ul>
      </div>
    </div>
  </div>

  
  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.slim.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>
