<?php
session_start(); // Start the session

// Unset the session variable 'username'
unset($_SESSION['username']);

// Destroy the entire session
session_destroy();

// Redirect the user to the login page (e.g., index.php)
header("Location: ../index.php"); // Replace with your actual login page URL
exit;
