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
        <!-- Title of the website -->
        <h1 class="mt-5"> Map navigation </h1>
        <!-- Getting the procedure code and state parameters from the index.php website -->
        <?php
            $procedureIDD=$_POST['procedureIDList'];
            $stateIDD=$_POST['stateListBasedOnProcedureID'];
            // SQL query to find the procedure that the patient chose in the index.php based on the procedure code provided by the index.php
            $sql = "SELECT DISTINCT procedureID, procedures FROM 19agileteam12db.data WHERE procedureID = \"$procedureIDD\";";
            $result1 = $con->query($sql);
            $row = mysqli_fetch_array($result1);
            $procedureName = $row['procedures'];
            // Printing the procedure code, the procedure name and the state ID
            echo $procedureIDD . "  " . $procedureName . "<br>" . $stateIDD;
        ?>
        <!-- Start of the table container, to contain the details of the available hospitals depending on the procedure code/ID and the state -->
        <div class="table-container">
          <?php
          // SQL query to receive the details of the available hospitals from the database
          $sql = "SELECT providerId, providerName, providerAddress, providerCity, providerState, providerZipCode, regionDescription, averageTotalPayment FROM 19agileteam12db.data WHERE providerState = \"$stateIDD\" AND procedureID = \"$procedureIDD\" ORDER BY averageTotalPayment ASC;";
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
