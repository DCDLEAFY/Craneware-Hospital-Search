
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

</head>
<!-- End of head -->
<!-- Start of body of the website-->
<body>

  <!-- Navigation bar for the website-->
  <?php include_once 'navigationBar.php'; ?>


  <!-- Two columns -->
  <div style="width: 100%; padding-right: 15px; padding-left: 15px; margin-right: auto; margin-left: auto;">
  <!-- First div -->
    <div class="col-lg-12 text-left" style="width: 30%">
    <?php
        $procedureD=$_POST['procedureList'];
        $stateD=$_POST['stateList'];
            // SQL query to receive the details of the available hospitals from the database
            $sql = "SELECT providerId, providerName, providerAddress, providerCity, providerState, providerZipCode, regionDescription, averageTotalPayment FROM 19agileteam12db.data WHERE providerState = \"$stateD\" AND procedures = \"$procedureD\" ORDER BY averageTotalPayment ASC;";
            $result = $con->query($sql);
            while ($row = mysqli_fetch_array($result)){
              echo "Hospital ID: " . $row['providerId']; 
              echo "<br>Hospital Name: " . $row['providerName'];
              echo "<br>Address: " . $row['providerAddress'] . " " . $row['providerCity'] . " " .  $row['providerState'] . " " . $row['providerZipCode'] . " " . $row['regionDescription'];
              echo "<br>Price: " .  $row['averageTotalPayment'] . "<br>";
            }
              mysqli_next_result($con);

    ?>
    </div>
  <!-- Second div -->
    <div class="col-lg-12 text-center">
      <div style= " width: 100%; height: 580px " id="mapContainer">
              <script src="js/map.js"></script>
        </div>
    </div>
  </div>
  <!-- Page Content -->
  <div class="container">
    <div class="row">
      <div class="col-lg-12 text-center">
      <!-- Title of the website -->
        <h1 class="mt-5"> Map navigation </h1>
        <!-- Getting the procedure and state parameters from the index.php website -->
        <?php
            $procedureD=$_POST['procedureList'];
            $stateD=$_POST['stateList'];
            echo $procedureD . "<br>" . $stateD;
        ?>
        <!-- Start of the table container, to contain the details of the available hospitals depending on the procedure and the state -->
        <div class="table-container">
          <?php
            // SQL query to receive the details of the available hospitals from the database
            $sql = "SELECT providerId, providerName, providerAddress, providerCity, providerState, providerZipCode, regionDescription, averageTotalPayment FROM 19agileteam12db.data WHERE providerState = \"$stateD\" AND procedures = \"$procedureD\" ORDER BY averageTotalPayment ASC;";
            $result = $con->query($sql);
            echo "<table class=\"table table-striped table-bordered\">
              <thead class=\"thead-dark\">
                <tr>
                  <th scope=\"col\">Provider ID</th>
                  <th scope=\"col\">Provider Name</th>
                  <th scope=\"col\">Address</th>
                  <th scope=\"col\">City</th>
                  <th scope=\"col\">State</th>
                  <th scope=\"col\">Zip Code</th>
                  <th scope=\"col\">Region Description</th>
                  <th scope=\"col\">Average Total Payment</th>
                </tr>
              </thead>
              <tbody>";
            // While loop used to list the available hospitals and their details on the table
            while ($row = mysqli_fetch_array($result)){
              echo "<tr>";
              echo "<td>" . $row['providerId'] . "</td>";
              echo "<td>" . $row['providerName'] . "</td>";
              echo "<td>" . $row['providerAddress'] . "</td>";
              echo "<td>" . $row['providerCity'] . "</td>";
              echo "<td>" . $row['providerState'] . "</td>";
              echo "<td>" . $row['providerZipCode'] . "</td>";
              echo "<td>" . $row['regionDescription'] . "</td>";
              echo "<td>" . $row['averageTotalPayment'] . "</td>";
              echo "</tr>";
              }
              mysqli_next_result($con);
              echo "</tbody>";
              echo "</table>";
          ?>
        <ul class="list-unstyled">
        <br>
          <li>Bootstrap 4.3.1</li>
          <li>jQuery 3.4.1</li>
        </ul>
      </div>
    </div>
  </div>
  <!-- End of table container -->
  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.slim.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>
<!-- End of body -->
</html>
<!-- End of HTML file -->
