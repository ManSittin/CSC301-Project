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
            <a href="#">assignments</a>
            <a href="#">schedule</a>
        </div>
        <div class="main">
            <h1>Welcome to the deadlines page. Here you can register deadlines for the scheduler, so that you can be reminded of them.</h1>

            <!-- Add a Textbox Feature -->
            <div class="textbox-section">
                <h2>Enter a new deadline below</h2>
                <form id="addDeadlineForm">
                    <p>Select tags:</p>
                    <textarea rows="4" cols="50" name="tags" id="tags" placeholder="Type your tags here..."></textarea>
                    <br>
                    </select>
                    <p>Enter the title:</p>
                    <textarea rows="1" cols="50" name="title" id="title" placeholder="Enter your title here..."></textarea>
                    <br>
                    <p>Enter a description:</p>
                    <textarea rows="4" cols="50" name="description" id="description" placeholder="Type a description here..."></textarea>
                    <br>
                    <p>Enter a date and time:</p>
                    <input
                        type="datetime-local"
                        id="date"
                        name="date"
                        value="2024-02-05T15:00"
                        min="0000-00-00T00:00"
                        max="9999-12-31T23:59"
                     />
                    <br><br>
                    <!--<textarea rows="4" cols="50" name="datetime" id="datetime" placeholder="Enter your date and time here..."></textarea> this is the original format
                    <br>
                    <input type="button" value="Add Datetime" onclick="setDateTime()"> -->
                    </select>
                </form>
                <input type="button" value="Submit deadline" onclick="submit()">
            </div>

            <!-- Placeholder for displaying deadlines by tag -->
            <div class="deadlines-by-tag" id="deadlinesByTag">
                <!-- Display deadlines here based on the selected tags -->
            </div>
        </div>
    </div>

    <script src="script.js">
    </script>
</body>
</html>