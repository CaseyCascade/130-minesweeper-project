<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
</head>

<body>
    <?php
    include 'header.html';
    ?>

    <form action="../server/process.php" method="POST">
    <h1>Login Page</h1>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username">
        <br><br>

        <label for="password">Password:</label>
        <input type="text" id="password" name="password">
        <br><br>

        <button type="submit" name="action" value="login">Submit</button>

    </form>



</body>

</html>