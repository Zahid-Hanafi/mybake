# MyBake

![CakePHP](https://img.shields.io/badge/CakePHP-4.x-red?style=flat-square&logo=cakephp)
![PHP](https://img.shields.io/badge/PHP-8.0+-blue?style=flat-square&logo=php)
![MySQL](https://img.shields.io/badge/MySQL-Database-orange?style=flat-square&logo=mysql)

**MyBake** is a comprehensive bakery e-commerce and management system built using the CakePHP 4 framework. It handles online ordering, offline sales tracking, stock management, and comprehensive sales reporting.

---

## Features

- **User Authentication** - Secure customer and admin login system
- **Online Ordering** - Browse products, manage carts, and checkout online
- **Order Management** - Admins can track orders from preparation to shipping and completion
- **Stock & Inventory** - Comprehensive stock tracking and restocking features
- **Offline Sales Tracking** - Record and monitor walk-in customer purchases
- **Dashboard & Reporting** - Dynamic analytics covering revenue, profit, unit trends, and more
- **Product Management** - Manage catalog, prices, and categories

---

## Requirements

- **PHP** 8.0 or higher
- **MySQL** 5.7+ or MariaDB 10.3+
- **Composer** (PHP dependency manager)
- **Web Server** (Apache/Nginx) or Laragon for Windows

---

## Installation

1. **Clone the repository:**
   ```bash
   git clone <repository_url>
   cd mybake
   ```

2. **Install dependencies:**
   ```bash
   composer install
   ```

3. **Configure Database:**
   - Copy `config/app_local.example.php` to `config/app_local.php`.
   - Update your database credentials in `app_local.php`.
   
4. **Setup Permissions:**
   Ensure `logs/` and `tmp/` are writable by the web server.

---

## Administrator Access

Use the following default administrator credentials to manage the system:

| Field    | Value           |
|----------|-----------------|
| Email    | `admin@mybake.com` (Example) |
| Password | `Admin@123`     |

*(Note: Adjust email login based on your seeder/setup)*

---

## Project Structure

- `src/Controller/`: Request handlers (e.g., `SalesController`, `AdminController`)
- `src/Model/`: Database interaction (Tables and Entities)
- `templates/`: View files and layout templates
- `webroot/`: Public assets (CSS, JS, Images)
- `config/`: Application and routing configuration

---

## License

This project is developed for educational purposes as part of a university assignment.
