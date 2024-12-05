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
        <input type="hidden" name="action" value="login">

        <label for="username">Username:</label>
        <input type="text" id="username" name="username">
        <br><br>

        <label for="password">Password:</label>
        <input type="text" id="password" name="password">
        <br><br>

        <button type="submit" name="action">Submit</button>

    </form>



</body>

</html>