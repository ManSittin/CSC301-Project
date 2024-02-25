<?php
    include_once 'dbh.php';
    include_once "Session.php";
    // sidebar database info
   if ($_SESSION['onlineUsers']){
    $loggedInUserId = $_SESSION['onlineUsers'];
   
      $deadlineQuery = "SELECT * FROM Deadlines WHERE Deadlines.username = ?";




      $stmt = mysqli_prepare($conn, $deadlineQuery);

      // Bind the username parameter
      mysqli_stmt_bind_param($stmt, "s", $loggedInUserId);
      
      // Execute the statement
      mysqli_stmt_execute($stmt);
      
      // Get the result
      $deadlines = mysqli_stmt_get_result($stmt);
    
    $numDeadlines = mysqli_num_rows($deadlines);

    $notesQuery = "SELECT * FROM Notes WHERE Notes.username = ?";


    
    $stmt1 = mysqli_prepare($conn, $notesQuery);

    // Bind the username parameter
    mysqli_stmt_bind_param($stmt1, "s", $loggedInUserId);
    
    // Execute the statement
    mysqli_stmt_execute($stmt1);
    
    // Get the result
    $notes = mysqli_stmt_get_result($stmt1);
    $numNotes =  mysqli_num_rows($notes);
   }
   else{
    $deadlineQuery = 'no query';

    $loggedInUserId = false;
    $numDeadlines = 0;
    $numNotes = 0;

   }
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






.userlogin{
    display: flex;
    text-align: center;
    justify-content: center;
    margin-top: 8%;
  }
  
  .signin{
   width: 25%;
   background-color: white;
   height:600px;
   border-radius: 3%;
   
  }
  .signin h1{
    margin-bottom: 15%;
  }
  
  
  .signup{
  width: 25%;
  background-color: rgb(112, 148, 210);
  height: 600px;
  border-radius: 3%;
  }
  
  .form{
    margin-top: 5%;
  }
  
  .email{
    border: none;
  }
  .password{
    border: none;
  }
  
  input{
    background-color: rgba(49, 48, 48, 0.088);
    border: none;
    width: 70%;
    padding: 3% 0 3% 3%;
  }
  .btnform{
    margin-top: 5%;
    border-radius: 11%;
    font-weight: bolder;
    border: none;
    color: white;
    width: 35%;
    padding: 3% 3%;
    background-color:  rgb(112, 148, 210);
    margin-bottom: 5%;
  
  }
  
  .signup{
  display: inline-block;
  
  
  }
  
  .signup1{
  color: white;
  font-size: 30px;
  margin-top: 20%;
  }
  .signup2{
    font-size: 18px;
    color: white;
    font-weight: 300;
  }
  
  .btnsignup{
    margin-top: 5%;
    border-radius: 11%;
    font-weight: bolder;
    border: none;
    color:  rgb(112, 148, 210);
    width: 35%;
    padding: 3% 3%;
    background-color:  rgb(255, 255, 255);
    margin-bottom: 5%;
  }


  @media (max-width: 480px) {
    .userlogin {
      flex-direction: column;
    }

    .signin,
    .signup {
      flex-basis: 100%;
    }
  }

  /* Responsive styles for screen size >= 481px and <= 768px */
  @media (min-width: 481px) and (max-width: 768px) {
    .userlogin {
      flex-direction: column;
    }

    .signin,
    .signup {
      flex-basis: 100%;
    }

    h1 {
      font-size: 24px;
    }

    .btnsignup {
      padding: 10px 20px;
      font-size: 16px;
    }
  }

  /* Responsive styles for screen size >= 769px and <= 1024px */
  @media (min-width: 769px) and (max-width: 1024px) {
    .userlogin {
      flex-wrap: wrap;
    }

    .signin,
    .signup {
      flex-basis: 48%;
    }
  }

  /* Responsive styles for screen size >= 1025px */
  @media (min-width: 1025px) {
    .userlogin {
      max-width: 1200px;
      margin: 0 auto;
      padding: 40px;
    }

    .signin,
    .signup {
      flex-basis: 40%;
    }

    h1 {
      font-size: 36px;
    }

    .btnsignup {
      padding: 20px 40px;
      font-size: 24px;
    }
  }

    </style>
</head>
<body>
    <div id="sidebar">
        <div class="nav" id="sidebar-nav">
            <label class="non-desktop hamburger-menu" id="sidebar-open-hamburger">
                <input type="checkbox" id="toggle-closed">
            </label>
            <a href = "profile.php" >profile</a>
            <a>settings</a>
           <?php
                if( $_SESSION['onlineUsers']){
                 
                  
                  echo  '<button onClick="handlelogout()"> Logout </button>';
                }
                ?>
        </div>
        <div id="sidebar-info">
            <div id="assignment info">
                <h2>Assignments</h2>
                <!-- <div class="info-block">Test</div> -->
                <?php
                    if ($numDeadlines > 0 &&  $_SESSION['onlineUsers'] ) {
                        while ($deadline = mysqli_fetch_assoc($deadlines)) {
                            echo '<div class="info-block">' . $deadline["deadline_name"]
                            . ' : ' . $deadline['due_date'] . '</div>';
                        }
                    }
                ?>
            </div>
            <div id="note info">
                <h2>Recent Notes</h2>
                <!-- <div class="info-block">Test</div> -->
                <?php
                    if ($numNotes > 0 && $_SESSION['onlineUsers'] ) {
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
            <a href="notes.php">notes</a>
            <a>flashcards</a>
            <a href="deadlines.php">assignments</a>
            <a>schedule</a>
        </div>
        <div class="main">
        <div >

            <div className='userlogin'>
      <div className='signin'>
        <h1>Sign in</h1>
        <span>or use your account</span>
        <form className='form' id = "login">
          <fieldset>
            <input type='email'
            placeholder='Email' />
          </fieldset>
          <fieldset>
            <input type='password'
            placeholder='Password' />
          </fieldset>
          <button type='button' className='btnsignin' onClick="handleSignInClick()">
          SIGN In
        </button>
    
        </form>
        <span className='forgotpassword' onClick={handlePassword}>
        <a href="Index.php">Home </a>
        </span>
      </div>
  
      <div className='signup'>
        <div className='signup1'>
          <h1> Join us today</h1>
        </div>
        <button type='button' className='btnsignup' onClick="handleSignupClick()">
          SIGN UP
        </button>
      </div>
    </div>
            </div>

            <!-- Placeholder for displaying notes by category -->
            <div class="notes-by-category" id="notesByCategory">
                <!-- Display notes here based on the selected category -->
            </div>
        </div>
    </div>

    <script src="script.js">
    </script>
</body>
</html>
