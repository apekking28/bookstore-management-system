# Bookstore Management System

A simple Laravel web application for managing bookstore inventory with book ratings and author popularity tracking.

## 📋 Requirements

- **PHP**: ^8.1
- **Laravel**: ^11.0
- **MySQL**: ^8.0
- **Composer**: Latest version

## 🚀 Installation

### 1. Clone Repository
```bash
git clone https://github.com/apekking28/bookstore-management-system.git
cd bookstore-app
```

### 2. Install Dependencies
```bash
composer install
```

### 3. Environment Setup
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Database Configuration
Edit `.env` file with your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bookstore_db
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 5. Create Database
```sql
-- Login to MySQL and create database
CREATE DATABASE bookstore_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 6. Run Migrations
```bash
php artisan migrate
```

### 7. Seed Sample Data
```bash
# This will create:
# - 1,000 authors
# - 3,000 categories  
# - 100,000 books
# - 500,000 ratings
php artisan db:seed
```

### 8. Start Application
```bash
php artisan serve
```

## 🌐 Access Application

Open your browser and visit:
- **Home/Books List**: http://localhost:8000
- **Famous Authors**: http://localhost:8000/authors/famous
- **Insert Rating**: http://localhost:8000/ratings/create

## ✨ Features

### 📚 Books List Page
- View books ordered by highest average rating
- Filter by number of books shown (10, 20, 30...100)
- Search by book title or author name
- Pagination for easy browsing

### 🏆 Top 10 Famous Authors
- Shows authors ranked by total votes (only ratings > 5)
- Displays author name and voter count

### ⭐ Insert Rating Form
- Select author from dropdown
- Select book from filtered list based on chosen author
- Give rating from 1-10
- Automatically redirects to books list after submission

## 📁 Project Structure

```
bookstore-app/
├── app/
│   ├── Http/Controllers/
│   │   ├── AuthorController.php     # Famous authors
│   │   ├── BookController.php       # Books list & search
│   │   └── RatingController.php     # Rating form
│   └── Models/
│       ├── Author.php
│       ├── Book.php
│       ├── Category.php
│       └── Rating.php
├── database/
│   ├── factories/                   # Fake data generators
│   ├── migrations/                  # Database schema
│   └── seeders/                     # Sample data creation
├── resources/views/
│   ├── layouts/app.blade.php        # Main template
│   ├── books/index.blade.php        # Books list
│   ├── authors/famous.blade.php     # Famous authors
│   └── ratings/create.blade.php     # Rating form
└── routes/web.php                   # Application routes
```

## 🔗 Routes

| URL | Page | Description |
|-----|------|-------------|
| `/` | Books List | Home page showing books with ratings |
| `/authors/famous` | Famous Authors | Top 10 authors by popularity |
| `/ratings/create` | Insert Rating | Form to submit book ratings |

## 📊 Sample Data

After running `php artisan db:seed`, the application will have:

- **1,000 Authors**: Fake author names
- **3,000 Categories**: Various book categories  
- **100,000 Books**: Books with random titles, assigned to authors and categories
- **500,000 Ratings**: Random ratings (1-10) for books

## 🔧 Database Reset

If you need to reset the database:
```bash
php artisan migrate:fresh --seed
```