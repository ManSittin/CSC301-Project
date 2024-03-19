<?php
    include_once 'sidebar-db.php';
    // Fetch Note for Editing
    $noteForEditing = null; // Initialize variable to hold note data for editing
    if (isset($_GET['id'])) {
        $noteId = $_GET['id'];
        $stmt = $conn->prepare("SELECT * FROM Notes WHERE id = ?");
        $stmt->bind_param("i", $noteId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
             $noteForEditing = $result->fetch_assoc();
        } else {
            echo "<script>alert('Note not found.'); window.location.href='notes-all.php';</script>";
        }
        $stmt->close();
    } else {
         echo "<script>alert('Note Edited'); window.location.href='notes-all.php';</script>";
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
<body onload="loadNote(<?php echo isset($noteForEditing['id']) ? $noteForEditing['id'] : 'null'; ?>)">
    <?php include_once 'sidebar-content.php'; ?>
    <div class="not-sidebar">
        <?php include_once 'navbar.html';
        $header_text = "Welcome to the notes page. Here you can add new notes or view the ones you have already added.";
        $page = "notes-view";
        include_once 'main.php';
        ?>
    </div>

    <script src="script.js">
    </script>
</body>
</html>
