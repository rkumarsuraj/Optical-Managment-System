<?php
session_start();

$frame = json_decode(json_encode($_SESSION['frameData']),true);

?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>LensKart</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="css/mdb.css" rel="stylesheet">
    <!-- Your custom styles (optional) -->
    <link href="css/style.css" rel="stylesheet">
    <style type="text/css">
    .cust-navbar {
    background-color: #000 !important;
    }
    .nav-link {
    color: #fff !important;
    margin-left: 40px !important;
    font-size: 14px !important;
    font-weight: 400;
    }
    .active {
    color: yellow !important;
    }
    </style>
  </head>
  
  <body>
    <!-- Start your project here-->
    <img src="images/logo.svg" width="300px" height="200px" style="margin-top: -70px">
    <nav class="mb-1 navbar navbar-expand-lg navbar-dark  cust-navbar" style="margin-top: -70px">
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-333"
      aria-controls="navbarSupportedContent-333" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent-333">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="home.php" style="margin-left: 50px !important;">Glasses</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="frames.php">Frames</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="Orders.php">Track Orders</a>
          </li>
        </ul>
      </div>
      <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle profile_name" id="navbarDropdownMenuLink-4" data-toggle="dropdown"
              aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-user"></i> Profile </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-info" aria-labelledby="navbarDropdownMenuLink-4">
              <a class="dropdown-item" href="user_update.php">Update Profile</a>
              <a class="dropdown-item" href="index.html">Cart</a>
              <a class="dropdown-item" href="index.html">Log out</a>
            </div>
          </li>
        </ul>
      </div>
    </nav>


    <div class="container" style="margin-top: 38px">
      <div class="row ">
        <?php 
        $frame_count = count($frame);
      
        for($i = 0; $i < $frame_count; $i++) {
                  $image_id = mt_rand(1,5);

            echo " <div class=\"col-3\" style=\"margin-bottom:20px;\">
                    <div class=\"card\">
                      <div class=\"view overlay\">
                       <img class=\"card-img-top\" src=\"images/".$image_id.".jpg\" alt=\"Card image cap\">
                        <a href=\"item.php?code=".$frame[$i]['code']."&image=".$image_id."\">
                        <div class=\"mask rgba-white-slight\"></div>
                        </a>
                      </div>

                      <div class=\"card-body\">
                        <div class=\"row\">
                        <div class=\"col\"><h6 class=\"card-title\">".$frame[$i]['brand']."</h6></div>
                        <div class=\"col\"><p class=\"card-text\"> &#8377 ".$frame[$i]['price']."</p></div>
                        </div>
                      </div>
                    </div>
                  </div>";
        }
        ?>
      </div>
    </div>

    <!-- SCRIPTS -->
    <!-- JQuery -->
    <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="js/popper.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="js/mdb.min.js"></script>
  </body>

</html>