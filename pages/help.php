<!DOCTYPE html>
<html>

<head>
    <title>Help</title>
    <?php
    include 'header.php';
    ?>
</head>

<body>
<main class="centered-thin">

    <h2>Before You Play...</h2>
    <p>
        Welcome to our Minesweeper game! To play, first create an account and sign in. Once you have done so, feel free to click 'Play Game' where you will be brought to the options menu!

        
</p>

    <h2>Minesweeper Rules</h2>
    <p>
        Minesweeper is a game of logic and deduction where the goal is to reveal all safe cells without clicking on a mine. 
        Click any cell to start, and numbers will appear, indicating how many mines are in the surrounding eight cells. Use these numbers to figure out where the mines are hidden, and right-click to place flags on suspected mines. 
        The game is won when all non-mine cells are revealed, or when all mines have been flagged, but if you click on a mine, the game ends. 
    </p>
    
    <h2>Available Options</h2>
<p>
        In the options you must choose a size for the board, and a number of mines (10-99), as well as a win condition. 
        The win condition "Clear All Mines" requires you to flag every mine in order to win. You have as many flags as there are mines, so each flag must be placed correctly. 
        The win condition 'Clear Entire Grid' requires you to reveal every cell in the grid except for the mines, leaving only safe tiles revealed. 

        You can also choose to toggle the "Auto First Move" checkbox to have the game automatically pick a safe cell to reveal for you. 
    </p>
</main>
<?php include 'footer.php' ?>
</body>

</html>