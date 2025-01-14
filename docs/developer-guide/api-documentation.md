As you develop more backend functionalities, document your API endpoints here.

```markdown
# Developer Guide - API Documentation

This section outlines the API endpoints used in **RetroPlay Hub** for various functionalities such as user authentication, game interactions, and leaderboard management.

## **Authentication Endpoints**

### **1. User Registration**

- **Endpoint:** `/backend/process_register.php`
- **Method:** `POST`
- **Parameters:**
  - `username` (string) - Required
  - `email` (string) - Required
  - `password` (string) - Required
- **Description:** Registers a new user by creating an account with the provided username, email, and password.
- **Response:**
  - **Success:** Redirects to `register.php` with a success message.
  - **Failure:** Redirects to `register.php` with an error message.

### **2. User Login**

- **Endpoint:** `/backend/process_login.php`
- **Method:** `POST`
- **Parameters:**
  - `email` (string) - Required
  - `password` (string) - Required
- **Description:** Authenticates a user based on email and password.
- **Response:**
  - **Success:** Sets session variables and redirects to the Landing Page.
  - **Failure:** Redirects to `login.php` with an error message.

### **3. User Logout**

- **Endpoint:** `/backend/logout.php`
- **Method:** `GET`
- **Parameters:** None
- **Description:** Logs out the current user by destroying the session.
- **Response:** Redirects to the Landing Page.

## **Game Endpoints**

*To be developed as game functionalities are implemented.*

### **1. TicTacToe**

- **Endpoint:** `/backend/games/tic-tac-toe.php`
- **Method:** `POST`
- **Parameters:**
  - Game-specific parameters
- **Description:** Handles game logic, score recording, and result history.
- **Response:** JSON response with game results and updated scores.

### **2. Connect the Dots**

- **Endpoint:** `/backend/games/connect-the-dots.php`
- **Method:** `POST`
- **Parameters:**
  - Game-specific parameters
- **Description:** Manages game logic, score tracking, and history recording.
- **Response:** JSON response with game outcomes and updated scores.

### **3. Hangman**

- **Endpoint:** `/backend/games/hangman.php`
- **Method:** `POST`
- **Parameters:**
  - Game-specific parameters
- **Description:** Handles word selection, game state, score updates, and leaderboard management.
- **Response:** JSON response with game results and leaderboard updates.

## **Leaderboard Endpoints**

### **1. Fetch Leaderboard**

- **Endpoint:** `/backend/leaderboard_fetch.php`
- **Method:** `GET`
- **Parameters:** None
- **Description:** Retrieves the current Hangman leaderboard data.
- **Response:** JSON array of top scores with user details and ranks.

### **2. Update Leaderboard**

- **Endpoint:** `/backend/leaderboard_update.php`
- **Method:** `POST`
- **Parameters:**
  - `user_id` (int) - Required
  - `score` (int) - Required
- **Description:** Updates the leaderboard with a new score for a user.
- **Response:** JSON object confirming the update and new rank.

## **Utility Endpoints**

### **1. Reset User Data**

- **Endpoint:** `/backend/reset_data.php`
- **Method:** `POST`
- **Parameters:**
  - `user_id` (int) - Required
- **Description:** Resets the user's high scores and game histories.
- **Response:** JSON object confirming the reset.