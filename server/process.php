<link rel="stylesheet" href="../styles/header.css">
<link rel="stylesheet" href="../styles/fs.css">
<?php

$displaybody = (isset($_POST['action']) && $_POST['action'] != 'none');

?>
<?php if ($displaybody): ?>
<body class="msgbody">
<div class="centermsg">
<?php endif; ?>
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
$userTable = 'users';
$gamesTable = 'games';

if (!isset($_SESSION)) session_start();

function handle_db($conn) {
    global $dbname, $userTable, $gamesTable;
    include("create_db.php");
    create_db($conn, $dbname);
    create_table($conn, $userTable);
    create_table($conn, $gamesTable);
}

function handleRequest() {
    global $servername, $username, $password;

    // Establish a database connection
    $conn = new mysqli($servername, $username, $password);

    // Check for connection errors
    if ($conn->connect_error) {
        return ["error" => "Connection failed: " . $conn->connect_error];
    }

    handle_db($conn);

    // Check if a specific key or parameter is set in the POST data
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        // echo "Performing action: $action<br>";

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
                    if (password_verify($password, $user['passhash'])) {
                        $_SESSION['userid'] = $user['id'];
                        $_SESSION['username'] = $user['username'];
                        header("Location: ../pages/index.php");
                        exit();
                    } else {
                        echo "Invalid Credentials.<br><br>";
                        echo "<a href='../pages/login.php'>Return to Login</a>";
                    }
                } else {
                    echo "Invalid credentials.";
                    echo "<a href='../pages/login.php'>Return to Login</a>";
                }

                break;
            
            case 'finishgame':

                // Retrieve all values needed for the games table
                $userid = -1;
                if (isset($_SESSION['userid'])) {
                    $userid = (int)$_SESSION['userid'];
                }
                $won = 0;
                if (isset($_POST['won'])) {
                    $won = (int)$_POST['won'];
                }
                $startdatetime = "YYYY-MM-DD HH:MI:SS";
                if (isset($_POST['startdatetime'])) {
                    $startdatetime = $_POST['startdatetime'];
                }
                $duration = "00:00:00";
                if (isset($_POST['duration'])) {
                    $duration = $_POST['duration'];
                }
                $numturns = -1;
                if (isset($_POST['numturns'])) {
                    $numturns = (int)$_POST['numturns'];
                }

                // Register game into database
                $stmt = $conn->prepare("
                    INSERT INTO `games` (userid, won, startdatetime, duration, numturns) 
                    VALUES (?, ?, ?, ?, ?);"
                );
                $stmt->bind_param("iissi", $userid, $won, $startdatetime, $duration, $numturns);
                if ($stmt->execute()) {
                    echo "Inserted game into the database.<br><br>";
                    $stmt = $conn->prepare("UPDATE `users` SET gameswon = gameswon + ?, gamesplayed = gamesplayed + 1, timeplayedsec = timeplayedsec + ? WHERE id = ?");
                    $duration_sec = strtotime($duration) - 1733439600;
                    echo 'Seconds: ' . $duration_sec . '<br>';
                    $stmt->bind_param("iii", $won, $duration_sec, $userid);
                    $stmt->execute();
                } else {
                    echo "Error: " . $stmt->error;
                }

                break;
            
            case 'none':
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

?>
<?php if ($displaybody): ?>
</div>
</body>
<?php endif; ?>