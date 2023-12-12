function updateLastEditDate() {
  const lastEditDateCell = document.getElementById("lastEditDate");
  const editDate = new Date();
  lastEditDateCell.textContent = "Last Edit: " + editDate.toLocaleString();
}

/* START OF LANDING PAGE RECORDS */

function addRecord() {
  document.getElementById("addpopupContent").innerHTML = `
  <form method="POST" action="">
      <div class="details">
      <div class="detail-value">
      <span class="question">Pick Up:</span>
      <input type="text" name="pickup" value="" required>
      </div>

      <div class="detail-value">
      <span class="question">Drop Off:</span>
      <input type="text" name="dropoff" value="" required>
      </div>

      <div class="detail-value">
      <span class="question">Price:</span>
      <input type="number" name="price" value="" required>
      </div>

      <div class="detail-value">
      <span class="question">Bus Number:</span>
      <input type="number" name="busnumber" value="" required>
      </div>

      <div class="detail-value">
      <span class="question">Travel Date:</span>
      <input type="date" name="date" value="" required>
      </div>
 
      <div class="detail-value">
      <button type="submit" name="save" class="addRecordBtn">ADD RECORD</button>
      </div>
      </form>
  </div>
  `;

  document.getElementById("addpopupContainer").style.display = "block";

  //updateLastEditDate();
}

function booking(schedule_id, pick_up, drop_off, price, bus_number, date) {
  //alert('success');
  document.getElementById("addpopupContent").innerHTML = `
    <form method="POST" action="">
      <input type="hidden" name="schedule_id" id="schedule_id" value="${schedule_id}">
      <input type="hidden" name="pick_up" id="pick_up" value="${pick_up}">
      <input type="hidden" name="drop_off" id="drop_off" value="${drop_off}"> 
      <input type="hidden" name="price" id="price" value="${price}"> 
      <input type="hidden" name="bus_number" id="bus_number" value="${bus_number}"> 
      <input type="hidden" name="date" id="date" value="${date}"> 
      <div class="details">
        <div class="detail-value">
          <span class="question">Pickup:</span>
          <input type="text" name="pick_up" value="${pick_up}" required readonly>
        </div>

        <div class="detail-value">
          <span class="question">Drop Off:</span>
          <input type="text" name="drop_off" value="${drop_off}" required readonly>
        </div>

        <div class="detail-value">
          <span class="question">Travel Date:</span>
          <input type="text" name="date" value="${date}" required readonly>
        </div>

        <label for="departure-time">Choose Preferred Time:</label>
        <select name="departure-time" id="departure-time" required>
          <option value="" disabled selected>Select Time</option>
          <option value="4:00:00">4:00 AM</option>
          <option value="7:00:00">7:00 AM</option>
          <option value="9:00:00">9:00 AM</option>
          <option value="13:00:00">1:00 PM</option>
          <option value="15:00:00">3:00 PM</option>
          <option value="17:00:00">5:00 PM</option>
        </select>
       
        <label for="passenger-count">Number of Passengers:</label>
        <select name="passenger-count" id="passenger-count" required>
          <option value="" disabled selected>
          Select Number of Passengers
              </option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
          <option value="6">6</option>
          <option value="7">7</option>
        </select>

        <div class="detail-value">
          <button id="next" name="next" type="submit" style="background-color: #e5cc77">
            Next
          </button>
        </div>
      </div>
    </form>
  `;

  document.getElementById("next").onclick = function () {
    var departureTime = document.getElementById("departure-time").value;
    var passengerCount = document.getElementById("passenger-count").value;
    displayBooking(
      schedule_id,
      pick_up,
      drop_off,
      price,
      bus_number,
      date,
      departureTime,
      passengerCount
    );
  };

  document.getElementById("addpopupContainer").style.display = "block";
}

