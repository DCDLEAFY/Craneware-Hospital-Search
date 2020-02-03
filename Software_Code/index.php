<!DOCTYPE html>
<!-- Language the website is written in -->
<html lang="en">
<!-- Including the connection.php file that connects the website to the database -->
<?php include_once 'connection.php'; ?>
<!-- Start of head -->
<head>
<!-- This contains the data that will be shown on the tab's title in the browser -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Craneware Maps</title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Ren's working here -->
      <!-- Here Maps Library -->
      <meta name="viewport" content="initial-scale=1.0,
            width=device-width" /> <!-- mobile compatibiity-->
    <script src="https://js.api.here.com/v3/3.1/mapsjs-core.js"
            type="text/javascript" charset="utf-8"></script>
    <script src="https://js.api.here.com/v3/3.1/mapsjs-service.js"
            type="text/javascript" charset="utf-8"></script>
    <script src="https://js.api.here.com/v3/3.1/mapsjs-ui.js"
            type="text/javascript" charset="utf-8"></script> <!-- map UI-->
    <script src="https://js.api.here.com/v3/3.1/mapsjs-mapevents.js"
            type="text/javascript" charset="utf-8"></script> <!-- enables interactve map-->
    <link rel="stylesheet" type="text/css"
          href="https://js.api.here.com/v3/3.1/mapsjs-ui.css" />


  <script src='https://api.mapbox.com/mapbox-gl-js/v1.7.0/mapbox-gl.js'></script>
  
  <link href='https://api.mapbox.com/mapbox-gl-js/v1.7.0/mapbox-gl.css' rel='stylesheet' />

</head>
<!-- End of head -->
<!-- Start of body of the website-->
<body>
  <!-- Navigation bar for the website-->
  <?php include_once 'navigationBar.php'; ?>

  <!-- Page Content -->
  <div class="container">
    <div class="row">
      <div class="col-lg-12 text-center">
        <h1 class="mt-5"> Welcome </h1>
        <!-- Form to view/list hospitals based on procedure name and state -->
        <br>
        <form action='hospital.php' method=post style="background-color:#ebebe0; border-radius: 25px">
        <!-- Procedures(Unique) to be selected by the user will be filled out by the database via php -->
          <br>
          <h5>
          What procedure are you looking for?
          </h5>
          <br><br>
          <!-- Select class allowing the patients to choose a procedure -->
          <select class="custom-select"  id="inputGroupSelect04" name="procedureList" style="width:80%; border-radius: 25px">
            <option value=""> Select a procedure </option>
            <!-- SQL query that gets the available procedures from the database -->
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
          <!-- Select class allowing the users to choose a state -->
          <select class="custom-select" id="inputGroupSelect04" name="stateList" style="width:80%; border-radius: 25px;">
            <option value=""> Select state </option>
            <!-- SQL query that gets the available states from the database -->
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
          <!-- Submit button to submit the form -->
          <button type="submit" class="btn btn-secondary" style="border-radius: 25px">Search</button>
         <br><br><br>
        </form>
        <!-- End of first form -->
        <!-- Form to view/list hospitals based on procedure code and state -->
        <br><br>
        <form action='hospitalBasedOnProcedureID.php' method=post style="background-color:#ccccff; border-radius: 25px">
          <!-- Procedures(Unique) code to be selected by the user will be filled out by the database via php -->
          <br>
          <h5>
          You can also search for a procedure using a procedure code:
          </h5>
          <br><br>
          <!-- Select class allowing the users to choose a procedure code -->
          <select class="custom-select" id="inputGroupSelect04" name="procedureIDList" style="width:80%; border-radius: 25px">
            <option value=""> Select a procedure code </option>
            <!-- SQL query that gets the available procedure codes from the database -->
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
            <!-- Select class allowing the users to choose a state -->
            <select class="custom-select" id="inputGroupSelect04" name="stateListBasedOnProcedureID" style="width:80%; border-radius: 25px">
              <option value=""> Select state </option>
              <!-- SQL query that gets the available states from the database -->
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
            <!-- Submit button to submit the form -->
            <button type="submit" class="btn btn-secondary" style="border-radius: 25px">Search</button>
            <br><br><br>
        </form>
        <br>
         <!-- Ren's working here -->
        <div style="width: 100%; height: 480px " id="mapContainer">
          <script src="js/map.js"></script>
        </div>
        <ul class="list-unstyled">
        <br>
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
<!-- End of body -->
</html>
<!-- End of HTML file -->