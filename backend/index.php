<?php
     include 'config/database.php';

     if ($link) {
         echo "Connection successful!";
     } else {
         echo "Connection failed.";
     }
     ?>