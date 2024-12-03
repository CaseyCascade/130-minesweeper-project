<?php
    function create_db($conn, $dbname, $tableName){}
        $jsonFile = '../data/preset_data.json'; // Path to your JSON file
        
        try {
            // Check if the database exists, create it if not
            $stmt = $conn->query("SHOW DATABASES LIKE '$dbname'");
            if ($stmt->rowCount() === 0) {
                // Create database
                $conn->exec("CREATE DATABASE `$dbname`");
                echo "Database '$dbname' created successfully.\n";
            } else {
                echo "Database '$dbname' already exists.\n";
            }
        
            // Select the database
            $conn->exec("USE `$dbname`");
        
            // Create a table if it doesn't exist
            $createTableSQL = "
                CREATE TABLE IF NOT EXISTS `$tableName` (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    name VARCHAR(255) NOT NULL,
                    value VARCHAR(255) NOT NULL
                );
            ";
            $conn->exec($createTableSQL);
            echo "Table '$tableName' is ready.\n";
        
            // Load preset data from JSON file
            if (file_exists($jsonFile)) {
                $data = json_decode(file_get_contents($jsonFile), true);
                if ($data && is_array($data)) {
                    $insertSQL = "INSERT INTO `$tableName` (name, value) VALUES (:name, :value)";
                    $stmt = $conn->prepare($insertSQL);
        
                    foreach ($data as $entry) {
                        if (isset($entry['name']) && isset($entry['value'])) {
                            $stmt->execute([
                                ':name' => $entry['name'],
                                ':value' => $entry['value']
                            ]);
                        }
                    }
                    echo "Preset data loaded successfully.\n";
                } else {
                    echo "Invalid JSON format in '$jsonFile'.\n";
                }
            } else {
                echo "JSON file '$jsonFile' not found.\n";
            }
        
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        
        $conn = null; // Close connection
    }    
?>