<?php
session_start();
include_once 'php/db_connection.php';

$code = $_GET['code'];
$image_id = $_GET['image'];

$query = "SELECT * FROM Products where productCode=?";
$data = array();

$conn = OpenCon();

if($stmt = $conn->prepare($query)) {
  $stmt->bind_param("i",$code);
  $stmt->execute();
  $res = $stmt->get_result();

  while ($row = $res->fetch_assoc()) {
              $data[] = array(
                  'code' => $row['productCode'],
                  'type' => $row['Type'],
                  'brand' => $row['Brand'],
                  'price' => $row['Price']
              ); 
  }
  $data = json_decode(json_encode($data),true);
}
else
  echo $conn->error;

$_SESSION['code'] = $data[0]['code'];
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
            <a class="nav-link" href="#"></a>
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
              <a class="dropdown-item" href="cart.html">Cart</a>
              <a class="dropdown-item" href="index.html">Log out</a>
            </div>
          </li>
        </ul>
      </div>
    </nav>
    
    <div class="container">

      <div class="row" style="margin-top: 28px">
        <div class="col-8" style="border: 1px solid black;">
          <img src="images/<?php echo $image_id ?>.jpg" style="max-width: 100%; max-height: 100%">
        </div>
        <div class="col" style="border: 1px solid black;">
        
          <div class="row">
            <div class="col">
               <h5 style="margin-top: 10px; font-weight: 500; color: black;">Product Details</h5>
            </div>
            <div class="col">
              <p style="float: right;">Product Id: <?php echo $data[0]['code'] ?></p>
            </div>
          </div>

          <div class="row">
            <div class="col glass_att">
              <p>GlassType</p>
            </div>
            <div class="col">
              <p> <?php echo $data[0]['type'] ?></p>
            </div>
          </div>

          <div class="row">
            <div class="col glass_att">
              <p>GlassBrand</p>
            </div>
            <div class="col">
              <p> <?php echo $data[0]['brand'] ?></p>
            </div>
          </div>

          <div class="row">
            <div class="col glass_att">
              <p>Price</p>
            </div>
            <div class="col">
              <p> &#8377  <?php echo $data[0]['price'] ?></p>
            </div>
          </div>

          <form class="text-center" action="php/update.php" method="POST">
          <div style="margin-top: 60px">
              Quantity (between 1 and 5):
            <input type="number" name="quantity" value="1" min="1" max="5">
            <button name = "order" type="submit" class="btn btn-success" style="width:100%">Buy Now</button>
            <button name = "cart" type="submit" class="btn btn-warning"  style="width:100%">Add to Cart</button>
          </div>
        </form>

        </div>
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