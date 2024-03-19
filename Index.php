<?php include_once 'sidebar-db.php'?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link href='https://fonts.googleapis.com/css?family=Outfit' rel='stylesheet'>
    <title>CourseBind</title>
</head>
<body>
    <div id="sidebar">
        <div class="nav" id="sidebar-nav">
            <label class="non-desktop hamburger-menu" id="sidebar-open-hamburger">
                <input type="checkbox" id="toggle-closed">
            </label>
            <a href = "profile.php" > profile</a>
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
                            echo '<div class="info-block">' . $note["title"] . '<button class="del-button" id="' . $note["id"] . '" onclick="handleNoteDelete(event)">✖</button></div>';
                        }
                    }
                ?>
            </div>
            <div id = "result"> </div>
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
            <a href="schedule.php">schedule</a>
        </div>
        <div class="main">
            <h1>Welcome to CourseBind! Use the links at the top of the page to access each of our core features :&rpar;
                The page will adapt dynamically to your chosen feature!
            </h1>
        </div>
    </div>
    
</body>
<script src="script.js">
</script>
</html>