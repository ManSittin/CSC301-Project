<?php include_once 'sidebar-db.php'?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link href='https://fonts.googleapis.com/css?family=Outfit' rel='stylesheet'>
    <title>CourseBind</title>
</head>
<body>
    <?php include_once 'sidebar-content.php'; ?>
    <div class="not-sidebar">
        <?php include_once 'navbar.html';
        $header_text = "Welcome to CourseBind! Use the links at the top of the page to access each of our core features :&rpar;
        The page will adapt dynamically to your chosen feature!";
        $page = "none"; // no page content
        include_once 'main.php';
        ?>
    </div>
</body>
<script src="script.js">
</script>
</html>