<?php
  session_start();
  include 'php/db_connection.php';
  

  $glass  = array();
  $frame  = array();
  $order = array();
  $user = array();
  
  $glass_query = "SELECT * FROM Glasses";
  $frame_query = "SELECT * FROM Frames";
  $order_query = "SELECT * FROM Orders";
  $user_query = "SELECT * FROM Customers";
  
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
      
      if ($stmt->execute()) {
         
          $user_result = $stmt->get_result();
  
          while ($row = $user_result->fetch_assoc()) {
              $user[] = array(
                  'id' => $row['CustomerID'],
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

 if ($stmt = $connection->prepare($order_query)) {
      
      if ($stmt->execute()) {
         
          $order_result = $stmt->get_result();
  
          while ($row = $order_result->fetch_assoc()) {
              $order[] = array(
                  'id' => $row['OrderID'],
                  'cID' => $row['CustomerID'],
                  'pID' => $row['ProductCode'],
                  'date' => $row['OrderDate'],
                  'ddate' => $row['DeliveryDate']
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
  CloseCon($connection);
  
  session_destroy();
  ?>
<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="css/mdb.css" rel="stylesheet">
    <!-- Your custom styles (optional) -->
    <link href="css/style.css" rel="stylesheet">
    <style>
      /* Style the tab */
      .tab {
      overflow: hidden;
      border: 1px solid #ccc;
      }
      /* Style the buttons inside the tab */
      .tab button {
      float: center;
      border: none;
      outline: none;
      cursor: pointer;
      padding: 14px 16px;
      transition: 0.3s;
      font-size: 17px;
      color: black;
      }
      .tab button:hover{
      }
      .tablinks:first-child{
        margin-left:500px;
      }
      /* Create an active/current tablink class */
      .tab button.active {
      background-color: yellow;
      }
      /* Style the tab content */
      .tabcontent {
      display: none;
      padding: 6px 12px;
      border: 1px solid black;
      }
      .add_product, .delete_product, .update_data{
      display: none;
      }
    </style>
  </head>
  <body>
    <div class="row" style="margin-top: 24px;">
      <div class="col"><h2 style="margin: auto;">Admin</h2></div>
      <div class="col"><h2 style="margin: auto;">Lenskart Database</h2></div>
      <div class="col" ><a href="index.html" class="btn btn-outline-warning float-right">Logout</a></div>
    </div> 
    <div class="tab">
      <button class="btn tablinks" id="defaultOpen" onclick="openTab(event, 'Glasses')">Glasses</button>
      <button class="btn tablinks" onclick="openTab(event, 'Frames')">Frames</button>
      <button class="btn tablinks" onclick="openTab(event, 'Customers')">Customers</button>
      <button class="btn tablinks" onclick="openTab(event, 'Orders')">Orders</button>
    </div>

    <div id="Glasses" class="tabcontent">
      <div style= " width:800px;margin:auto; margin-top: 10px">
        <div class="wrapper-editor">
          <div class="d-flex justify-content-center buttons-wrapper">
            <button name="data" class="btn btn-sm btn-primary" onclick="Show_data()">Data</button>
            <button name="add" class="btn btn-sm btn-teal" onclick="Show_add_form()">Add</button>
            <button name="delete" class="btn btn-sm btn-mdb-color" onclick="Show_delete_form()">Delete</button>
            <button name="update" class="btn btn-sm btn-info" onclick="Show_update_form()">Update</button>
          </div>
          <table class="table table-bordered data" cellspacing="0" width="100%">
            <thead class="indigo white-text">
              <tr>
                <th class="th-sm">Glass Code
                </th>
                <th class="th-sm">Glass Type
                </th>
                <th class="th-sm">Glass Brand
                </th>
                <th class="th-sm">Price
                </th>
              </tr>
            </thead>
            <tbody>
              <?php
                $glass_count = count($glass);
                
                for($i = 0; $i < $glass_count; $i++) {
                
                  echo "<tr>
                          <td>".$glass[$i]['code']."</td>
                          <td>".$glass[$i]['type']."</td>
                          <td>".$glass[$i]['brand']."</td>
                          <td>&#8377 ".$glass[$i]['price']."</td>
                        </tr>";
                }
                ?>
            </tbody>
          </table>
        </div>
        <form class="text-center border border-light p-5 add_product" action="php/admin_operations.php" method="POST">
          <div class="row">
            <div class="col">
              <input type="text" name="type" id="defaultLoginFormtext" class="form-control mb-4" placeholder="Glass Type">
            </div>
          </div>
          <div class="row">
            <div class="col">
              <input type="text" name="brand" id="defaultLoginFormtext" class="form-control mb-4" placeholder="Glass Brand">
              <input type="text" name="price" id="defaultLoginFormtext" class="form-control mb-4" placeholder="Glass Price">
            </div>
          </div>
          <button class="btn btn-success btn-block my-4" type="submit" name="add_glass">ADD</button>
        </form>

        <form class="text-center border border-light p-5 delete_product"  action="php/admin_operations.php" method="POST">
          <div class="row">
            <div class="col">
              <input type="text" name="code" id="defaultLoginFormEmail" class="form-control mb-4" placeholder="Enter Glass Code">
            </div>
          </div>
          <button class="btn btn-danger btn-block my-4" type="submit" name="delete_glass">DELETE</button>
        </form>

        <table class="table table-bordered update_data" cellspacing="0" width="100%">
            <thead class="indigo white-text">
              <tr>
                <th class="th-sm">Glass Code
                </th>
                <th class="th-sm">Glass Type
                </th>
                <th class="th-sm">Glass Brand
                </th>
                <th class="th-sm">Price
                </th>
                <th class="th-sm">Update
                </th>
              </tr>
            </thead>
            <tbody>
              <?php
                $glass_count = count($glass);
                
                for($i = 0; $i < $glass_count; $i++) {
                
                  echo "<form action=\"php/admin_operations.php\" method=\"POST\">
                          <tr>
                            <td>".$glass[$i]['code']."</td>
                            <td><input name=\"type\" value=\"".$glass[$i]['type']."\"></td>
                            <td><input name=\"brand\" value=\"".$glass[$i]['brand']."\"></td>
                            <td><input name=\"price\" value=\"".$glass[$i]['price']."\"></td>
                            <td><input class=\"btn btn-success\" type=\"submit\" name=\"update_glass\" value=\"Update\"></td>
                            <input type=\"hidden\" name=\"code\" value=\"".$glass[$i]['code']."\">
                          </tr>
                        </form>";
                }
                ?>
            </tbody>
        </table>

      </div>
    </div>
    <div id="Frames" class="tabcontent">
      <div style= "width:800px;margin:auto; margin-top: 10px">
        <div class="wrapper-editor">
          <div class="d-flex justify-content-center buttons-wrapper">
            <button name="data" class="btn btn-sm btn-primary" onclick="Show_data()">Data</button>
            <button name="add" class="btn btn-sm btn-teal" onclick="Show_add_form()">Add</button>
            <button name="delete" class="btn btn-sm btn-mdb-color" onclick="Show_delete_form()">Delete</button>
            <button name="update" class="btn btn-sm btn-info" onclick="Show_update_form()">Update</button>
          </div>
          <table class="table table-bordered data" cellspacing="0" width="100%">
            <thead class="indigo white-text">
              <tr>
                <th class="th-sm">Frame Code
                </th>
                <th class="th-sm">Frame Type
                </th>
                <th class="th-sm">Frame Brand
                </th>
                <th class="th-sm">Price
                </th>
              </tr>
            </thead>
            <tbody>
              <?php
                $frame_count = count($frame);
                
                for($i = 0; $i < $frame_count; $i++) {
                
                  echo "<tr>
                          <td>".$frame[$i]['code']."</td>
                          <td>".$frame[$i]['type']."</td>
                          <td>".$frame[$i]['brand']."</td>
                          <td>&#8377 ".$frame[$i]['price']."</td>
                        </tr>";
                }
                ?>
            </tbody>
          </table>
        </div>
        <form class="text-center border border-light p-5 add_product" action="php/admin_operations.php" method="POST">
          <div class="row">
            <div class="col">
              <input type="text" name="type" id="defaultLoginFormtext" class="form-control mb-4" placeholder="Frame Type">
            </div>
          </div>
          <div class="row">
            <div class="col">
              <input type="text" name="brand" id="defaultLoginFormtext" class="form-control mb-4" placeholder="Frame Brand">
              <input type="text" name="price" id="defaultLoginFormtext" class="form-control mb-4" placeholder="Frame Price">
            </div>
          </div>
          <button class="btn btn-success btn-block my-4" type="submit" name="add_frame">ADD</button>
        </form>
        <form class="text-center border border-light p-5 delete_product" action="php/admin_operations.php" method="POST">
          <div class="row">
            <div class="col">
              <input type="text" name="code" id="defaultLoginFormEmail" class="form-control mb-4" placeholder="Enter Frame Code">
            </div>
          </div>
          <button class="btn btn-danger btn-block my-4" type="submit" name="delete_frame">DELETE</button>
        </form>

        <table class="table table-bordered update_data" cellspacing="0" width="100%">
            <thead class="indigo white-text">
              <tr>
                <th class="th-sm">Frame Code
                </th>
                <th class="th-sm">Frame Type
                </th>
                <th class="th-sm">Frame Brand
                </th>
                <th class="th-sm">Price
                </th>
                <th class="th-sm">Update
                </th>
              </tr>
            </thead>
            <tbody>
              <?php
                $frame_count = count($frame);
                
                for($i = 0; $i < $frame_count; $i++) {
                
                  echo "<form action=\"php/admin_operations.php\" method=\"POST\">
                          <tr>
                            <td>".$frame[$i]['code']."</td>
                            <td><input name=\"type\" value=\"".$frame[$i]['type']."\"></td>
                            <td><input name=\"brand\" value=\"".$frame[$i]['brand']."\"></td>
                            <td><input name=\"price\" value=\"".$frame[$i]['price']."\"></td>
                            <td><input class=\"btn btn-success\" type=\"submit\" name=\"update_glass\" value=\"Update\"></td>
                            <input type=\"hidden\" name=\"code\" value=\"".$frame[$i]['code']."\">
                          </tr>
                        </form>";
                }
                ?>
            </tbody>
        </table>

      </div>
    </div>
    <div id="Customers" class="tabcontent">
       <div style= " width:800px;margin:auto; margin-top: 10px">
        <div class="wrapper-editor">
  
          <table class="table table-bordered data" cellspacing="0" width="100%">
            <thead class="indigo white-text">
              <tr>
                <th class="th-sm">CustomerID
                </th>
                <th class="th-sm">Name
                </th>
                <th class="th-sm">Contact
                </th>
                <th class="th-sm">LeftEyeSight
                </th>
                <th class="th-sm">RightEyeSight
                </th>
                <th class="th-sm">EmailID
                </th>
                <th class="th-sm">Password
                </th>
              </tr>
            </thead>

            <tbody>
              <?php
                $user_count = count($user);
                
                for($i = 0; $i < $user_count; $i++) {
                
                  echo "<tr>
                          <td>".$user[$i]['id']."</td>
                          <td>".$user[$i]['name']."</td>
                          <td>".$user[$i]['phno']."</td>
                          <td>".$user[$i]['left']."</td>
                          <td>".$user[$i]['rightt']."</td>
                          <td>".$user[$i]['email']."</td>
                          <td>".$user[$i]['pass']."</td>
                        </tr>";
                }
                ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div id="Orders" class="tabcontent">
      <div style= "width:800px;margin:auto; margin-top: 10px">
 
          <table class="table table-bordered data" cellspacing="0" width="100%">
            <thead class="indigo white-text">
              <tr>
                <th class="th-sm">Order ID
                </th>
                <th class="th-sm">Customer ID
                </th>
                <th class="th-sm">Product ID
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
                          <td>".$order[$i]['id']."</td>
                          <td>".$order[$i]['cID']."</td>
                          <td>".$order[$i]['pID']."</td>
                          <td>".$order[$i]['date']."</td>
                          <td>".$order[$i]['ddate']."</td>
                        </tr>";
                }
                ?>
            </tbody>
          </table>
        </div>
        <form class="text-center border border-light p-5 add_product" action="php/admin_operations.php" method="POST">
          <div class="row">
            <div class="col">
              <input type="text" name="type" id="defaultLoginFormtext" class="form-control mb-4" placeholder="Frame Type">
            </div>
          </div>
          <div class="row">
            <div class="col">
              <input type="text" name="brand" id="defaultLoginFormtext" class="form-control mb-4" placeholder="Frame Brand">
              <input type="text" name="price" id="defaultLoginFormtext" class="form-control mb-4" placeholder="Frame Price">
            </div>
          </div>
          <button class="btn btn-success btn-block my-4" type="submit" name="add_frame">ADD</button>
        </form>
        <form class="text-center border border-light p-5 delete_product" action="php/admin_operations.php" method="POST">
          <div class="row">
            <div class="col">
              <input type="text" name="code" id="defaultLoginFormEmail" class="form-control mb-4" placeholder="Enter Frame Code">
            </div>
          </div>
          <button class="btn btn-danger btn-block my-4" type="submit" name="delete_frame">DELETE</button>
        </form>
      </div>
    </div>

    <script>
      function openTab(evt, tabName) {
      
      var ele = document.getElementsByClassName('data');
      for (var i = 0; i < ele.length; i++) {
      ele[i].style.display = "table";
      }
      var ele = document.getElementsByClassName('update_data');
           for (var i = 0; i < ele.length; i++ ) {
             ele[i].style.display = "none";
           }
      var ele = document.getElementsByClassName('add_product');
      for (var i = 0; i < ele.length; i++) {
      ele[i].style.display = "none";
      }
      var ele = document.getElementsByClassName('delete_product');
      for (var i = 0; i < ele.length; i++) {
      ele[i].style.display = "none";
      }
      
      var i, tabcontent, tablinks;
      tabcontent = document.getElementsByClassName("tabcontent");
      for (i = 0; i < tabcontent.length; i++) {
      tabcontent[i].style.display = "none";
      }
      tablinks = document.getElementsByClassName("tablinks");
      for (i = 0; i < tablinks.length; i++) {
      tablinks[i].className = tablinks[i].className.replace(" active", "");
      }
      document.getElementById(tabName).style.display = "block";
      evt.currentTarget.className += " active";
      }
      document.getElementById("defaultOpen").click();
      function Show_data() {
      
         var ele = document.getElementsByClassName('delete_product');
           for (var i = 0; i < ele.length; i++ ) {
             ele[i].style.display = "none";
           }
        var ele = document.getElementsByClassName('update_data');
           for (var i = 0; i < ele.length; i++ ) {
             ele[i].style.display = "none";
           }

         var ele = document.getElementsByClassName('add_product');
           for (var i = 0; i < ele.length; i++ ) {
             ele[i].style.display = "none";
           }
         var ele = document.getElementsByClassName('data');
           for (var i = 0; i < ele.length; i++ ) {
             ele[i].style.display = "table";
           }
      }
      
      function Show_add_form() {
      
         var ele = document.getElementsByClassName('delete_product');
           for (var i = 0; i < ele.length; i++ ) {
             ele[i].style.display = "none";
           }
        
        var ele = document.getElementsByClassName('update_data');
           for (var i = 0; i < ele.length; i++ ) {
             ele[i].style.display = "none";
           }
         var ele = document.getElementsByClassName('data');
           for (var i = 0; i < ele.length; i++ ) {
             ele[i].style.display = "none";
           }
         var ele = document.getElementsByClassName('add_product');
           for (var i = 0; i < ele.length; i++ ) {
             ele[i].style.display = "block";
           }
      }
      
      function Show_delete_form() {
         var ele = document.getElementsByClassName('data');
           for (var i = 0; i < ele.length; i++ ) {
             ele[i].style.display = "none";
           }
          var ele = document.getElementsByClassName('update_data');
           for (var i = 0; i < ele.length; i++ ) {
             ele[i].style.display = "none";
           }
         var ele = document.getElementsByClassName('add_product');
           for (var i = 0; i < ele.length; i++ ) {
             ele[i].style.display = "none";
           }
         var ele = document.getElementsByClassName('delete_product');
           for (var i = 0; i < ele.length; i++ ) {
             ele[i].style.display = "block";
           }
      }
      
      function Show_update_form() {
         var ele = document.getElementsByClassName('data');
           for (var i = 0; i < ele.length; i++ ) {
             ele[i].style.display = "none";
           }
      
         var ele = document.getElementsByClassName('add_product');
           for (var i = 0; i < ele.length; i++ ) {
             ele[i].style.display = "none";
           }
         var ele = document.getElementsByClassName('delete_product');
           for (var i = 0; i < ele.length; i++ ) {
             ele[i].style.display = "none";
           }
         var ele = document.getElementsByClassName('update_data');
           for (var i = 0; i < ele.length; i++ ) {
             ele[i].style.display = "table";
           }
      }
      
    </script>
  </body>
</html>