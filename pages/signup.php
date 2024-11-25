<!DOCTYPE html>
<html>

<head>
    <title>Sign Up</title>
</head>

<body>
    <?php
    include 'header.html';
    ?>

    <form action="../server/process.php" method="POST">
    <h1>Sign Up Page</h1>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username">
        <br><br>

        <label for="password">Password:</label>
        <input type="text" id="password" name="password">
        <br><br>

        <button type="submit" name="action" value="signup">Submit</button>

    </form>



</body>

</html>