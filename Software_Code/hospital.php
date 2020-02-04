
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
  <?php
            $procedureD=$_POST['procedureList'];
            $stateD=$_POST['stateList'];
            // SQL query to find the procedure that the patient chose in the index.php based on the procedure code provided by the index.php
            $sql = "SELECT DISTINCT procedureID, procedures FROM 19agileteam12db.data WHERE procedures = \"$procedureD\";";
            $result1 = $con->query($sql);
            $row = mysqli_fetch_array($result1);
            $procedureID = $row['procedureID'];
        ?>
  <br>
  <!-- Main Body -->
  <div class="container">
  <!-- Table used to show the procedure to the patient -->
    <table class="table table-striped table-borderless">
      <thead class="thead-dark">
        <tr>
          <th>Procedure code:</th>
          <td> 
          <?php
              echo $procedureID;
          ?>
          </td>
        </tr>
        <tr>
          <th>Procedure:</th>
          <td> 
          <?php
              echo $procedureD;
          ?>
          </td>
        </tr>
      </thread>
    </table>
    <!-- First div -->
      <div class="col-lg-12 text-center">
        <div style= " width: 100%; height: 580px" id="mapContainer">
                <script src="js/map.js"></script>
          </div>
      </div>
      
    <!-- Second div -->
    <div class="col-lg-12 text-left" >
      <?php
        $procedureD=$_POST['procedureList'];
        $stateD=$_POST['stateList'];
        $rank=1;
        // SQL query to receive the details of the available hospitals from the database
        $sql = "SELECT providerId, providerName, providerAddress, providerCity, providerState, providerZipCode, regionDescription, averageTotalPayment FROM 19agileteam12db.data WHERE providerState = \"$stateD\" AND procedures = \"$procedureD\" ORDER BY averageTotalPayment ASC;";
        $result = $con->query($sql);
        //Start of the table container, to contain the details of the available hospitals depending on the procedure and the state
        // While loop used to list the available hospitals and their details on the table
        while ($row = mysqli_fetch_array($result)){
          echo "
          <br>
          <div style=\"border: 2px solid grey; border-radius:25px\">
          <br>
          <table class=\"table table-striped table-borderless\">
          <thead class=\"thead-dark\">
            <tr>
              <td style=\"width:10%\"></td>
              <th style=\"width:25%\">Hospital Name:</th>
              <td> " . $row['providerName'] . " </td>
            </tr>
            <tr>
              <td><b> <div style=\"border: 2px solid green; text-align:center; border-radius:25px\">" . $rank . "<div><b></td>
              <th>Address:</th>
              <td> " .  $row['providerAddress'] . " " . $row['providerCity'] . " " . $row['providerZipCode'] . " " . $row['regionDescription'] . "</td>
            </tr>
            <tr>
              <td></td>
              <th>Price:</th>
              <td> $ " . $row['averageTotalPayment'] . "</td>
            </tr>
          </thread>
          </table>
          </div>";
          $rank=$rank+1;
        }
        mysqli_next_result($con);
      ?>
    </div>
      <ul class="list-unstyled"  style="text-align:center">
          <br>
            <li>Bootstrap 4.3.1</li>
            <li>jQuery 3.4.1</li>
      </ul>
  </div>

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.slim.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>
<!-- End of body -->
</html>
<!-- End of HTML file -->
