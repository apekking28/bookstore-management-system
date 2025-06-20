# Bookstore Management System

A Laravel-based web application for managing bookstore inventory with book ratings and author popularity tracking.

## 📋 Table of Contents

- [Project Overview](#-project-overview)
- [System Requirements](#-system-requirements)
- [Installation Guide](#-installation-guide)
- [Database Setup](#-database-setup)
- [Running the Application](#-running-the-application)
- [Features](#-features)
- [Project Structure](#-project-structure)
- [API Endpoints](#-api-endpoints)
- [Performance Notes](#-performance-notes)
- [Troubleshooting](#-troubleshooting)

## 🎯 Project Overview

This application helps bookstore owners manage their inventory by tracking:
- **Book Collection**: Comprehensive book catalog with categories and authors
- **Customer Ratings**: 1-10 rating system for books
- **Author Popularity**: Ranking based on customer feedback (ratings > 5)
- **Search & Filter**: Easy book discovery functionality

**Key Metrics:**
- 1,000 Authors
- 3,000 Categories  
- 100,000 Books
- 500,000 Ratings

## 🔧 System Requirements

- **PHP**: ^8.1
- **Laravel**: ^11.0
- **MySQL**: ^8.0
- **Composer**: Latest version
- **Node.js**: ^18.0 (optional, for future asset compilation)

### PHP Extensions Required:
```
php-mysql
php-mbstring
php-xml
php-bcmath
php-curl
```

## 🚀 Installation Guide

### 1. Clone Repository
```bash
git clone <your-repository-url>
cd bookstore-app
```

### 2. Install Dependencies
```bash
composer install
```

### 3. Environment Configuration
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Configure Environment Variables
Edit `.env` file with your database credentials:

```env
APP_NAME="Bookstore Management"
APP_ENV=local
APP_KEY=base64:your-generated-key
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database Configuration
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bookstore_db
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

## 💾 Database Setup

### 1. Create Database
```sql
-- Login to MySQL
mysql -u root -p

-- Create database
CREATE DATABASE bookstore_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 2. Run Migrations
```bash
php artisan migrate
```

### 3. Seed Sample Data
```bash
# This will take 10-15 minutes due to large dataset
php artisan db:seed

# Alternative: Run seeders individually for better monitoring
php artisan db:seed --class=AuthorSeeder
php artisan db:seed --class=CategorySeeder  
php artisan db:seed --class=BookSeeder
php artisan db:seed --class=RatingSeeder
```

### 4. Verify Data
```bash
php artisan tinker

# Check record counts
App\Models\Author::count();    // Should return 1000
App\Models\Category::count();  // Should return 3000
App\Models\Book::count();      // Should return 100000
App\Models\Rating::count();    // Should return 500000
```

## ▶️ Running the Application

### 1. Start Development Server
```bash
php artisan serve
```

### 2. Access Application
Open your browser and navigate to:
- **Home/Books List**: http://localhost:8000
- **Famous Authors**: http://localhost:8000/authors/famous
- **Insert Rating**: http://localhost:8000/ratings/create

## ✨ Features

### 📚 Books List Page
- **Default View**: Top 10 books with highest average rating
- **List Control**: Dropdown to show 10, 20, 30...100 books per page
- **Search**: Filter by book title or author name
- **Sorting**: Automatically sorted by average rating (highest first)
- **Pagination**: Smart pagination for large datasets
- **Data Display**: Book title, category, author, average rating, and voter count

### 🏆 Top 10 Famous Authors
- **Ranking Logic**: Based on total votes from ratings > 5 only
- **Display**: Author name and total voter count
- **Automatic Sorting**: Highest voter count first

### ⭐ Insert Rating Form
- **Dependent Dropdowns**: Select author first, then book list updates via AJAX
- **Rating Scale**: 1-10 integer values
- **Validation**: Ensures selected book belongs to selected author
- **Success Flow**: Redirects to books list after successful submission

### 🔍 Search & Filter
- **Real-time Search**: Search across book titles and author names
- **Query Persistence**: Search terms and filters preserved during pagination
- **Performance Optimized**: Indexed database queries for fast results

## 📁 Project Structure

```
bookstore-app/
├── app/
│   ├── Http/Controllers/
│   │   ├── AuthorController.php     # Famous authors logic
│   │   ├── BookController.php       # Books list & search
│   │   └── RatingController.php     # Rating form & AJAX
│   └── Models/
│       ├── Author.php               # Author model with relationships
│       ├── Book.php                 # Book model with scopes
│       ├── Category.php             # Category model
│       └── Rating.php               # Rating model with validation
├── database/
│   ├── factories/                   # Model factories for fake data
│   ├── migrations/                  # Database schema
│   └── seeders/                     # Data seeders (chunked for performance)
├── resources/views/
│   ├── layouts/app.blade.php        # Main layout template
│   ├── books/index.blade.php        # Books list page
│   ├── authors/famous.blade.php     # Famous authors page
│   └── ratings/create.blade.php     # Rating form page
└── routes/web.php                   # Application routes
```

## 🔗 API Endpoints

### Web Routes
| Method | URI | Controller@Method | Description |
|--------|-----|-------------------|-------------|
| GET | `/` | BookController@index | Books list (home page) |
| GET | `/books` | BookController@index | Books list with filters |
| GET | `/authors/famous` | AuthorController@famousAuthors | Top 10 famous authors |
| GET | `/ratings/create` | RatingController@create | Rating form |
| POST | `/ratings` | RatingController@store | Submit rating |

### AJAX Endpoints
| Method | URI | Controller@Method | Description |
|--------|-----|-------------------|-------------|
| GET | `/api/books-by-author/{id}` | RatingController@getBooksByAuthor | Get books by author (JSON) |

## ⚡ Performance Notes

### Database Optimization
- **Indexes**: Added on frequently queried columns (author_id, category_id, rating, book_id)
- **Relationships**: Eager loading to prevent N+1 queries
- **Query Scopes**: Reusable query logic in models
- **Chunked Seeding**: Memory-efficient data insertion

### Query Examples
```php
// Efficient books query with relationships and aggregates
Book::with(['author', 'category'])
    ->withAvg('ratings', 'rating')
    ->withCount('ratings')
    ->orderByDesc('ratings_avg_rating')
    ->paginate(10);

// Famous authors query (ratings > 5 only)
Author::withCount(['ratingsThoughBooks as fame_count' => function($query) {
    $query->where('rating', '>', 5);
}])->orderByDesc('fame_count')->take(10)->get();
```

### Memory Management
- **Chunked Insertions**: Large datasets inserted in batches
- **Smart Pagination**: Limited page numbers displayed
- **Optimized Factories**: Efficient fake data generation

## 🐛 Troubleshooting

### Common Issues

#### 1. "Maximum retries reached" during seeding
```bash
# Solution: Use chunked seeding approach
php artisan db:seed --class=CategorySeeder
```

#### 2. Slow query performance
```bash
# Check if indexes are created
php artisan tinker
>>> DB::select("SHOW INDEX FROM books");
```

#### 3. Memory exhaustion during seeding
```bash
# Increase PHP memory limit
php -d memory_limit=2G artisan db:seed
```

#### 4. Pagination showing too many pages
The smart pagination is implemented to show maximum 7 page numbers at a time.

#### 5. AJAX dropdown not working
Ensure CSRF token is properly set in the layout:
```html
<meta name="csrf-token" content="{{ csrf_token() }}">
```

### Database Reset
If you need to reset the database:
```bash
# Complete reset
php artisan migrate:fresh --seed

# Or step by step
php artisan migrate:rollback --step=4
php artisan migrate
php artisan db:seed
```

### Performance Testing
```bash
# Test query performance
php artisan tinker
>>> $start = microtime(true);
>>> $books = App\Models\Book::withRatingStats()->take(10)->get();
>>> echo "Query time: " . (microtime(true) - $start) . " seconds";
```

## 📊 Expected Performance

- **Books List Load**: < 500ms (with 100K records)
- **Search Query**: < 200ms (with proper indexing)
- **Author Fame Calculation**: < 300ms
- **AJAX Book Loading**: < 100ms
- **Database Seeding**: 10-15 minutes (one-time)

## 🔐 Security Features

- **CSRF Protection**: All forms protected with CSRF tokens
- **Input Validation**: Server-side validation for all inputs
- **SQL Injection Prevention**: Eloquent ORM and parameterized queries
- **XSS Prevention**: Blade template escaping

## 📝 Notes for Reviewers

### Key Implementation Highlights:
1. **No Caching**: As per requirements, no caching mechanisms used
2. **Large Dataset Handling**: Optimized for 500K ratings with proper indexing
3. **Clean Code**: Following Laravel best practices and conventions
4. **Performance Focused**: Efficient queries and memory management
5. **User Experience**: Smart pagination and real-time search

### Test Scenarios:
1. Browse books with different "List shown" values
2. Search for books using partial names
3. Check author fame calculation accuracy
4. Test dependent dropdown functionality
5. Verify rating submission and redirect flow

---

**Author**: [Your Name]  
**Laravel Version**: 11.x  
**PHP Version**: 8.1+  
**Database**: MySQL 8.0+

For any questions or issues, please check the troubleshooting section or create an issue in the repository.