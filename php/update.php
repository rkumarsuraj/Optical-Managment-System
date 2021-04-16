<?php
session_start();

include_once 'db_connection.php';
date_default_timezone_set('Asia/Kolkata');

$connection = OpenCon();

$address = json_decode(json_encode($_SESSION['addressData']),true);

$id = $_SESSION['customerID'];

$addressID = $_SESSION['addressID'];

if (isset($_POST['profile_update'])) {
    	
    
    $query = "UPDATE Customers
              set 
              Name=?,
              Phone=?,
              EmailID=?,
              Password=?,
              LeftEyeSight=?,
              RightEyeSight=?
              where CustomerID=?";
    
    $name    = $_POST['name'];
    $left    = $_POST['left'];
    $right    = $_POST['right'];
    $phno     = $_POST['phno'];
    $email    = $_POST['email'];
    $pass     = $_POST['pass'];
    $cnf_pass = $_POST['cnf_pass'];
    
    if ($pass != $cnf_pass) {
        Print '<script>alert("Passwords Do not Match");</script>';
        Print '<script>window.location.assign("http://localhost:8080/lienskart/user_update.php");</script>';
    }
    
    if($pass == ''){
    	$pass = $_SESSION['pass'];
    }

    if ($stmt = $connection->prepare($query)) {
        
        if ($stmt->bind_param("sissddi", $name, $phno, $email, $pass, $left, $right,$id)) {
            
            $stmt->execute();
            print '<script>alert("Account Updated");</script>';
            Print '<script>window.location.assign("http://localhost:8080/lenskart/index.html");</script>';

        } else {
            echo "Prepare Statement Error:" . $stmt->error;
        }
    } else {
        echo "Update Failed:" . $connection->error;
    }
    
}
if (isset($_POST['address_update'])) {
      
    
    $query = "UPDATE Addresses
              set 
              Line1=?,
              Line2=?,
              City=?,
              Zipcode=?,
              State=?
              where AddressID=?";
    
    $line1    = $_POST['line1'];
    $line2    = $_POST['line2'];
    $city    = $_POST['city'];
    $zipcode    = $_POST['zipcode'];
    $state   = $_POST['state'];
    $addressID = $_SESSION['addressID'];
    
    if ($stmt = $connection->prepare($query)) {
        
        if ($stmt->bind_param("sssssi", $line1, $line2, $city, $zipcode, $state,$addressID)) {
            
            $stmt->execute();

            print '<script>alert("Account Updated");</script>';
            Print '<script>window.location.assign("http://localhost:8080/lenskart/user_update.php");</script>';

        } else {
            echo "Prepare Statement Error:" . $stmt->error;
        }
    } else {
        echo "Update Failed:" . $connection->error;
    }
    
}
if(isset($_POST['delete_user'])){

  $order_query = "DELETE FROM Orders
                  where CustomerID = ?";

  $user_query = "DELETE 
                 FROM Customers
                 where CustomerID =?";

  $address_query = "DELETE FROM Addresses where AddressID = ?";


  if($stmt1 = $connection->prepare($user_query) and $stmt2 = $connection->prepare($user_query) and $stmt3 = $connection->prepare($address_query)){
    $stmt1->bind_param("i",$id);
    $stmt1->execute();
    $stmt2->bind_param("i",$id);
    $stmt2->execute();
    $stmt3->bind_param("i",$id);
    $stmt3->execute();
    print '<script>alert("Account Deleted");</script>';
    Print '<script>window.location.assign("http://localhost:8080/lenskart/index.html");</script>';
  } 

  if($stmt = $connection->prepare($address_query)) {
    $stmt->bind_param("i",$addressID);
    $stmt->execute();
  }

}

if(isset($_POST['cart'])){

  $ProductCode =  $_SESSION['code'];
  $quantity = $_POST['quantity'];

  $query = "INSERT INTO Cart(CustomerID,ProductCode,Quantity) Values(?,?,?)";

  if($stmt = $connection->prepare($query)){
    $stmt->bind_param("iii",$id,$ProductCode,$quantity);
    $stmt->execute();

    Print '<script>window.location.assign("http://localhost:8080/lenskart/home.php");</script>';
  }
  else
    echo $connection->error;
}

if(isset($_POST['remove_from_cart']) || isset($_POST['cart_to_order'])){
  $cart_id = $_POST['cartID'];

  if($stmt = $connection->prepare("DELETE FROM Cart where cartID=?")){
    $stmt->bind_param("i",$cart_id);
    $stmt->execute();
    
  }
}

if(isset($_POST['cart_to_order'])){

   $product_id = $_POST['productCode'];
   $date = date("Y-m-d");
   $quantity = $_POST['quantity'];
   $query = "INSERT INTO Orders(CustomerID,ProductCode,OrderDate,Quantity) Values(?,?,?,?)";

   if($stmt =$connection->prepare($query)){
    $stmt->bind_param("iisi",$id,$product_id,$date,$quantity);
    $stmt->execute();
    if($stmt = $connection->prepare("CALL UpdateDeliveryDate()"))
      $stmt->execute();

     print '<script>alert("Product Ordered");</script>';
     Print '<script>window.location.assign("http://localhost:8080/lenskart/home.php");</script>';
   }
}

if(isset($_POST['order'])){

  $product_id = $_SESSION['code'];
  $date = date("Y-m-d");
  $quantity = $_POST['quantity'];
  $query = "INSERT INTO Orders(CustomerID,ProductCode,OrderDate,Quantity) Values(?,?,?,?)";

  if($stmt = $connection->prepare($query)){
    $stmt->bind_param("iisi",$id,$product_id,$date,$quantity);
    $stmt->execute();
      
     if($stmt = $connection->prepare("CALL UpdateDeliveryDate()"))
      $stmt->execute();

     print '<script>alert("Product Ordered");</script>';
     Print '<script>window.location.assign("http://localhost:8080/lenskart/home.php");</script>';

  }
  else
    echo $connection->error;
}

?>