function displayBooking(
  schedule_id,
  pick_up,
  drop_off,
  price,
  bus_number,
  date,
  departure_time,
  passenger_count
) {
  document.getElementById("addpopupContent").innerHTML = `
    <form method="POST" action="">
      <input type="hidden" name="schedule_id" id="schedule_id" value="${schedule_id}">
      <input type="hidden" name="pick_up" id="pick_up" value="${pick_up}">
      <input type="hidden" name="drop_off" id="drop_off" value="${drop_off}"> 
      <input type="hidden" name="price" id="price" value="${price}"> 
      <input type="hidden" name="bus_number" id="bus_number" value="${bus_number}"> 
      <input type="hidden" name="date" id="date" value="${date}"> 
      <input type="hidden" name="departure_time" id="departure_time" value="${departure_time}"> 
      <input type="hidden" name="passenger_count" id="passenger_count" value="${passenger_count}"> 
      <div class="details">
        <div class="detail-value">
          <span class="question">Pickup:</span>
          <input type="text" name="pick_up" value="${pick_up}" required readonly>
        </div>

        <div class="detail-value">
          <span class="question">Drop Off:</span>
          <input type="text" name="drop_off" value="${drop_off}" required readonly>
        </div>

        <div class="detail-value">
          <span class="question">Travel Date:</span>
          <input type="text" name="date" value="${date}" required readonly>
        </div>

        <label for="departure-time">Choose Preferred Time:</label>
        <input type="text" name="departure_time" value="${departure_time}" required readonly>

        <label for="passenger-count">Number of Passengers:</label>
        <input type="text" name="passenger_count" value="${passenger_count}" required readonly>

        <div class="detail-value">
          <button name="confirm" type="submit" style="background-color: #e5cc77">
            Confirm
          </button>
        </div>
      </div>
    </form>
  `;
  document.getElementById("addpopupContainer").style.display = "block";
}

function displayRecord(
  schedule_id,
  pick_up,
  drop_off,
  price,
  bus_number,
  date,
  time
) {
  document.getElementById("editpopupContent").innerHTML = `
  <form method="POST" action="">
    <input type ="hidden" name="schedule_id" id="schedule_id" value="${schedule_id}">
      <input type ="hidden" name="pick_up" id="pick_up" value="${pick_up}">
      <input type ="hidden" name="drop_off" id="drop_off" value="${drop_off}"> 
      <input type ="hidden" name="price" id="price" value="${price}"> 
      <input type ="hidden" name="bus_number" id="bus_number" value="${bus_number}"> 
      <input type ="hidden" name="date" id="date" value="${date}"> 
      <div class="details">
      
      <div class="detail-value">
      <span class="question">Pickup:</span>
      <input type="text" name="pick_up" value="${pick_up}" required>
      </div>

      <div class="detail-value">
      <span class="question">Drop Off:</span>
      <input type="text" name="drop_off" value="${drop_off}" required>
      </div>

      <div class="detail-value">
      <span class="question">Price:</span>
      <input type="number" name="price" value="${price}" required>
      </div>

      <div class="detail-value">
      <span class="question">Bus Number:</span>
      <input type="number" name="bus_number" value="${bus_number}" required>
      </div>

      <div class="detail-value">
      <span class="question">Travel Date:</span>
      <input type="date" name="date" value="${date}">
      </div>
 
      <div class="detail-value">
        <button type="submit" name="edit" class="addRecordBtn">EDIT</button>
        <button type="submit" name="remove" class="addRecordBtn">REMOVE</button>
      </div>
  </form>
  </div>

  `;

  document.getElementById("editpopupContainer").style.display = "block";

  //updateLastEditDate();
}

window.closePopup = function () {
  const popupContainer = document.getElementById("addpopupContainer");
  const popupContainer2 = document.getElementById("editpopupContainer");
  popupContainer.style.display = "none";
  popupContainer2.style.display = "none";
  updateLastEditDate();
};

/* START USER ACCOUNTS PAGE */

