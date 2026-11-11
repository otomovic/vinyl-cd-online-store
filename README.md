# Vinyl & CD Online Store

Information system for an online store selling vinyl records and CDs.
Built as my high school graduation thesis at Zemun Gymnasium (2023).

## Technologies used
PHP, MySQL (phpMyAdmin), JavaScript, jQuery, Bootstrap, XAMPP

## Features
- Role-based access: **customer** and **administrator**
- Full CRUD for releases, artists, genres and users (admin only)
- Releases can have multiple artists and genres (many-to-many tables)
- Session-based shopping cart; orders are rejected if the quantity exceeds stock
- Order history: customers see their own orders, admins see all and can filter by user
- Soft delete: removed records are flagged in the database, not erased, and admins can restore them
- Cover image upload and form submission via jQuery AJAX

## Setup
1. Install XAMPP and start Apache and MySQL.
2. Copy the project files into `htdocs/`.
3. Import `prodavnica.sql` into a new database named `prodavnica` using phpMyAdmin.
4. Open `http://localhost/index.php`.

The database connection is in `funkcije.php` (default XAMPP: user `root`, empty password).

## Limitations
This is a learning project and is not production-ready: passwords are stored
in plain text and SQL queries are built with string concatenation
(no prepared statements).
