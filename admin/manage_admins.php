<?php
session_start();
require_once '../config/db.php';

// Sirf Super Admin hi is page ko dekh sakta hai
if (!isset($_SESSION['admin_id']) || $_SESSION['role'] !== 'superadmin') {
    die("Access Denied: Only Super Admin can manage staff.");
}

$msg = "";

// Naya Admin add karne ki logic
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_admin'])) {
    $user = htmlspecialchars($_POST['username']);
    $pass = $_POST['password']; // As per simple setup, plain text for now
    $role = $_POST['role'];

    $sql = "INSERT INTO admins (username, password, role) VALUES (:u, :p, :r)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['u' => $user, 'p' => $pass, 'r' => $role]);
    $msg = "New staff member added successfully!";
}

// Tamam admins ki list nikalna
$admins = $pdo->query("SELECT * FROM admins")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Staff - Super Admin</title>
</head>
<body>
    <h1>Staff Management</h1>
    <a href="dashboard.php">Back to Dashboard</a>
    <hr>

    <?php if($msg) echo "<p style='color:green;'>$msg</p>"; ?>

    <h3>Add New Admin/Staff</h3>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <select name="role">
            <option value="admin">Regular Admin</option>
            <option value="superadmin">Super Admin</option>
        </select>
        <button type="submit" name="add_admin">Add Member</button>
    </form>

    <br>
    <h3>Current Staff List</h3>
    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Role</th>
        </tr>
        <?php foreach($admins as $a): ?>
        <tr>
            <td><?php echo $a['id']; ?></td>
            <td><?php echo htmlspecialchars($a['username']); ?></td>
            <td><?php echo strtoupper($a['role']); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>