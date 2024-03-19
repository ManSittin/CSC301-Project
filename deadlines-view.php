<?php
    include_once 'sidebar-db.php';
    $deadlineForEditing = null; // Initialize variable to hold deadline data for editing
    if (isset($_GET['id'])) {
        $deadlineId = $_GET['id'];
        $stmt = $conn->prepare("SELECT * FROM Deadlines WHERE id = ?");
        $stmt->bind_param("i", $deadlineId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $deadlineForEditing = $result->fetch_assoc();
        } else {
            //echo "<script>alert('Deadline not found.'); window.location.href='deadlines.php';</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Deadline Edited'); window.location.href='deadlines-all.php';</script>";
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
<body onload="loadDeadline(<?php echo isset($deadlineForEditing['id']) ? $deadlineForEditing['id'] : 'null'; ?>)">
    <?php include_once 'sidebar-content.php'; ?>
    <div class="not-sidebar">
        <?php include_once 'navbar.html';
        $header_text = "Welcome to the deadlines page. Here you can add new deadlines or view the ones you have already added. ";
        $page = "deadlines-view";
        include_once 'main.php';
        ?>
    </div>

    <script src="script.js">
    </script>
</body>
</html>