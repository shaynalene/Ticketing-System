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
      <span class="question">Pickup:</span>
      <input type="text" name="pickup" value="" required>
      </div>

      <div class="detail-value">
      <span class="question">Drop Off:</span>
      <input type="text" name="dropoff" value="" required>
      </div>

      <div class="detail-value">
      <span class="question">Price:</span>
      <input type="text" name="price" value="" required>
      </div>

      <div class="detail-value">
      <span class="question">Bus Number:</span>
      <input type="text" name="number" value="" required>
      </div>

      <div class="detail-value">
      <span class="question">Travel Date:</span>
      <input type="text" name="date" value="" required>
      </div>

      <div class="detail-value">
      <span class="question">Arrival Time:</span>
      <input type="text" name="date" value="" required>
      </div>
 
      <div class="detail-value">
      <span class="question">Status:</span>
      <input type="text" name="status" value="" required>
      </div>
 
      <div class="detail-value">
      <button type="submit" name="save" class="addRecordBtn">ADD RECORD</button>
      </div>
      </form>
  </div>
  `;

  document.getElementById("addpopupContainer").style.display = "block";

  updateLastEditDate();
}

function displayRecord(schedule_id, pick_up, drop_off, price) {
  document.getElementById("editpopupContent").innerHTML = `
  <form method="POST" action="">
    <input type ="hidden" name="schedule_id" id="schedule_id" value="${schedule_id}">
      <input type ="hidden" name="pick_up" id="pick_up" value="${pick_up}">
      <input type ="hidden" name="drop_off" id="drop_off" value="${drop_off}"> 
      <input type ="hidden" name="price" id="price" value="${price}">  
      <div class="details">
      
      <div class="detail-value">
      <span class="question">Pickup:</span>
      <input type="text" name="pickup" value="${pick_up}" required>
      </div>

      <div class="detail-value">
      <span class="question">Drop Off:</span>
      <input type="text" name="dropoff" value="${drop_off}" required>
      </div>

      <div class="detail-value">
      <span class="question">Price:</span>
      <input type="text" name="price" value="${price}" required>
      </div>

      <div class="detail-value">
      <span class="question">Bus Number:</span>
      <input type="text" name="number" value="" required>
      </div>

      <div class="detail-value">
      <span class="question">Travel Date:</span>
      <input type="text" name="date" value="" required>
      </div>

      <div class="detail-value">
      <span class="question">Arrival Time:</span>
      <input type="text" name="date" value="" required>
      </div>
 
      <div class="detail-value">
      <span class="question">Status:</span>
      <input type="text" name="status" value="" required>
      </div>
 
      <div class="detail-value">
      <form method="post" action="">
        <button type="submit" name="edit" class="addRecordBtn">EDIT</button>
        <button type="submit" name="remove" class="addRecordBtn">REMOVE</button>
      </form>
      </div>
  </form>
  </div>

  `;

  document.getElementById("editpopupContainer").style.display = "block";

  updateLastEditDate();
}

window.closePopup = function () {
  const popupContainer = document.getElementById("addpopupContainer");
  const popupContainer2 = document.getElementById("editpopupContainer");
  popupContainer.style.display = "none";
  popupContainer2.style.display = "none";
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

    if (file) {
      var reader = new FileReader();
      reader.onloadend = function () {
        mediaData = reader.result;
        saveCommentToDatabase(name, comment, email, time, mediaData);
      };
      reader.readAsDataURL(file);
    } else {
      saveCommentToDatabase(name, comment, email, time, mediaData);
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
  console.log("saving to database comment...");
  // Save the data to the database
  var newCommentRef = ref.push({
    name: name,
    comment: comment,
    time: time,
    email: email,
    mediaData: mediaData,
  });

  // Retrieve the key after the comment is added
  var commentKey = newCommentRef.key;

  // Display the comment
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
    );
  });
});

function addComment(commentKey, name, email, comment, timeStamp, mediaData) {
  var comments = document.getElementById("comments");
  var newComment = document.createElement("div");

  newComment.innerHTML =
    "<hr><h4>" +
    name +
    " says<span>" +
    timeStamp +
    "</span></h4><p>" +
    comment +
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
