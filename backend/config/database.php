<?php
// backend/config/database.php

// Disable error display for production
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

// Database credentials
$db_host = 'localhost';
$db_user = 'root'; // Replace with your DB username
$db_pass = '';     // Replace with your DB password
$db_name = 'retroplyhub_db'; // Ensure this matches your database name

// Create connection
$link = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// Check connection
if (!$link) {
    // Log the error instead of displaying
    error_log("Connection failed: " . mysqli_connect_error());
    die(json_encode(['status' => 'error', 'message' => 'Database connection failed']));
}
