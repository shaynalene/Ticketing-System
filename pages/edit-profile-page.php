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
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    />
    <link rel="shortcut icon" type="image/jpg" href="../img/bts-logo.png" />
  </head>
  <body>
    <!-- NAVIGATION BAR -->
    <nav>
      <div class="wrapper">
        <div class="logo">
          <a href="#"
            ><img src="../img/bts-logo-nav.png" alt="BTS" class="logo-pic"
          /></a>
        </div>
        <input type="radio" name="slider" id="menu-btn" />
        <input type="radio" name="slider" id="close-btn" />
        <ul class="nav-links">
          <label for="close-btn" class="navbtn close-btn"
            ><i class="fa fa-times"></i
          ></label>
          <li><a href="../index.php">HOME</a></li>
          <li>
            <a href="../pages/booking-form1.php">BOOKING</a>
          </li>
          <li>
            <a href="#">TRANSACTIONS</a>
          </li>
          <li>
            <a href="..pages/about-us.html">ABOUT US</a>
          </li>
          <li><a href="#">FEEDBACK</a></li>
          <div class="login">
            <a href="profile-page" id="login-button">Your Account</a>
            <!--redirect to user accounts page-->
          </div>
        </ul>
        <label for="menu-btn" class="navbtn menu-btn"
          ><i class="fa fa-bars"></i
        ></label>
      </div>
    </nav>

<?php
include "../php/server.php";
session_start();
// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
  header("Location: login-page.html");
  exit();
}
$email = $_SESSION['email'];
$username = $_SESSION['username'];
$firstname = $_SESSION['firstname'];
$lastname = $_SESSION['lastname'];
$number = $_SESSION['number'];
$hashed_password = $_SESSION['hashed_password'];
$name = $firstname . ' ' . ' ' . $lastname;

if (isset($_POST['save'])){
  //transfer new data to database
$username = $_POST["username"];
$firstname = $_POST["firstname"];
$lastname = $_POST["lastname"];
$number = $_POST["number"];
$email = $_POST["email"];
$password = $_POST['password'];
$user_id = $_SESSION["user_id"];

//insert the data to database
$sql = "UPDATE user_accounts
        SET 
        username = $username,
        firstname = $firstname,
        lastname = $lastname,
        number = $number,
        email = $email,
        password = $password
        
        WHERE $user_id = user_id";
        
$stmt = $conn->prepare($sql);

// Bind parameters
$stmt->bind_param('sssiss', $username, $firstname, $lastname, $number, $email, $password);

// Execute the statement
$stmt->execute();

// Close the statement
$stmt->close();

// Redirect to the profile page after the update
header("Location: profile-page.php");
exit();
}
    ?>

    <!--BODY-->
    <div class="account-page">
        <h1>GUEST/USERNAME</h1>
        
    </div>
<div class="confirmTable">
  <div class="details">
    <br>
    <form method="post" action="">   
      <span class="question">Username:</span>
      <input type="text" name="username" value="<?php echo $username ? htmlspecialchars($username) : ''; ?>" required>
      <br><br>
      <span class="question">First Name:</span>
      <input type="text" name="firstname" value="<?php echo $firstname ? htmlspecialchars($firstname) : ''; ?>" required>
      <br><br>
      <span class="question">Last Name:</span>
      <input type="text" name="lastname" value="<?php echo $lastname ? htmlspecialchars($lastname) : ''; ?>" required>
      <br><br>
      <span class="question">Phone Number:</span>
      <input type="text" name="number" value="<?php echo $number ? htmlspecialchars($number) : ''; ?>" required>
      <br><br>
      <span class="question">Email:</span>
      <input type="text" name="email" value="<?php echo $email ? htmlspecialchars($email) : ''; ?>" required>
      <br><br>
      <span class="question">Password:</span>
      <input type="text" name="password" value="<?php echo $hashed_password ? htmlspecialchars($hashed_password) : ''; ?>" required>
      <br><br>
      <button type="submit" name="save">SAVE</button>
    </form>
  </div>
</div>

    <!-- FOOTER -->
  </body>
</html>
