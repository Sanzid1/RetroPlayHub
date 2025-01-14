<?php
     // backend/process_register.php
     session_start();
     include 'config/database.php';
     
     if($_SERVER["REQUEST_METHOD"] == "POST"){
         // Get input values
         $username = mysqli_real_escape_string($link, $_POST['username']);
         $email = mysqli_real_escape_string($link, $_POST['email']);
         $password = mysqli_real_escape_string($link, $_POST['password']);
     
         // Check if email or username already exists
         $check_sql = "SELECT * FROM users WHERE email = '$email' OR username = '$username'";
         $check_result = mysqli_query($link, $check_sql);
     
         if(mysqli_num_rows($check_result) > 0){
             $_SESSION['error'] = "Username or Email already exists.";
             header("location: register.php");
             exit();
         } else{
             // Hash the password
             $password_hash = password_hash($password, PASSWORD_BCRYPT);
     
             // Insert into users table
             $insert_sql = "INSERT INTO users (username, email, password_hash) VALUES ('$username', '$email', '$password_hash')";
             if(mysqli_query($link, $insert_sql)){
                 $_SESSION['success'] = "Registration successful. You can now log in.";
                 header("location: register.php");
                 exit();
             } else{
                 $_SESSION['error'] = "Something went wrong. Please try again.";
                 header("location: register.php");
                 exit();
             }
         }
     }
     ?>