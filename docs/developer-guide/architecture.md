# Developer Guide - Architecture Overview

## Database Design

RetroPlay Hub utilizes a relational database to manage user data, game scores, leaderboards, and game histories. The database is designed to ensure data integrity, reduce redundancy, and facilitate efficient data retrieval.

### **Database Schema**

### **1. Users Table**

Stores user information and credentials.

- **Table Name:** `users`
- **Columns:**
  - `user_id` (INT, Primary Key, Auto-Increment)
  - `username` (VARCHAR(50), Unique, Not Null)
  - `email` (VARCHAR(100), Unique, Not Null)
  - `password_hash` (VARCHAR(255), Not Null)
  - `registration_date` (DATETIME, Default Current Timestamp)

### **2. Scores Table**

Records individual game scores for each user.

- **Table Name:** `scores`
- **Columns:**
  - `score_id` (INT, Primary Key, Auto-Increment)
  - `user_id` (INT, Foreign Key references `users(user_id)`, Not Null)
  - `game_type` (ENUM('TicTacToe', 'ConnectTheDots', 'Hangman'), Not Null)
  - `score` (INT, Not Null)
  - `date` (DATETIME, Default Current Timestamp)

### **3. Leaderboards Table**

Maintains real-time leaderboards for the Hangman game.

- **Table Name:** `leaderboards`
- **Columns:**
  - `leaderboard_id` (INT, Primary Key, Auto-Increment)
  - `user_id` (INT, Foreign Key references `users(user_id)`, Not Null)
  - `score` (INT, Not Null)
  - `rank` (INT, Not Null, Default 0)
  - `date` (DATETIME, Default Current Timestamp)

### **4. GameHistory Table**

Keeps a history of game results for each user session.

- **Table Name:** `game_history`
- **Columns:**
  - `history_id` (INT, Primary Key, Auto-Increment)
  - `user_id` (INT, Foreign Key references `users(user_id)`, Not Null)
  - `game_type` (ENUM('TicTacToe', 'ConnectTheDots', 'Hangman'), Not Null)
  - `result` (ENUM('Win', 'Lose', 'Draw'), Not Null)
  - `date` (DATETIME, Default Current Timestamp)

### **Relationships**

- **One-to-Many:**
  - A single user can have multiple scores (`users.user_id` → `scores.user_id`).
  - A single user can appear multiple times in the leaderboards (`users.user_id` → `leaderboards.user_id`).
  - A single user can have multiple game history records (`users.user_id` → `game_history.user_id`).

### **Normalization**

The database is normalized to the **Third Normal Form (3NF)** to ensure:

- **Elimination of Redundant Data:** Each piece of information is stored only once.
- **Ensured Data Integrity:** Dependencies are properly enforced via foreign keys.
- **Efficient Data Retrieval:** Queries can be executed efficiently without unnecessary joins or data duplication.

## **Backend Structure**

The backend follows the **Model-View-Controller (MVC)** architectural pattern:

- **Models:** Represent the data structures (e.g., User, Score).
- **Views:** Handle the presentation layer (HTML/CSS/JS).
- **Controllers:** Manage the business logic and handle user requests.

### **Directory Structure**

```
RetroPlayHub/
│
├── backend/
│   ├── config/
│   │   └── database.php
│   ├── controllers/
│   │   └── (Controller files)
│   ├── models/
│   │   └── (Model files)
│   ├── views/
│   │   └── (View files)
│   └── index.php
```

### **Database Connection**

- **File:** `backend/config/database.php`
- **Purpose:** Establishes a connection to the MySQL database using PHP's `mysqli` extension.
- **Usage:** Included in controller files to interact with the database.

### **ORM Consideration**

While this project uses plain PHP for simplicity, consider using an Object-Relational Mapping (ORM) tool like **Eloquent** in future projects to streamline database interactions.
### **Frontend Structure**

The frontend of RetroPlay Hub is built using HTML, CSS, JavaScript, and Bootstrap 5.3.3. It follows a modular structure to separate concerns and enhance maintainability.

#### **Directory Structure**

```
RetroPlayHub/
│
├── assets/
│   ├── css/
│   │   └── styles.css
│   ├── js/
│   │   └── scripts.js
│   └── images/
│
├── components/
│   ├── tic-tac-toe/
│   │   ├── index.html
│   │   ├── tic-tac-toe.js
│   │   └── tic-tac-toe.css
│   ├── connect-the-dots/
│   │   ├── index.html
│   │   ├── connect-the-dots.js
│   │   └── connect-the-dots.css
│   └── hangman/
│       ├── index.html
│       ├── hangman.js
│       └── hangman.css
│
├── backend/
│   ├── config/
│   ├── controllers/
│   ├── models/
│   ├── views/
│   ├── login.php
│   ├── register.php
│   ├── process_login.php
│   └── process_register.php
│
├── docs/
│   ├── user-guide/
│   ├── developer-guide/
│   │   ├── setup.md
│   │   ├── architecture.md
│   │   └── api-documentation.md
│   └── progress-reports/
│
├── htdocs/
│
├── .gitignore
├── README.md
└── LICENSE
```

#### **Landing Page**

- **File:** `index.html`
- **Description:** Serves as the entry point for users, providing navigation to the three games and authentication pages.

#### **Authentication Pages**

- **Login Page:** `backend/login.php`
  - **Functionality:** Allows users to log in using email/password or social media (to be implemented).
  
- **Registration Page:** `backend/register.php`
  - **Functionality:** Enables new users to create an account with a username, email, and password.

#### **Components**

Each game has its own directory within `components/`, containing separate HTML, CSS, and JavaScript files to maintain modularity.

- **TicTacToe:** `components/tic-tac-toe/`
- **Connect the Dots:** `components/connect-the-dots/`
- **Hangman:** `components/hangman/`

#### **Assets**

- **CSS:** `assets/css/styles.css` contains custom styles overriding or extending Bootstrap's default styles.
- **JavaScript:** `assets/js/scripts.js` is reserved for custom JavaScript functionalities.

#### **Responsive Design**

Bootstrap's grid system and utility classes ensure that the application is responsive across various devices. The navbar collapses into a hamburger menu on smaller screens, and game buttons adjust their size based on the viewport.

#### **Accessibility**

- **Color Contrast:** Ensured that text and interactive elements have sufficient contrast.
- **Keyboard Navigation:** Forms and buttons are accessible via keyboard.
- **ARIA Attributes:** Can be added to enhance screen reader compatibility in future updates.

#### **Future Enhancements**

- **Social Media Integration:** Implement OAuth for Google and Facebook logins.
- **Dynamic Game Loading:** Load game components dynamically based on user interactions.
- **Real-Time Features:** Utilize AJAX for real-time leaderboard updates and other interactive functionalities.
```


## **Summary**

This architecture ensures a clean separation of concerns, making the application maintainable and scalable. The database design adheres to best practices, ensuring data integrity and efficient management of user and game data.