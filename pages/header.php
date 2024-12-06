<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minesweeper Header</title>
    <link rel="stylesheet" href="../styles/header.css">
    <link rel="stylesheet" href="../styles/fs.css">
</head>

<body>
    <header>
        <div class="nav-container">
            <div class="logo">Bravo & Casey's Minesweeper</div> 
            <nav>
                <a href="index.php">Home</a>
                <a href="options.php">Play</a>
                <a href="leaderboard.php">Leaderboard</a>
<?php
    if (!isset($_SESSION)) session_start();
    if (!isset($_SESSION['username'])) {
        echo '<a href="login.php">Login</a>';
        echo '<a href="signup.php">Sign Up</a>';
    } else {
        echo '<a href="logout.php">Logout</a>';
    }
?>
            </nav>
        </div>
    </header>
</body>

</html>