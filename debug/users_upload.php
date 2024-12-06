<?php
session_start();

// Assuming the user is already logged in
if (!isset($_SESSION['userid'])) {
    echo "Please log in first.";
    exit();
}

$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'minesweeper';

// Establish a database connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect data from the form
    $userid = $_SESSION['userid']; // Already stored in session
    $won = isset($_POST['won']) ? (int)$_POST['won'] : 0;
    $numturns = isset($_POST['numturns']) ? (int)$_POST['numturns'] : 0;
    $duration = isset($_POST['duration']) ? $_POST['duration'] : "00:00:00";
    $startdatetime = isset($_POST['startdatetime']) ? $_POST['startdatetime'] : date('Y-m-d H:i:s');

    // Insert the game result into the database
    $stmt = $conn->prepare("INSERT INTO `games` (userid, won, numturns, duration, startdatetime) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iiiss", $userid, $won, $numturns, $duration, $startdatetime);

    if ($stmt->execute()) {
        // Update user's gameswon and gamesplayed
        $stmt = $conn->prepare("UPDATE `users` SET gameswon = gameswon + ?, gamesplayed = gamesplayed + 1, timeplayedsec = timeplayedsec + ? WHERE id = ?");
        $duration_sec = strtotime($duration) - 1733439600;
        echo 'Seconds: ' . $duration_sec . '<br>';
        $stmt->bind_param("iii", $won, $duration_sec, $userid);
        $stmt->execute();

        echo "Game submitted successfully.";
    } else {
        echo "Error submitting the game: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Game</title>
</head>
<body>
    <h1>Complete a Game</h1>

    <form method="POST" action="">
        <!-- User information (non-editable) -->
        <input type="hidden" name="userid" value="<?php echo $_SESSION['userid']; ?>">

        <p><strong>User ID:</strong> <?php echo $_SESSION['userid']; ?></p>
        <p><strong>Username:</strong> <?php echo $_SESSION['username']; ?></p>

        <!-- Game result fields -->
        <label for="won">Did you win?</label><br>
        <input type="radio" name="won" value="1" required> Yes
        <input type="radio" name="won" value="0" required> No<br><br>

        <label for="numturns">Number of Turns:</label><br>
        <input type="number" name="numturns" required><br><br>

        <label for="duration">Game Duration (HH:MM:SS):</label><br>
        <input type="text" name="duration" value="00:00:00" required><br><br>

        <label for="startdatetime">Start Date & Time:</label><br>
        <input type="datetime-local" name="startdatetime" value="<?php echo date('Y-m-d\TH:i'); ?>" required><br><br>

        <button type="submit">Submit Game</button>
    </form>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
