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
    <link rel="stylesheet" href="styles.css">
    <link href='https://fonts.googleapis.com/css?family=Outfit' rel='stylesheet'>
    <title>CourseBind</title>
    <style>
        /* Existing style here */
    </style>
</head>
<body onload="loadNote(4)">
    <div id="sidebar">
        <div class="nav" id="sidebar-nav">
            <label class="non-desktop hamburger-menu" id="sidebar-open-hamburger">
                <input type="checkbox" id="toggle-closed">
            </label>
            <a href = "profile.php">profile</a>
            <a>settings</a>
        </div>
        <div id="sidebar-info">
            <div id="assignment info">
                <h2>Assignments</h2>
                <!-- <div class="info-block">Test</div> -->
                <?php
                    if ($numDeadlines > 0) {
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
            <a href="notes.php">notes</a>
            <a href="flashcards.php">flashcards</a>
            <a href="deadlines.php">assignments</a>
            <a href="#">schedule</a>
        </div>
        <!-- hard-coded note for now; will pull this in when a note is selected -->
        <div class="main">
            <h1>Welcome to the deadlines page. Here you can add new deadlines or view the ones you have already added. </h1>
            <div class="textbox-section">
                <!-- Loaded note info preloads here... -->
                <h2 class="note-title">Your Note</h2> 
                <form id="editNoteForm">
                    <textarea rows="4" cols="50" name="note" class="note-body"></textarea>
                    <br>
                    <input type="button" value="Update Note" class="update-note">
                </form>
        </div>
    </div>

    <script src="script.js">
    </script>
</body>
</html>
