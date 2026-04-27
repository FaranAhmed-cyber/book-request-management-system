<?php
session_start();
require_once '../config/db.php';

// Check if Admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Tamam requests ko database se nikalna (User ke naam ke saath)
$sql = "SELECT br.*, u.username FROM book_requests br 
        JOIN users u ON br.user_id = u.id 
        ORDER BY br.request_date DESC";
$requests = $pdo->query($sql)->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        .status-pending { color: orange; }
        .status-completed { color: green; }
    </style>
</head>
<body>
    <h1>Admin Panel - Manage Requests</h1>
    <p>Logged in as: <?php echo $_SESSION['admin_name']; ?> (<?php echo $_SESSION['role']; ?>)</p>
    <a href="../logout.php">Logout</a>
    <hr>

    <table>
        <tr>
            <th>User</th>
            <th>Book Title</th>
            <th>Category</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php foreach ($requests as $req): ?>
        <tr>
            <td><?php echo htmlspecialchars($req['username']); ?></td>
            <td><?php echo htmlspecialchars($req['book_title']); ?></td>
            <td><?php echo htmlspecialchars($req['category']); ?></td>
            <td class="status-<?php echo $req['status']; ?>"><?php echo strtoupper($req['status']); ?></td>
            <td>
                <form method="POST" action="update_status.php">
                    <input type="hidden" name="request_id" value="<?php echo $req['id']; ?>">
                    <select name="new_status">
                        <option value="pending">Pending</option>
                        <option value="in_progress">In-Progress</option>
                        <option value="completed">Completed</option>
                    </select>
                    <button type="submit">Update</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>