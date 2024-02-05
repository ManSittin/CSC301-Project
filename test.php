<?php
include('server.php');

$model = new Model();

$testUsername = "test1";
$testTitle = "Title 1";
$testContent = "Note content";

$testCourse = "CSC108";
$testName = "Exam";
$testDuedate = "2029-12-31";


$model->initDatabase();
$model->initTables();

if ($model->newNote($testUsername, $testTitle, $testContent)) {
    echo "Note created";
} else {
    echo "Note unable to be created";
}

if ($model->newDeadline($testUsername, $testCourse, $testName, $testDuedate)) {
    echo "Assignment created";
} else {
    echo "Assignment unable to be created";
}
unset($model);

$command = isset($_GET['command']) ? $_GET['command'] : 'test';

switch ($command) {
    case 'notes':
        $controller = new Controller();
        $controller->handle();
        break;
    case 'deadlines':
    default:
        break;
}
?>