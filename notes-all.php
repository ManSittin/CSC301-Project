<?php include_once 'sidebar-db.php';?>
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
    <?php include_once 'sidebar-content.php'; ?>
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
        <!-- hard-coded note for now; will pull this in when a note is selected -->
                
        <div id="note info">
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
        }
    ?>
        </div>


    <script src="script.js"></script>
</body>
    </div>
</body>
</html>
