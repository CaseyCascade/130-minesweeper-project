<!DOCTYPE html>
<html>

<head>
    <title>Sign Up</title>
    <?php
    include 'header.php';
    ?>
</head>

<body>

    <form action="../server/process.php" method="POST">
        <br>
        <h1>Sign Up Page</h1>
        <br>
        <input type="hidden" name="action" value="signup">

        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br><br>

        <label for="confpassword">Confirm Password:</label>
        <input type="password" id="confpassword" name="confpassword" required>
        <br><br>

        <button type="submit">Submit</button>

        <br><br>
        <p>Already have an account? <a href="login.php">Log in</a></p>

    </form>

</body>

<script>

var passwordElement = document.getElementById("password");
var confPasswordElement = document.getElementById("confpassword");

function validatePassword() {
    if (passwordElement.value != confPasswordElement.value) {
        confPasswordElement.setCustomValidity("Passwords don't match.");
    } else {
        confPasswordElement.setCustomValidity("");
    }
}

passwordElement.onchange = validatePassword;
confPasswordElement.onchange = validatePassword;

</script>

</html>