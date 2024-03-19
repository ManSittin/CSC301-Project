<?php

include('query.php');
include_once "Session.php";

class Controller {
    public function handle() {
        $request_method = $_SERVER['REQUEST_METHOD'];

        switch ($request_method) {
            case 'GET':
                $this->handleGet();
                break;
            case 'POST':
                $this->handlePost();
                break;
            case 'DELETE':
                $this->handleDelete();
                break;
            default:
                http_response_code(400);
                echo "Request method not allowed";
                exit();
        }
    }

    private function handlePost() {
        $command = $_POST['command'];
        $model = new Model();
        
        switch ($command) {
            case ('notes'):
                $username = $_POST['username'];
                $title = $_POST['title'];
                $content = $_POST['content'];
                
                $result = $model->newNote($username, $title, $content);

                break;

            case ('deadlines'):
                $username = $_POST['username'];
                $course = $_POST['course'];
                $name = $_POST['deadline_name'];
                $due_date = $_POST['duedate'];

                $result = $model->newDeadline($username, $course, $name, $due_date);

                break;
            
            case ('flashcards'):
                $username = $_POST['username'];
                $cue = $_POST['cue'];
                $response = $_POST['response'];
                $review_date = $_POST['review_date'];
                $result = $model->newFlashcard($username, $cue, $response, $review_date);

                break;

            case ('courses'):
                $username = $_POST['username'];
                $course_name = $_POST['course_name'];

                $result = $model->newCourse($username, $course_name);
                break;
            
            case ('timeslots'):
                $course_id = $_POST['course_id'];
                $day_of_week = $_POST['day_of_week'];
                $num_hours = $_POST['num_hours'];
                $start_time = $_POST['start_time'];
                
                $result = $model->addTimeslot($course_id, $day_of_week, $num_hours, $start_time);
                break;
            case ('note-update'):
                $id = $_POST['id'];
                $username = $_POST['username'];
                $title = $_POST['title'];
                $content = $_POST['content'];
                $result = $model->updateNote($id, $username, $title, $content);

                break;

            case ('deadline-update'):
                $id = $_POST['id'];
                $username = $_POST['username'];
                $course = $_POST['course'];
                $deadline_name = $_POST['deadline_name'];
                $due_date = $_POST['due_date'];
                $result = $model->updateDeadline($id, $username, $course, $deadline_name, $due_date);

                break;

            case ('flashcard-update'):
                $id = $_POST['id'];
                $username = $_POST['username'];
                $cue = $_POST['cue'];
                $response = $_POST['response'];
                $review_date = $_POST['review_date'];
                $result = $model->updateFlashcard($id, $username, $cue, $response, $review_date);

                break;
                
            case ('users'):
                $username = $_POST['username'];
                $email = $_POST['email'];
                $first_name = $_POST['first_name'];
                $last_name = $_POST['last_name'];
                $password = $_POST['password'];

                $result = $model->newUser($username, $email, $first_name, $last_name, $password);

                break;
            case ('connect'):
                    $email = $_POST['email'];
                    $password = $_POST['password'];
                    $results = $model->getUser($email,  $password);
                        if(!$results) {
                            http_response_code(500);
                            header('Content-Type: application/json');
                            echo json_encode(['status' => 'Failure: ' . $command, 'message' => ""]);
                            exit();
                        } else {
                            http_response_code(200);
                            addUserToOnlineUsers($results);
                            header('Content-Type: application/json');
                            echo json_encode(['status' => 'Success' . $command, 'message' => $results]);
                            exit();
                        }
                        break;

            case ('logout'):
                    removeUserFromOnlineUsers('123');

            default:
                http_response_code(400);
                header('Content-Type: application/json');
                echo json_encode(['status' => "Failure " . $command, 'message' => $command . " is an invalid command"]);
                exit();
        }
        if ($result) {
            http_response_code(200);
            header('Content-Type: application/json');
            echo json_encode(['status' => "Success " . $command, 'message' => $command . " successfully created"]);
            exit();
        } else {
            http_response_code(500);
            header('Content-Type: application/json');
            echo json_encode(['status' => "Failure " . $command, 'message' => $command . " was unable to be created"]);
            exit();
        }
    }
    
