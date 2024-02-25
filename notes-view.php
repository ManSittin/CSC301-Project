<?php
    include_once 'dbh.php';

    // sidebar database info
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
    // Fetch Note for Editing
    $noteForEditing = null; // Initialize variable to hold note data for editing
    if (isset($_GET['id'])) {
        $noteId = $_GET['id'];
        $stmt = $conn->prepare("SELECT * FROM Notes WHERE id = ?");
        $stmt->bind_param("i", $noteId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
             $noteForEditing = $result->fetch_assoc();
        } else {
            echo "<script>alert('Note not found.'); window.location.href='notes-all.php';</script>";
        }
        $stmt->close();
    } else {
         echo "<script>alert('Note Edited'); window.location.href='notes-all.php';</script>";
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link href='https://fonts.googleapis.com/css?family=Outfit' rel='stylesheet'>
    <title>CourseBind</title>
    <style>
        /* Existing style here */
    </style>
</head>
<body onload="loadNote(<?php echo isset($noteForEditing['id']) ? $noteForEditing['id'] : 'null'; ?>)">
    <div id="sidebar">
        <div class="nav" id="sidebar-nav">
            <label class="non-desktop hamburger-menu" id="sidebar-open-hamburger">
                <input type="checkbox" id="toggle-closed">
            </label>
            <a href = "profile.php">profile</a>
            <a>settings</a>
            <?php
                if($_SESSION['onlineUsers'] ){echo  '<button onClick="handlelogout()"> Logout </button>';}
                ?>
        </div>
        <div id="sidebar-info">
            <div id="assignment info">
                <h2>Assignments</h2>
                <!-- <div class="info-block">Test</div> -->
                <?php
                    if ($numDeadlines > 0 && $_SESSION['onlineUsers']) {
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
                    if ($numNotes > 0 && $_SESSION['onlineUsers']) {
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
            <a href="flashcards.php">flashcards</a>
            <a href="deadlines.php">assignments</a>
            <a href="#">schedule</a>
        </div>
        <!-- hard-coded note for now; will pull this in when a note is selected -->
        <div class="main">
            <h1>Welcome to the notes page. Here you can add new notes or view the ones you have already added.</h1>
            <div class="textbox-section">
                <!-- Loaded note info preloads here... -->
                <h2 class="note-title">Your Note</h2> 
                <form id="editNoteForm" method="post" action="notes-view.php">
                <input type="hidden" id="hiddenNoteId" value="<?php echo isset($noteForEditing['id']) ? $noteForEditing['id'] : ''; ?>">
                <textarea rows="4" cols="50" name="noteContent" class="note-body"><?php echo isset($noteForEditing['content']) ? $noteForEditing['content'] : ''; ?></textarea>
                <br>
                <input type="submit" value="Update Note" class="update-note">
            </form>
        </div>
    </div>

    <script src="script.js">
    </script>
</body>
</html>
