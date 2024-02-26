
<?php

session_start(); // Start or resume the session

if (!isset($_SESSION['onlineUsers'])) {
    // Initialize the 'onlineUsers' session variable as an array if it's not already set
    $_SESSION['onlineUsers']= False;
}
// Function to add a user to the list of online users
function addUserToOnlineUsers($userId) {
    $_SESSION['onlineUsers'] = $userId;
    return $_SESSION['onlineUsers'];
}

// Function to remove a user from the list of online users
function removeUserFromOnlineUsers($userId) {
    $_SESSION['onlineUsers'] = False;
}

// Check if the user is logged in and online
if (isset($_SESSION['onlineUsers'])) {
    $loggedInUserId = $_SESSION['onlineUsers'];
    return $loggedInUserId ;
}

// To retrieve the list of online users:
$onlineUsers = $_SESSION['onlineUsers'];

// Example usage:
foreach ($onlineUsers as $userId => $value) {
    echo "User ID: $userId is online.<br>";
}
?>