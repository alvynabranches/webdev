<?php
session_start();
if (!empty($_SESSION["username"])) {
    header("Location: user.php");
}
$servername = "db:3306";
$username = "alvyn";
$password = "pass";
$dbname = "db";
$con = new mysqli($servername, $username, $password, $dbname);

if (!empty($_POST["username"]) && !empty($_POST["password"])) {
    $un = $_POST["username"];
    $pwd = $_POST["password"];
    $result = $con->query("SELECT password FROM users WHERE username='$un';");
    if ($result->num_rows == 1) {
        // echo "User already exists";
        while ($row = $result->fetch_assoc()) {
            $hash_pwd = $row["password"];
        }
        if (password_verify($pwd, $hash_pwd) == 1) {
            // echo "<br>Valid Password";
            $_SESSION["username"] = $un;
            header("Location: user.php");
        } else {
            echo "<br>Invalid Password";
        }
    } else {
        echo "Username not found!";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <form action="" method="post">
        Username: <input type="text" name="username"><br><br>
        Password: <input type="password" name="password">
        <button type="submit">Submit</button>
    </form>

</body>

</html>