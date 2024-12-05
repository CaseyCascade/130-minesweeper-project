<?php
// Database connection credentials
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

// Default sorting parameters
$sort_column = 'best_duration';
$sort_order = 'ASC';
$unique_users = true;

// Update sorting and unique option based on user input
if (isset($_GET['sort']) && isset($_GET['order'])) {
    $allowed_columns = ['best_duration', 'best_turns', 'best_date'];
    $allowed_orders = ['ASC', 'DESC'];

    if (in_array($_GET['sort'], $allowed_columns) && in_array($_GET['order'], $allowed_orders)) {
        $sort_column = $_GET['sort'];
        $sort_order = $_GET['order'];
    }
}

if (isset($_GET['unique']) && $_GET['unique'] === 'false') {
    $unique_users = false;
}

// Build the query with combined ranking
if ($unique_users) {
    $query = "
        SELECT g.userid, u.username, 
               MIN(g.numturns) AS best_turns, 
               MIN(g.duration) AS best_duration, 
               DATE(MIN(g.startdatetime)) AS best_date
        FROM games g
        INNER JOIN users u ON g.userid = u.id
        WHERE g.won = 1
        GROUP BY g.userid
        ORDER BY best_duration ASC, best_turns ASC;
    ";
} else {
    $query = "
        SELECT g.userid, u.username, 
               g.numturns AS best_turns, 
               g.duration AS best_duration, 
               DATE(g.startdatetime) AS best_date
        FROM games g
        INNER JOIN users u ON g.userid = u.id
        WHERE g.won = 1
        ORDER BY best_duration ASC, best_turns ASC;
    ";
}

$result = $conn->query($query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard</title>
</head>
<body>
    <h1>Leaderboard</h1>

    <form method="GET" action="">
        <p>Sort By:</p>

        <!-- Sort by Turns -->
        <button type="submit" name="sort" value="best_turns">Sort by Turns (<?php echo $sort_column === 'best_turns' && $sort_order === 'ASC' ? 'Descending' : 'Ascending'; ?>)</button>
        <input type="hidden" name="order" value="<?php echo $sort_column === 'best_turns' && $sort_order === 'ASC' ? 'DESC' : 'ASC'; ?>">

        <!-- Sort by Duration -->
        <button type="submit" name="sort" value="best_duration">Sort by Duration (<?php echo $sort_column === 'best_duration' && $sort_order === 'ASC' ? 'Descending' : 'Ascending'; ?>)</button>
        <input type="hidden" name="order" value="<?php echo $sort_column === 'best_duration' && $sort_order === 'ASC' ? 'DESC' : 'ASC'; ?>">

        <!-- Sort by Date -->
        <button type="submit" name="sort" value="best_date">Sort by Date (<?php echo $sort_column === 'best_date' && $sort_order === 'ASC' ? 'Descending' : 'Ascending'; ?>)</button>
        <input type="hidden" name="order" value="<?php echo $sort_column === 'best_date' && $sort_order === 'ASC' ? 'DESC' : 'ASC'; ?>">

        <p>
            <label>
                <input type="checkbox" name="unique" value="false" <?php if (!$unique_users) echo 'checked'; ?>>
                Show all game records (uncheck for unique users only)
            </label>
        </p>

        <button type="submit">Apply</button>
    </form>

    <table border="1">
        <thead>
            <tr>
                <th>Rank</th>
                <th>Username</th>
                <th>Turns</th>
                <th>Duration</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                $rank = 1;
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $rank . "</td>";
                    echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                    echo "<td>" . (int)$row['best_turns'] . "</td>";
                    echo "<td>" . htmlspecialchars($row['best_duration']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['best_date']) . "</td>";
                    echo "</tr>";
                    $rank++;
                }
            } else {
                echo "<tr><td colspan='5'>No data available</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>

<?php
// Close the connection
$conn->close();
?>
