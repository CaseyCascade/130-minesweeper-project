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
    <?php
    include 'header.php';
    ?>
</head>

<body>

<p>Successfully logged out!</p>
<a href="index.php">Return to Homepage</a>
</body>

</html>