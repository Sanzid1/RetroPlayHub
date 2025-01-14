<?php
     // backend/login.php
     session_start();
     include 'config/database.php';
     ?>
     <!DOCTYPE html>
     <html lang="en">
     <head>
         <meta charset="UTF-8">
         <meta http-equiv="X-UA-Compatible" content="IE=edge">
         <meta name="viewport" content="width=device-width, initial-scale=1.0">
         <title>Login - RetroPlay Hub</title>
         <!-- Bootstrap CSS -->
         <link href="assets/css/bootstrap.min.css" rel="stylesheet">
         <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
         <!-- Custom CSS -->
         <link rel="stylesheet" href="../assets/css/styles.css">
     </head>
     <body>
     
         <!-- Navbar -->
         <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
             <div class="container-fluid">
                 <a class="navbar-brand" href="../index.html">RetroPlay Hub</a>
                 <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                     aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                     <span class="navbar-toggler-icon"></span>
                 </button>
                 <div class="collapse navbar-collapse" id="navbarNav">
                     <ul class="navbar-nav ms-auto">
                         <li class="nav-item">
                             <a class="nav-link active" aria-current="page" href="login.php">Login</a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link" href="register.php">Register</a>
                         </li>
                     </ul>
                 </div>
             </div>
         </nav>
     
         <!-- Main Content -->
         <div class="container mt-5">
             <h2 class="text-center mb-4">Login to RetroPlay Hub</h2>
             <div class="row justify-content-center">
                 <div class="col-md-6">
                     <?php
                     // Display error messages
                     if(isset($_SESSION['error'])){
                         echo '<div class="alert alert-danger">'.$_SESSION['error'].'</div>';
                         unset($_SESSION['error']);
                     }
                     ?>
                     <form action="process_login.php" method="POST">
                         <div class="mb-3">
                             <label for="email" class="form-label">Email address</label>
                             <input type="email" class="form-control" id="email" name="email" required>
                         </div>
                         <div class="mb-3">
                             <label for="password" class="form-label">Password</label>
                             <input type="password" class="form-control" id="password" name="password" required>
                         </div>
                         <button type="submit" class="btn btn-primary w-100">Login</button>
                     </form>
                 </div>
             </div>
         </div>
     
         <!-- Footer -->
         <footer class="bg-dark text-white text-center py-3 mt-5">
             &copy; 2025 RetroPlay Hub. All rights reserved.
         </footer>
     
         <!-- Bootstrap JS -->
         <script src="assets/js/bootstrap.bundle.min.js"></script>
         <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
         <!-- Custom JS -->
         <script src="../assets/js/scripts.js"></script>
     </body>
     </html>