    private function handleGet() {
        file_put_contents('get_data.log', print_r($_GET, true));
        $command = $_GET['command'];
        $model = new Model();

        switch ($command) {
            case 'notes':
                $username = $_GET['username'];
                $results = $model->getNotes($username);
                if($results) {
                    http_response_code(200);
                    header('Content-Type: application/json');
                    echo json_encode(['status' => 'Success: ' . $command, 'message' => $results]);
                    exit();
                } else {
                    http_response_code(500);
                    header('Content-Type: application/json');
                    echo json_encode(['status' => 'Failure: ' . $command, 'message' => ""]);
                    exit();
                }
                break;
            case 'deadlines':
                $username = $_GET['username'];
    
                $results = $model->getDeadlines($username);
                if($results == "Failure") {
                    http_response_code(500);
                    header('Content-Type: application/json');
                    echo json_encode(['status' => 'Failure: ' . $command, 'message' => ""]);
                    exit();
                } else {
                    http_response_code(200);
                    header('Content-Type: application/json');
                    echo json_encode(['status' => 'Success' . $command, 'message' => $results]);
                    exit();
                }
                break;
            case 'flashcards':
                $username = $_GET['username'];
                
                $results = $model->getFlashcards($username);
                if($results) {
                    http_response_code(200);
                    header('Content-Type: application/json');
                    echo json_encode(['status' => 'Success: ' . $command, 'message' => $results]);
                    exit();
                } else {
                    http_response_code(500);
                    header('Content-Type: application/json');
                    echo json_encode(['status' => 'Failure: ' . $command, 'message' => ""]);
                    exit();
                }
                break;

            case 'courses':
                $username = $_GET['username'];
                $results = $model->getCourses($username);
                if($results) {
                    http_response_code(200);
                    header('Content-Type: application/json');
                    echo json_encode($results);
                    exit();
                } else {
                    http_response_code(500);
                    header('Content-Type: application/json');
                    echo json_encode("");
                    exit();
                }
                break;
            case 'timeslots':
                $course_id = $_GET['course_id'];
                $results = $model->getTimeslots($course_id);
                if($results) {
                    http_response_code(200);
                    header('Content-Type: application/json');
                    echo json_encode($results);
                    exit();
                } else {
                    http_response_code(500);
                    header('Content-Type: application/json');
                    echo json_encode("");
                    exit();
                }
                break;
            

            default:
            
                // handle incorrect command, bad request?
                http_response_code(400);
                header('Content-Type: application/json');
                echo json_encode(['status' => 'Failure' . $command, 'message' => $command . ' is an invalid command']);
                exit();
        }
        if($results) {
            http_response_code(200);
            header('Content-Type: application/json');
            echo json_encode(['status' => 'Success' . $command, 'message' => $results]);
            exit();
        } else {
            http_response_code(500);
            header('Content-Type: application/json');
            echo json_encode(['status' => 'Failure: ' . $command, 'message' => "Internal error"]);
            exit();
        }
    }
    private function handleDelete() {
        $request_uri = $_SERVER['REQUEST_URI'];
        $segments = explode('/', $request_uri);
        $model = new Model();

        $command = $segments[2]; 
        $id = $segments[3];
        file_put_contents('post_data.log', $command, true);

        switch ($command) {

            case 'deadlines':
                $results = $model->deleteDeadline($id);
                break;
            case 'notes':
                $results = $model->deleteNote($id);
                break;
            default:
                http_response_code(400);
                header('Content-Type: application/json');
                echo json_encode(['status' => 'Failure' . $command, 'message' => $command . ' is an invalid command']);
                exit();
        }
        if($results) {
            http_response_code(200);
            header('Content-Type: application/json');
            echo json_encode(['status' => 'Success: ' . $command, 'message' => $results]);
            exit();
        } else {
            http_response_code(500);
            header('Content-Type: application/json');
            echo json_encode(['status' => 'Failure: ' . $command, 'message' => ""]);
            exit();
        }
    }
}
$controller = new Controller();
$controller->handle();
?>