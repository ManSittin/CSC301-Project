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
    <?php include_once 'sidebar-content.php'; ?>
    <div class="not-sidebar">
        <?php include_once 'navbar.html';
        $header_text = "Welcome to the deadlines page. Here you can add new deadlines or view the ones you have already added. ";
        $page = "deadlines-insertion";
        include_once 'main.php';
        ?>
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
