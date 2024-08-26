# Blog Application

This is a Laravel-based blog application with user authentication, CRUD operations for posts and comments, email notifications, and RESTful API endpoints.

## Features

- User Registration and Authentication
- CRUD Operations for Blog Posts
- Commenting on Posts
- Email Notifications for New Comments
- RESTful API Endpoints with Laravel Sanctum
- API Endpoints documention using Swagger
- Testing with PHPUnit

## Tools and Technologies

- **PHP**: 8.x
- **Laravel**: 11.x
- **Database**: SQLite (for testing), MySQL (for production)
- **Mail Service**: Mailgun, SendGrid, or similar
- **Version Control**: Git

## Installation

1. **Clone the Repository**
   ```bash
   git clone https://github.com/mahereldesoky/BlogTask.git

2. **Install Dependencies**
composer install
npm install


3. **Set Up Environment**
Copy the .env.example file to .env and configure it:

4. **Run Migrations**
php artisan migrate

5. **Generate Application Key**
php artisan key:generate


6. **Start the Application**
php artisan serve
npm run dev


