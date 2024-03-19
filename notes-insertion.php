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
<body>
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
        <div class="main">
            <h1>Welcome to the notes page. Here you can add new notes or view the ones you have already added. </h1>

            <!-- Add a Textbox Feature -->
            <div class="textbox-section">
                <h2>Enter a new note</h2>
                <form id="addNoteForm">
                    <p>Enter title:</p>
                    <textarea rows="4" cols="50" name="title" id="title" placeholder="Type your title here..."></textarea>
                    <br>
                        <!-- Planning to give the user freedom to create their own category -->
                    </select>
                    <p>Enter your note:</p>
                    <textarea rows="4" cols="50" name="note" id="note" placeholder="Type your note here..."></textarea>
                    <br>
                    <input type="button" value="Add Note" onclick="addNote()">
                </form>
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
