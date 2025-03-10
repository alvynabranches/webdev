<?php
    session_start();
    if (!empty($_SESSION["username"])) {
        header("Location: login.php");
    }
    ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User: <?php $_SESSION["username"] ?></title>
</head>
<body>
    <?php echo $_SESSION["username"]; ?>
</body>
</html>