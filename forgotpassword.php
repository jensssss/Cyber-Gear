<?php
// Start session
session_start();

// Database connection
$conn = new mysqli('localhost', 'root', '', 'cybersecurity_db');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = ""; // Variable to store feedback messages

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $conn->real_escape_string($_POST['email']);
    $new_password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash the new password

    // Check if the user exists
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Update the password
        $sql = "UPDATE users SET password='$new_password' WHERE email='$email'";
        if ($conn->query($sql) === TRUE) {
            $message = "<p class='success'>Password updated successfully! <a href='login.php'>Login here</a></p>";
        } else {
            $message = "<p class='error'>Error updating password: " . $conn->error . "</p>";
        }
    } else {
        $message = "<p class='error'>Email not found!</p>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
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

    /* Form Container */
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

    /* Feedback Messages */
    .success {
        background-color: #28a745;
        color: #fff;
        padding: 10px;
        margin-bottom: 15px;
        border-radius: 5px;
        font-weight: bold;
        text-align: center;
    }

    .error {
        background-color: #dc3545;
        color: #fff;
        padding: 10px;
        margin-bottom: 15px;
        border-radius: 5px;
        font-weight: bold;
        text-align: center;
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
    <form method="POST" action="forgotpassword.php">
        <h2>Forgot Password</h2>
        <!-- Display the feedback message -->
        <?php echo $message; ?>
        <input type="email" name="email" placeholder="Enter your email" required><br>
        <input type="password" name="password" placeholder="Enter your new password" required><br>
        <button type="submit">Reset Password</button>
        <p>Back to <a href="login.php">Login</a></p>
    </form>
</body>
</html>
