<?php
     // backend/logout.php
     session_start();
     
     // Unset all session variables
     $_SESSION = array();
     
     // Destroy the session.
     session_destroy();
     
     // Redirect to Landing Page
     header("location: ../index.html");
     exit();
     ?>