<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>

<body>
    <h1>Hello</h1>
    <!-- <form action="" method="get">
        <input type="number" name="value1">
        <input type="number" name="value2">
        <button type="submit">Calculate</button>
    </form> -->
    <?php
        // $val = 5;
        // echo $val;
        // $name = "Your Name";
        // echo $name;
        // // print_r($_GET);
        // // print_r($_POST);
        // if (isset($_POST["value1"]) && isset($_POST["value2"])) {
        //     $val1 = $_POST["value1"];
        //     $val2 = $_POST["value2"];
        //     $sum = $val1 + $val2;
        //     $sub = $val1 - $val2;
        //     $mul = $val1 * $val2;
        //     $div = $val1 / $val2;
        //     echo "<br>";
        //     echo $sum;
        //     echo "<br>";
        //     echo $sub;
        //     echo "<br>";
        //     echo $mul;
        //     echo "<br>";
        //     echo $div;
        //     echo "<br>";
        //     $password = $_POST['password'];
        //     $hash = password_hash($password, PASSWORD_DEFAULT);
        //     $hash2 = password_hash($password, PASSWORD_DEFAULT);
        //     echo password_verify($password, $hash);
        //     echo password_verify($password, $hash2);
        // }
    ?>

    <form action="" method="post">
        <input type="text" name="username" id="username">
        <input type="password" name="password" id="password">
        <input type="checkbox" name="sports[]" id="sports" value="cricket">Cricket
        <input type="checkbox" name="sports[]" id="sports" value="football">Football
        <input type="checkbox" name="sports[]" id="sports" value="chess">Chess
        <input type="checkbox" name="sports[]" id="sports" value="kabaddi">Kabaddi
        <input type="checkbox" name="sports[]" id="sports" value="badminton">Badminton
        <button type="submit">Submit</button>
    </form>
    <?php
    $servername = "db:3306";
    $username = "alvyn";
    $password = "pass";
    $dbname = "db";

    $con = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($con->connect_error) {
        die("connection error: " . $con->connect_error);
    } else {
        echo "Connection established";
    }

    $con->query("CREATE TABLE IF NOT EXISTS users (id INTEGER PRIMARY KEY AUTO_INCREMENT, username VARCHAR(32) UNIQUE NOT NULL, password VARCHAR(512));");
    $con->query("CREATE TABLE IF NOT EXISTS sports (id INTEGER PRIMARY KEY AUTO_INCREMENT, name VARCHAR(255) NOT NULL, uid INTEGER NOT NULL, FOREIGN KEY (uid) REFERENCES users (id));");
    if (!empty($_POST["username"]) && !empty($_POST["password"])) {
        $un = $_POST["username"];
        $pw = password_hash($_POST["password"], PASSWORD_DEFAULT);
        $con->query("INSERT INTO users (username, password) VALUES (\"" . $un . "\", \""     . $pw . "\");");
        $result = $con->query("SELECT * FROM users WHERE username=\"" . $un . "\";");
        if ($result->num_rows == 1) {
            while ($row = $result->fetch_assoc()) {
                $uid = $row['id'];
            }
            if (isset($_POST["sports"])) {
                $sports = $_POST["sports"];
                for ($i = 0; $i < count($sports); $i++) {
                    $con->query("INSERT INTO sports (name, uid) VALUES (\"" . $sports[$i] . "\", \"" . $uid . "\");");
                }
            }
        } else {
            echo $result->num_rows;
        }
    }

    ?>

    <?php
        // $sports = $_POST["sports"];
        // echo $sports;
        // $s = array("cricket", "badminton");
        // $person = array("name" => "Rohit", "age" => 25, "gender" => "male");
        // echo $s[0];
        // echo $person["name"];

        // for ($i = 0; $i <= sizeof($person); $i++) {
        //     echo $sports[$i];
        // }
    ?>

    <?php
        // $servername = "localhost:3306";
        // $username = "root";
        // $password = "";
        // $dbname = "<dbname>";

        // $con = new mysqli($servername, $username, $password, $dbname);

        // // Check connection
        // if ($con->connect_error) {
        //     die("connection error: " . $con->connect_error);
        // } else {
        //     echo "Connection established";
        // }

        // $con->query("CREATE TABLE IF NOT EXISTS person (id int PRIMARY KEY, name VARCHAR(50));");

        // $con->close();
    ?>
</body>

</html>