<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
</head>

<body>
    <?php
    include 'header.html';
    ?>

    <form action="./server/login.php" method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username">
        <br><br>

        <label for="password">Password:</label>
        <input type="text" id="password" name="password">
        <br><br>

        <button type="submit" name="action" value="login">Login</button>
        <button type="submit" name="action" value="register">Register</button>

    </form>



</body>

</html>