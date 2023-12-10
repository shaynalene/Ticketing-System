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
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    />
    <link rel="shortcut icon" type="image/jpg" href="../img/bts-logo.png" />

    <style>
      .details-container {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-flow: column wrap;
      }

      .nav-container {
        position: relative;
      }

      .form-buttons {
        display: flex;
        align-items: center;
        justify-content: space-between;
        text-align: center;
      }

      .form-buttons button {
        font-size: 18px;
        padding: 10px 20px;
        border-radius: 5px;
        background-color: #365f32;
        color: white;
        border: none;
        cursor: pointer;
        text-align: center;
      }

      .form-buttons button:hover {
        background-color: #4caf50; /* Darker shade on hover for LOG OUT button */
      }
    </style>
  </head>

  <body class="pages-flex-feedback">
    <!-- NAVIGATION BAR -->
    <div class="navbar-ctr">
      <nav class="navbar">
        <div class="wrapper">
          <div class="logo">
            <a href="#">
              <img src="../img/bts-logo-nav.png" alt="BTS" class="logo-pic" />
            </a>
          </div>
          <input type="radio" name="slider" id="menu-btn" />
          <input type="radio" name="slider" id="close-btn" />
          <ul class="nav-links">
            <label for="close-btn" class="navbtn close-btn"
              ><i class="fa fa-times"></i
            ></label>
            <li><a href="../index.php">HOME</a></li>
            <li><a href="../pages/booking.php">BOOKING</a></li>
            <li><a href="../pages/transaction.php">TRANSACTIONS</a></li>
            <li><a href="..pages/about-us.html">ABOUT US</a></li>
            <li><a href="#">FEEDBACK</a></li>
            <div class="login">
              <a href="profile-page2.php" id="login-button">Account</a>
            </div>
          </ul>
          <label for="menu-btn" class="navbtn menu-btn"
            ><i class="fa fa-bars"></i
          ></label>
        </div>
      </nav>
    </div>

    <!-- BODY -->
    <div class="main-content-feedback">
      <div class="details-container">
        <div class="profilechange-container">
          <!--<form action="../php/registration.php" method="post" class="register-container">
        <form action="../php/registration.php" method="post" class="register-container">-->
          <div class="profile-header">PROFILE DETAILS</div>
          <div>
            <div class="rgs-input">
              Username
              <input
                class="rgs-ipt-style"
                type="text"
                name="username"
                value="<?php echo $username ? htmlspecialchars($username) : ''; ?>"
                required
                readonly
                style="background-color: #e5e5e5"
              />
            </div>
            <div class="rgs-input">
              First Name
              <input
                class="rgs-ipt-style"
                type="text"
                name="firstname"
                value="<?php echo $firstname ? htmlspecialchars($firstname) : ''; ?>"
                required
                readonly
                style="background-color: #e5e5e5"
              />
            </div>
            <div class="rgs-input">
              Last Name
              <input
                class="rgs-ipt-style"
                type="text"
                name="lastname"
                value="<?php echo $lastname ? htmlspecialchars($lastname) : ''; ?>"
                required
                readonly
                style="background-color: #e5e5e5"
              />
            </div>
            <div class="rgs-input">
              Phone Number
              <input
                class="rgs-ipt-style"
                type="number"
                name="phonenumber"
                value="<?php echo $number ? htmlspecialchars($number) : ''; ?>"
                required
                readonly
                style="background-color: #e5e5e5"
              />
            </div>
            <div class="rgs-input">
              Enter Email
              <input
                class="rgs-ipt-style"
                type="email"
                name="email"
                value="<?php echo $email ? htmlspecialchars($email) : ''; ?>"
                required
                readonly
                style="background-color: #e5e5e5"
              />
            </div>
          </div>

          <div>
            <form method="post" action="" class="form-buttons">
              <button type="submit" name="edit">EDIT DETAILS</button>
              <button type="submit" name="logout" class="logoutbtn">
                LOG OUT
              </button>
            </form>
          </div>
        </div>
        <!--</form>-->

        <!-- Edit Details Button -->
      </div>
    </div>

    <!-- FOOTER -->
    <div class="footer">
      <div class="footer-content">Copyright © 2023 BTS Co.</div>
      <div class="footer-content">
        <ul class="social-footer">
          <li>
            <a href="#" class="social-button"
              ><i class="fa fa-facebook" aria-hidden="true"></i
            ></a>
          </li>
          <li>
            <a href="#" class="social-button"
              ><i class="fa fa-twitter" aria-hidden="true"></i
            ></a>
          </li>
          <li>
            <a href="#" class="social-button"
              ><i class="fa fa-google" aria-hidden="true"></i
            ></a>
          </li>
        </ul>
      </div>
    </div>
  </body>
</html>
