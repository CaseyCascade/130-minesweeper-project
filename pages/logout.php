<?php
session_start();
session_unset();
session_destroy();
//header("Location: ../pages/index.php");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Index</title>
</head>

<body>
    <?php
    include 'header.php';
    ?>

<p>Successfully logged out!</p>
<a href="index.php">Return to Homepage</a>
</body>

</html>