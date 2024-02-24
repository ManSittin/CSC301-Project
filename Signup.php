<?php
    include_once 'dbh.php';

    // sidebar database info
    $deadlineQuery = "SELECT * FROM Deadlines;";
    $deadlines = mysqli_query($conn, $deadlineQuery);
    $numDeadlines = mysqli_num_rows($deadlines);
    $notesQuery = "SELECT * FROM Notes;";
    $notes = mysqli_query($conn, $notesQuery);
    $numNotes = mysqli_num_rows($notes);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://fonts.googleapis.com/css?family=Outfit' rel='stylesheet'>
    <title>CourseBind</title>
    <style>
       body, html {
  width: 100%;
  height: 100%;
  margin: 0;
  padding: 0;
  display: flex;
  font: #001858;
  font-family: Outfit;
}

#sidebar {
  width: 25vw;
  height: 100vh;
  background-color: #8BD3DD;
}

.not-sidebar {
  width: 75vw;
  height: 100vh;
  background-color: #FEF6E4;
}

.nav {
  display: flex;
  justify-content: space-around;
  position: absolute;
  top: 5vh;
}

a {
  text-decoration: none;
  all: unset;
}

#sidebar .nav {
  left: 2.5%;
  width: 20%;
}

#sidebar-info {
  position: absolute;
  top: 15vh;
  left: 2.5vw;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  gap: 20px;
}

.assignment-info, .note-info {
  display: flex;
  gap: 5px;
}

.not-sidebar .nav {
  right: 0px;
  width: 40%;
}
.main {
  height: 83%;
  margin: 10% 2% 2% 2%;
  border: 1px solid black;
  text-align: center;
}

.non-desktop {
  display: none;
}


.info-block {
  background-color: #f582ae;
  text-align: center;
  width: 20vw;
  height: 15%;
}

#sidebar-info h2 {
  word-wrap: break-word;
}

/* tablet view */

@media only screen and (max-width: 768px) {

  #sidebar {
      display: none;
  }

  .non-desktop {
      display: inline;
  }

  .not-sidebar {
      width: 100%;
  }

  .not-sidebar .nav {
      right: 0px;
      width: 100%;
  }

  .main {
      height: 90%;
  }

  .nav {
      top: 3vh;
  }

  .hamburger-menu {
      display: flex;
      flex-direction: column;
      gap: 6px;
      width: max-content;
      cursor: pointer;
      z-index: 2;
  }

  #sidebar-closed-hamburger::before, #sidebar-closed-hamburger::after, #sidebar-closed-hamburger input {
      background-color: #8BD3DD;
  }

  #sidebar-open-hamburger::before, #sidebar-open-hamburger::after, #sidebar-open-hamburger input {
      background-color: #f582ae;
  }

  .hamburger-menu::before, .hamburger-menu::after, .hamburger-menu input {
      content: "";
      width: 60px;
      height: 6px;
      border-radius: 9999px;
      transform-origin: left center;
  }

  .hamburger-menu input {
      appearance: none;
      padding: 0;
      margin: 0;
      outline: none;
      pointer-events: none;
  }

  #sidebar-info {
      position: absolute;
      top: 15vh;
      left: 4vw;
  }

  #sidebar-info h2 {
      font-size: 10px;
  }

  .info-block {
      background-color: #f582ae;
      text-align: center;
      width: 15vw;
      height: 15%;
  }
}


/* mobile view */
@media only screen and (max-width: 600px) {

  .nav {
      top: 2vh;
  }
}




.signuppage {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
}

.signupform {
  width: 500px;
  height: 700px; /* Increased height to accommodate wrapped text */
  background-color: white;
  border-radius: 5px;
  padding: 40px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
  margin-top: -50px;
  word-wrap: break-word; /* Added word-wrap to wrap long texts */
}


.signupform h1 {
  margin-bottom: 20px;
  color: #333;
}

.signupform p {
  color: #777;
  margin-bottom: 30px;
}

.inputField {
  margin-bottom: 15px;
}

.inputField label {
  display: block;
  margin-bottom: 5px;
  color: #333;
}

.inputField input {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
  outline: none;
}

