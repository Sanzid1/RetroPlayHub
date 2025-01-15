<?php
     // backend/config/database.php

     // Database credentials
     $db_host = 'localhost';
     $db_user = 'root'; // Replace with your DB username
     $db_pass = '';     // Replace with your DB password
     $db_name = 'retroplyhub_db'; // Replace with your DB name

     // Create connection
     $link = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

     // Check connection
     if (!$link) {
         die("Connection failed: " . mysqli_connect_error());
     }
     // Enable error reporting for debugging (development only)
   ini_set('display_errors', 1);
   ini_set('display_startup_errors', 1);
   error_reporting(E_ALL);

   // Session timeout duration (e.g., 30 minutes)
   $session_timeout = 1800; // 1800 seconds = 30 minutes

   // Check if session is set
   if(isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $session_timeout)){
       // Last request was more than 30 minutes ago
       session_unset();     // Unset $_SESSION variable
       session_destroy();   // Destroy session data
       header("location: ../index.html?message=Session expired. Please log in again.");
       exit();
   }

   $_SESSION['last_activity'] = time(); // Update last activity time

   // Database credentials
   $db_host = 'localhost';
   $db_user = 'root'; // Replace with your DB username
   $db_pass = '';     // Replace with your DB password
   $db_name = 'retroplyhub_db'; // Replace with your DB name

   // Create connection
   $link = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

   // Check connection
   if (!$link) {
       die("Connection failed: " . mysqli_connect_error());
   }
     ?>