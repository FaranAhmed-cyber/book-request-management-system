<?php
session_start();

// Check karna ke kya session mein user_id mojud hai
function checkLogin() {
    if (!isset($_SESSION['user_id'])) {
        // Agar login nahi hai to wapas login page par bhej do
        header("Location: login.php");
        exit();
    }
}
?>