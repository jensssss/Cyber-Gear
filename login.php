<?php
// Start session
session_start();

// Database connection
$conn = new mysqli('localhost', 'root', '', 'cybersecurity_db');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    // Check if the user exists
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Verify password
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            header('Location: index.php');
        } else {
            echo "Incorrect password!";
        }
    } else {
        echo "User does not exist!";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
    /* General Reset and Styling */
    *, *::after, *::before {
        box-sizing: border-box;
    }
    body {
        font-family: 'Roboto', sans-serif;
        margin: 0;
        padding: 0;
        background-color: #0a0a0a;
        color: #fff;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        transition: background-color 0.3s ease;
    }

    /* Login Container */
    form {
        background-color: #111;
        padding: 20px 30px;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0, 255, 153, 0.3);
        display: flex;
        flex-direction: column;
        width: 100%;
        max-width: 400px;
        text-align: center;
    }

    h2 {
        margin-bottom: 20px;
        color: #00FF99;
        text-shadow: 0 0 10px rgba(0, 255, 153, 0.8);
    }

    /* Input Fields */
    input {
        background-color: #222;
        border: 1px solid #444;
        color: #fff;
        padding: 10px;
        margin-bottom: 15px;
        border-radius: 5px;
        font-size: 16px;
        outline: none;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }

    input:focus {
        border-color: #00FF99;
        box-shadow: 0 0 10px rgba(0, 255, 153, 0.6);
    }

    /* Button */
    button {
        background-color: #00FF99;
        border: none;
        color: #111;
        padding: 10px 20px;
        cursor: pointer;
        font-size: 16px;
        border-radius: 5px;
        font-weight: bold;
        transition: background-color 0.3s ease, transform 0.3s ease;
    }

    button:hover {
        background-color: #fff;
        color: #00FF99;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0, 255, 153, 0.5);
    }

    /* Register Link */
    p {
        margin-top: 15px;
        font-size: 14px;
    }

    a {
        color: #00FF99;
        text-decoration: none;
        font-weight: bold;
        transition: color 0.3s ease;
    }

    a:hover {
        color: #fff;
        text-shadow: 0 0 10px rgba(0, 255, 153, 0.8);
    }
</style>

</head>
<body>
    <form method="POST" action="login.php">
        <h2>Login</h2>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Login</button>
        <p>Don't have an account? <a href="register.php">Register</a></p>
    </form>
</body>
</html>
