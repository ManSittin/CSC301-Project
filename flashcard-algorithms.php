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
    </style>
</head>
<body>
    <?php include_once 'sidebar-content.php'; ?>
    <div class="not-sidebar">
        <?php include_once 'navbar.html';
        $header_text = "Choose a flashcard algorithm below. 'Random' will give you a random flashcard each time. 'Leitner' will prioritize flashcards you struggle the most with. Switching algorithms will reset the state of all flashcards.";
        $page = "flashcard-algorithms";
        include_once 'main.php';
        ?>
    </div>
    <script src="script.js">
    </script>
</body>
</html>
