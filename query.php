<?php

include ('db_info.php');

    
class Model {
    public function newDeadline($user_id, $course, $deadline_name, $due_date) {
        $conn = new mysqli(HOST, USERNAME, PASSWORD, DB);

        if ($conn->connect_error) {
            die("Connection to database failed: " . $conn->connect_error);
        }
        
        $stmt = $conn->prepare("INSERT INTO Deadlines (user_id, course, deadline_name, due_date) VALUES (?,?,?,?)");
        $stmt->bind_param("ssss", $user_id, $course, $deadline_name, $due_date);
        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }

    public function getDeadlines($username) {
        $conn = new mysqli(HOST, USERNAME, PASSWORD, DB);

        if ($conn->connect_error) {
            die("Connection to database failed: " . $conn->connect_error);
            return ; // TODO
        }

        $stmt = $conn->prepare("SELECT * FROM Deadlines WHERE Deadlines.username = ?");
        $stmt->bind_param("s", $username);
        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }

    public function newNote($user_id, $content) {
        $conn = new mysqli(HOST, USERNAME, PASSWORD, DB);

        if ($conn->connect_error) {
            die("Connection to database failed: " . $conn->connect_error);
            return "Connection Error"; // TODO
        }

        $stmt = $conn->prepare("INSERT INTO Notes (user_id, content) VALUES (?,?)");
        $stmt->bind_param("ss", $user_id, $content);
        $result = $stmt->execute(); // check if query worked
        $stmt->close();
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

    public function initDatabase() {
        $conn = new mysqli(HOST, USERNAME, PASSWORD, DB);

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