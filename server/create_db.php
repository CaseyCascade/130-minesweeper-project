<?php
    function create_db($conn, $dbname, $tableName){
        try {
            // Check if the database exists, create it if not
            $stmt = $conn->query("SHOW DATABASES LIKE '$dbname'");
            if ($stmt->num_rows === 0) {
                // Create database
                $conn->query("CREATE DATABASE `$dbname`");
                echo "Database '$dbname' created successfully.<br>";
            } else {
                // echo "Database '$dbname' already exists.<br>";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    function create_table($conn, $tableName) {
        try {
            $tableExistsQuery = "SHOW TABLES LIKE '" . $tableName . "';";
            $result = $conn->query($tableExistsQuery);

            if ($result->num_rows == 0) {
                // Create a table if it doesn't exist
                $createTableSQL = "";
                if ($tableName == "users") {
                    $createTableSQL = "
                    CREATE TABLE `$tableName` (
                        id INT AUTO_INCREMENT PRIMARY KEY,
                        username VARCHAR(255) NOT NULL,
                        passhash VARCHAR(255) NOT NULL
                    );
                    ";
                }
                if ($tableName == "games") {
                    $createTableSQL = "
                    CREATE TABLE `$tableName` (
                        id INT AUTO_INCREMENT PRIMARY KEY,
                        username VARCHAR(255) NOT NULL,
                        passhash VARCHAR(255) NOT NULL
                    );
                    ";
                }

                
                $conn->query($createTableSQL);
                echo "Table '$tableName' is ready.<br>";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
?>