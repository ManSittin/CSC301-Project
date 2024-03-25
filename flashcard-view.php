<?php
    include_once 'sidebar-db.php';
    // Fetch Note for Editing
    $noteForEditing = null; // Initialize variable to hold note data for editing
    if (isset($_GET['id'])) {
        $flashcardID = $_GET['id'];
        $stmt = $conn->prepare("SELECT * FROM Flashcards WHERE id = ?");
        $stmt->bind_param("i", $flashcardID);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
             $flashcardForEditing = $result->fetch_assoc();
        } else {
            echo "<script>alert('Flashcard not found.'); window.location.href='notes-all.php';</script>";
        }
        $stmt->close();
    } else {
         echo "<script>alert('Flashcard Edited'); window.location.href='flashcard-all.php';</script>";
    }

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
<body onload="loadNote(<?php echo isset($flashcardForEditing['id']) ? $flashcardForEditing['id'] : 'null'; ?>)">
    <?php include_once 'sidebar-content.php'; ?>
    <div class="not-sidebar">
        <?php include_once 'navbar.html';
        $header_text = "Welcome to the flashcards page. Here you can add new flashcards or review the ones you have already added. ";
        $page = "flashcards-view";
        include_once 'main.php';
        ?>
    </div>

    <script src="script.js">
    </script>
</body>
</html>
