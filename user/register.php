<?php
// Database connection file ko shamil karna
require_once '../config/db.php';

$message = "";

// Check karna ke kya form submit hua hai
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $password = $_POST['password'];

    // Password ko hash karna (Security ke liye lazmi hai)
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    try {
        // SQL Query taiyar karna (Prepared Statement)
        $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
        $stmt = $pdo->prepare($sql);
        
        // Data ko query ke saath jorna
        $stmt->execute([
            'username' => $username,
            'email' => $email,
            'password' => $hashed_password
        ]);

        $message = "Registration successful! You can now login.";
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) { // Unique constraint error (Email pehle se mojud hai)
            $message = "Error: This email is already registered.";
        } else {
            $message = "Something went wrong: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Registration</title>
</head>
<body>
    <h2>Create New Account</h2>
    
    <?php if($message) echo "<p>$message</p>"; ?>

    <form method="POST" action="">
        <label>Username:</label><br>
        <input type="text" name="username" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <button type="submit">Register</button>
    </form>
    
    <p>Do you have an account? <a href="login.php">Login</a></p>
</body>
</html>