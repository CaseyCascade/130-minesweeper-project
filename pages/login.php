<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <link rel="stylesheet" href="../styles/fs.css">
</head>

<body>
    <?php
    include 'header.php';
    ?>

    <form action="../server/process.php" method="POST">
    <h1>Login Page</h1>
        <input type="hidden" name="action" value="login">

        <label for="username">Username:</label>
        <input type="text" id="username" name="username">
        <br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password">
        <br><br>

        <button type="submit">Submit</button>

    </form>



</body>

</html>