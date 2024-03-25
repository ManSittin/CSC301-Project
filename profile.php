<?php include_once 'sidebar-db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://fonts.googleapis.com/css?family=Outfit' rel='stylesheet'>
    <title>CourseBind</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include_once 'sidebar-content.php'; ?>
    <div class="not-sidebar">
      <?php include_once 'navbar.html';
        $header_text = ""; //none
        $page = "profile";
        include_once 'main.php';
        ?>
    <script src="script.js">
    </script>
</body>
</html>
