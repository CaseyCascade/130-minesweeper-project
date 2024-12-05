<?php
    function create_db($conn, $dbname){
        // Check if the database exists, create it if not
        $stmt = $conn->query("SHOW DATABASES LIKE '$dbname'");
        if ($stmt->num_rows === 0) {
            // Create database
            $conn->query("CREATE DATABASE `$dbname`");
            echo "Database '$dbname' created successfully.<br>";
        } else {
            // echo "Database '$dbname' already exists.<br>";
        }
        $conn->query("USE `$dbname`;");
    }

    function create_table($conn, $tableName) {
        $tableExistsQuery = "SHOW TABLES LIKE '" . $tableName . "';";
        $result = $conn->query($tableExistsQuery);

        if ($result->num_rows == 0) {
            // Create a table if it doesn't exist
            $createTableSQL = "";
            if ($tableName == "users") {
                $createTableSQL = "
                CREATE TABLE `users` (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    username VARCHAR(255) NOT NULL,
                    passhash VARCHAR(255) NOT NULL
                );
                ";
            }
            if ($tableName == "games") {
                $createTableSQL = "
                CREATE TABLE `games` (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `userid` int(11) NOT NULL,
                    `won` tinyint(1) NOT NULL,
                    `startdatetime` datetime NOT NULL,
                    `duration` time NOT NULL,
                    `numturns` int(11) NOT NULL,
                    PRIMARY KEY (`id`)
                );
                ";
            }
            
            $conn->query($createTableSQL);
            echo "Table '$tableName' is ready.<br>";
        }
    }
?>