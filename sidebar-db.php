<?php
    include_once 'dbh.php';
    include_once "Session.php";
    // sidebar database info
   if ($_SESSION['onlineUsers']){
    $loggedInUserId = $_SESSION['onlineUsers'];
   
      $deadlineQuery = "SELECT * FROM Deadlines WHERE Deadlines.username = ?";

      $stmt = mysqli_prepare($conn, $deadlineQuery);

      // Bind the username parameter
      mysqli_stmt_bind_param($stmt, "s", $loggedInUserId);
      
      // Execute the statement
      mysqli_stmt_execute($stmt);
      
      // Get the result
      $deadlines = mysqli_stmt_get_result($stmt);
    
    $numDeadlines = mysqli_num_rows($deadlines);

    $notesQuery = "SELECT * FROM Notes WHERE Notes.username = ?";


    
    $stmt1 = mysqli_prepare($conn, $notesQuery);

    // Bind the username parameter
    mysqli_stmt_bind_param($stmt1, "s", $loggedInUserId);
    
    // Execute the statement
    mysqli_stmt_execute($stmt1);
    
    // Get the result
    $notes = mysqli_stmt_get_result($stmt1);
    $numNotes =  mysqli_num_rows($notes);
    $flashcardsQuery = "SELECT * FROM Flashcards WHERE Flashcards.username = ?";
    $stmt2 = mysqli_prepare($conn, $flashcardsQuery);
    mysqli_stmt_bind_param($stmt2, "s", $loggedInUserId);
    mysqli_stmt_execute($stmt2);
    $flashcards = mysqli_stmt_get_result($stmt2);
    $numFlashcards = mysqli_num_rows($flashcards);
   }
   else{
    $deadlineQuery = 'no query';

    $loggedInUserId = false;
    $numDeadlines = 0;
    $numNotes = 0;
    $numFlashcards = 0;

   }
?>
