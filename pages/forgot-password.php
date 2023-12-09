<?php 
session_start();
include '../php/server.php';

if (isset($_POST['save'])){
    $username = $_POST['username'];
    $new_password = $_POST['new_password'];
    $confirm_new_password  = $_POST['confirm_new_password'];

    //confirm the password
    if ($new_password !== $confirm_new_password) {
        echo '  <script>
                    alert("Passwords do not match!");
                    window.location.href = "../pages/forgot-password.php";
                </script>';
        exit();
    }
    else{
        //check if there is an existing account
        $stmt = $conn->prepare("SELECT * FROM user_accounts WHERE username=?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();

            $new_hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
            //update in database
            $sql = "UPDATE user_accounts SET password = ? WHERE username = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ss', $new_hashed_password, $username);
            $stmt->execute();
        }   
        header("Location: ../pages/login-usr-page.html");
        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>BTS | Bus Ticketing System</title>
  <link rel="stylesheet" href="../style.css" />
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
  />
  <link rel="shortcut icon" type="image/jpg" href="../img/bts-logo.png" />
</head>
<body class="login-height">
  <!-- LOGIN PAGE -->
  <div class="slider-thumb" id="yellow-slider"></div>
  <div class="slider-thumb" id="green-slider"></div>
  <!-- REGISTER SECTION -->
  <div class="login-container">
    <a href="../index.php">
      <img src="../img/bts-logo.png" id="lgn-logo-pic" />
    </a>
    <div>
      <form action="" method="post" class="login-btn-ctr">
      <div class="lgn-input">
            Username: <input class="ipt-style" type="text" name="username" required/>
        </div>
        <div class="lgn-input">
            New Password: <input class="ipt-style" type="password" name="new_password" required/>
        </div>
        <div class="lgn-input" id="lgn-pass">
            Confirm New Password: <input class="ipt-style" type="password" name="confirm_new_password" required/>
        </div>
        <input type="submit" value="SAVE" name="save" class="btn" id="login-btn">
      </form>
    </div>
  </div>
</body>
</html>
