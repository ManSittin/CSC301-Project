<?php

class Controller {
    public function nameTBD() {
        $request_method = $_SERVER['REQUEST_METHOD'];
        switch ($request_method) {
            case 'POST':
                $this->handlePost();
                break;
            default:
                http_response_code(405); // TODO use a good response
                echo "Request method not allowed";
                break;
        }
    }

    private function handlePost() {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $
    }
}







function handleGet() {
    /*
        what to allow:
            - want to access the notes of a user
            
            - want to access the 
    */
    $param = $_GET['param_name'];
    echo "GET handled";
}

function handlePost() {
    /*

    $param = $_POST['']
*/
}

?>