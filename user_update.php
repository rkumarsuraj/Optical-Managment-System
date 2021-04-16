<?php
session_start();
include 'php/db_connection.php';

$user = json_decode(json_encode($_SESSION['userData']),true);

$_SESSION['id'] = $user[0]['id'];

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
    body {font-family: Arial;}
    /* Style the tab */
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
        margin-left:550px;
      }
      /* Create an active/current tablink class */
      .tab button.active {
      background-color: black
      color:yellow;
      }
    /* Style the tab content */
    .tabcontent {
    display: none;
    padding: 6px 12px;
    border: 1px solid #ccc;
    border-top: none;
    }
    </style>
  </head>
  <body>
    
    <div class="row" style="margin-top: 24px;">
      <div class="col"><h2 style="margin: auto;"><?php echo $user[0]['name'] ?></h2></div>
      <div class="col" style="margin:auto"><a href="home.php" class="btn btn-warning float-right">Go Back Home</a></div>
    </div>  
    <div class="tab">
      <button class="btn tablinks" id="defaultOpen" onclick="openTab(event, 'Profile')">Profile</button>
      <button class="btn tablinks" onclick="openTab(event, 'Address')">Address</button>
      <button class="btn tablinks" onclick="openTab(event, 'Account')">Account</button>
    </div>

    <div id="Profile" class="tabcontent">
      <div style= "width:450px;margin:auto; margin-top: 10px">
        <form class="text-center border border-light p-5" action="php/update.php" method="POST">
          <div class="form-row mb-4">
            <div class="col">
              <input type="text" id="defaultRegisterFormFirstName" class="form-control" value="<?php echo $user[0]['name'] ?>" name = "name" required>
            </div>
          </div>
          <input type="tel" name="phno" class="form-control mb-4" value="<?php echo $user[0]['phno'] ?>"
          pattern="[789][0-9]{9}" required>
          <div class="row">
            <div class="col">
              <input type="text" id="defaultRegisterFormPassword" name="left" class="form-control mb-4"
              value="<?php if($user[0]['left'] == null) echo "LeftEyeSight"; else echo $user[0]['left']?>" aria-describedby="defaultRegisterFormPasswordHelpBlock" required>
            </div>
            <div class="col">
              <input type="text" id="defaultRegisterFormPassword" name = "right" class="form-control mb-4"
              value="<?php if($user[0]['left'] == null) echo "RightEyeSight"; else echo $user[0]['left']?>" aria-describedby="defaultRegisterFormPasswordHelpBlock">
            </div>
          </div>
          <input type="email" id="defaultRegisterFormEmail" class="form-control mb-4" name="email" value="<?php echo $user[0]['email'] ?>" required>
          <div class="row">
            <div class="col">
              <input type="password" id="defaultRegisterFormPassword" name="pass" class="form-control mb-4" placeholder="password" aria-describedby="defaultRegisterFormPasswordHelpBlock">
            </div>
            <div class="col">
              <input type="password" id="defaultRegisterFormPassword" name = "cnf_pass" class="form-control mb-4"
              placeholder="Confirm Password" aria-describedby="defaultRegisterFormPasswordHelpBlock">
            </div>
          </div>
            <button style = "margin:auto;" class="btn btn-success my-4 btn-block" type="submit" name="profile_update">Update</button>
          </form>
        </div>
      </div>

      <div id="Address" class="tabcontent">
      <div style= "width:450px;margin:auto; margin-top: 10px">
        <form class="text-center border border-light p-5" action="php/update.php" method="post">
        
        <input type="text" name="line1" id="defaultLoginFormEmail" class="form-control mb-4" placeholder="Line1" required>
        <input type="text" name="line2" id="defaultLoginFormEmail" class="form-control mb-4" placeholder="Line2">
        <div class="form-row mb-4">
          <div class="col">
            <input type="text" name ="city" id="defaultRegisterFormFirstName" class="form-control" placeholder="City" required>
          </div>
          <div class="col">
            <input type="text" name="zipcode" id="defaultRegisterFormLastName" class="form-control" placeholder="Zipcode" required>
          </div>
        </div>
        <div class="form-row mb-4">
          <div class="col">
            <input type="text" name ="state" id="defaultRegisterFormFirstName" class="form-control" placeholder="State" required>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <button class="btn btn-success my-4 btn-block" type="submit" name="address_update">Update</button>
          </div>
        </div>
      </form>
        </div>
      </div>

      <div id="Account" class="tabcontent">
      <div style= "width:450px;margin:auto; margin-top: 10px">
        <form class="text-center border border-light p-5" action="php/update.php" method="post">
          <h5 class="text-danger">Once Delete Account Can't be Recovered</h5>
          <button class="btn btn-danger my-4 btn-block" type="submit" name="delete_user">Delete</button>
      </form>
        </div>
      </div>

      <script>
      function openTab(evt, tabName) {
      
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
      document.getElementsByClassName("data").style.display="none";
      document.getElementsByClassName("add_product").style.display="block";
      }
      
      </script>
    </body>
  </html>