<?php
session_start();
include "../php/server.php";

// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
  header("Location: login-page.html");
  exit();
}

//get data from session
$email = $_SESSION['email'];
$username = $_SESSION['username'];
$firstname = $_SESSION['firstname'];
$lastname = $_SESSION['lastname'];
$number = $_SESSION['number'];
//$hashed_password = $_SESSION['hashed_password'];
$name = $firstname . ' ' . ' ' . $lastname;

//if edit button is clicked
if (isset($_POST['edit'])){
  header("Location: edit-profile-page.php");
}

//if logout button is clicked
if (isset($_POST['logout'])){
  $_SESSION = array();
  session_destroy();
  header("Location: login-page.html");
  exit();
}
?>
    
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>BTS | Bus Ticketing System</title>
    <link rel="stylesheet" href="../style.css" />
    <link rel="stylesheet" href="../profile.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
    <link rel="shortcut icon" type="image/jpg" href="../img/bts-logo.png" />
  </head>
  <body>
    <!-- NAVIGATION BAR -->
    <nav>
      <div class="wrapper">
        <div class="logo">
          <a href="#">
            <img src="../img/bts-logo-nav.png" alt="BTS" class="logo-pic"/>
          </a>
        </div>
        <input type="radio" name="slider" id="menu-btn" />
        <input type="radio" name="slider" id="close-btn" />
        <ul class="nav-links">
          <label for="close-btn" class="navbtn close-btn"><i class="fa fa-times"></i></label>
          <li><a href="../index.php">HOME</a></li>
          <li><a href="../pages/booking-form1.php">BOOKING</a></li>
          <li><a href="../pages/transaction.php">TRANSACTIONS</a></li>
          <li><a href="..pages/about-us.html">ABOUT US</a></li>
          <li><a href="#">FEEDBACK</a></li>
          <div class="login">
            <a href="profile-page.php" id="login-button">Account</a>
          </div>
        </ul>
        <label for="menu-btn" class="navbtn menu-btn"><i class="fa fa-bars"></i></label>
      </div>
    </nav>

    <!--BODY-->
    <div class="account-page">
        <h1>GUEST/USERNAME</h1>
        <form method="post" action="">
          <button type="submit" name="edit">EDIT</button>
        </form>
        <form method="post" action="">
          <button type="submit" name="logout">LOG OUT</button>
        </form>
    </div>
<div class="confirmTable">
  <div class="details">
    <br>
      <span class="question">Username:</span>
      <input type="text" name="name" id="name" value="<?php echo $username ? htmlspecialchars($username) : ''; ?>" required readonly style="background-color: #e5e5e5;">
      <br><br>
      <span class="question">First Name:</span>
      <input type="text" name="name" id="name" value="<?php echo $firstname ? htmlspecialchars($firstname) : ''; ?>" required readonly style="background-color: #e5e5e5;">
      <br><br>
      <span class="question">Last Name:</span>
      <input type="text" name="name" id="name" value="<?php echo $lastname ? htmlspecialchars($lastname) : ''; ?>" required readonly style="background-color: #e5e5e5;">
      <br><br>
      <span class="question">Phone Number:</span>
      <input type="text" name="name" id="name" value="<?php echo $number ? htmlspecialchars($number) : ''; ?>" required readonly style="background-color: #e5e5e5;">
      <br><br>
      <span class="question">Email:</span>
      <input type="text" name="name" id="name" value="<?php echo $email ? htmlspecialchars($email) : ''; ?>" required readonly style="background-color: #e5e5e5;">
      <br><br>
  </div>
</div>

    <!-- FOOTER -->
  </body>
</html>
