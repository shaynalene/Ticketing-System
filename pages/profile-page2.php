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
    <link rel="stylesheet" href="../about-us.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="shortcut icon" type="image/jpg" href="../img/bts-logo.png" />  
    
<style>
    /* ... (your existing styles) ... */

    .details-container {
      background-color: #f2eacb;
      display: flex;
      justify-content: center;
      align-items: center;
      flex-flow: column wrap;
      height: 100vh;
    }

    .nav-container {
      position: relative;
    }

    .form-buttons {
      align-items: center;
      text-align: center;
      margin-top: 20px;

    }

    .form-buttons button {
      padding: 10px 20px;
      border-radius: 5px;
      background-color:  #4CAF50;
      color: white;
      border: none;
      cursor: pointer;
      margin-top: 50px;
      text-align: center;
    }

    .form-buttons button:hover {
      background-color: #d64535; /* Darker shade on hover for LOG OUT button */
    }
  </style>
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
              <li><a href="../pages/booking.php">BOOKING</a></li>
              <li><a href="../pages/transaction.php">TRANSACTIONS</a></li>
              <li><a href="..pages/about-us.html">ABOUT US</a></li>
              <li><a href="#">FEEDBACK</a></li>
              <div class="login">
                <a href="profile-page2.php" id="login-button">Account</a>
              </div>
            </ul>
            <label for="menu-btn" class="navbtn menu-btn"><i class="fa fa-bars"></i></label>
          </div>
        </nav>
  
    <!-- BODY -->
    <div class="details-container">
      <div class="register-container">
      <!--<form action="../php/registration.php" method="post" class="register-container">
        <form action="../php/registration.php" method="post" class="register-container">-->
            <div class="rgs-header">PROFILE DETAILS</div>
            <div class="rgs-input">
              Username <input class="rgs-ipt-style" type="text" name="username" value="<?php echo $username ? htmlspecialchars($username) : ''; ?>" required readonly style="background-color: #e5e5e5;" />
            </div>
            <div class="rgs-input">
              First Name <input class="rgs-ipt-style" type="text" name="firstname" value="<?php echo $firstname ? htmlspecialchars($firstname) : ''; ?>" required readonly style="background-color: #e5e5e5;" />
            </div>
            <div class="rgs-input">
              Last Name <input class="rgs-ipt-style" type="text" name="lastname" value="<?php echo $lastname ? htmlspecialchars($lastname) : ''; ?>" required readonly style="background-color: #e5e5e5;" />
            </div>
            <div class="rgs-input">
              Phone Number <input class="rgs-ipt-style" type="number" name="phonenumber" value="<?php echo $number ? htmlspecialchars($number) : ''; ?>" required readonly style="background-color: #e5e5e5;" />
            </div>
            <div class="rgs-input">
              Enter Email <input class="rgs-ipt-style" type="email" name="email" value="<?php echo $email ? htmlspecialchars($email) : ''; ?>" required readonly style="background-color: #e5e5e5;" />
            </div>
  
            <div class="form-buttons">
                <form method="post" action="">
                  <button type="submit" name="edit">EDIT DETAILS</button>
                  <button type="submit" name="logout">LOG OUT</button>
                </form>
              </div>
              </div>
            <!--</form>-->
    
  
    <!-- Edit Details Button -->
    

    </div>
  
    <!-- FOOTER -->
  </body>
  </html>