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
 

<h1>Game Page</h1>
</body>
<div id ="resultPanel">
</div>
<div class="game-wrapper">
    <div id="timer">0:00</div>
    <div id="gameContainer"></div>
    <div id="infoPanel"></div>
</div>
</html>

<script type="module" src="../src/game.js"></script>