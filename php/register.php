<?php

session_start();

include 'db_connection.php';

$name    = $_POST['name'];
$phno     = $_POST['phno'];
$email    = $_POST['email'];
$pass     = $_POST['pass'];
$cnf_pass = $_POST['cnf_pass'];


if ($pass != $cnf_pass) {
    
    Print '<script>alert("Passwords Do not match");</script>';
    Print '<script>window.location.assign("http://localhost:8080/lenskart/register.html");</script>';
    exit();
}

$connection = OpenCon();

$address_query = "INSERT INTO Addresses(Line1, Line2, City, Zipcode, State) values('','','','','')";

if($stmt = $connection->prepare($address_query)){
    $stmt->execute();
    $address_id = $connection->insert_id;
}
$query = "INSERT INTO customers (Name, AddressID,Phone, EmailID, Password) VALUES(?,?,?,?,?)";


    if ($stmt = $connection->prepare($query)) {
        $stmt->bind_param("siiss", $name,$address_id,$phno,$email,$pass);
        $stmt->execute();
        
        header('Location: http://localhost:8080/lenskart/index.html');
        exit();
    } else {
        echo ("Registration failed :" . $connection->error . "<br>");
    }

CloseCon($connection);

session_destroy();

?>