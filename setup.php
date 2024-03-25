<?php
include('query.php');


$model = new Model();
$model->initDatabase();
$model->initTables();
$model->newUser('userAA', 'userAA@mail.com', 'A', 'A', 'password');
// File where the time will be stored and modified
$filename = 'time.txt';

$command = "php -S 10.0.0.109:3000 -t . -f Index.php";
// Get the current timestamp
    $currentTime = date('Y-m-d H:i:s');

    // Read the current content of the file
    $fileContent = file($filename, FILE_IGNORE_NEW_LINES); // Read each line of the file into an array

    // Ensure the file has at least two lines, padding with empty strings if necessary
    while (count($fileContent) < 2) {
    $fileContent[] = '';
    }

    // Update the second line with the current time
    $fileContent[0] = $currentTime;

    // Write the modified content back to the file
    file_put_contents($filename, implode("\n", $fileContent));
$command = "php -S localhost:3000 -t . -f Index.php";
exec($command);


?>