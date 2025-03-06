<?php
session_start();

$servername = "db:3306";
$username = "alvyn";
$password = "pass";
$dbname = "db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Drop existing social_media table if exists and recreate it
$sql = "DROP TABLE IF EXISTS social_media";
if ($conn->query($sql) === FALSE) {
    echo "Error dropping social_media table: " . $conn->error;
}

// Create users table if not exists
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === FALSE) {
    echo "Error creating users table: " . $conn->error;
}

// Create new social_media table with user_id
$sql = "CREATE TABLE IF NOT EXISTS social_media (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    platform VARCHAR(50) NOT NULL,
    username VARCHAR(100) NOT NULL,
    profile_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
)";

if ($conn->query($sql) === FALSE) {
    echo "Error creating social_media table: " . $conn->error;
}

// Handle user registration
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $username = $conn->real_escape_string($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = $conn->real_escape_string($_POST['email']);
    
    $sql = "INSERT INTO users (username, password, email) VALUES ('$username', '$password', '$email')";
    
    if ($conn->query($sql) === TRUE) {
        echo "<p class='success'>Registration successful! Please login.</p>";
    } else {
        echo "<p class='error'>Error: " . $conn->error . "</p>";
    }
}

// Handle user login
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];
    
    $sql = "SELECT id, username, password FROM users WHERE username = '$username'";
    $result = $conn->query($sql);
    
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            echo "<p class='success'>Login successful!</p>";
        } else {
            echo "<p class='error'>Invalid password!</p>";
        }
    } else {
        echo "<p class='error'>User not found!</p>";
    }
}

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Handle social media account submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_social']) && isset($_SESSION['user_id'])) {
    $platform = $conn->real_escape_string($_POST['platform']);
    $username = $conn->real_escape_string($_POST['username']);
    $profile_url = $conn->real_escape_string($_POST['profile_url']);
    $user_id = $_SESSION['user_id'];
    
    $sql = "INSERT INTO social_media (user_id, platform, username, profile_url) 
            VALUES ('$user_id', '$platform', '$username', '$profile_url')";
    
    if ($conn->query($sql) === TRUE) {
        echo "<p class='success'>Social media account added successfully!</p>";
    } else {
        echo "<p class='error'>Error: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Social Media Accounts Manager</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .success {
            color: green;
            background-color: #dff0d8;
            padding: 10px;
            border-radius: 4px;
        }
        .error {
            color: red;
            background-color: #f2dede;
            padding: 10px;
            border-radius: 4px;
        }
        .auth-forms {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
        }
        .auth-form {
            flex: 1;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .logout {
            float: right;
            text-decoration: none;
            color: #666;
        }
    </style>
</head>
<body>
    <?php if (!isset($_SESSION['user_id'])): ?>
        <div class="auth-forms">
            <div class="auth-form">
                <h2>Login</h2>
                <form method="POST">
                    <div class="form-group">
                        <label for="login-username">Username:</label>
                        <input type="text" name="username" id="login-username" required>
                    </div>
                    <div class="form-group">
                        <label for="login-password">Password:</label>
                        <input type="password" name="password" id="login-password" required>
                    </div>
                    <button type="submit" name="login">Login</button>
                </form>
            </div>

            <div class="auth-form">
                <h2>Register</h2>
                <form method="POST">
                    <div class="form-group">
                        <label for="reg-username">Username:</label>
                        <input type="text" name="username" id="reg-username" required>
                    </div>
                    <div class="form-group">
                        <label for="reg-password">Password:</label>
                        <input type="password" name="password" id="reg-password" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" name="email" id="email" required>
                    </div>
                    <button type="submit" name="register">Register</button>
                </form>
            </div>
        </div>
    <?php else: ?>
        <h1>Social Media Accounts Manager</h1>
        <p>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>! 
           <a href="?logout" class="logout">Logout</a>
        </p>
        
        <form method="POST">
            <div class="form-group">
                <label for="platform">Platform:</label>
                <select name="platform" id="platform" required>
                    <option value="">Select Platform</option>
                    <option value="Facebook">Facebook</option>
                    <option value="Twitter">Twitter</option>
                    <option value="Instagram">Instagram</option>
                    <option value="LinkedIn">LinkedIn</option>
                    <option value="YouTube">YouTube</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" required>
            </div>
            
            <div class="form-group">
                <label for="profile_url">Profile URL:</label>
                <input type="text" name="profile_url" id="profile_url">
            </div>
            
            <button type="submit" name="add_social">Add Account</button>
        </form>

        <?php
        // Display existing social media accounts for the logged-in user
        $user_id = $_SESSION['user_id'];
        $result = $conn->query("SELECT * FROM social_media WHERE user_id = $user_id ORDER BY created_at DESC");
        if ($result->num_rows > 0) {
            echo "<h2>Your Social Media Accounts</h2>";
            echo "<table border='1' style='width: 100%; border-collapse: collapse;'>";
            echo "<tr><th>Platform</th><th>Username</th><th>Profile URL</th><th>Added On</th></tr>";
            
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row["platform"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["username"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["profile_url"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["created_at"]) . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
        ?>
    <?php endif; ?>
    
    <?php $conn->close(); ?>
</body>
</html>
