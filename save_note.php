<?php
include_once 'dbh.php'; // Assuming this file includes your database connection

// Retrieve data from POST request
$userId = mysqli_real_escape_string($conn, $_POST['userId']);
$username = mysqli_real_escape_string($conn, $_POST['username']);
$category = mysqli_real_escape_string($conn, $_POST['category']);
$note = mysqli_real_escape_string($conn, $_POST['note']);

// Insert the note into the database
$sql = "INSERT INTO Users (user_id, username, category, note) VALUES ('$userId', '$username', '$category', '$note');";
mysqli_query($conn, $sql);

// send a response back to the client if needed
if (mysqli_affected_rows($conn) > 0) {
    echo "Note added successfully.";
} else {
    echo "Failed to add note. Please try again later.";
}
?>
