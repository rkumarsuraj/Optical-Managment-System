<?php
session_start();
include 'php/db_connection.php';
$email = $_SESSION['email'];
$conn = OpenCon();
$glass  = array();
$frame  = array();
$orders = array();
$user = array();
$address = array();
$glass_query = "SELECT * FROM Glasses";
$frame_query = "SELECT * FROM Frames";
$user_query = "SELECT * FROM Customers where EmailID = ?";
$address_query = "SELECT * FROM Addresses WHERE AddressID = ?";
$connection = OpenCon();

if ($stmt = $connection->prepare($glass_query)) {

if ($stmt->execute()) {

$glass_result = $stmt->get_result();
$frame_result = $stmt->get_result();

while ($row = $glass_result->fetch_assoc()) {
$glass[] = array(
'code' => $row['glasscode'],
'type' => $row['GlassType'],
'brand' => $row['GlassBrand'],
'price' => $row['Price']
);
}
$glass = json_decode(json_encode($glass),true);
$stmt->close();
}
else
echo $stmt->error;

}
else
echo $connection->error;

if ($stmt = $connection->prepare($frame_query)) {

if ($stmt->execute()) {

$frame_result = $stmt->get_result();

while ($row = $frame_result->fetch_assoc()) {
$frame[] = array(
'code' => $row['framecode'],
'type' => $row['FrameType'],
'brand' => $row['FrameBrand'],
'price' => $row['Price']
);
}
$frame= json_decode(json_encode($frame),true);
$stmt->close();
}
else
echo $stmt->error;
}
else
echo $connection->error;
if ($stmt = $connection->prepare($user_query)) {
$stmt->bind_param("s",$email);
if ($stmt->execute()) {

$user_result = $stmt->get_result();

while ($row = $user_result->fetch_assoc()) {
$user[] = array(
'id' => $row['CustomerID'],
'addressID' => $row['AddressID'],
'name' => $row['Name'],
'phno' => $row['Phone'],
'left' => $row['LeftEyeSight'],
'rightt' => $row['RightEyeSight'],
'email' => $row['EmailID'],
'pass' => $row['Password']
);
}
$user = json_decode(json_encode($user),true);
$stmt->close();
}
else
echo $stmt->error;
}
else
echo $connection->error;
if ($stmt = $connection->prepare($address_query)) {
$stmt->bind_param("i", $user_data[0]['addressID']);
if ($stmt->execute()) {
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
$address[] = array(
'line1' => $row['Line1'],
'line2' => $row['Line2'],
'city' => $row['City'],
'state' => $row['State'],
'zipcode' => $row['Zipcode']
);
}
$address = json_decode(json_encode($address), true);
}
}
$_SESSION['glassData'] = $glass;
$_SESSION['frameData'] = $frame;
$_SESSION['userData'] = $user;
$_SESSION['addressData'] = $address;
$_SESSION['customerID'] = $user[0]['id'];
$_SESSION['addressID'] = $user[0]['addressID'];
CloseCon($conn);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php echo $user[0]['name'] ?></title>
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
    <nav class="mb-1 navbar navbar-expand-lg navbar-dark cust-navbar" style="margin-top: -70px;">
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
            <a class="nav-link" href="Frames.php">Frames</a>
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
              <a class="dropdown-item" href="cart.php">Cart</a>
              <a class="dropdown-item" href="php/logout.php">Log out</a>
            </div>
          </li>
        </ul>
      </div>
    </nav>
    <div class="container" style="margin-top: 38px">
      <div class="row ">
        <?php
        $glass_count = count($glass);
        
        for($i = 0; $i < $glass_count; $i++) {
        $image_id = mt_rand(1,5);
        echo " <div class=\"col-3\" style=\"margin-bottom:20px;\">
          <div class=\"card\">
            <div class=\"view overlay\">
              <img class=\"card-img-top\" src=\"images/".$image_id.".jpg\" alt=\"Card image cap\">
              <a href=\"item.php?code=".$glass[$i]['code']."&image=".$image_id."\">
                <div class=\"mask rgba-white-slight\"></div>
              </a>
            </div>
            <div class=\"card-body\">
              <div class=\"row\">
                <div class=\"col\"><h6 class=\"card-title\">".$glass[$i]['brand']."</h6></div>
                <div class=\"col\"><p class=\"card-text\"> &#8377 ".$glass[$i]['price']."</p></div>
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