function displayUserAccount(
  user_id,
  user_type,
  username,
  firstname,
  lastname,
  number,
  email,
  account_status
) {
  document.getElementById("editpopupContent").innerHTML = `
  <form method="POST" action="">
    <input type ="hidden" name="user_type" id="user_type" value="${user_type}">
    <input type ="hidden" name="firstname" id="firstname" value="${firstname}"> 
    <input type ="hidden" name="lastname" id="lastname" value="${lastname}">  
    <input type ="hidden" name="number" id="number" value="${number}">
    <input type ="hidden" name="email" id="email" value="${email}">
    <input type ="hidden" name="account_status" id="account_status" value="${account_status}"> 
    <input type ="hidden" name="user_id" id="user_id" value="${user_id}">  
    <input type ="hidden" name="username" id="username" value="${username}">
      <div class="details">

      <div class="detail-value">
      <span class="question">Username:</span>
      <input type="text" name="username" value="${username}" required>
      </div>

      <div class="detail-value">
      <span class="question">First Name:</span>
      <input type="text" name="firstname" value="${firstname}" required>
      </div>

      <div class="detail-value">
      <span class="question">Last Name:</span>
      <input type="text" name="lastname" value="${lastname}" required>
      </div>

      <div class="detail-value">
      <span class="question">Phone Number:</span>
      <input type="text" name="number" value="${number}" required>
      </div>

      <div class="detail-value">
      <span class="question">Email:</span>
      <input type="text" name="email" value="${email}" required>
      </div>
 
      <div class="detail-value">
      <button type="submit" name="edit" class="addRecordBtn">SAVE</button>
      <button type="submit" name="remove" class="addRecordBtn">REMOVE</button>
      </div>
    </form>
  </div>

  `;

  document.getElementById("editpopupContainer").style.display = "block";

  updateLastEditDate();
}

window.closePopupUA = function () {
  const popupContainer = document.getElementById("editpopupContainer");
  popupContainer.style.display = "none";
  updateLastEditDate();
};

/* START OF FEEDBACK PAGE */

var firebaseConfig = {
  apiKey: "AIzaSyDZYKEAdoUO_6aI1O-HN7tHR_JZicxCQVs",
  authDomain: "feedback-comment-32724.firebaseapp.com",
  databaseURL: "https://feedback-comment-32724-default-rtdb.firebaseio.com",
  projectId: "feedback-comment-32724",
  storageBucket: "feedback-comment-32724.appspot.com",
  messagingSenderId: "757100195149",
  appId: "1:757100195149:web:2aefd83d32317f2cf15b04",
};

firebase.initializeApp(firebaseConfig);

const firebaseConfig2 = {
  apiKey: "AIzaSyCM7d2Yghph9sjmxoRC_MLEC9iBTq-ORAg",
  authDomain: "archived-comments.firebaseapp.com",
  databaseURL: "https://archived-comments-default-rtdb.firebaseio.com",
  projectId: "archived-comments",
  storageBucket: "archived-comments.appspot.com",
  messagingSenderId: "574454007243",
  appId: "1:574454007243:web:ffcd0a9532316fa94ce24e",
  measurementId: "G-F9M8MLEXR4",
};

var firebaseApp2 = firebase.initializeApp(firebaseConfig2, "app2");

var database = firebase.database();
var ref = database.ref("comments");

function timeStamp() {
  var now = new Date();
  var date = [now.getMonth() + 1, now.getDate(), now.getFullYear()];
  var time = [now.getHours(), now.getMinutes()];
  var suffix = time[0] < 12 ? "AM" : "PM";
  time[0] = time[0] < 12 ? time[0] : time[0] - 12;

  for (var i = 1; i < 3; i++) {
    if (time[i] < 10) {
      time[i] = "0" + time[i];
    }
  }

  return date.join("/") + ", " + time.join(":") + " " + suffix;
}

/* STAR RATING

var currentRating = 0; // Default rating

// Event listener for star clicks
document
  .getElementById("star-rating")
  .addEventListener("click", function (event) {
    if (event.target.classList.contains("star")) {
      currentRating = parseInt(event.target.getAttribute("data-rating"));
      highlightStars(currentRating);
    }
  });

function highlightStars(rating) {
  // Highlight stars up to the selected rating
  var stars = document.querySelectorAll(".star");
  stars.forEach(function (star) {
    var starRating = parseInt(star.getAttribute("data-rating"));
    star.classList.toggle("selected", starRating <= rating);
  });
}

*/

