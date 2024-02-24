<?php
include ('db_info.php');

class Model {

    private function checkUsernameTaken($conn, $username) {
        $stmt = $conn->prepare("SELECT id FROM Users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        $usernameTaken = $stmt->num_rows > 0;
        $stmt->close();
        return $usernameTaken;
    }
    public function newUser($username, $email, $first_name, $last_name, $password) {
        $conn = new mysqli(HOST, USERNAME, PASSWORD, DB);

        if ($conn->connect_error) {
            die("Connection to database failed: " . $conn->connect_error);
        }

        if ($this->checkUsernameTaken($conn, $username)) {
            return false; // username is taken
        }

        // $passwordHash = password_hash($password, PASSWORD_BCRYPT); temp change
        
        $stmt = $conn->prepare("INSERT INTO Users (username, email, first_name, last_name, password) VALUES (?,?,?,?,?)");
        $stmt->bind_param("sssss", $username, $email, $first_name, $last_name, $password); // temp change
        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }


    public function newDeadline($username, $course, $deadline_name, $due_date) {
        $conn = new mysqli(HOST, USERNAME, PASSWORD, DB);

        if ($conn->connect_error) {
            die("Connection to database failed: " . $conn->connect_error);
            return false;
        }
        
        $stmt = $conn->prepare("INSERT INTO Deadlines (username, course, deadline_name, due_date) VALUES (?,?,?,?)");
        $stmt->bind_param("ssss", $username, $course, $deadline_name, $due_date);
        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }

    public function updateDeadline($id, $username, $course, $deadline_name, $due_date) {
        $conn = new mysqli(HOST, USERNAME, PASSWORD, DB);

        if ($conn->connect_error) {
            die("Connection to database failed: " . $conn->connect_error);
            return false;
        }
        $stmt = $conn->prepare("UPDATE Deadlines SET course = ?, deadline_name = ?, due_date = ? WHERE Deadlines.id = ? AND Deadlines.username = ?;");
        $stmt->bind_param("sssis", $course, $deadline_name, $due_date, $id, $username);
        $result = $stmt->execute(); // check if query worked
        return $result;
    }

    public function getDeadlines($username) {
        $conn = new mysqli(HOST, USERNAME, PASSWORD, DB);

        if ($conn->connect_error) {
            die("Connection to database failed: " . $conn->connect_error);
            return false;
        }

        $stmt = $conn->prepare("SELECT * FROM Deadlines WHERE Deadlines.username = ?");
        $stmt->bind_param("s", $username);
        $result = $stmt->execute();
        
        if ($result) {
            $stmt->bind_result($id, $username, $course, $deadline_name, $due_date);
    
            $results = [];
            while ($stmt->fetch()) {
                $results[] = ['id' => $id, 'username' => $username, 'course' => $course, 'deadline_name' => $deadline_name, 'due_date' => $due_date];
            }
            $stmt->close();
            return $results;
        } else {
            return false;
        }
    }

    public function getUser($email, $pass) {
        $conn = new mysqli(HOST, USERNAME, PASSWORD, DB);

        if ($conn->connect_error) {
            die("Connection to database failed: " . $conn->connect_error);
            return false;
        }

        $stmt = $conn->prepare("SELECT * FROM Users WHERE Users.email = ?");
        $stmt->bind_param("s", $email);
        $result = $stmt->execute();
        if ($result) {
            $stmt->bind_result($id, $username, $email, $first_name, $last_name, $password);
    
            if ($stmt->fetch()) {
                // Now $password should contain the password fetched from the database
                file_put_contents('post_data.log', print_r($password, true));
                if (strcmp($password, $pass) === 0) {
                    $stmt->close();
                    return true;
                }
            }

           
        }
            return false;
        
    }

    public function newNote($username, $title, $content) {
        $conn = new mysqli(HOST, USERNAME, PASSWORD, DB);

        if ($conn->connect_error) {
            die("Connection to database failed: " . $conn->connect_error);
            return false;
        }

        $stmt = $conn->prepare("INSERT INTO Notes (username, title, content) VALUES (?,?,?)");
        $stmt->bind_param("sss", $username, $title, $content);
        $result = $stmt->execute(); // check if query worked
        return $result;
    }

    public function getNotes($username) {
        $conn = new mysqli(HOST, USERNAME, PASSWORD, DB);

        if ($conn->connect_error) {
            die("Connection to database failed: " . $conn->connect_error);
            return false; // TODO
        }
        $stmt = $conn->prepare("SELECT * FROM Notes WHERE Notes.username = ?");
        $stmt->bind_param("s", $username);
        $result = $stmt->execute();
        if ($result) {
            $stmt->bind_result($id, $username, $title, $content);

            $results = [];
            while ($stmt->fetch()) {
                $results[] = ['id' => $id, 'username' => $username, 'title' => $title, 'content' => $content];
            }
            $stmt->close();
            return $results;
        } else {
            return false;
        }
    }

    public function newFlashcard($username, $cue, $response) {
        $conn = new mysqli(HOST, USERNAME, PASSWORD, DB);

        if ($conn->connect_error) {
            die("Connection to database failed: " . $conn->connect_error);
            return false;
        }

        $stmt = $conn->prepare("INSERT INTO Flashcards (username, cue, response) VALUES (?,?,?)");
        $stmt->bind_param("sss", $username, $cue, $response);
        $result = $stmt->execute(); // check if query worked
        return $result;
    }

    public function getFlashcards($username) {
        $conn = new mysqli(HOST, USERNAME, PASSWORD, DB);

        if ($conn->connect_error) {
            die("Connection to database failed: " . $conn->connect_error);
            return false; // TODO
        }
        $stmt = $conn->prepare("SELECT * FROM Flashcards WHERE Flashcards.username = ?");
        $stmt->bind_param("s", $username);
        $result = $stmt->execute();
        if ($result) {
            $stmt->bind_result($id, $username, $cue, $response);

            $results = [];
            while ($stmt->fetch()) {
                $results[] = ['id' => $id, 'username' => $username, 'cue' => $cue, 'response' => $response];
            }
            $stmt->close();
            return $results;
        } else {
            return false;
        }
    }

    public function initDatabase() {
        $conn = new mysqli(HOST, USERNAME, PASSWORD);

        if ($conn->connect_error) {
            die("Connection to database failed: " . $conn->connect_error);
            return false;
        }
        $createDbQuery = "CREATE DATABASE IF NOT EXISTS " . DB;
        if ($conn->query($createDbQuery) === TRUE) {
            echo "Database created or already exists\n";
        } else {
            die("Error creating database: " . $conn->error);
            $conn->close();
            return false;
        }
        return true;
    }
    
    public function initTables() {
        $conn = new mysqli(HOST, USERNAME, PASSWORD, DB);

        if ($conn->connect_error) {
            die("Connection to database failed: " . $conn->connect_error);
            return false;
        }
        $sqlFile = "database.sql";
        $sqlContent = file_get_contents($sqlFile);
        if ($conn->multi_query($sqlContent) === TRUE) {
            do {
                if ($result = $conn->store_result()) {
                    $result->free();
                }
            } while ($conn->more_results() && $conn->next_result()); 
            echo "Tables created successfully\n";
        } else {
            die("Error creating tables: " . $conn->error);
            $conn->close();
            return false;
        }
        return true;
    }
}
?>