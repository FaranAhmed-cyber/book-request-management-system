<?php
// PHP ko batana ke errors dikhaye ya nahi (Assignment requirement)
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
ini_set('display_errors', 0); // User ko errors na dikhao
ini_set('log_errors', 1);     // Errors ko log file mein save karo

$host = 'localhost';
$db   = 'book_request_db';
$user = 'root'; 
$pass = ''; 

try {
    // PDO connection banaya ja raha hai
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    // Agar koi galti ho to exception throw kare
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Connection kamyab!
} catch (PDOException $e) {
    // Agar masla ho to message dikhao
    die("Database connection fail ho gaya: " . $e->getMessage());
}
?>