<?php
session_start();
include "../php/server.php";

// Check if the user is logged in
if (empty($_SESSION["user_id"])) {
    header("Location: login-page.html");
    exit();
}

//to reset the seat_reservation database
/*$status = "vacant";
    $booking_id = "";
    $reserved = "reserved";
    $sql = "UPDATE seat_reservation SET status=?, booking_id=? WHERE status = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sis', $status, $booking_id, $reserved); 
    $stmt->execute();
    $stmt->close();*/

// Fetch seat statuses from the database
$bus_number = $_SESSION['bus_number'];
$sql = "SELECT bus_seat, status FROM seat_reservation WHERE bus_no = $bus_number";
$result = $conn->query($sql);

// Create an associative array to store seat statuses
$seatStatuses = [];
while ($row = $result->fetch_assoc()) {
    $seatStatuses[$row['bus_seat']] = $row['status'];
}

/*
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["reset"]) && !isset($_SESSION["reset_clicked"])) {
  $_SESSION["reset_clicked"] = true;
    $status = "vacant";
    $reserved = "reserved";
    $sql = "UPDATE seat_reservation SET status=? WHERE status = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $status, $reserved); 
    $stmt->execute();
    $stmt->close();
}*/
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
    <link
      rel="shortcut icon"
      type="image/jpg"
      href="../img/bts-logo.png"
    />
    <style>
      .title-header{
        color:#365f32;
      }
    .seatButton {
      width: 100px;
      height: 40px;
      margin: 5px;
      background-color: green;
      color: white;
    }
    .selected{
      width: 100px;
      height: 40px;
      margin: 5px;
      background-color: yellow;
    }
    .reserved{
      width: 100px;
      height: 40px;
      margin: 5px;
      background-color: red;
      color: white;
    }
    .main-content-seat{
  flex: 0 80vh;
  width: 100%;
  padding: 3em;
  display: flex;
  justify-content: center;
  align-items: center;
  background-color: #e9e8f9;
  flex-flow: column;
  gap: 1em;
}
.button-ctr-seat{
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 2em;
}

.seat-btn{
  background-color: #e5cc77;
  padding: 10px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  display: block;
  
}
.main-seat-ctr{
  display:flex;
  gap:2em;
}
.main-seat-ctr-2{
  display:flex;
  flex-flow:column;
  gap:2em;
}
.main-legend-ctr{
  display:flex;
  flex-flow:column;
  gap:2em;
}
.main-legend-ctr{
  display:flex;
  flex-flow:column;
  gap:2em;
}
.color-box {
    width: 20px;
    height: 20px;
    margin-right: 10px; 
}
.legend-item {
    display: flex;
    align-items: center;
}
#green-btn{
  background-color: #4caf50;
}

.seat-design{
  display: flex;
  flex-flow: row wrap;
  align-items: center;
  gap:1em;
}
.seat-design-2{
  display: flex;
  flex-flow: column wrap;
  align-items: center;
  gap:1em;
}
  </style>
  </head>
  <script>
    var passengerCount = <?php echo $_SESSION['passenger_count']; ?>;
  </script>
  <body class="pages-flex-feedback">
    <!-- NAVIGATION BAR -->
    <div class="navbar-ctr">
      <nav class="navbar">
        <div class="wrapper">
          <div class="logo">
            <a href="#"
              ><img
                src="../img/bts-logo-nav.png"
                alt="BTS"
                class="logo-pic"
            /></a>
          </div>
          <input type="radio" name="slider" id="menu-btn" />
          <input type="radio" name="slider" id="close-btn" />
          <ul class="nav-links">
            <label for="close-btn" class="navbtn close-btn"
              ><i class="fa fa-times"></i
            ></label>
            <li>
              <a href="../index.php" id="active-page">HOME</a>
            </li>
            <li>
              <a href="../pages/booking.php">BOOKING</a>
            </li>
            <li>
              <a href="../pages/user-transaction.php">TRANSACTIONS</a>
            </li>
            <li>
              <a href="../pages/about-us.html">ABOUT US</a>
            </li>
            <li><a href="../pages/user-feedback.html">FEEDBACK</a></li>
            <div class="login">
              <a
                href="../pages/profile-page.php"
                id="login-button"
                >Your Account</a
              >
            </div>
          </ul>
          <label for="menu-btn" class="navbtn menu-btn"
            ><i class="fa fa-bars"></i
          ></label>
        </div>
      </nav>
    </div>

    <!-- SEAT SELECTION -->
    <div class="main-content-seat">
      <div class="title-header">SEAT SELECTION</div>
    <!--<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <button type="submit" name="reset">RESET IN DATABASE</button>
    </form>-->
<!-- Legend -->
<div class="main-seat-ctr">
  <!--
