<?php
session_start();
include "../php/server.php";

// Check if the user is logged in
if (empty($_SESSION["user_id"])) {
    header("Location: login-page.html");
    exit();
}

//get data from other pages
$firstname = $_SESSION['firstname'];
$lastname = $_SESSION['lastname'];
$number = $_SESSION['number'];
$email = $_SESSION['email'];
$name = $firstname . ' ' . $lastname;
$user_id = $_SESSION["user_id"];  

//cancel button is clicked
if (isset($_POST['cancel'])){
    $bus_number = $_POST["bus_number"];
    $selected_booking = $_POST["variable"];
    $seat_status = "vacant";
    $booking = "";
    $status = "Booking Cancelled";
    $sql = "UPDATE booking_form SET status=? WHERE booking_id = ?";
    $stmt = $conn->prepare($sql); 
    $stmt->bind_param('si', $status, $selected_booking); 
    $stmt->execute(); 
    
    $sql = "UPDATE seat_reservation SET status= '$seat_status', booking_id = '$booking' WHERE booking_id = $selected_booking AND bus_no = $bus_number";
    $conn->query($sql);
    

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
      $mail->Subject = 'Booking Cancellation and Refund Process';
      $mail->Body    = 'Dear Customer,' . '<br>' .

      'I trust this email finds you well. We are writing to confirm the cancellation of your recent booking with us. We understand that circumstances can change, and we appreciate your prompt communication regarding the cancellation.'
      . '<br>' .
      'As part of our cancellation process, we are initiating the refund for your booking. However, please note that a cancellation fee has been applied to your refund amount in accordance with our terms and conditions. The deduction is made to cover administrative and processing costs associated with cancellations.'
      . '<br>' .
      'To ensure the swift processing of your refund, we kindly request you to provide us with your bank account details. Please share the following information at your earliest convenience:' . '<br>'.

        '1. Account Holder Name:
        2. Bank Name:
        3. Account Number:
        4. Routing Number (if applicable):
        5. Swift Code (for international transactions):' . '<br>'.
        
        'Your refund amount, after deducting the cancellation fee, will be promptly processed upon receiving the necessary information.' . '<br>'.
        
        'You can reply directly to this email with the required details. If you have any questions or concerns, feel free to reach out to our customer support team at 888-888-888.' . '<br>' .
        'We understand that cancellations can be inconvenient, and we appreciate your understanding of our cancellation policy. Thank you for choosing our services, and we hope to have the opportunity to serve you again in the future.'
. '<br>' .
'Best regards,
BTS TEAM';
      $mail->addAttachment('../img/bts-logo.png', 'ticket.png');
      $mail->send();
    }
    catch (Exception $e) {}
    header("Location: ../pages/admin-transaction.php");

} 

