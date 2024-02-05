<?php
include('query.php');

$model = new Model();

$testUsername = "test1";
$testTitle = "Title 1";
$testContent = "Note content";


$model->initDatabase();
$model->initTables();

if ($model->newNote($testUsername, $testTitle, $testContent)) {
    echo "Note created";
} else {
    echo "Note unable to be created";
}

unset($model);
?>