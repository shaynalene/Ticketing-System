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
$name = $firstname . " " . $lastname;
//$password = $_SESSION['password'];

//replace the data in the database
if (isset($_POST['save'])){

  //GENERATE EMAIL
  include "../php/generate-email.php";
  try {
    // Server settings
    $mail->SMTPDebug = 0;                      
    $mail->isSMTP();                                            
    $mail->Host       = 'smtp.gmail.com';                    
    $mail->SMTPAuth   = true;                              
    $mail->Username   = 'bus.ticketing.system.co@gmail.com';                    
    $mail->Password   = 'obiy hpfs bkhy achs';                           
    $mail->SMTPSecure = 'tls';         
    $mail->Port       = 587;                                    
    
    // EMAIL DETAILS
    $mail->setFrom('bus.ticketing.system.co@gmail.com', 'Bus Ticketing System Co');
    $mail->addAddress($email, $name);     
    
    // EMAIL CONTENTS
    //BOOKING CANCELLED EMAIL
    $mail->isHTML(true);                                
    $mail->Subject = 'Account Detail Changes';
    $mail->Body    = 'Dear Customer,' 
    . '<br>' .
    'We have noticed that you made changes from your account details. If this was you, you can safely ignore this email. Should you encounter any problems in accessing your account, please reach out through our email or social media. Thank you for choosing our services.'
    . '<br>' .
    'Best regards,' 
    . '<br>' .
    'BTS TEAM';
    $mail->addAttachment('../img/bts-logo.png', 'ticket.png');
    $mail->send();
  }
  catch (Exception $e) {}

  //UPDATE THE DATABASE
  $newusername = $_POST["username"];
  $newfirstname = $_POST["firstname"];
  $newlastname = $_POST["lastname"];
  $newnumber = $_POST["number"];
  $newemail = $_POST["email"];
  $newpassword = $_POST['password'];
  $new_hashed_password = password_hash($newpassword, PASSWORD_BCRYPT);
  $user_id = $_SESSION["user_id"];

  $sql = "UPDATE user_accounts SET username = ?, firstname = ?, lastname = ?, number = ?, email = ?, password = ? WHERE user_id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('sssissi', $newusername, $newfirstname, $newlastname, $newnumber, $newemail, $new_hashed_password, $user_id);
  $stmt->execute();
  $stmt->close();

  // Redirect to the profile page after the update
  $_SESSION['username'] = $newusername;
  $_SESSION['firstname'] = $newfirstname;
  $_SESSION['lastname'] = $newlastname;
  $_SESSION['number'] = $newnumber;
  $_SESSION['email'] = $newemail;
  $_SESSION['password'] = $newpassword;
  header("Location: profile-page.php");
  $conn->close();
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>BTS | Bus Ticketing System</title>
  <link rel="stylesheet" href="../style.css"/>
  <link rel="stylesheet" href="../profile.css"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
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
        <li>
          <a href="../index.php">HOME</a>
        </li>
        <li>
          <a href="../pages/admin-transaction.php">TRANSACTIONS</a>
        </li>
        <li>
          <a href="../pages/about-us.html">ABOUT US</a>
        </li>
        <li>
          <a href="../pages/admin-feedback.html">FEEDBACK</a>
        </li>
        <div class="login">
          <a href="admin-profile-page.php" id="login-button">Account</a>
        </div>
      </ul>
      <label for="menu-btn" class="navbtn menu-btn"><i class="fa fa-bars"></i></label>
    </div>
  </nav>

  <div class="account-page">
    <h1>EDIT ACCOUNT DETAILS</h1>
  </div>
  <div class="confirmTable">
    <div class="details"><br>
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
        <button type="submit" name="save">SAVE</button>
      </form>
    </div>
  </div>
  </body>
</html>
