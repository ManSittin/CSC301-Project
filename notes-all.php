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
                
        <div id="note info">
        <h2>Recent Notes</h2>
        <?php
            if ($numNotes > 0) {
                while ($note = mysqli_fetch_assoc($notes)) {
                    echo '<div class="info-block">' . htmlspecialchars($note["title"]) . '</div>';
                }
                // Reset the data pointer for $notes
                mysqli_data_seek($notes, 0);
            }
        ?>
        </div>

        <div class="main">
        <h1>Welcome to the notes page. Here you can view all of your notes and edit them!</h1>
        <?php
        if ($numNotes > 0) {
            while ($note = mysqli_fetch_assoc($notes)) {
                echo '<div class="note-container">';
                echo '<div class="note-title">' . htmlspecialchars($note['title']) . '</div>';
                echo '<div class="note-content">' . htmlspecialchars(substr($note['content'], 0, 50)) . '...</div>'; // preview

                // Update the onclick attribute below
                echo '<button class="edit-button" onclick="location.href=\'notes-view.php?id=' . $note['id'] . '\'">View/Edit</button>';
                echo '</div>';
            }
        } else {
            echo '<p>No notes found.</p>';
            echo '<p>No notes fod.</p>';
        }
    ?>
        </div>


    <script src="script.js"></script>
</body>
    </div>
</body>
</html>
