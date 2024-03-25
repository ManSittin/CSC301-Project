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

    public function newPreference($username, $flashcard_algorithm) {
        $conn = new mysqli(HOST, USERNAME, PASSWORD, DB);

        if ($conn->connect_error) {
            die("Connection to database failed: " . $conn->connect_error);
            return false;
        }

        $stmt = $conn->prepare("INSERT INTO Preferences (username, flashcard_algorithm) VALUES (?,?)");
        $stmt->bind_param("ss", $username, $flashcard_algorithm);
        $result = $stmt->execute(); // check if query worked
        return $result;
    }

    public function updatePreference($username, $flashcard_algorithm) {
        $conn = new mysqli(HOST, USERNAME, PASSWORD, DB);
      
        if ($conn->connect_error) {
            die("Connection to database failed: " . $conn->connect_error);
            return false;
        }
        $stmt = $conn->prepare("UPDATE Preferences SET flashcard_algorithm = ? WHERE username = ?;");
        $stmt->bind_param("ss", $flashcard_algorithm, $username);

        $result = $stmt->execute(); // check if query worked
        return $result;
    }  

    public function newDeadline($username, $course, $deadline_name, $due_date, $tag) {
        $conn = new mysqli(HOST, USERNAME, PASSWORD, DB);

        if ($conn->connect_error) {
            die("Connection to database failed: " . $conn->connect_error);
            return false;
        }
        
        $stmt = $conn->prepare("INSERT INTO Deadlines (username, course, deadline_name, due_date, tag_id) VALUES (?,?,?,?,?)");
        $stmt->bind_param("ssssi", $username, $course, $deadline_name, $due_date, $tag);
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
    public function deleteDeadline($deadline_id) {
        $conn = new mysqli(HOST, USERNAME, PASSWORD, DB);
  
        if ($conn->connect_error) {
            die("Connection to database failed: " . $conn->connect_error);
            return false;
        }
  
        $stmt = $conn->prepare("DELETE FROM Deadlines WHERE id = ?"); 
        $stmt->bind_param("s", $deadline_id);
      
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
            $stmt->bind_result($id, $username, $course, $deadline_name, $due_date, $tag);
    
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
                    return  $username;
                }
            }

           
        }
            return false;
        
    }

 
    public function getPreference($username) {
      
        $conn = new mysqli(HOST, USERNAME, PASSWORD, DB);

        if ($conn->connect_error) {
            die("Connection to database failed: " . $conn->connect_error);
            return false;
        }
       
        $stmt = $conn->prepare("SELECT * FROM Preferences, Users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $result = $stmt->execute();
        if ($result) {
            $result = $stmt->execute(); // check if query worked
            return $result;
        }
    }

    public function newNote($username, $title, $content, $is_public, $tag) {
        $conn = new mysqli(HOST, USERNAME, PASSWORD, DB);

        if ($conn->connect_error) {
            die("Connection to database failed: " . $conn->connect_error);
            return false;
        }

        $stmt = $conn->prepare("INSERT INTO Notes (username, title, content, is_public, tag_id) VALUES (?,?,?,?,?)");
        $stmt->bind_param("sssii", $username, $title, $content, $is_public, $tag);
        $result = $stmt->execute(); // check if query worked
        return $result;
    }

    public function deleteNote($note_id) {
        $conn = new mysqli(HOST, USERNAME, PASSWORD, DB);
        if ($conn->connect_error) {
            die("Connection to database failed: " . $conn->connect_error);
            return false;
        }
        $stmt = $conn->prepare("DELETE FROM Notes WHERE id = ?"); 
        $stmt->bind_param("s", $note_id);
        $result = $stmt->execute(); // check if query worked
        return $result;
    }
    public function updateNote($id, $username, $title, $content) {
        $conn = new mysqli(HOST, USERNAME, PASSWORD, DB);
        if ($conn->connect_error) {
            die("Connection to database failed: " . $conn->connect_error);
            return false;
        }
        $stmt = $conn->prepare("UPDATE Notes SET title = ?, content = ? WHERE Notes.id = ? AND Notes.username = ?;");
        $stmt->bind_param("ssis", $title, $content, $id, $username);
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
            $stmt->bind_result($id, $username, $title, $content, $tag);

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
    public function searchNotesByTitle($searchQuery, $username) {
        $conn = new mysqli(HOST, USERNAME, PASSWORD, DB);
        if ($conn->connect_error) {
            die("Connection to database failed: " . $conn->connect_error);
            return false; // Connection failure
        }
    
        // "SELECT * FROM Notes WHERE username = do AND title LIKE CONCAT('%', ?, '%')";
        $sql = "SELECT * FROM Notes WHERE username = ? AND title LIKE CONCAT('%', ?, '%')";
        $stmt = $conn->prepare($sql);

        // Now, this matches the number of ? in the query
        $stmt->bind_param("ss", $username, $searchQuery);
        $result = $stmt->execute();    
        // Bind both the username and the search query parameters
        if ($result) {
            $res = $stmt->get_result(); // Use get_result() for flexibility in fetching
            $results = [];
            while ($row = $res->fetch_assoc()) { // Fetch as associative array
                $results[] = $row;
            }
            $stmt->close();
            return $results;
        } else {
            $stmt->close();
            return false; // Execution failure or no results
        }
    }

    public function searchDeadlinesByName($searchQuery, $username) {
        $conn = new mysqli(HOST, USERNAME, PASSWORD, DB);
        if ($conn->connect_error) {
            die("Connection to database failed: " . $conn->connect_error);
            return false; // Connection failure
        }
    
        // Assuming the structure of your Deadlines table matches the expected columns
        $sql = "SELECT * FROM Deadlines WHERE username = ? AND course LIKE CONCAT('%', ?, '%')";
        $stmt = $conn->prepare($sql);
    
        // Bind the username and search query to the prepared statement
        $stmt->bind_param("ss", $username, $searchQuery);
        $result = $stmt->execute();
    
        if ($result) {
            $res = $stmt->get_result(); // Fetch the results of the query
            $results = [];
            while ($row = $res->fetch_assoc()) { // Iterate through each row in the result set
                $results[] = $row;
            }
            $stmt->close();
            return $results; // Return the array of fetched deadlines
        } else {
            $stmt->close();
            return false; // In case of execution failure or no results
        }
    }

    public function searchFlashcardsByCue($searchQuery, $username) {
    $conn = new mysqli(HOST, USERNAME, PASSWORD, DB);
    if ($conn->connect_error) {
        die("Connection to database failed: " . $conn->connect_error);
        return false; // Connection failure
    }
    
    $sql = "SELECT * FROM Flashcards WHERE username = ? AND cue LIKE CONCAT('%', ?, '%')";
    $stmt = $conn->prepare($sql);

    $stmt->bind_param("ss", $username, $searchQuery);
    $result = $stmt->execute();
    
    if ($result) {
        $res = $stmt->get_result();
        $results = [];
        while ($row = $res->fetch_assoc()) {
            $results[] = $row;
        }
        $stmt->close();
        return $results;
    } else {
        $stmt->close();
        return false; // Execution failure or no results
    }
}



    public function newFlashcard($username, $cue, $response, $review_date, $priority, $is_public) {
        $conn = new mysqli(HOST, USERNAME, PASSWORD, DB);

        if ($conn->connect_error) {
            die("Connection to database failed: " . $conn->connect_error);
            return false;
        }

        $stmt = $conn->prepare("INSERT INTO Flashcards (username, cue, response, review_date, priority, is_public) VALUES (?,?,?,?,?,?)");
        $stmt->bind_param("ssssii", $username, $cue, $response, $review_date, $priority, $is_public);
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
            $stmt->bind_result($id, $username, $cue, $response, $review_date, $priority);

            $results = [];
            while ($stmt->fetch()) {
                $results[] = ['id' => $id, 'username' => $username, 'cue' => $cue, 'response' => $response, 'review_date' => $review_date, 'priority' => $priority];
            }
            $stmt->close();
            return $results;
        } else {
            return false;
        }
    }

    public function updateFlashcard($id, $username, $cue, $response, $review_date, $priority) {
        $conn = new mysqli(HOST, USERNAME, PASSWORD, DB);
      
        if ($conn->connect_error) {
            die("Connection to database failed: " . $conn->connect_error);
            return false;
        }
        $stmt = $conn->prepare("UPDATE Flashcards SET cue = ?, response = ?, review_date = ?, priority = ? WHERE Flashcards.id = ? AND Flashcards.username = ?;");
        $stmt->bind_param("sssiis", $cue, $response, $review_date, $priority, $id, $username);

        $result = $stmt->execute(); // check if query worked
        return $result;
    }  

    public function newCourse($username, $course_name) {
        $conn = new mysqli(HOST, USERNAME, PASSWORD, DB);

        if ($conn->connect_error) {
            die("Connection to database failed: " . $conn->connect_error);
            return false;
        }

        $stmt = $conn->prepare("INSERT INTO Courses (username, course_name) VALUES (?,?)");
        $stmt->bind_param("ss", $username, $course_name);

        $result = $stmt->execute(); // check if query worked
        return $result;
    }

    public function getCourses($username) {
        $conn = new mysqli(HOST, USERNAME, PASSWORD, DB);

        if ($conn->connect_error) {
            die("Connection to database failed: " . $conn->connect_error);
            return false; // TODO
        }
        $stmt = $conn->prepare("SELECT * FROM Courses WHERE Courses.username = ?");
        $stmt->bind_param("s", $username);
        $result = $stmt->execute();
        if ($result) {
            $stmt->bind_result($id, $username, $course_name);

            $results = [];
            while ($stmt->fetch()) {
                $results[] = ['id' => $id, 'username' => $username, 'course_name' => $course_name];
            }
            $stmt->close();
            return $results;
        } else {
            return false;
        }
    }

    public function addTimeslot($course_id, $day_of_week, $num_hours, $start_time) {
        $conn = new mysqli(HOST, USERNAME, PASSWORD, DB);

        if ($conn->connect_error) {
            die("Connection to database failed: " . $conn->connect_error);
            return false;
        }

        $stmt = $conn->prepare("INSERT INTO Course_Timeslots (course_id, day_of_week, num_hours, start_time) VALUES (?,?,?,?)");
        $stmt->bind_param("isis", $course_id, $day_of_week, $num_hours, $start_time);
        $result = $stmt->execute(); // check if query worked
        return $result;
    }

    public function getTimeslots($course_id) {
        $conn = new mysqli(HOST, USERNAME, PASSWORD, DB);

        if ($conn->connect_error) {
            die("Connection to database failed: " . $conn->connect_error);
            return false; // TODO
        }
        $stmt = $conn->prepare("SELECT * FROM Course_Timeslots WHERE course_id = ?");
        $stmt->bind_param("i", $course_id);
        $result = $stmt->execute();
        if ($result) {
            $stmt->bind_result($temp, $day_of_week, $num_hours, $start_time);

            $results = [];
            while ($stmt->fetch()) {
                $results[] = ['course_id' => $course_id, 'day_of_week' => $day_of_week, 'num_hours' => $num_hours, 'start_time' => $start_time];
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