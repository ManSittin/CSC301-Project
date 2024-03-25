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
                $is_public = $_POST['is_public'];
                $tag = $_POST['tag'];
            
                $result = $model->newNote($username, $title, $content, $is_public, $tag);
                break;

            case ('deadlines'):
                $username = $_POST['username'];
                $course = $_POST['course'];
                $name = $_POST['deadline_name'];
                $due_date = $_POST['duedate'];
                $tag = $_POST['tag'];

                $result = $model->newDeadline($username, $course, $name, $due_date, $tag);

                break;
            
            case ('flashcards'):
                $username = $_POST['username'];
                $cue = $_POST['cue'];
                $response = $_POST['response'];
                $review_date = $_POST['review_date'];
                $priority = $_POST['priority'];  
                $is_public = $_POST['is_public'];
                $tag = $_POST['tag'];
                $result = $model->newFlashcard($username, $cue, $response, $review_date, $priority, $is_public, $tag);
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
                $priority = $_POST['priority'];
                $is_public = $_POST['is_public'];
                $result = $model->updateFlashcard($id, $username, $cue, $response, $review_date, $priority, $is_public);

                break;
                
            case ('users'):
                $username = $_POST['username'];
                $email = $_POST['email'];
                $first_name = $_POST['first_name'];
                $last_name = $_POST['last_name'];
                $password = $_POST['password'];

                $result = $model->newUser($username, $email, $first_name, $last_name, $password);

                break;

            case ('preferences'):
                $flashcard_algorithm = $_POST['flashcard_algorithm'];
                $username = $_POST['username'];
                $result = $model->newPreference($username, $flashcard_algorithm);
                    break;
            
            case ('preferences-update'):
                $flashcard_algorithm = $_POST['flashcard_algorithm'];
                $username = $_POST['username'];
                $result = $model->updatePreference($username, $flashcard_algorithm);
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


                    // File where the time will be stored and modified
                    $filename = 'time.txt';

                    // Get the current timestamp
                        $currentTime = date('Y-m-d H:i:s');

                        // Read the current content of the file
                        $fileContent = file($filename, FILE_IGNORE_NEW_LINES); // Read each line of the file into an array

                        // Ensure the file has at least two lines, padding with empty strings if necessary
                        while (count($fileContent) < 2) {
                        $fileContent[] = '';
                        }

                        // Update the second line with the current time
                        $fileContent[1] = $currentTime;

                        // Write the modified content back to the file
                        file_put_contents($filename, implode("\n", $fileContent));
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
        $results = null;

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
                    echo json_encode(['courses' => $results]);
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

            case 'preferences':
                $username = $_GET['username'];
                $results = $model->getPreference($username);
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
            


                case 'search_notes':
                    // Assuming the search query parameter is named 'query'
                    $query = $_GET['query'];
                    $username = $_GET['username'];
                    $tag = $_GET['tag'];
                    $notesfiltered = $model->searchNotesByTitle($query, $username, $tag);
                    if ($notesfiltered) {
                        http_response_code(200);
                        header('Content-Type: application/json');
                        echo json_encode(['status' => 'Success', 'notes' => $notesfiltered]);
                    } else {
                        http_response_code(500); // Not Found if there are no results
                        header('Content-Type: application/json');
                        echo json_encode(['status' => 'Failure', 'message' => 'No notes found']);
                    }
                        exit();
                        break;

                    case 'search_deadlines':
                        $query = $_GET['query']; // Assuming the search query parameter is named 'query'
                        $username = $_GET['username']; // Assuming you also need to filter by username
                        $deadlinesFiltered = $model->searchDeadlinesByName($query, $username);
                        if ($deadlinesFiltered) {
                            http_response_code(200);
                            header('Content-Type: application/json');
                            echo json_encode(['status' => 'Success', 'deadlines' => $deadlinesFiltered]);
                        } else {
                            http_response_code(404); // Use 404 for "Not Found" if there are no results
                            header('Content-Type: application/json');
                            echo json_encode(['status' => 'Failure', 'message' => 'No deadlines found']);
                        }
                        exit();
                        break;

                    case 'search_flashcards':
                        $query = $_GET['query'];
                        $username = $_GET['username'];
                        $flashcardsFiltered = $model->searchFlashcardsByCue($query, $username);
                        if ($flashcardsFiltered) {
                            http_response_code(200);
                            header('Content-Type: application/json');
                            echo json_encode(['status' => 'Success', 'flashcards' => $flashcardsFiltered]);
                            } else {
                                http_response_code(404); // Use 404 for "Not Found" if there are no results
                                header('Content-Type: application/json');
                                echo json_encode(['status' => 'Failure', 'message' => 'No flashcards found']);
                            }
                        exit();
                    break;

                    case 'load_all_flashcards':
                        $username = $_GET['username']; // Obtain the username
                        $flashcards = $model->getFlashcards($username); // Assume this function exists and fetches flashcards for the user
                        if ($flashcards) {
                            http_response_code(200);
                            header('Content-Type: application/json');
                            echo json_encode(['flashcards' => $flashcards]);
                        } else {
                            http_response_code(404); // No flashcards found
                            header('Content-Type: application/json');
                            echo json_encode(['message' => 'No flashcards found']);
                        }
                        exit();
                        break;

                    case 'load_all_notes':
                        $username = $_GET['username'];
                        $notes = $model->getNotes($username);
                        if ($notes) {
                            http_response_code(200);
                            header('Content-Type: application/json');
                            echo json_encode(['notes' => $notes]);
                        } else {
                            http_response_code(404); // Or another appropriate status code
                            header('Content-Type: application/json');
                            echo json_encode(['message' => 'No notes found']);
                        }
                        exit();
                        break;

                    case 'load_all_deadlines':
                        $username = $_GET['username'];
                        $deadlines = $model->getDeadlines($username);
                        if ($deadlines) {
                            http_response_code(200);
                            header('Content-Type: application/json');
                            echo json_encode(['deadlines' => $deadlines]);
                        } else {
                            http_response_code(404); // Or another appropriate status code
                            header('Content-Type: application/json');
                            echo json_encode(['message' => 'No notes found']);
                        }
                        exit();
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
            case 'flashcards':
                $results = $model->deleteFlashcard($id);
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
