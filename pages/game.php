<?php
if (!isset($_SESSION)) session_start();

if (isset($_SESSION['visited'])) {
    header("Location: options.php");
    exit();
} else {
    $_SESSION['visited'] = true;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Minesweeper</title>
    
    <link rel="stylesheet" href="../styles/game.css">
    <?php
    include 'header.php';
    ?>
</head>

<body>

<main>
<br>

<div id ="resultPanel">
</div>
<div class="game-wrapper">
    <div id="timer">0:00</div>
    <div id="gameContainer"></div>
    <div id="infoPanel"></div>
</div>

<!- Sound Effects & Other Assets -!>
<audio id="gameOverSound" src="../data/assets/kaboom.mp3"></audio>
<audio id="youWinSound" src="../data/assets/victory.mp3"></audio> 
<audio loop id="music" src="../data/assets/music.mp3"></audio> <!-- TODO Replace w/ Music File -->

</main>
<?php include 'footer.php' ?>
</body>

</html>

<script type="module" src="../src/game.js"></script>