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
<body onload="loadDeadline(<?php echo isset($deadlineForEditing['id']) ? $deadlineForEditing['id'] : 'null'; ?>)">
    <div id="sidebar">
        <div class="nav" id="sidebar-nav">
            <label class="non-desktop hamburger-menu" id="sidebar-open-hamburger">
                <input type="checkbox" id="toggle-closed">
            </label>
            <a href = "profile.php">profile</a>
            <a>settings</a>
            <?php
                if($_SESSION['onlineUsers'] ){echo  '<button onClick="handlelogout()"> Logout </button>';}
                ?>
        </div>
        <div id="sidebar-info">
            <div id="assignment info">
                <h2>Assignments</h2>
                <!-- <div class="info-block">Test</div> -->
                <?php
                    if ($numDeadlines > 0 && $_SESSION['onlineUsers']) {
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
                    if ($numNotes > 0 && $_SESSION['onlineUsers']) {
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
        <!-- hard-coded note for now; will pull this in when a note is selected -->
        <div class="main">
            <h1>Welcome to the deadlines page. Here you can add new deadlines or view the ones you have already added. </h1>
            <div class="textbox-section">
                <!-- Loaded deadline info preloads here... -->
                <h2>Edit Deadline</h2> 
                <form id="editDeadlineForm" method="post" action="deadlines-view.php">
                <input type="hidden" name="hiddenDeadlineId" id="hiddenDeadlineId" value="<?php echo isset($deadlineForEditing['id']) ? $deadlineForEditing['id'] : ''; ?>">
                <p>Edit Course: </p>
                <textarea rows="1" cols="50" name="course" class="deadline_course"><?php echo isset($deadlineForEditing['course']) ? $deadlineForEditing['course'] : ''; ?></textarea>
                <p>Edit Deadline Name:</p>
                <textarea rows="1" cols="50" name="deadline_name" class="deadline_name"><?php echo isset($deadlineForEditing['deadline_name']) ? $deadlineForEditing['deadline_name'] : ''; ?></textarea>
                <p>Edit Date:</p>
                <input
                    type="datetime-local"
                    id="date"
                    name="due_date"
                    value="<?php echo isset($deadlineForEditing['due_date']) ? str_replace(' ', 'T', $deadlineForEditing['due_date']) : ''; ?>"
                    class="deadline_date"
                />
                <br><br>
                <input type="submit" value="Update Deadline" class="update-deadline">
            </form>
                <form id="editDeadlineForm" method="post" action="deadlines-view.php">
                <input type="hidden" name="hiddenDeadlineId" id="hiddenDeadlineId" value="<?php echo isset($deadlineForEditing['id']) ? $deadlineForEditing['id'] : ''; ?>">
                <p>Edit Course: </p>
                <textarea rows="1" cols="50" name="course" class="deadline_course"><?php echo isset($deadlineForEditing['course']) ? $deadlineForEditing['course'] : ''; ?></textarea>
                <p>Edit Deadline Name:</p>
                <textarea rows="1" cols="50" name="deadline_name" class="deadline_name"><?php echo isset($deadlineForEditing['deadline_name']) ? $deadlineForEditing['deadline_name'] : ''; ?></textarea>
                <p>Edit Date:</p>
                <input
                    type="datetime-local"
                    id="date"
                    name="due_date"
                    value="<?php echo isset($deadlineForEditing['due_date']) ? str_replace(' ', 'T', $deadlineForEditing['due_date']) : ''; ?>"
                    class="deadline_date"
                />
                <br><br>
                <input type="submit" value="Update Deadline" class="update-deadline">
            </form>
        </div>
    </div>

    <script src="script.js">
    </script>
</body>
</html>