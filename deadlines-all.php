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
        <?php include_once 'navbar.html'?>
        <!-- hard-coded note for now; will pull this in when a note is selected -->
                
        <div id="deadline info">
        <h2>Recent Deadlines</h2>
        <?php
            if ($numDeadlines > 0) {
                while ($deadline = mysqli_fetch_assoc($deadlines)) {
                    echo '<div class="info-block">' . htmlspecialchars($deadline["course"]) . '</div>';
                }
                // Reset the data pointer for $notes
                mysqli_data_seek($deadlines, 0);
            }
        ?>
        </div>

        <div class="main">
        <h1>Welcome to the deadlines page. Here you can view all the deadlines you have previously added!</h1>
        <?php
        if ($numDeadlines > 0) {
            while ($deadline = mysqli_fetch_assoc($deadlines)) {
                echo '<div class="note-container">';
                echo '<div class="deadline-course">' . htmlspecialchars($deadline['course']) . '</div>';
                echo '<div class="note-content">' . htmlspecialchars(substr($deadline['deadline_name'], 0, 50)) . '...</div>'; // preview
                echo '<div class="deadline-date">Due: ' . htmlspecialchars($deadline['due_date']) . '</div>'; // Displaying the due date

            
                // Update the onclick attribute below
                echo '<button class="edit-button" onclick="location.href=\'deadlines-view.php?id=' . $deadline['id'] . '\'">View/Edit</button>';
                echo '</div>';
            }
        } else {
            echo '<p>No deadlines found.</p>';
        }
    ?>
        </div>


    <script src="script.js"></script>
</body>
    </div>
</body>
</html>