<!DOCTYPE html>
<html lang="en">

<?php include_once 'connection.php'; ?>

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
            <a class="nav-link" href="index.php">Home
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
        <h1 class="mt-5"> Welcome </h1>
        <!-- Form to view/list hospitals -->
        <br>
        <form action='hospital.php' method=post style="background-color:#ebebe0; border-radius: 25px">
        <!-- Procedures(Unique) to be selected by the user will be filled out by the database via php -->
          <br>
          <h5>
          What procedure are you looking for?
          </h5>
          <br><br>
          <select class="custom-select"  id="inputGroupSelect04" name="procedureList" style="width:80%; border-radius: 25px">
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
          <br>
          <h5>
          Which State code are you in?
          </h5>
          <br><br>
          <select class="custom-select" id="inputGroupSelect04" name="stateList" style="width:80%; border-radius: 25px;">
            <option value=""> Select state </option>
            <?php
             $sql = 'SELECT DISTINCT providerState FROM 19agileteam12db.data ORDER BY providerState ASC';
             $result = $con->query($sql);
             foreach ($result as $state){
               echo '<option value="'.$state["providerState"].'">'.$state["providerState"].' </option>';
             }
             mysqli_next_result($con);
            ?>
          </select>
          <br><br><br>
          <button type="submit" class="btn btn-secondary" style="border-radius: 25px">Submit</button>
          <br><br>
          </select>
          <br>
        </form>
        <br><br>
        <form action='hospitalBasedOnProcedureID.php' method=post style="background-color:#ccccff; border-radius: 25px">
          <!-- Procedures(Unique) code to be selected by the user will be filled out by the database via php -->
          <br>
          <h5>
          You can also search for a procedure using a procedure code:
          </h5>
          <br><br>
          <select class="custom-select" id="inputGroupSelect04" name="procedureIDList" style="width:80%; border-radius: 25px">
            <option value=""> Select a procedure code </option>
            <?php
             $sql = 'SELECT DISTINCT procedureID FROM 19agileteam12db.data ORDER BY procedureID ASC';
             $result = $con->query($sql);
             foreach ($result as $procedureID){
               echo '<option value="'.$procedureID["procedureID"].'">'.$procedureID["procedureID"].' </option>';
             }
            ?>
            </select>
            <br>
            <!-- States(Unique) will be selected via php from the database so the user can select it-->
            <br>
            <h5>
            Which State code are you in?
            </h5>
            <br><br>
            <select class="custom-select" id="inputGroupSelect04" name="stateListBasedOnProcedureID" style="width:80%; border-radius: 25px">
              <option value=""> Select state </option>
              <?php
              $sql = 'SELECT DISTINCT providerState FROM 19agileteam12db.data ORDER BY providerState ASC';
              $result = $con->query($sql);
              foreach ($result as $stateID){
                echo '<option value="'.$stateID["providerState"].'">'.$stateID["providerState"].' </option>';
              }
              mysqli_next_result($con);
              ?>
            </select>
            <br><br><br>
            <button type="submit" class="btn btn-secondary" style="border-radius: 25px">Submit</button>
            <br><br><br>
          
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