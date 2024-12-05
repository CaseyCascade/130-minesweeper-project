<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Finish Debug Form</title>
</head>
<?php
    include '../pages/header.php';
?>
<body>
    <h1>Finish Game Debug Form</h1>
    <form method="POST" action="../server/process.php">
        <!-- Specify the action -->
        <input type="hidden" name="action" value="finishgame">

        <!-- User ID (can be hardcoded or left blank to use session data) -->
        <label for="userid">User ID:</label>
        <input type="number" id="userid" name="userid" placeholder="Optional (use session if blank)">
        <br><br>

        <!-- Game outcome -->
        <label for="won">Game Won (1 = Yes, 0 = No):</label>
        <select id="won" name="won">
            <option value="1">Yes</option>
            <option value="0">No</option>
        </select>
        <br><br>

        <!-- Start datetime -->
        <label for="startdatetime">Start Datetime:</label>
        <input type="datetime-local" id="startdatetime" name="startdatetime" required>
        <br><br>

        <!-- Game duration -->
        <label for="duration">Duration (HH:MM:SS):</label>
        <input type="text" id="duration" name="duration" placeholder="e.g., 00:15:23" required>
        <br><br>

        <!-- Number of turns -->
        <label for="numturns">Number of Turns:</label>
        <input type="number" id="numturns" name="numturns" required>
        <br><br>

        <button type="submit">Submit Game Data</button>
    </form>
</body>
</html>
