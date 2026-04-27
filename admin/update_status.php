<?php
session_start();
require_once '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['admin_id'])) {
    $id = $_POST['request_id'];
    $status = $_POST['new_status'];

    // Status update karne ki query
    $sql = "UPDATE book_requests SET status = :status WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['status' => $status, 'id' => $id]);

    header("Location: dashboard.php?msg=Status Updated");
}
?>