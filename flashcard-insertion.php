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
        /* Existing style here */
    </style>
</head>
<body>
    <?php include_once 'sidebar-content.php'; ?>
    <div class="not-sidebar">
        <?php include_once 'navbar.html'?>
        <div class="main">
            <h1>Welcome to the flashcards page. Here you can add new flashcards or review the ones you have already added. </h1>

            <!-- Add a Textbox Feature -->
            <div class="textbox-section">
                <h2>Add a new flashcard</h2>
                <form id="addFlashcardForm">
                    <p>Cue:</p>
                    <textarea rows="2" cols="50" name="cue" id="enter-cue" placeholder="Type your cue here..."></textarea>
                    <br>
                        <!-- Planning to give the user freedom to create their own category -->
                    </select>
                    <p>Response:</p>
                    <textarea rows="4" cols="50" name="response" id="enter-response" placeholder="Type your response here..."></textarea>
                    <br>
                    <input type="button" value="Add Flashcard" onclick="addFlashcard()">
                </form>
            </div>
        </div>
    </div>

    <script src="script.js">
    </script>
</body>
</html>