//approve button is clicked
if (isset($_POST['approve'])){
    $status = "Booking Approved";

    $selected_booking = $_POST["variable"];

    $sql = "UPDATE booking_form SET status=? WHERE  booking_id = ?";
    $stmt = $conn->prepare($sql); $stmt->bind_param('si', $status, $selected_booking);
    $stmt->execute(); 
    $stmt->close(); 

    //seats
    /*
$stmt = $conn->prepare("SELECT * FROM seat_reservation WHERE bus_no=? AND booking_id =?");
$stmt->bind_param("ii", $bus_number, $selected_booking);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Fetch the row from the result
    $row = $result->fetch_assoc();

    // Check if "bus_seat" is set and is a string
    if (isset($row["bus_seat"]) && is_string($row["bus_seat"])) {
        $bus_seat_length = strlen($row["bus_seat"]);

        for ($i = 0; $i < $bus_seat_length; $i++) {
            ${'seat_' . ($i + 1)} = $row["bus_seat"][$i];
        }

        for ($i = 0; $i < $bus_seat_length; $i++) {
            echo ${'seat_' . ($i + 1)};
        }
    }
}*/


    
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
      //BOOKING APPROVED EMAIL
      $mail->isHTML(true);                                
      $mail->Subject = 'Booking Approved';
      $mail->Body    = 'Hi, ' . $firstname . " " . $lastname . '. ' 
                      . 'Your booking has been approved. View your ticket in the transactions page.' 
                      .  '<br>' .  '<br>' 
                      . 'Thank you for trusting BTS!';
      $mail->addAttachment('../img/bts-logo.png', 'ticket.png');
      $mail->send();
    }
    catch (Exception $e) {}
    header("Location: ../pages/admin-transaction.php");
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
      body {
        font-family: "Arial", sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;
      }
      /* Style for the 3 table containers (ongoing, upcoming, & past) */
      .container {
        max-width: 800px;
        margin: 50px auto;
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      }
      h1 {
        text-align: center;
        color: #333;
      }
      table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
      }
      th,
      td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #ddd;
      }
      th {
        background-color: #f2f2f2;
      }
      /* Style for the pop-up containers for view details button */
      .popup-container {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: #fff;
        width: 400px;
        height: 600px;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        z-index: 1000;
      }
      /* Style to center the content of the pop-up containers */
      #popupContent {
        text-align: center;
      }
      /* Style for the close button for the view details pop-up */
      .close-button {
        background-color: #4caf50;
        color: white;
        padding: 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 1001;
        display: block;
      }
      /* Style for the cancel confirmation container */
      #cancelConfirmationContainer {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: #fff;
        width: 300px;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        z-index: 1001;
        text-align: center;
      }
      #cancelConfirmationContainer h3 {
        margin-bottom: 20px;
        color: #333;
      }
      #cancelConfirmationContainer button {
        background-color: #e74c3c;
        color: white;
        padding: 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin-top: 10px;
      }
      .details-indiv {
        display: flex;
        justify-content: space-between;
        align-items: center;
      }

      .details-ctr {
        display: flex;
        flex-direction: column;
        gap: 1.5em;
      }
    </style>
  </head>
  <body>
    <!-- Start of Navigation Bar -------------------------------------------------------->
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
          <li><a href="../pages/admin-landing-page.php">HOME</a></li>
          <!--<li><a href="../pages/booking.php">BOOKING</a></li>-->
          <li><a href="" id="active-page">TRANSACTIONS</a></li>
          <li><a href="../pages/admin-useraccounts.php">USERS</a></li>
          <li><a href="../pages/admin-feedback.html">FEEDBACK</a></li>
          <div class="login">
            <a href="admin-profile-page.php" id="login-button">Account</a>
          </div>
        </ul>
        <label for="menu-btn" class="navbtn menu-btn"
          ><i class="fa fa-bars"></i
        ></label>
      </div>
    </nav>
    </div>
    <!-- End of Navigation Bar -------------------------------------------------------->

    <!-- Start of Transaction History (BODY)-------------------------------------------------------->
    <br /><br /><br /><br /><br /><br />
    <h1 style="color: #365f32">Transaction History</h1>


    <!-- ONGOING ACTIVITY TABLE -->
    <!--
    <div class="container">
      <h3 style="color: #365f32">ONGOING ACTIVITY</h3>
      <table id="ongoingTable">
        <thead>
          <tr>
            <th>Date</th>
            <th>Pick up</th>
            <th>Destination</th>
            <th>Bus #</th>
            <th>Seat #</th>
            <th>Status</th>
            <th>View Details</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $sql = "SELECT BF.user_id, firstname, lastname, number, booking_id, pick_up, drop_off, date, time, passenger_number, status, total_price, bus_number FROM booking_form BF INNER JOIN user_accounts UA ON BF.user_id=UA.user_id WHERE status='Ongoing' AND BF.user_id='$user_id' ORDER BY date";
            $result = $conn->query($sql); if ($result->num_rows > 0) { while
          ($row = $result->fetch_assoc()) { echo "
          <tr>
            <td>{$row['date']}</td>
            <td>{$row['pick_up']}</td>
            <td>{$row['drop_off']}</td>
            <td>{$row['bus_number']}</td>
            <td>seat_number</td>
            <td>{$row['status']}</td>
            <td><button onclick=\"displayReceipt('{$row['booking_id']}', '{$row['firstname']} {$row['lastname']}', '{$row['number']}', '{$row['pick_up']}', '{$row['drop_off']}', '{$row['date']}', '{$row['time']}', '{$row['passenger_number']}', '{$row['status']}', '{$row['total_price']}', {$row['bus_number']})\">View Details</button></td> 
          </tr>
          "; } } ?>
        </tbody>
      </table>
    </div>
          -->

    <!-- UPCOMING ACTIVITY TABLE -->
    <div class="container">
      <h3 style="color: #365f32">PENDING BOOKINGS FOR APPROVAL</h3>
      <table id="upcomingTable">
        <thead>
          <tr>
            <th>Date</th>
            <th>Pick up</th>
            <th>Destination</th>
            <th>Bus #</th>
            <th>Passenger #</th>
            <th>Proof of Payment</th>
            <th>Status</th>
            <th>View Details</th>
          </tr>
        </thead>
        <tbody>
          <?php
            include "../php/server.php";
            $sql = "SELECT
                BF.user_id,
                firstname,
                lastname,
                number,
                BF.booking_id,
                pick_up,
                drop_off,
                date,
                time,
                passenger_number,
                BF.status,
                total_price,
                bus_number,
                bus_seat,
                reference_no
                image
            FROM
                booking_form BF
            INNER JOIN
                user_accounts UA ON BF.user_id = UA.user_id
            INNER JOIN
                seat_reservation SR ON BF.booking_id = SR.booking_id
            INNER JOIN 
                payment_proof PP ON reference_no = reference_number
            WHERE
                (BF.status = 'For Approval')
            GROUP BY
                BF.booking_id,
                BF.user_id
            ORDER BY
                status,
                date;
            ";
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['date']}</td>
                        <td>{$row['pick_up']}</td>
                        <td>{$row['drop_off']}</td>
                        <td>{$row['bus_number']}</td>
                        <td>{$row['passenger_number']}</td>
                        <td>{$row['image']}</td>
                        <td>{$row['status']}</td>
                        <td><button onclick=\"displayReceipt('{$row['booking_id']}', '{$row['firstname']} {$row['lastname']}', '{$row['number']}', '{$row['pick_up']}', '{$row['drop_off']}', '{$row['date']}', '{$row['time']}', '{$row['passenger_number']}', '{$row['status']}', '{$row['total_price']}', '{$row['bus_number']}')\">View Details</button></td>
                        </tr>";
                }
            }
          ?>
            </tbody>
        </table>

        <!-- TESTING --->

      <!-- TESTING --->
    </div>

    <!-- PAST ACTIVITY TABLE -->
    <div class="container">
      <h3 style="color: #365f32">FOR CANCELLATION</h3>
      <table id="pastTable">
        <thead>
          <tr>
            <th>Date</th>
            <th>Pick up</th>
            <th>Destination</th>
            <th>Bus #</th>
            <th>Passenger #</th>
            <th>Status</th>
            <th>View Details</th>
          </tr>
        </thead>
        <tbody>
          <?php
            include "../php/server.php";
            $sql = "SELECT
                BF.user_id,
                firstname,
                lastname,
                number,
                BF.booking_id,
                pick_up,
                drop_off,
                date,
                time,
                passenger_number,
                BF.status,
                total_price,
                bus_number,
                bus_seat
            FROM
                booking_form BF
            INNER JOIN
                user_accounts UA ON BF.user_id = UA.user_id
            INNER JOIN
                seat_reservation SR ON BF.booking_id = SR.booking_id
            WHERE
                (BF.status = 'Cancel Request')
            GROUP BY
                BF.booking_id,
                BF.user_id
            ORDER BY
                status,
                date;
            ";
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                  echo "<tr>
                      <td>{$row['date']}</td>
                      <td>{$row['pick_up']}</td>
                      <td>{$row['drop_off']}</td>
                      <td>{$row['bus_number']}</td>
                      <td>{$row['passenger_number']}</td>
                      <td>{$row['status']}</td>
                      <td><button onclick=\"displayReceipt('{$row['booking_id']}', '{$row['firstname']} {$row['lastname']}', '{$row['number']}', '{$row['pick_up']}', '{$row['drop_off']}', '{$row['date']}', '{$row['time']}', '{$row['passenger_number']}', '{$row['status']}', '{$row['total_price']}', '{$row['bus_number']}')\">View Details</button></td>
                      </tr>";
              }
          }
            ?>
            </tbody>
        </table>
    </div>

    <!-- PAST ACTIVITY TABLE -->
    <div class="container">
      <h3 style="color: #365f32">PAST AND APPROVED BOOKINGS</h3>
      <table id="pastTable">
        <thead>
          <tr>
            <th>Date</th>
            <th>Pick up</th>
            <th>Destination</th>
            <th>Bus #</th>
            <th>Passenger #</th>
            <th>Status</th>
            <th>View Details</th>
          </tr>
        </thead>
        <tbody>
          <?php
            include "../php/server.php";
            $sql = "SELECT
                BF.user_id,
                firstname,
                lastname,
                number,
                BF.booking_id,
                pick_up,
                drop_off,
                date,
                time,
                passenger_number,
                BF.status,
                total_price,
                bus_number
            FROM
                booking_form BF
            INNER JOIN
                user_accounts UA ON BF.user_id = UA.user_id
            WHERE
                (BF.status = 'Booking Cancelled' OR BF.status = 'Booking Approved')
            GROUP BY
                BF.booking_id,
                BF.user_id
            ORDER BY
                status,
                date;
            ";
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                  echo "<tr>
                      <td>{$row['date']}</td>
                      <td>{$row['pick_up']}</td>
                      <td>{$row['drop_off']}</td>
                      <td>{$row['bus_number']}</td>
                      <td>{$row['passenger_number']}</td>
                      <td>{$row['status']}</td>
                      <td><button onclick=\"displayReceipt('{$row['booking_id']}', '{$row['firstname']} {$row['lastname']}', '{$row['number']}', '{$row['pick_up']}', '{$row['drop_off']}', '{$row['date']}', '{$row['time']}', '{$row['passenger_number']}', '{$row['status']}', '{$row['total_price']}', '{$row['bus_number']}')\">View Details</button></td>
                      </tr>";
              }
          }
            ?>
            </tbody>
        </table>
    </div>

    <!-- POP-UP CONTAINER -->
    <div class="popup-container" id="popupContainer">
      <h3>Receipt Details</h3>
      <br />
      <div class="details" id="popupContent"></div>
      <button
        style="
          background-color: #4caf50;
          color: white;
          padding: 10px;
          border: none;
          border-radius: 5px;
          cursor: pointer;
          position: absolute;
          top: 10px;
          right: 10px;
          z-index: 1001;
        "
        onclick="closePopup()"
      >
        Close
      </button>
      <button
        id="cancelButton"
        style="
          background-color: #e74c3c;
          color: white;
          padding: 10px;
          border: none;
          border-radius: 5px;
          cursor: pointer;
          position: absolute;
          bottom: 20px;
          left: 50%;
          transform: translateX(-50%);
          z-index: 1001;
        "
      >
        Cancel Booking
      </button>
      <button
        id="approveButton"
        style="
          background-color: #4caf50;
          color: white;
          padding: 10px;
          border: none;
          border-radius: 5px;
          cursor: pointer;
          position: absolute;
          bottom: 20px;
          left: 50%;
          transform: translateX(-50%);
          z-index: 1001;
        "
      >
        Approve Booking
      </button>
    </div>

    <!-- Cancel Confirmation Container -->
    <div id="cancelConfirmationContainer"></div>

    <!-- End of Transaction History (BODY)-------------------------------------------------------->

    <script>
      function displayReceipt(booking_id, customer_name, number, pick_up, drop_off, date, time, passenger_number, status, total_price, bus_number) {
        document.getElementById("popupContent").innerHTML = `
            <div class="details-ctr">
            <div class="details-indiv">
            <span class="question">Transaction Number:</span>
            <span class="answer">${booking_id}</span>
            </div>

            <div class="details-indiv">
            <span class="question">Bus Number:</span>
            <span class="answer">${bus_number}</span>
            </div>

            <div class="details-indiv">
            <span class="question">Customer's Name:</span>
            <span class="answer">${customer_name}</span>
            </div>
 
            <div class="details-indiv">
            <span class="question">Contact Number:</span>
            <span class="answer">${number}</span>
            </div>
   
            <div class="details-indiv">
            <span class="question">Pick-up Terminal:</span>
            <span class="answer">${pick_up}</span>
            </div>
            
            <div class="details-indiv">
            <span class="question">Drop-off Destination:</span>
            <span class="answer">${drop_off}</span>
            </div>
            
            <div class="details-indiv">
            <span class="question">Departure Date:</span>
            <span class="answer">${date}</span>
            </div>
            
            <div class="details-indiv">
            <span class="question">Departure Time:</span>
            <span class="answer">${time}</span>
            </div>
           
            <div class="details-indiv">
            <span class="question">Number of Passengers:</span>
            <span class="answer">${passenger_number}</span>
            </div>
            
            <div class="details-indiv">
            <span class="question">Trip Fare:</span>
            <span class="answer">${total_price}</span>
            </div>
            
        </div>
        <hr>
        `;

        document.getElementById("popupContainer").style.display = "block";
        if (status == "Cancel Request") {
          document.getElementById("cancelButton").style.display = "block";
        } else {
          document.getElementById("cancelButton").style.display = "none";
        }
        document
          .getElementById("cancelButton")
          .addEventListener("click", function () {
            cancelUpcoming(booking_id, bus_number);
          });

        if (status == "For Approval" || status == "Upcoming") {
          document.getElementById("approveButton").style.display = "block";
        } else {
          document.getElementById("approveButton").style.display = "none";
        }

        document
          .getElementById("approveButton")
          .addEventListener("click", function () {
            approveBooking(booking_id);
          });


          
      }

      window.closePopup = function () {
        const popupContainer = document.getElementById("popupContainer");
        const cancelConfirmationContainer = document.getElementById(
          "cancelConfirmationContainer"
        );
        popupContainer.style.display = "none";
        cancelConfirmationContainer.style.display = "none";
      };

      //approve
      function approveBooking(booking_id) {
        const cancelConfirmationContainer = document.getElementById(
          "cancelConfirmationContainer"
        );
        document.getElementById("cancelConfirmationContainer").innerHTML = `
        <h3>Confirm Booking</h3>
        <p>Are you sure you want to approve this booking?</p>
        <form method="POST" action="">
        <input type ="hidden" name="variable" id="variable" value="${booking_id}"> 
        <button id="approve" name="approve" onclick="confirmBooking(${booking_id})">Yes, Approve</button>
        </form>
        <button style="background-color: #4CAF50; color: white;" onclick="closePopup()">No</button>
        `;
        var selected_booking = booking_id;

        cancelConfirmationContainer.style.display = "block";
      }

      // Function to confirm the booking and update the status
      function confirmBooking(booking_id, bus_number) {
        const cancelButton = document.getElementById("cancelButton");
        alert("Booking Approved");
        closePopup(); // Code to close the pop-up after canceling
      }

      // Function to start the cancellation process
      function cancelUpcoming(booking_id, bus_number) {
        const cancelConfirmationContainer = document.getElementById(
          "cancelConfirmationContainer"
        );
        document.getElementById("cancelConfirmationContainer").innerHTML = `
        <h3>Confirm Cancellation</h3>
        <p>Are you sure you want to cancel this booking?</p>
        <form method="POST" action="">
        <input type ="hidden" name="variable" id="variable" value="${booking_id}"> 
        <input type ="hidden" name="bus_number" id="bus_number" value="${bus_number}"> 
        <button id="cancel" name="cancel" onclick="confirmCancellation(${booking_id})">Yes, Cancel</button>
        </form>
        <button style="background-color: #4CAF50; color: white;" onclick="closePopup()">No, Keep Booking</button>
        `;
        var selected_booking = booking_id;

        cancelConfirmationContainer.style.display = "block";
      }

      // Function to confirm the cancellation and update the status
      function confirmCancellation(booking_id) {
        const cancelButton = document.getElementById("cancelButton");
        alert(
          "Upcoming activity canceled! Kindly check your registered email for the complete cancellation and refund process of your booking."
        );
        closePopup(); // Code to close the pop-up after canceling
      }
    </script>
  </body>
</html>
