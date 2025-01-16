Srs Retro
### **RetroPlay Hub - Comprehensive Software Requirements Specification (SRS)**

---

## **1. Introduction**

### **1.1. Purpose**

**RetroPlay Hub** is a web application designed to host and allow users to play three classic PC games: TicTacToe, Connect the Dots, and Hangman.  The application aims to evoke nostalgia while providing an engaging and interactive gaming experience across various platforms.

### **1.2. Scope**

RetroPlay Hub will support all major platforms, including desktops, tablets, and mobile devices, ensuring broad accessibility and interactivity. While the initial focus is on three games, the architecture will be designed to accommodate potential future additions, even though there are no immediate plans for such features.

### **1.3. Definitions, Acronyms, and Abbreviations**

- **SRS**: Software Requirements Specification
- **AI**: Artificial Intelligence
- **MVC**: Model-View-Controller
- **AJAX**: Asynchronous JavaScript and XML
- **OAuth**: Open Authorization
- **SQL Injection**: A code injection technique that might destroy your database
- **XSS**: Cross-Site Scripting

### **1.4. References**

- [Bootstrap Documentation](https://getbootstrap.com/docs/5.3/getting-started/introduction/)
- [PHP Official Documentation](https://www.php.net/docs.php)
- [MySQL Official Documentation](https://dev.mysql.com/doc/)
- [GitHub Issues Guide](https://guides.github.com/features/issues/)

---

## **2. Overall Description**

### **2.1. Product Perspective**

RetroPlay Hub is a standalone web application built using HTML, CSS, JavaScript (with Bootstrap 5.3.3), PHP for the backend, and MySQL for the database. It will be hosted locally initially using XAMPP and later can be deployed to a public server if desired.

### **2.2. Product Functions**

- **User Management:**
  - **Registration & Login:** Users can register and log in using email/password. Social media integrations with Google and Facebook via OAuth will be implemented.
  - **Password Recovery:** Users can recover their passwords if forgotten.
  
- **Games:**
  - **TicTacToe:**
    - Single-player mode with three difficulty levels of AI.
    - Two-player mode on the same device.
    - Result history displayed on a dedicated history page.
  
  - **Connect the Dots:**
    - Single-player mode with three difficulty levels of AI.
    - Two-player mode on the same device.
    - Result history displayed on a dedicated history page.
  
  - **Hangman:**
    - Three categories: Countries, Animals, and Colours.
    - Three difficulty levels within each category.
    - Leaderboard showcasing top scores in real-time.
  
- **Leaderboard & High Scores:**
  - **Hangman Leaderboard:** Updates in real-time as new scores are submitted.
  - **User High Scores:** Track number of wins, average score, and number of games played for each game.
  
- **Reset Functionality:**
  - Users can reset their own data with a confirmation prompt to prevent accidental data loss.
  
- **Feedback Mechanisms:**
  - Visual and textual feedback displaying game results, errors, and confirmations.

- **Error Logging & Handling:**
  - Comprehensive error logging system to monitor and handle application errors.

### **2.3. User Characteristics**

- **Target Audience:** Everyone, with a focus on users seeking nostalgic gaming experiences.
- **User Roles:**
  - **Player:** Can register, log in, play games, view high scores and history.
  - **Admin:** Not implemented in this version.

### **2.4. Constraints**

- **Technology Constraints:**
  - Limited to using HTML, CSS, JavaScript, Bootstrap, PHP, and MySQL.
  
- **Resource Constraints:**
  - Development is to be completed within one to two days with 3-4 hours of daily commitment.
  
- **Time Constraints:**
  - Rapid development cycle with immediate code provision from the assistant.

### **2.5. Assumptions and Dependencies**

- Users primarily access the application from desktops.
- The application will function locally initially; public deployment considerations will be addressed later.
- Basic security measures are sufficient for a local environment, with plans to enhance post-development.

---

## **3. Specific Requirements**

### **3.1. Functional Requirements**

#### **3.1.1. User Registration & Login**

- **Registration:**
  - Users can register using an email and password.
  - Social media login options via Google and Facebook using OAuth.
  
- **Login:**
  - Registered users can log in using their credentials or social media accounts.
  
- **Password Recovery:**
  - Users can recover their passwords through a recovery option.

#### **3.1.2. Games**

- **TicTacToe & Connect the Dots:**
  - **Single-Player Mode:**
    - Three difficulty levels of AI (Easy, Medium, Hard) with sophisticated algorithms.
  - **Two-Player Mode:**
    - Players take turns on the same device.
  - **Result History:**
    - Dedicated history page displaying the number of wins, average score, and number of games played.
  
- **Hangman:**
  - **Categories:**
    - Countries, Animals, and Colours.
  - **Difficulty Levels:**
    - Easy, Medium, Hard within each category.
  - **Leaderboard:**
    - Real-time updates showcasing top scores.

#### **3.1.3. Leaderboard & High Scores**

- **Hangman Leaderboard:**
  - Rankings based on a scoring algorithm that considers the number of letters and difficulty levels.
  
- **User High Scores:**
  - Track number of wins, average score, and number of games played.
  - Visible to all users.

#### **3.1.4. Reset Functionality**

- Users can reset their own data, which includes clearing high scores and game histories.
- A confirmation prompt is required before performing a reset to prevent accidental data loss.

#### **3.1.5. Feedback Mechanisms**

- **Visual Feedback:**
  - Animations and color changes during gameplay.
  
- **Textual Feedback:**
  - Notifications displaying game results, errors, and confirmations.

#### **3.1.6. Error Logging & Handling**

- Implement an error logging system to track and monitor application errors.
- User-friendly error messages should be displayed in case of downtimes or server issues.

### **3.2. Non-Functional Requirements**

#### **3.2.1. Performance**

- The application should load quickly and remain responsive across all supported platforms.
- Optimize assets and code to ensure minimal load times.

#### **3.2.2. Usability**

- Design should emulate the original games to evoke nostalgia.
- Ensure color schemes meet accessibility standards for color blindness and other visual impairments.
- Provide intuitive navigation with a responsive design that adapts to different device sizes, including collapsing into a hamburger menu on mobile devices.
- Persistent navbar and login/register buttons for unregistered users.

#### **3.2.3. Reliability**

- Implement comprehensive error logging.
- Handle unexpected downtimes gracefully with appropriate user notifications.
- Ensure high uptime, with plans to improve based on future deployment needs.

#### **3.2.4. Security**

- **Data Encryption:**
  - Encrypt sensitive data such as user passwords using hashing algorithms (e.g., bcrypt).
  
- **Session Management:**
  - Secure user sessions to prevent unauthorized access, possibly using secure cookies and session tokens.
  
- **Input Validation:**
  - Validate and sanitize all user inputs to prevent SQL injection, XSS attacks, and other security vulnerabilities.

### **3.3. Technical Requirements**

#### **3.3.1. Frontend**

- **Technologies:**
  - HTML, CSS, JavaScript, and Bootstrap 5.3.3.
  
- **Communication Method:**
  - Use AJAX for asynchronous data exchange between frontend and backend, suitable for real-time leaderboard updates and game interactions.
  
- **Frameworks/Libraries:**
  - No additional JavaScript frameworks or libraries beyond Bootstrap.

#### **3.3.2. Backend**

- **Technologies:**
  - Plain PHP for server-side logic.
  
- **Architecture:**
  - Follow the MVC (Model-View-Controller) pattern for maintainability and scalability.
  
- **Directory Structure:**
  - Organized into separate folders for assets (CSS, JS, images), components (game modules), and backend scripts.

#### **3.3.3. Database**

- **Technology:**
  - MySQL for data storage.
  
- **Data Storage:**
  - **Users Table:**
    - `user_id` (Primary Key)
    - `username`
    - `email`
    - `password_hash`
    - `registration_date`
  
  - **Scores Table:**
    - `score_id` (Primary Key)
    - `user_id` (Foreign Key)
    - `game_type`
    - `score`
    - `date`
  
  - **Leaderboards Table:**
    - `leaderboard_id` (Primary Key)
    - `game_type`
    - `user_id` (Foreign Key)
    - `score`
    - `rank`
  
  - **GameHistory Table:**
    - `history_id` (Primary Key)
    - `user_id` (Foreign Key)
    - `game_type`
    - `result`
    - `date`
  
- **Normalization:**
  - Ensure the database is normalized to at least the third normal form (3NF) to reduce redundancy and improve data integrity.
  
- **Migrations and Backups:**
  - Use SQL scripts for database migrations.
  - Implement regular backups manually initially, with guidance provided for future automation.

#### **3.3.4. Development Tools**

- **IDE:**
  - Visual Studio Code for code editing.
  
- **Version Control:**
  - GitHub Desktop for managing Git repositories.
  
- **Bug Tracking:**
  - GitHub Issues for tracking and managing bugs.

### **3.4. User Interface & Experience**

#### **3.4.1. Design**

- **Mockups:**
  - No specific mockups; design will emulate original games with a sleek, simple, and soothing color scheme.
  
- **Color Schemes:**
  - Soothing colors with high contrast to meet accessibility standards.
  
- **Accessibility:**
  - Implement basic accessibility features like keyboard navigation and screen reader compatibility.

#### **3.4.2. Navigation**

- **Landing Page:**
  - Users land on the main page with options to play any of the three games.
  - Persistent navbar with login/register buttons for unregistered users.
  
- **Responsive Design:**
  - Navigation adapts to different device sizes, collapsing into a hamburger menu on smaller screens.
  
- **Persistent Elements:**
  - Navbar remains visible as users navigate through different sections.

#### **3.4.3. Feedback**

- **Visual Feedback:**
  - Animations and color changes during gameplay.
  
- **Textual Feedback:**
  - Notifications displaying game results, errors, and confirmations.
  
- **Audio Feedback:**
  - Not implemented in this version but planned for future updates.

### **3.5. Testing & Quality Assurance**

#### **3.5.1. Testing Strategies**

- **Manual Testing:**
  - Perform manual testing to identify and fix bugs.
  
- **Automated Testing:**
  - Incorporate automated testing for repetitive tasks and critical functionalities as needed.

#### **3.5.2. Bug Tracking**

- **Tool:**
  - Use GitHub Issues for organizing and prioritizing bug fixes.
  
- **Process:**
  - Report bugs with detailed descriptions, steps to reproduce, and screenshots if necessary.
  - Assign priorities and track progress within GitHub Issues.

#### **3.5.3. Quality Metrics**

- **Performance Metrics:**
  - Page load times and response times.
  
- **Usability Metrics:**
  - User satisfaction ratings and task completion rates.
  
- **Reliability Metrics:**
  - Number of bugs reported and uptime percentage.

### **3.6. Deployment & Maintenance**

#### **3.6.1. Deployment**

- **Initial Deployment:**
  - Deploy the web app locally using XAMPP within the `htdocs` directory.
  
- **Environment Configuration:**
  - Configure PHP settings and MySQL configurations via phpMyAdmin.

- **Future Deployment:**
  - Plans for public deployment on hosting platforms like AWS, Heroku, or DigitalOcean will be considered later.

#### **3.6.2. Maintenance**

- **Update Management:**
  - Manage and deploy updates based on future deployment strategies.
  
- **Monitoring Tools:**
  - Implement monitoring tools post-deployment to track performance and health.

### **3.7. Documentation & Reporting**

#### **3.7.1. Documentation Structure**

- **Types of Documentation:**
  - **User Documentation:** Guides on using the web app, playing the games, managing accounts.
  - **Developer Documentation:** Code structure explanations, API documentation, setup instructions, contribution guidelines.
  
- **Documentation Tools:**
  - Use Markdown files in GitHub for all documentation needs.

- **Folder Structure:**
  ```
  /docs
    /user-guide
      README.md
      game-instructions.md
    /developer-guide
      setup.md
      architecture.md
      api-documentation.md
    /progress-reports
      report-01.md
      report-02.md
      ...
  ```

#### **3.7.2. Progress Reports**

- **Frequency:**
  - Generate progress reports after completing each feature.
  
- **Content:**
  - Include code snippets, screenshots, challenges faced, solutions implemented, and other relevant details.

### **3.8. Constraints & Assumptions**

#### **3.8.1. Constraints**

- **Technology Limitations:**
  - Limited to HTML, CSS, JavaScript, Bootstrap, PHP, and MySQL.
  
- **Time Constraints:**
  - Development aimed to be completed within one to two days with 3-4 hours of daily commitment.

#### **3.8.2. Assumptions**

- **User Behavior:**
  - Users seek nostalgic gaming experiences and primarily access the app from desktops.
  
- **Technology Use:**
  - Users have basic internet connectivity and access to modern web browsers.
  
- **Device Preferences:**
  - Majority of users will access the app from desktops, with support for other devices.

---

## **4. Additional Considerations**

### **4.1. Accessibility**

Implement basic accessibility features such as keyboard navigation and screen reader compatibility to make the app more inclusive.

### **4.2. Localization**

Plan to support multiple languages in future updates to cater to a diverse user base.

### **4.3. Analytics**

Consider integrating analytics tools like Google Analytics post-project completion to monitor user behavior and engagement.

### **4.4. Scalability**

Design the application architecture to handle increased traffic and additional features seamlessly in the future.

---

## **5. Next Steps**

With the comprehensive SRS in place, the following steps will guide the development process:

1. **Project Setup:**
   - **Directory Structure:**
     - Create separate folders for assets (`css`, `js`, `images`), components (game modules), backend scripts (`php`), and documentation (`docs`).
   - **Initialize Git Repository:**
     - Set up GitHub repository and configure GitHub Desktop for version control.
   
2. **Database Design:**
   - **Create MySQL Database:**
     - Define tables (`users`, `scores`, `leaderboards`, `game_history`) with appropriate relationships and normalization.
   - **Implement Migration Scripts:**
     - Write SQL scripts to create and manage database schema changes.
   - **Set Up Backup Strategy:**
     - Establish manual backup procedures initially, with guidance provided for future automation.

3. **Frontend Development:**
   - **Design Landing Page:**
     - Create a responsive landing page with options to play each game.
   - **Implement Navigation:**
     - Develop a persistent navbar with login/register buttons for unregistered users.
   - **Develop Game Interfaces:**
     - Build the user interfaces for TicTacToe, Connect the Dots, and Hangman, ensuring they are interactive and accessible.

4. **Backend Development:**
   - **User Authentication:**
     - Implement registration, login, and password recovery functionalities using PHP and MySQL.
     - Integrate OAuth for Google and Facebook logins.
   - **Game Logic:**
     - Develop game algorithms, including AI for single-player modes with three difficulty levels.
   - **Leaderboard & High Scores:**
     - Create real-time updating leaderboards and user high score tracking.

5. **Testing & Quality Assurance:**
   - **Manual Testing:**
     - Conduct thorough manual testing of all features and functionalities.
   - **Automated Testing:**
     - Implement automated tests for critical functionalities as needed.
   - **Bug Tracking:**
     - Use GitHub Issues to log and manage bugs.

6. **Documentation:**
   - **User Documentation:**
     - Write guides on using the web app and playing the games.
   - **Developer Documentation:**
     - Document code structure, API endpoints, setup instructions, and contribution guidelines.
   - **Progress Reports:**
     - Generate detailed progress reports after completing each feature.

7. **Deployment:**
   - **Local Deployment:**
     - Deploy the application locally using XAMPP within the `htdocs` directory.
   - **Future Deployment:**
     - Plan for public deployment on hosting platforms if desired.

8. **Maintenance:**
   - **Update Management:**
     - Establish procedures for updating the application post-deployment.
   - **Monitoring:**
     - Implement monitoring tools to track performance and health.

---

## **6. Appendices**

### **6.1. Glossary**

- **OAuth:** An open standard for access delegation, commonly used for token-based authentication.
- **AJAX:** A set of web development techniques using many web technologies on the client side to create asynchronous web applications.
- **MVC:** A software architectural pattern for implementing user interfaces, dividing the related program logic into three interconnected elements.

### **6.2. Revision History**

| Version | Date       | Description                  |
|---------|------------|------------------------------|
| 1.0     | 2025-01-14 | Initial SRS creation         |
| 1.1     | 2025-01-15 | Updated with user-provided details |

---

## **7. Approval**

*This section is to be filled out once the SRS is reviewed and approved by all stakeholders.*

---

### **Conclusion**

The above Software Requirements Specification (SRS) for **RetroPlay Hub** outlines the comprehensive requirements and specifications necessary for the successful development and deployment of the web application. By adhering to this SRS, the project aims to deliver a high-quality, nostalgic, and engaging gaming platform that meets user expectations and maintains scalability for future enhancements.

---