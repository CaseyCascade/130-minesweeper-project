<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <?php
    include 'header.php';
    ?>
</head>

<body>
<main>

    <form action="../server/process.php" method="POST">
        <h1>Login</h1>
        <input type="hidden" name="action" value="login">

        <label for="username">Username:</label>
        <input type="text" id="username" name="username">
        <br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password">
        <br><br>

        <button type="submit">Log In</button>

        <br><br>
        <p>Don't have an account? <a href="signup.php">Sign up</a></p>

    </form>
</main>
<?php include 'footer.php' ?>
</body>

</html>