<div class="legend">
    <h3>Legend:</h3>
    <!-- Window Seats
    <div class="legend-item">
        <div class="color-box" style="background-color: rgb(194, 144, 194);"></div>
        <h4>Window Seats</h4>
    </div>
    <!-- Front Seats
    <div class="legend-item">
        <div class="color-box" style="background-color: yellow;"></div>
        <h4>Front Seats</h4>
    </div>
    <!-- Back Seats
    <div class="legend-item">
        <div class="color-box" style="background-color: rgb(78, 146, 255);"></div>
        <h4>Back Seats</h4>
    </div>
    <!-- Aisle (Not Available) 
    <div class="legend-item">
        <div class="color-box" style="background-color: black;"></div>
        <h4>Aisle (Not Available)</h4>
    </div>
    <br><br>
    <hr><br>
    <!-- Insert backend code here (bus number and bus seat based from the booking form) -->
    <h4>Number of Seats to select: </h4>
    <h4><?php echo $_SESSION['passenger_count'];?></h4>
    <hr><br>
    <h4>Available Seat(s) from Bus # </h4>
    <h4><?php echo $bus_number?></h4>

    <br>
    
</div>
<div class="main-seat-ctr-2">
  <div class="seat-design">
  <div class="">WINDOW</div>
  <div class="seat-design-2">
  <div class="">-------------------- FRONT --------------------</div>
    <table border="1">
        <?php
        echo $date;
        //$passenger_number = $_SESSION['passenger_count'];

        $rows = ['A', 'B', 'C', 'D', 'E', 'F'];
        $cols = [1, 2, 3, 4];

        foreach ($rows as $row) {
            echo "<tr>";

            foreach ($cols as $col) {
                $seatId = $row . $col;
                $buttonClass = 'seatButton';

                // Check if the seat is reserved
                $bus_number = $_SESSION['bus_number'];
                if (isset($seatStatuses[$seatId]) &&  $seatStatuses[$seatId] === 'reserved') {
                    $buttonClass = 'reserved';
                }

                echo "<td><button onclick=\"buttonClick('$row', $col)\" name=\"$row$col\" id=\"$row$col\" class=\"$buttonClass\">$row$col</button></td>";
            }

            echo "</tr>";
        }
        ?>
    </table>
    <div class="">-------------------- BACK --------------------</div>
    </div>
    <div class="">WINDOW</div>
    </div>
    <div class ="button-ctr-seat">
    <button onclick="resetSeats()" class="seat-btn">UNSELECT</button>
    <button onclick="confirm()" name="confirm" class="seat-btn"  id="green-btn">CONFIRM</button>
    </div>
    </div>
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
  <script>
    function buttonClick(row, col) {
    var button = row + col;
    var seatButton = document.getElementById(button);

    // Check if the seat is already selected
    if (seatButton.classList.contains('selected')) {
      seatButton.classList.remove('selected');
      seatButton.classList.add('seatButton');
    } else {
      // Check if the total selected seats are less than or equal to passenger_count
      var selectedSeats = document.querySelectorAll('.selected');
      if (selectedSeats.length < passengerCount) {
        seatButton.classList.remove('seatButton');
        seatButton.classList.add('selected');
        console.log(button);
      } else {
        alert('You can only select ' + passengerCount + ' seats.');
      }
    }
  }
    /*function buttonClick(row, col) {
      //alert('Button clicked: Row ' + row + ', Column ' + col);
      var button = row+col;
      document.getElementById(button).classList.remove('seatButton');
      document.getElementById(button).classList.add('selected');
      console.log(button);
    }*/

    function resetSeats() {
      var buttons = document.querySelectorAll('.selected');
      for (var i = 0; i < buttons.length; i++) {
        buttons[i].classList.remove('selected');
        buttons[i].classList.add('seatButton');
      }
      // Trigger form submission
      document.getElementById('resetForm').submit();
    }

    function confirm(){
      var selectedSeats = document.querySelectorAll('.selected');
      if (selectedSeats.length < passengerCount){
        alert('Please select exactly ' + passengerCount + ' seats.');
      }
      else{
        //alert('Confirm');
        var buttons = document.querySelectorAll('.selected');
        var selectedValues = [];
        
        for (var i = 0; i < buttons.length; i++) {
          var selected = buttons[i].id;
          selectedValues.push(selected);
          console.log(selected);
        }

        // Send selectedValues array to PHP using AJAX
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '../php/seat.php', true); // Specify the correct PHP script filename
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
          if (xhr.readyState == 4 && xhr.status == 200) {
            // Handle the response from the server if needed
            console.log(xhr.responseText);
          }
        };

        // Convert the array to a JSON string for easy handling on the server
        var jsonData = JSON.stringify({ selectedValues: selectedValues });

        // Send the data to the server
        xhr.send('jsonData=' + encodeURIComponent(jsonData));

        window.location = "../pages/booking-payment.php";
      }
    }
  </script>
</html>