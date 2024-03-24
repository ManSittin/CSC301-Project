
<?php
//include_once "server.php";

session_start(); // Start or resume the session


if (!isset($_SESSION['onlineUsers'])) {
    // Initialize the 'onlineUsers' session variable as an array if it's not already set
    $_SESSION['onlineUsers']= False;
}

$filename = 'time.txt';

// Get the current timestamp

// Read the current content of the file
$fileContent = file($filename, FILE_IGNORE_NEW_LINES); // Read each line of the file into an array
$timeLine1 = $fileContent[0];
$timeLine2 = $fileContent[1];
$timestamp1 = strtotime($timeLine1);
$timestamp2 = strtotime($timeLine2);

// Compare the timestamps
if ( $_SESSION['onlineUsers'] && $timestamp1 > $timestamp2) {
    $_SESSION['onlineUsers'] = False;
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

echo "User online status: " . ($onlineUsers ? 'Online' : 'Offline');
?>