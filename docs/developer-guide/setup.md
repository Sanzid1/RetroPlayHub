# Developer Guide - Setup Instructions

## Prerequisites

- **XAMPP:** Installed and configured on Windows 11.
- **GitHub Desktop:** Installed for version control.
- **Visual Studio Code:** Installed for code editing.
- **Web Browser:** Modern browser like Chrome, Firefox, or Edge.

## Project Directory Structure

The project is organized as follows:

```
RetroPlayHub/
│
├── assets/
│   ├── css/
│   ├── js/
│   └── images/
│
├── components/
│   ├── tic-tac-toe/
│   ├── connect-the-dots/
│   └── hangman/
│
├── backend/
│   ├── config/
│   ├── controllers/
│   ├── models/
│   ├── views/
│   └── index.php
│
├── docs/
│   ├── user-guide/
│   ├── developer-guide/
│   └── progress-reports/
│
├── htdocs/
│   └── (XAMPP's root directory files)
│
├── .gitignore
├── README.md
└── LICENSE
```

## Setting Up the Local Development Environment

1. **Start XAMPP:**
   - Open **XAMPP Control Panel**.
   - Start the **Apache** and **MySQL** modules.

2. **Clone the Repository:**
   - Open **GitHub Desktop**.
   - Clone the `RetroPlayHub` repository to your local machine if not already done.

3. **Configure the Database:**
   - Open **phpMyAdmin** by navigating to `http://localhost/phpmyadmin/`.
   - Create a new database named `retroplyhub_db`.
   - Update the database configuration in `backend/config/database.php` if necessary.

4. **Test the Setup:**
   - Navigate to `http://localhost/RetroPlayHub/backend/index.php` in your browser.
   - You should see **"Connection successful!"**

## Additional Configuration

- **.gitignore:** Ensures that unnecessary files are excluded from version control.
- **README.md & LICENSE:** Provides project information and licensing details.

## Troubleshooting

- **Database Connection Issues:**
  - Ensure MySQL is running in XAMPP.
  - Verify database credentials in `backend/config/database.php`.
  
- **Server Not Responding:**
  - Check if Apache is running in XAMPP.
  - Ensure no other services are using the same ports (default is 80 for HTTP).

---
**Description:**
Step-by-step instructions to set up the TicTacToe game within the RetroPlayHub project, including environment setup, database configuration, and running the application locally.

**Content:**

```markdown
# Setup Guide

## Introduction

This guide provides detailed instructions to set up the TicTacToe game within the RetroPlayHub project on your local machine. Follow the steps below to ensure a smooth installation and configuration process.

## Prerequisites

- **XAMPP Installed:** Ensure that XAMPP is installed on your system. XAMPP provides the necessary Apache server and MySQL database.
- **Web Browser:** A modern web browser (e.g., Chrome, Firefox) for accessing the application.
- **Text Editor/IDE:** For editing and managing project files (e.g., VS Code, Sublime Text).

## Step 1: Clone the Repository

1. **Download the Project Files:**
   - If using Git, clone the repository:
     ```bash
     git clone https://github.com/yourusername/RetroPlayHub.git
     ```
   - Alternatively, download the ZIP archive and extract it to your `htdocs` directory.

2. **Directory Placement:**
   - Ensure the project resides in the `C:\xampp\htdocs\RetroPlayHub\` directory.

## Step 2: Start XAMPP Services

1. **Open XAMPP Control Panel:**
   - Launch the XAMPP Control Panel application.

2. **Start Apache and MySQL:**
   - Click the **Start** buttons next to **Apache** and **MySQL** modules.
   - Ensure both services are running without errors.

## Step 3: Configure the Database

1. **Access phpMyAdmin:**
   - Open your web browser and navigate to `http://localhost/phpmyadmin/`.

2. **Create the Database:**
   - Click on **"New"** in the left sidebar.
   - Enter `retroplyhub_db` as the database name and click **"Create"**.

3. **Import Database Schema:**
   - Select the newly created `retroplyhub_db` database.
   - Go to the **"Import"** tab.
   - Choose the SQL file containing the table schemas or manually create the tables as outlined in the [Database Schema](../architecture.md#3-database-schema) section.

## Step 4: Configure Database Credentials

1. **Open `database.php`:**
   - Navigate to `C:\xampp\htdocs\RetroPlayHub\backend\config\database.php`.

2. **Update Credentials:**
   - Modify the following variables with your MySQL credentials:
     ```php
     $db_host = 'localhost';
     $db_user = 'root'; // Your MySQL username
     $db_pass = '';     // Your MySQL password
     $db_name = 'retroplyhub_db'; // Your database name
     ```

3. **Save Changes:**
   - Ensure the file is saved without a closing `?>` tag to prevent accidental whitespace.

## Step 5: Access the Application

1. **Open Web Browser:**
   - Navigate to `http://localhost/RetroPlayHub/components/tic-tac-toe/index.html`.

2. **Register a New User:**
   - If you haven't registered yet, go to `http://localhost/RetroPlayHub/backend/register.php`.
   - Fill in the registration form and submit.

3. **Log In:**
   - After registration, navigate to `http://localhost/RetroPlayHub/backend/login.php`.
   - Enter your credentials to log in.

4. **Play TicTacToe:**
   - Upon successful login, you should be redirected to the TicTacToe game interface.
   - Select a difficulty level and start playing!

## Troubleshooting

- **Apache/MySQL Not Starting:**
  - Ensure no other applications are using ports `80` or `443` for Apache and `3306` for MySQL.
  - Change the listening ports in XAMPP if necessary.

- **Database Connection Errors:**
  - Verify that the database credentials in `database.php` are correct.
  - Ensure that the `retroplyhub_db` database exists and contains the required tables.

- **Page Not Found (404 Error):**
  - Confirm that the project files are correctly placed within the `htdocs` directory.
  - Check the URL for any typos.

## Conclusion

Following this setup guide will enable you to run the TicTacToe game within the RetroPlayHub project on your local machine. For any further assistance, refer to the [Troubleshooting](#troubleshooting) section or consult the additional resources provided in the [Developer Guide](../architecture.md#9-additional-resources).

---