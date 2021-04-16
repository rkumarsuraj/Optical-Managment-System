<?php
session_start();
include 'php/db_connection.php';

$connection = OpenCon();

$query = "SELECT * from cart";
$cart = array();
 if ($stmt = $connection->prepare($query)) {
      
      if ($stmt->execute()) {
         
          $cart_result = $stmt->get_result();
  
          while ($row = $cart_result->fetch_assoc()) {
              $cart[] = array(
                  'id' => $row['CartID'],
                  'cID' => $row['CustomerID'],
                  'pID' => $row['ProductCode'],
                  'quantity' => $row['Quantity']
              ); 
          }
          $cart = json_decode(json_encode($cart),true);
          $stmt->close();
      }
      else
       echo $stmt->error;
  }
  else
   echo $connection->error;
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
      <nav class="mb-1 navbar navbar-expand-lg navbar-dark cust-navbar" style="margin-top: -70px">
         <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-333"
            aria-controls="navbarSupportedContent-333" aria-expanded="false" aria-label="Toggle navigation">
         <span class="navbar-toggler-icon"></span>
         </button>
         <div class="collapse navbar-collapse" id="navbarSupportedContent-333">
            <ul class="navbar-nav mr-auto">
               <li class="nav-item">
                  <a class="nav-link active" href="home.php" style="margin-left: 50px !important;">Glasses</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="frames.php">Frames</a>
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
                     <a class="dropdown-item" href="index.html">Update Profile</a>
                     <a class="dropdown-item" href="index.html">Cart</a>
                     <a class="dropdown-item" href="index.html">Log out</a>
                  </div>
               </li>
            </ul>
         </div>
      </nav>
      <div class="container" style="margin-top: 34px;">
         <div class="row">
            <?php  {
              
              for($i = 0; $i < count($cart); $i++){

                echo "<div class=\"col-3\">
                        <div class=\"card\">
                        <img class=\"card-img-top\" src=\"images/1.jpg\">
                        <div class=\"card-body\">
                          <h5 class=\"card-title\"><a>Quantity:".$cart[$i]['quantity']."</a></h5>
                          <p class=\"card-text\">ProductCode:".$cart[$i]['pID']."</p>
                          <form action=\"php\update.php\" method=\"POST\">
                            <div class=\"row\">
                            <input type=\"hidden\" name=\"cartID\" value=\"".$cart[$i]['id']."\">
                            <input type=\"hidden\" name=\"quantity\" value=\"".$cart[$i]['quantity']."\">
                            <input type=\"hidden\" name=\"productCode\" value=\"".$cart[$i]['pID']."\">
                              <div class=\"col\"><button name=\"cart_to_order\" class=\"btn btn-primary\">Buy</button></div>
                              <div class=\"col\"><button name=\"remove_from_cart\" class=\"btn btn-warning\">Remove</button></div>
                            </div>
                          </form>
                        </div>
                        </div>
                      </div>";
              }
            }

            ?>


</div>
<!-- Card -->
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