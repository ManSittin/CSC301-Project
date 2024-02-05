<?php
    include_once 'dbh.php';
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link href='https://fonts.googleapis.com/css?family=Outfit' rel='stylesheet'>
    <title>CourseBind</title>
</head>
<body>
    <div id="sidebar">
        <div class="nav" id="sidebar-nav">
            <label class="non-desktop hamburger-menu" id="sidebar-open-hamburger">
                <input type="checkbox" id="toggle-closed">
            </label>
            <a>profile</a>
            <a>settings</a>
        </div>
    </div>
    <div class="not-sidebar">
        <div class="nav" id="pages-nav">
            <label class="non-desktop hamburger-menu" id="sidebar-closed-hamburger">
                <input type="checkbox" id="toggle-open">
            </label>
            <a>notes</a>
            <a>flashcards</a>
            <a>assignments</a>
            <a>schedule</a>
        </div>
        <div class="main">
            <h1>Welcome to CourseBind! Use the links at the top of the page to access each of our core features :&rpar;
                The page will adapt dynamically to your chosen feature!
            </h1>
        </div>
    </div>

    <?php 
        $sql = "SELECT * FROM Users;";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);

        if ($resultCheck > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo $row['username'] . "<br>";
            }
        }
    ?>
</body>
<script src="script.js">
</script>
</html>