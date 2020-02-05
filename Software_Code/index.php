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
  <style>
    .slidecontainer {
      width: 100%;
    }

    .slider {
      -webkit-appearance: none;
      width: 100%;
      height: 25px;
      background: #d3d3d3;
      outline: none;
      opacity: 0.7;
      -webkit-transition: .2s;
      transition: opacity .2s;
    }

    .slider:hover {
      opacity: 1;
    }

    .slider::-webkit-slider-thumb {
      -webkit-appearance: none;
      appearance: none;
      width: 25px;
      height: 25px;
      background: #4CAF50;
      cursor: pointer;
    }

    .slider::-moz-range-thumb {
      width: 25px;
      height: 25px;
      background: #4CAF50;
      cursor: pointer;
    }
  </style>
  <title>Craneware Maps</title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Ren's working here -->
  <!-- Here Maps Library -->
  <meta name="viewport" content="initial-scale=1.0,
            width=device-width" /> <!-- mobile compatibiity-->
  <script src="https://js.api.here.com/v3/3.1/mapsjs-core.js" type="text/javascript" charset="utf-8"></script>
  <script src="https://js.api.here.com/v3/3.1/mapsjs-service.js" type="text/javascript" charset="utf-8"></script>
  <script src="https://js.api.here.com/v3/3.1/mapsjs-ui.js" type="text/javascript" charset="utf-8"></script> <!-- map UI-->
  <script src="https://js.api.here.com/v3/3.1/mapsjs-mapevents.js" type="text/javascript" charset="utf-8"></script> <!-- enables interactve map-->
  <link rel="stylesheet" type="text/css" href="https://js.api.here.com/v3/3.1/mapsjs-ui.css" />


  <script src='https://api.mapbox.com/mapbox-gl-js/v1.7.0/mapbox-gl.js'></script>

  <link href='https://api.mapbox.com/mapbox-gl-js/v1.7.0/mapbox-gl.css' rel='stylesheet' />


  <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

  <style>
    .select2-container .select2-selection--single {
      height: 34px !important;
    }

    .select2-container--default .select2-selection--single {
      border: 1px solid #ccc !important;
      border-radius: 25px !important;

    }
  </style>
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
          <select class="form-control select2 custom-select" name="procedureList" style="width:80%">
            <option value=""> Select a procedure </option>
            <!-- SQL query that gets the available procedures from the database -->
            <?php
            $sql = 'SELECT DISTINCT extendedProcedures FROM 19agileteam12db.data ORDER BY extendedProcedures ASC';
            $result = $con->query($sql);
            foreach ($result as $procedure) {
              echo '<option value="' . $procedure["extendedProcedures"] . '">' . $procedure["extendedProcedures"] . ' </option>';
            }
            ?>
          </select>
          <script>
            $('.select2').select2();
          </script>

          <!-- Select class allowing the patients to choose a procedure -->

          <br>
          <!-- States(Unique) will be selected via php from the database so the user can select it-->
          <br>
          <h5>
            Which State code are you in?
          </h5>
          <br><br>
          <!-- Select class allowing the users to choose a state -->
          <select class="form-control select2 custom-select" id="inputGroupSelect04" name="stateList" style="width:80%; border-radius: 25px;">
            <option value="" style="text-align:center"> Select a state </option>
            <!-- SQL query that gets the available states from the database -->
            <?php
            $sql = 'SELECT DISTINCT providerState FROM 19agileteam12db.data ORDER BY providerState ASC';
            $result = $con->query($sql);
            foreach ($result as $state) {
              echo '<option value="' . $state["providerState"] . '">' . $state["providerState"] . ' </option>';
            }
            mysqli_next_result($con);
            ?>
          </select>
          <script>
            $('.select2').select2();
          </script>
          <br><br><br>
          <?php
          $sqlMax = 'SELECT MAX(data.averageTotalPayment) as maxVal FROM 19agileteam12db.data';
          $result = $con->query($sqlMax);
          $maxVal;
          foreach ($result as $val) {
            $maxVal = $val['maxVal'];
          }
          ?>
          <div>
            <input class="slider" id="priceSlider" name="priceSlider" value="<?php echo $maxVal ?>" type="range" min="0" max="<?php echo $maxVal ?>" oninput="document.getElementById('pSlider').innerHTML = this.value" />
            <kbd><label id="pSlider"><?php echo $maxVal ?></label> <label> Dollars</label></kbd>
          </div>
          <br>
          <div>
            <input class="slider" id="distanceSlider" name="distanceSlider" value="" type="range" min="0" max="3000" oninput="document.getElementById('dSlider').innerHTML = this.value" />
            <kbd><label id="dSlider">3000</label> <label> Miles</label></kbd>
          </div>
          <br>
          <!-- Submit button to submit the form -->
          <button type="submit" class="btn btn-secondary" style="border-radius: 25px">Search</button>
          <br><br><br>
        </form>
        <!-- End of first form -->
        
        <br>
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