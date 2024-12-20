<?php

// handle db before doing anything
$_POST['action'] = 'none';
include("../server/process.php");

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

if (isset($_GET['self'])) {
    $playerId = $_SESSION['userid'];
}

// Set default sorting
$validColumns = ['username', 'gameswon', 'timeplayedsec', 'gamesplayed'];
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
$playerName = null;
$playerNameResult = null;
if ($playerId) {
    $playerGamesSql = "SELECT numturns, duration, startdatetime, won 
                       FROM games 
                       WHERE userid = $playerId
                       ORDER BY startdatetime DESC";
    $playerGames = $conn->query($playerGamesSql);
    $playerNameSql = "SELECT username FROM users WHERE id = $playerId;";
    $playerName = $conn->query($playerNameSql);
    $playerNameResult = $playerName->fetch_assoc();
}

function echo_sort_href($str) {
    global $sortColumn, $sortOrder;
    $order = $sortColumn == $str ? ($sortOrder == 'ASC' ? 'DESC' : 'ASC') : 'DESC';
    if ($str == 'username') {
        $order = $sortColumn == $str ? ($sortOrder == 'ASC' ? 'DESC' : 'ASC') : 'ASC';
    }
    $outstr = "?sortColumn=$str&sortOrder=$order";
    echo $outstr;
}

function echo_username() {
    global $row;
    echo htmlspecialchars($row['username']);
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard</title>
    <?php
    include 'header.php';
    ?>
</head>

<body>
<main class="centered">
<div class="leaderboard">
<h1>Leaderboard</h1>
<table>
    <thead>
        <tr>
            <th><a href="<?php echo_sort_href('username'); ?>">Username</a></th>
            <th><a href="<?php echo_sort_href('gameswon'); ?>">Games Won</a></th>
            <th><a href="<?php echo_sort_href('gamesplayed'); ?>">Games Played</a></th>
            <th><a href="<?php echo_sort_href('timeplayedsec'); ?>">Time Played (Seconds)</a></th>
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
    <h3>Games played by: <h1><?php echo htmlspecialchars($playerNameResult['username']); ?></h1></h3>
    <?php 

    $creatornames = ['casey', 'caseycascade', 'bravo', 'braveo'];
    if (in_array(strtolower($playerNameResult['username']), $creatornames)) {
        echo '<div>Hey, isn\'t that one of the creators?...</div>';
        echo '<div>Why are they here? They should be working on this project, <a target="_blank" href="https://www.youtube.com/watch?v=4VTBMznLrWs">HAHA!</a> *knee slap*</div>';
        echo '<div>pls this isn\'t funny we only have till friday to finish it 🥲</div>';
    }

    if ($playerNameResult['username'] == 'spamton') {
        echo '<img src="https://i.redd.it/z6971venlho91.gif" width=120 height=60>';
    }
    ?>
    <?php if ($playerGames->num_rows > 0): ?>
    <table>
        <thead>
            <tr>
                <th>Won</th>
                <th>Turns</th>
                <th>Duration</th>
                <th>DateTime</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($game = $playerGames->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $game['won'] ? '✅' : '❌'; ?></td>
                    <td><?php echo $game['numturns']; ?></td>
                    <td><?php echo $game['duration']; ?></td>
                    <td><?php echo $game['startdatetime']; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <?php else: ?>
    <br>
    <div>No games found for this player 🙀. How unfortunate.</div>
    <div>You know, <?php echo htmlspecialchars($playerNameResult['username']); ?> should start playing...</div>
    <div>Why not make it a game? Convince them to play, and you'll get a special name in the credits :3 (maybe?) (no)</div>
    <?php endif; ?>
<?php endif; ?>

<?php if (isset($_GET['debug'])): ?>
    <h1>I must say, what a brilliant trick you've made...</h1>
    <p>How did you find this? Huh, guess I have to give you something super secret.</p>
    <p>Here, wouldn't you like a taste of the power?</p>
    <a href="../debug/users_upload.php">AND I CALL THIS ONE, HOLY MOLY</p>
<?php endif; ?>
</div>

</main>
<?php include 'footer.php' ?>
</body>

</html>