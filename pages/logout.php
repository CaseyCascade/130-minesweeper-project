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
<main class="centered">
<h1>Successfully logged out!</h1>
<p>We will see you in another time...</p>
<a href="index.php">Return to Homepage</a>
</main>
<?php include 'footer.php' ?>
</body>

</html>