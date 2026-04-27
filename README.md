# Book Request Management System

A web-based system to manage book requests using PHP, MySQL, and Google Books API.

## Features
- **User Side:** Registration, Login, and Requesting books based on categories (AI, Web, Mobile).
- **Admin Side:** View user requests and update their status (Pending, In-Progress, Completed).
- **Super Admin:** Create and manage other staff/admin accounts.
- **API Integration:** Fetches real-time book data from Google Books API with a daily limit of 5 calls per user.

## Tech Stack
- Frontend: HTML5, CSS3, JavaScript (AJAX/Fetch API)
- Backend: PHP (PDO for Database security)
- Database: MySQL
- External API: Google Books API

## Setup Instructions
1. Clone this repository into your XAMPP `htdocs` folder.
2. Import the `book_request_db.sql` file into your local phpMyAdmin.
3. Update `config/db.php` with your database credentials.
4. Access the system via `localhost/faran_rollnumber/user/login.php`.
