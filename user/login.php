<?php
// Session start karna zaroori hai taake user login reh sakay
session_start();
require_once '../config/db.php';

$error = "";

// Check karna ke kya login button dabaya gaya hai
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = htmlspecialchars($_POST['email']);
    $password = $_POST['password'];

    // Database se user ka record nikalna email ke zariye
    $sql = "SELECT * FROM users WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    // Agar user mil gaya aur password bhi sahi hai
    if ($user && password_verify($password, $user['password'])) {
        // User ki details session mein save ki ja rahi hain
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = 'user';

        // Login ke baad dashboard par bhejna
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid email or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Book Request System</title>
</head>
<body>
    <h2>User Login</h2>

    <?php if($error) echo "<p style='color:red;'>$error</p>"; ?>

    <form method="POST" action="">
        <div style="margin-bottom: 10px;">
            <label>Email Address:</label><br>
            <input type="email" name="email" required>
        </div>

        <div style="margin-bottom: 10px;">
            <label>Password:</label><br>
            <input type="password" name="password" required>
        </div>

        <button type="submit">Login</button>
    </form>

    <p>Don't have an account? <a href="register.php">Register here</a></p>
</body>
</html>