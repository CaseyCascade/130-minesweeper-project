<?php
# Server Globals # Idk how exactly this works without localhost so feel free to change the credentials 
$servername = "localhost";
$username = "caseycascade";
$password = "Z7-X!8AOuK7*bnwr";
$dbname = "minesweeper";

function handleRequest() {
    global $servername, $username, $password, $dbname, $data; 

    // Establish a database connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check for connection errors
    if ($conn->connect_error) {
        return ["error" => "Connection failed: " . $conn->connect_error];
    }

    // Check if a specific key or parameter is set in the POST data
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        // Handle different actions based on the 'action' key
        switch ($action) {
            case 'signup':
                $username = isset($_POST['username']) ? $_POST['username'] : 0;
                $password = isset($_POST['password']) ? $_POST['password'] : 0;
                
                // Code to register user into database //TODO
                break;

            case 'login':
                $username = isset($_POST['username']) ? $_POST['username'] : 0;
                $password = isset($_POST['password']) ? $_POST['password'] : 0;

                // Code to login user //TODO
                break; 
                
            default:
                echo json_encode(['error' => 'Invalid action specified']);
                break;
        }
    } else {
        echo json_encode(['error' => 'No action specified']);
    }

    $conn->close();
}

handleRequest();  