.btnformReg {
  margin-top: 20px;
  border-radius: 4px;
  font-weight: bold;
  border: none;
  color: white;
  width: 100%;
  padding: 12px;
  background-color: rgb(112, 148, 210);
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.btnformReg:hover {
  background-color: #7596cc;
}

span {
  color: #777;
}

a {
  color: rgb(112, 148, 210);
  text-decoration: none;
}

a:hover {
  text-decoration: underline;
}

.password-length-info {
  font-size: 12px;
  color: #666;
  margin-top: 1px;
}

    </style>
</head>
<body>
    <div id="sidebar">
        <div class="nav" id="sidebar-nav">
            <label class="non-desktop hamburger-menu" id="sidebar-open-hamburger">
                <input type="checkbox" id="toggle-closed">
            </label>
            <a>profile</a>
            <a>settings</a>
        </div>
        <div id="sidebar-info">
            <div id="assignment info">
                <h2>Assignments</h2>
                <!-- <div class="info-block">Test</div> -->
                <?php
                    if ($numDeadlines > 0) {
                        while ($deadline = mysqli_fetch_assoc($deadlines)) {
                            echo '<div class="info-block">' . $deadline["deadline_name"] . ' : ' . $deadline['due_date'] . '<button class="del-button" id="' . $deadline["id"] . '"onclick="handleDeadlineDelete(event)">✖</button></div>';
                        }
                    }
                ?>
            </div>
            <div id="note info">
                <h2>Recent Notes</h2>
                <!-- <div class="info-block">Test</div> -->
                <?php
                    if ($numNotes > 0) {
                        while ($note = mysqli_fetch_assoc($notes)) {
                            echo '<div class="info-block">' . $note["title"] . '</div>';
                        }
                    }
                ?>
            </div>
        </div>
    </div>
    </div>
    <div class="not-sidebar">
        <div class="nav" id="pages-nav">
            <label class="non-desktop hamburger-menu" id="sidebar-closed-hamburger">
                <input type="checkbox" id="toggle-open">
            </label>
            <a href="#">notes</a>
            <a href="#">flashcards</a>
            <a href="deadlines.php">assignments</a>
            <a href="#">schedule</a>
        </div>
        <div class="main">
        <div className='signuppage'>
      <div className='signupform'>
        <h1>Join Us Today!</h1>
        <p>Sign up and start exploring our platform!</p>
        <form id = "signup" className="formReg">
          <div className="inputField">
            <label htmlFor="firstName">First Name*</label>
            <input type="text" id="firstName" placeholder="Enter your first name" 
            />
          </div>
          <div className="inputField">
            <label htmlFor="lastName">Last Name*</label>
            <input type="text" id="lastName" placeholder="Enter your last name"
            />
            
          </div>


          <div className="inputField">
            <label htmlFor="email">Email*</label>
            <input type="email" id="email" placeholder="Enter your email"
            />

          
          
          </div>

          <div className="inputField">
            <label htmlFor="user">Username*</label>
            <input type="user" id="username" placeholder="Enter your username"

            /> 
          </div>

          <div className="inputField">
            <label htmlFor="password">Password*</label>
            <input type="password" id="password" placeholder="Enter your password" 
            />
          </div>
          <span className="password-length-info">(Password must be longer than 8 characters)</span>
          <button type="button" className="btnformReg" onClick="handleSignUpClick()">
            SIGN UP
          </button>
        </form>
        <span>Already have an account? <a href="profile.php">Sign In</a></span>
      </div>
    </div>

            <!-- Placeholder for displaying notes by category -->
            <div class="notes-by-category" id="notesByCategory">
                <!-- Display notes here based on the selected category -->
            </div>
        </div>
    </div>

    <script>


    function handleSignUpClick() {
    // Prevent the default form submission behavior
    console.log(document.getElementById("signup").elements)
   // event.preventDefault();
  
    // Retrieve the email and password from the input fields
    var firstname = document.getElementById("firstName").value;
    var lastname = document.getElementById("lastName").value;
    var email =  document.getElementById("email").value;
    var username =  document.getElementById("username").value;
    var password =  document.getElementById("password").value;
    
    // Perform validation if needed

    // Perform sign-in logic (e.g., send AJAX request to the server)
    // Here, you can use fetch() or any other method to send the data to the server
    // For demonstration purposes, we'll simply log the email and password
    var formData = new FormData();
            formData.append('command', 'users');
            formData.append('first_name', document.getElementById("firstName").value);
            formData.append('last_name', document.getElementById("lastName").value);
            formData.append('email', document.getElementById("email").value);
            formData.append('username', document.getElementById("username").value);
            formData.append('password', document.getElementById("password").value);

        fetch('/server.php', {
                method: 'POST',
                body: formData,
            })
        .then(data => {
    // Handle the data returned by the server
        console.log('Response:', data);

    // Check the status field in the response
        if (data.status ===  200) {
            alert('user online !');
        // User data retrieval was successful
        // You can access the user data from the 'message' field in the response
        console.log('User data:', data.message);
    } else {
        // User data retrieval failed
        console.error('Error:', data.message);
    }
})
    
          
}
    </script>
</body>
</html>
