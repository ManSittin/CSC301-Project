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