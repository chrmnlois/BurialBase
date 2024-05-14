<?php
// Start the session
session_start();

// Unset all session variables
$_SESSION = [];

// Destroy the session
session_unset();
session_destroy();

// Optional: Redirect the user to a specific page after logout
header("Location: index.php");
exit; // Ensure script execution stops here
?>