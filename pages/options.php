<?php

if (!isset($_SESSION)) session_start();
if (!isset($_SESSION['userid'])) {
    echo '<link rel="stylesheet" href="../styles/header.css">';
    echo '<link rel="stylesheet" href="../styles/fs.css">';
    echo '<body class="msgbody">';
    echo '<div class="centermsg">';
    echo '<p>You must be logged in before you can play...</p>';
    echo '<p><form action="login.php"><button type="submit">Go To Login Page</button></form></p>';
    echo '</div>';
    echo '</body>';
    die();
}
if (isset($_SESSION['visited'])) {
    unset($_SESSION['visited']);
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Game Options</title>
    <?php
    include 'header.php';
    ?>
</head>

<body>
<main class="centered">
<form>
    
    <h1>Game Options</h1>

    <label for="num_mines"># of Mines:</label>
    <input type="number" id="num_mines" name="num_mines" min="10" max="99" step="1" value="10" required>
    <br>

    <label for="win_condition">Win Condition:</label>
    <select id="win_condition" required> 
        <option value="clear_mines">Clear All Mines</option>
        <option value="clear_grid">Clear Entire Grid</option>
    </select> <br>

    <label for="auto_first_move">Auto First Move:</label>
    <input type="checkbox" id="auto_first_move"> <br>

    <label for="board_size">Board Size:</label>
    <select id="board_size"> 
        <option value="small">Small (8x8)</option>
        <option value="medium">Medium (16x16)</option>
        <option value="large">Large (30x16)</option>
    </select> <br>

    <label for="style">Board Theme:</label>
    <select id="style" required> 
        <option value="default">Default</option>
        <option value="hackerman">Hackerman</option>
        <option value="beans">Beans</option>
    </select> <br>

    <label for="theme">Color Theme:<label>
    <select id="theme" required> 
        <option value="default">Default</option>
        <option value="dark">Dark</option>
        <option value="candyland">Candyland</option>
    </select> <br><br>

    <button type="button" onclick="setInitParameters()">Play Game</button>

</form>
</main>
<?php include 'footer.php' ?>
</body>

</html>

<script type="module" src="../src/game.js"></script>