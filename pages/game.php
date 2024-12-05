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
<audio id="music" src="../data/assets/kaboom.mp3"></audio> <!-- TODO Replace w/ Music File -->
</html>

</body>

<script type="module" src="../src/game.js"></script>