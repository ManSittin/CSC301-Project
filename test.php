<?php
include('query.php');

$model = new Model();

$testUsername = "test1";
$testEmail = "test1@email.com";
$testFirstName = "First";
$testLastName = "Last";
$testPassword = "password";

$model->initDatabase();
$model->initTables();

if ($model->newUser($testUsername, $testEmail, $testFirstName, $testLastName, $testPassword)) {
    echo "User registered";
} else {
    echo "Username taken";
}

unset($model);
?>