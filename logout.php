<?php
session_start();

// Destroy the session to log out the user
session_unset(); // Unset all session variables
session_destroy(); // Destroy the session

// Redirect to the login page with a logout message
header("Location: login.php?message=You have been logged out successfully.");
exit;
?>