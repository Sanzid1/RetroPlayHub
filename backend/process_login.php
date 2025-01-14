<?php
// backend/process_login.php
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 1); // Use HTTPS
     // backend/process_login.php
     session_start();
     include 'config/database.php';
     
     if($_SERVER["REQUEST_METHOD"] == "POST"){
         // Get input values
         $email = mysqli_real_escape_string($link, $_POST['email']);
         $password = mysqli_real_escape_string($link, $_POST['password']);
     
         // Validate credentials
         $sql = "SELECT user_id, username, password_hash FROM users WHERE email = '$email'";
         $result = mysqli_query($link, $sql);
     
         if(mysqli_num_rows($result) == 1){
             $row = mysqli_fetch_assoc($result);
             if(password_verify($password, $row['password_hash'])){
                session_regenerate_id(true);
                 // Password is correct, start a session
                 $_SESSION['user_id'] = $row['user_id'];
                 $_SESSION['username'] = $row['username'];
                 header("location: ../index.html"); // Redirect to Landing Page or Dashboard
                 
                 exit();
             } else{
                 // Password is incorrect
                 $_SESSION['error'] = "Invalid password.";
                 header("location: login.php");
                 exit();
             }
         } else{
             // Email not found
             $_SESSION['error'] = "No account found with that email.";
             header("location: login.php");
             exit();
         }
     }
     ?>
     