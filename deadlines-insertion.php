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
            <h1>Welcome to the deadlines page. Here you can add new deadlines or view the ones you have already added. </h1>

            <!-- Add a Textbox Feature -->
            <div class="textbox-section">
                <h2>Enter a new deadline below</h2>
                <form id="addDeadlineForm">
                    <p>Enter Course: </p>
                    <textarea rows="1" cols="50" name="tags" id="tags" placeholder="Type your course here..."></textarea>
                    </select>
                    <p>Enter Deadline Name:</p>
                    <textarea rows="1" cols="50" name="title" id="title" placeholder="Enter the name of your deadline here..."></textarea>
                    <input
                        type="datetime-local"
                        id="date"
                        name="date"
                        value="2024-02-05T15:00"
                        min="0000-00-00T00:00"
                        max="9999-12-31T23:59"
                     />
                    <br><br>
                    <input type="button" value="Submit deadline" onclick="addDeadline()">
                </form>
            </div>
        </div>
    </div>

    <script src="script.js">
    </script>
</body>
</html>