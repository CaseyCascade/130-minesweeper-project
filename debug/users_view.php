<?php
session_start();

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

$sortColumn = isset($_GET['sortColumn']) ? $_GET['sortColumn'] : 'gameswon';
$sortOrder = isset($_GET['sortOrder']) ? $_GET['sortOrder'] : 'DESC';
$playerId = isset($_GET['playerId']) ? (int)$_GET['playerId'] : null;

// Set default sorting
$validColumns = ['gameswon', 'timeplayedsec', 'gamesplayed'];
if (!in_array($sortColumn, $validColumns)) {
    $sortColumn = 'gameswon';
}

$validOrders = ['ASC', 'DESC'];
if (!in_array($sortOrder, $validOrders)) {
    $sortOrder = 'DESC';
}

// Global leaderboard query
$sql = "SELECT id, username, gameswon, gamesplayed, timeplayedsec
        FROM users
        ORDER BY $sortColumn $sortOrder";
$result = $conn->query($sql);

// Specific player's games query
$playerGames = null;
if ($playerId) {
    $playerGamesSql = "SELECT numturns, duration, startdatetime, won 
                       FROM games 
                       WHERE userid = $playerId
                       ORDER BY startdatetime DESC";
    $playerGames = $conn->query($playerGamesSql);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard</title>
</head>
<body>

<h1>Global Leaderboard</h1>

<table border="1">
    <thead>
        <tr>
            <th><a href="?sortColumn=username&sortOrder=<?php echo $sortOrder == 'ASC' ? 'DESC' : 'ASC'; ?>">Username</a></th>
            <th><a href="?sortColumn=gameswon&sortOrder=<?php echo $sortOrder == 'ASC' ? 'DESC' : 'ASC'; ?>">Games Won</a></th>
            <th><a href="?sortColumn=gamesplayed&sortOrder=<?php echo $sortOrder == 'ASC' ? 'DESC' : 'ASC'; ?>">Games Played</a></th>
            <th><a href="?sortColumn=timeplayedsec&sortOrder=<?php echo $sortOrder == 'ASC' ? 'DESC' : 'ASC'; ?>">Time Played (Seconds)</a></th>
        </tr>
    </thead>
    <tbody>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><a href="?playerId=<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['username']); ?></a></td>
                    <td><?php echo $row['gameswon']; ?></td>
                    <td><?php echo $row['gamesplayed']; ?></td>
                    <td><?php echo $row['timeplayedsec']; ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="4">No data available.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<?php if ($playerId && $playerGames): ?>
    <h2>Games Played by <?php echo htmlspecialchars($row['username']); ?></h2>
    <table border="1">
        <thead>
            <tr>
                <th>Turns</th>
                <th>Duration</th>
                <th>Start Date</th>
                <th>Won</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($playerGames->num_rows > 0): ?>
                <?php while ($game = $playerGames->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $game['numturns']; ?></td>
                        <td><?php echo $game['duration']; ?></td>
                        <td><?php echo $game['startdatetime']; ?></td>
                        <td><?php echo $game['won'] ? 'Yes' : 'No'; ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="4">No games found for this player.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
<?php endif; ?>

</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
