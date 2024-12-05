<!DOCTYPE html>
<html>

<head>
    <title>Game Options</title>
</head>

<body>
    <?php
    include 'header.php';
    ?>

<h1>Game Options</h1>

<label for="num_mines"># of Mines:</label>
<input type="number" id="num_mines" name="num_mines" min="0" max="100" step="1" required>
<br>

<label for="win_condition">Win Condition:</label>
<select id="win_condition" required> 
    <option value="clear_grid">Clear Entire Grid</option>
    <option value="clear_mines">Clear All Mines</option>
</select> <br>

<label for="auto_first_move">Auto First Move:</label>
<input type="checkbox" id="auto_first_move"> <br>

<label for="board_size">Board Size:</label>
<select id="board_size"> 
    <option value="small">Small (8x8)</option>
    <option value="medium">Medium (16x16)</option>
    <option value="large">Large (30x16)</option>
</select> <br>

<label for="style">Board Color / Texture:</label>
<select id="style" required> 
    <option value="default">Default</option>
    <option value="default">Option 1</option>
    <option value="default">Option 2</option>
</select> <br>

<label for="theme">Color Theme:<label>
<select id="theme" required> 
    <option value="default">Default</option>
    <option value="default">Option 1</option>
    <option value="default">Option 2</option>
</select> <br>

<button type="button" onclick="setInitParameters()">Play Game</button>
</body>

</html>

<script type="module" src="../src/game.js"></script>