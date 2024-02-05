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

        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        
        $stmt = $conn->prepare("INSERT INTO Users (username, email, first_name, last_name, password) VALUES (?,?,?,?,?)");
        $stmt->bind_param("sssss", $username, $email, $first_name, $last_name, $passwordHash);
        $result = $stmt->execute();
        $stmt->close();

        return $result;
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
    
    public function checkForTest() {
        global $conn, $database;
        $sql = "SHOW TABLES LIKE 'test'";
        $result = $conn->query($sql);
    
        if ($result) {
            echo "Table test exists\n";
            $result->free();
        } else {
            echo "Error: " . $conn->error;
        }
    }
}
?>