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
            <h1>Welcome to the flashcards page. Here you can add new flashcards or review the ones you have already added. </h1>

            <!-- Add a Textbox Feature -->
            <div class="textbox-section">
                <h2>Review Flashcards</h2>
                <div class="flashcards">
                    <div class="cue"><h3>Cue</h3></div>
                    <div class="response"><h3>Response</h3></div>
                </div>

                <div class="flashcard-buttons">
                    <div class="reveal"><button>Reveal Response</button></div>
                    <div class="next"><button>Next Cue</button></div>
                </div>

            </div>


            </div>

        </div>
    </div>

    <script src="script.js">
    </script>
</body>
</html>