var badWords = ["badword1", "badword2", "badword3", "wtf"];

function filterBadWords(comment) {
  // Convert the comment to lowercase for case-insensitive matching
  var lowerComment = comment.toLowerCase();

  // Check if the comment contains any bad words
  var containsBadWord = badWords.some(function (word) {
    return lowerComment.includes(word);
  });

  if (containsBadWord) {
    // Modify the comment or reject it based on your requirements
    alert(
      "This comment contains inappropriate content. Your comment will automatically be filtered and may be subjected for deletion."
    );
  }

  // Replace bad words with asterisks
  badWords.forEach(function (word) {
    var regex = new RegExp("\\b" + word + "\\b", "ig");
    comment = comment.replace(regex, "*".repeat(word.length));
  });

  // If no bad words found, return the original comment
  return comment;
}

function postComment(event) {
  var submitBtn = document.getElementById("submit-btn");

  // Disable the submit button to prevent multiple submissions
  submitBtn.disabled = true;

  var name = document.getElementById("name").value,
    comment = document.getElementById("comment").value,
    email = document.getElementById("email").value,
    time = timeStamp(),
    fileInput = document.getElementById("file-input"),
    file = fileInput.files[0];

  if (name && comment) {
    var mediaData = null;

    comment = filterBadWords(comment); // filters comments

    if (file) {
      var reader = new FileReader();
      reader.onloadend = function () {
        mediaData = reader.result;
        saveCommentToDatabase(
          name,
          comment,
          email,
          time,
          mediaData
          //currentRating
        );
      };
      reader.readAsDataURL(file);
    } else {
      saveCommentToDatabase(
        name,
        comment,
        email,
        time,
        mediaData
        //currentRating
      );
    }

    clearFormFields(); // Clear form fields after successful submission
  }

  // Re-enable the submit button after the comment is posted
  submitBtn.disabled = false;
}

// Simplified function to clear form fields
function clearFormFields() {
  document.getElementById("name").value = "";
  document.getElementById("comment").value = "";
  document.getElementById("email").value = "";
  document.getElementById("file-input").value = "";
}

function saveCommentToDatabase(name, comment, email, time, mediaData) {
  //rating) {
  // Save the data to the database, including the rating
  var newCommentRef = ref.push({
    name: name,
    comment: comment,
    time: time,
    email: email,
    mediaData: mediaData,
    //rating: rating,
  });

  // Retrieve the key after the comment is added
  var commentKey = newCommentRef.key;

  // Display the comment and rating
  addComment(commentKey, name, email, comment, time, mediaData);
}

// Use once method for initial loading
ref.once("value").then(function (snapshot) {
  snapshot.forEach(function (childSnapshot) {
    var comment = childSnapshot.val();
    var commentKey = childSnapshot.key;
    addComment(
      commentKey,
      comment.name,
      comment.email,
      comment.comment,
      comment.time,
      comment.mediaData
      //comment.rating
    );
  });
});

function addComment(
  commentKey,
  name,
  email,
  comment,
  timeStamp,
  mediaData
  //rating
) {
  var comments = document.getElementById("comments");
  var newComment = document.createElement("div");

  newComment.innerHTML =
    "<hr><h4>" +
    name +
    " says<span>" +
    timeStamp +
    "</span></h4><p>" +
    comment +
    //rating;
    "</p>";

  // Display the image or video based on the mediaData
  if (mediaData) {
    if (isImage(mediaData)) {
      newComment.innerHTML += `<img src="${mediaData}" alt="Uploaded Image" style="width: 100%;">`;
    } else if (isVideo(mediaData)) {
      newComment.innerHTML += `<video src="${mediaData}" controls style="width: 100%;"></video>`;
    }
  }

  newComment.setAttribute("data-comment-key", commentKey);

  // Insert the new comment at the beginning of the comments container
  comments.insertBefore(newComment, comments.firstChild);
}

function isImage(dataUrl) {
  return /^data:image\//.test(dataUrl);
}

function isVideo(dataUrl) {
  return /^data:video\//.test(dataUrl);
}
