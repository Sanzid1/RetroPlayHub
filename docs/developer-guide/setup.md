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
