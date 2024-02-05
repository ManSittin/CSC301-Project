<?php
include_once 'dbh.php'; // Assuming this file includes your database connection

// Retrieve data from POST request
$userId = mysqli_real_escape_string($conn, $_POST['userId']);
$tags = mysqli_real_escape_string($conn, $_POST['tags']);
$title = mysqli_real_escape_string($conn, $_POST['title']);
$due_date = mysqli_real_escape_string($conn, $_POST['due_date']);

// Insert the deadline into the database, not up to date
$sql = "INSERT INTO Deadlines (user_id, tags, title, due_date) VALUES ('$userId', '$tags', '$title', '$due_date');";
mysqli_query($conn, $sql);

// send a response back to the client if needed
if (mysqli_affected_rows($conn) > 0) {
    echo "Note added successfully.";
} else {
    echo "Failed to add note. Please try again later.";
}
?>