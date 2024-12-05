<?php
# Server Globals # Idk how exactly this works without localhost so feel free to change the credentials 

// $servername = "localhost";
// $username = "caseycascade";
// $password = "Z7-X!8AOuK7*bnwr";
// $dbname = "minesweeper";

$host = 'localhost';
$username = 'root';
$password = '';

$dbname = 'minesweeper';
$usertable = 'users';

session_start();

function handleRequest() {
    global $servername, $username, $password;
    global $dbname, $usertable;


    // Establish a database connection
    $conn = new mysqli($servername, $username, $password);

    // Check for connection errors
    if ($conn->connect_error) {
        return ["error" => "Connection failed: " . $conn->connect_error];
    }

    include("create_db.php");
    create_db($conn, $dbname, $usertable);

    // Check if a specific key or parameter is set in the POST data
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        echo "Performing action: $action<br>";

        // Handle different actions based on the 'action' key
        switch ($action) {
            case 'signup':
                
                // Store POST data into variables
                $username = $_POST['username'];
                $passhash = password_hash($_POST['password'], PASSWORD_DEFAULT);

                // Check if user exists
                $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?;");
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    echo "User already exists, please pick a different username.<br><br>";
                    echo "<a href='../pages/signup.php'>Return to Signup</a><br>";
                    break;
                }

                // Register user into database
                $stmt = $conn->prepare("INSERT INTO users (`username`, `passhash`) VALUES (?, ?)");
                $stmt->bind_param("ss", $username, $passhash);
                if ($stmt->execute()) {
                    echo "Sign-up successful.<br><br>";
                    echo "<a href='../pages/login.php'>Log In</a>";
                } else {
                    echo "Error: " . $stmt->error;
                }
                
                break;

            case 'login':

                // TODO: Code to login user

                // Store POST data into variables
                $username = $_POST['username'];
                $password = $_POST['password'];

                // Check if user exists
                $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?;");
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows == 1) {
                    $user = $result->fetch_assoc();
                    echo $user['passhash'] . "<br>";
                    if (password_verify($password, $user['passhash'])) {
                        $_SESSION['userid'] = $user['id'];
                        $_SESSION['username'] = $user['username'];
                        header("Location: ../pages/index.php");
                        exit();
                    } else {
                        echo "Invalid Credentials.<br>";
                        echo "<a href='../pages/login.php'>Return to Login</a>";
                    }
                } else {
                    echo "Invalid credentials.";
                    echo "<a href='../pages/login.php'>Return to Login</a>";
                }

                break; 
                
            default:
                echo "Invalid action specified.";
                break;
        }
    } else {
        echo "Invalid action specified.";
    }

    $conn->close();
}

handleRequest();  
