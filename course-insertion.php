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
        $header_text = "Welcome to the schedule page. Here you can add new courses, view the ones you have already or generate a schedule for your courses.";
        $page = "course-insertion"; 
        include_once 'main.php';
        ?>
    </div>
    <script src="script.js">
    </script>
</body>
</html>
