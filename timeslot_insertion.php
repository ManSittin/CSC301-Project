<?php include_once 'sidebar-db.php'; ?>
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
            <a href="schedule.php">schedule</a>
        </div>
        <div class="main">
            <h1>Welcome to the schedule page. Here you can add new courses, view the ones you have already or generate a schedule for your courses. </h1>

            <!-- Add a Textbox Feature -->
            <div class="textbox-section">
                <h2>Enter timeslot below</h2>
                <form id="addTimeslotForm">
                    <p>Enter Day of Week: </p>
                    <select id="dayOfWeek">
                        <option value="Monday">Monday</option>
                        <option value="Tuesday">Tuesday</option>
                        <option value="Wednesday">Wednesday</option>
                        <option value="Thursday">Thursday</option>
                        <option value="Friday">Friday</option>
                        <option value="Saturday">Saturday</option>
                        <option value="Sunday">Sunday</option>
                    </select>
                    <br><br>
                    <p>Enter class start time: </p>
                    <input
                        type="time"
                        id="startTime"
                        value="09:00"
                    >
                    <br><br>
                    <p>Enter class length in hours</p>
                    <input
                        type="number"
                        min="0"
                        max="4"
                        value="0"
                    >
                    <br><br>
                    <input type="button" value="Add timeslot" onclick="addTimeslot()">
                </form>
            </div>
        </div>
    </div>

    <script src="script.js">
    </script>
</body>
</html>
