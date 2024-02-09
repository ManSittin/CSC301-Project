<?php

include('query.php');

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
            default:
                http_response_code(400);
                echo "Request method not allowed";
                exit();
        }
    }

    private function handlePost() {
        file_put_contents('post_data.log', print_r($_POST, true));
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
                $duedate = $_POST['duedate'];

                $result = $model->newDeadline($username, $course, $name, $duedate);

                break;
            case ('users'):
                $username = $_POST['username'];
                $email = $_POST['email'];
                $first_name = $_POST['first_name'];
                $last_name = $_POST['last_name'];
                $password = $_POST['password'];

                $result = $model->newUser($username, $email, $first_name, $last_name, $password);

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
}

$controller = new Controller();
$controller->handle();
?>