
<!DOCTYPE html>
<html lang="en">

<?php include 'connection.php'; ?>

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
        <h1 class="mt-5"> Map navigation </h1>

        <?php
            $procedureD=$_POST['procedureList'];
            $stateD=$_POST['stateList'];
            echo $procedureD . "<br>" . $stateD;
        ?>

        <div class="table-container">
          <?php
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
