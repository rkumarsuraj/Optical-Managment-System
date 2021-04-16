<?php
session_start();
include 'php/db_connection.php';

$email = $_SESSION['email'];

$conn = OpenCon();

$order = array();

$order_query = "SELECT * FROM Orders where CustomerID = ?";

  $connection = OpenCon();
  
 if ($stmt = $connection->prepare($order_query)) {
      $stmt->bind_param("i",$_SESSION['customerID']);
      if ($stmt->execute()) {
         
          $order_result = $stmt->get_result();
  
          while ($row = $order_result->fetch_assoc()) {
              $order[] = array(
                  'id' => $row['OrderID'],
                  'pID' => $row['ProductCode'],
                  'date' => $row['OrderDate'],
                  'ddate' => $row['DeliveryDate'],
                  'quant' => $row['Quantity'],
                  'tcost' => $row['TotalCost']
              ); 
          }
          $order = json_decode(json_encode($order),true);
          $stmt->close();
      }
      else
       echo $stmt->error;
  }
  else
   echo $connection->error;

CloseCon($conn);

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title></title> 
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
            <a class="nav-link" href="home.php" style="margin-left: 50px !important;">Glasses</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="Frames.php">Frames</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="Orders.php">Track Orders</a>
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
              <a class="dropdown-item" href="cart.php">Cart</a>
              <a class="dropdown-item" href="php/logout.php">Log out</a>
            </div>
          </li>
        </ul>
      </div>
    </nav>

    <div class="container">
        <table class="table table-bordered data" cellspacing="0" width="100%">
            <thead class="indigo white-text">
              <tr>
                <th class="th-sm">Orders
                </th>
                <th class="th-sm">Product ID
                </th>
                <th class="th-sm">Quantity
                </th>
                <th class="th-sm">Price
                </th>
                <th class="th-sm">Order Date
                </th>
                <th class="th-sm">Delivery Date
                </th>
              </tr>
            </thead>
            <tbody>
              <?php
                $order_count = count($order);
                
                for($i = 0; $i < $order_count; $i++) {
                
                  echo "<tr>
                          <td>".($i+1)."</td>
                          <td>".$order[$i]['pID']."</td>
                          <td>".$order[$i]['quant']."</td>
                          <td>".$order[$i]['tcost']."</td>
                          <td>".$order[$i]['date']."</td>
                          <td>".$order[$i]['ddate']."</td>
                        </tr>";
                }
                ?>
            </tbody>
          </table>
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