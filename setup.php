<?php
include('query.php');


$model = new Model();
$model->initDatabase();
$model->initTables();
$model->newUser('userAA', 'userAA@mail.com', 'A', 'A', 'password');

$command = "php -S localhost:8000 -t . -f home.php";
exec($command);


?>