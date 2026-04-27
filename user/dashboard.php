<?php
require_once '../includes/auth.php';
checkLogin();
require_once '../config/db.php';

// User ki apni requests nikalna
$u_id = $_SESSION['user_id'];
$sql = "SELECT * FROM book_requests WHERE user_id = :u_id ORDER BY request_date DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute(['u_id' => $u_id]);
$my_requests = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Dashboard</title>
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .status-pending { color: #d97706; font-weight: bold; }
        .status-completed { color: #059669; font-weight: bold; }
        .status-progress { color: #2563eb; font-weight: bold; }
    </style>
</head>
<body>
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
    
    <nav>
        <a href="request_book.php" style="padding: 10px; background: #007bff; color: white; text-decoration: none; border-radius: 5px;">+ Request New Book</a>
        <a href="../logout.php" style="margin-left: 20px;">Logout</a>
    </nav>

    <h3>Your Book Requests</h3>
    <table>
        <tr>
            <th>Book Title</th>
            <th>Category</th>
            <th>Status</th>
            <th>Date</th>
        </tr>
        <?php foreach ($my_requests as $req): ?>
        <tr>
            <td><?php echo htmlspecialchars($req['book_title']); ?></td>
            <td><?php echo htmlspecialchars($req['category']); ?></td>
            <td class="status-<?php echo $req['status']; ?>">
                <?php echo strtoupper($req['status']); ?>
            </td>
            <td><?php echo $req['request_date']; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>