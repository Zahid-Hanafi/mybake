# MyBake - Bakery E-Commerce & Management System

![CakePHP](https://img.shields.io/badge/CakePHP-4.x-red?style=flat-square&logo=cakephp)
![PHP](https://img.shields.io/badge/PHP-8.0+-blue?style=flat-square&logo=php)
![MySQL](https://img.shields.io/badge/MySQL-Database-orange?style=flat-square&logo=mysql)

**MyBake** is a comprehensive web application for managing a bakery's e-commerce operations, including online ordering, offline sales tracking, stock inventory management, and extensive administrative reporting. Built with the CakePHP 4.x framework.

---

## Table of Contents

- [Features](#features)
- [Requirements](#requirements)
- [Installation](#installation)
- [Database Setup](#database-setup)
- [Test Accounts](#test-accounts)
- [Usage Guide](#usage-guide)
- [Project Structure](#project-structure)

---

## Features

- **User Authentication** - Secure login/logout system with role-based access for Admins and Customers
- **Online Ordering System** - Customers can browse products, manage their cart, and checkout online securely
- **Order Management** - Admins can track and update order statuses (Preparing, Shipping, Complete) and generate QR-based packing slips
- **Stock & Inventory** - Comprehensive stock tracking, status toggling (Open/Closed), and rapid restocking capabilities
- **Offline Sales Tracking** - Record, monitor, and analyze walk-in customer purchases alongside online sales
- **Dashboard & Reporting** - Dynamic analytics covering total revenue, profit estimations, unit trends, and filterable reports by year/month
- **Product Management** - Manage the bakery catalog, product lines, prices, and promotional badges (New Arrival, Best Seller)

---

## Requirements

- **PHP** 8.0 or higher
- **MySQL** 5.7+ or MariaDB 10.3+
- **Composer** (PHP dependency manager)
- **Web Server** (Apache/Nginx) or Laragon for Windows

---

## Installation

### Step 1: Clone the Repository

```bash
git clone https://github.com/Zahid-Hanafi/mybake.git
cd mybake
```

### Step 2: Install Dependencies

```bash
composer install
```

### Step 3: Configure Environment

1. Copy the example configuration file:
   ```bash
   cp config/app_local.example.php config/app_local.php
   ```

2. Edit `config/app_local.php` and update the database credentials:
   ```php
   'Datasources' => [
       'default' => [
           'host' => 'localhost',
           'username' => 'root',
           'password' => '',         // Your MySQL password
           'database' => 'mybake',   // Database name
       ],
   ],
   ```

### Step 4: Set Directory Permissions

Ensure the following directories are writable:
```bash
# Linux/Mac
chmod -R 777 logs tmp

# Windows (using Laragon)
# These permissions are typically set automatically
```

---

## Database Setup

### Step 1: Create the Database

Using phpMyAdmin or MySQL command line:

```sql
CREATE DATABASE mybake CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### Step 2: Import Database Schema

Import the database SQL file provided with the project:

```bash
mysql -u root -p mybake < database/mybake.sql
```

Or using phpMyAdmin:
1. Open phpMyAdmin (http://localhost/phpmyadmin)
2. Select the `mybake` database
3. Click **Import**
4. Choose the SQL file and click **Go**

---

## Test Accounts

### Administrator Account

Use this account to access the admin panel and manage sales, products, stock, and view the analytics dashboard.

| Field    | Value                  |
|----------|------------------------|
| Email    | `admin@example.com`    |
| Password | `Admin@123`            |

*(Note: Adjust the admin credentials based on your initial database seeder)*

---

### Testing Account (Recommended for New Customers)

This is the **primary testing account** for exploring the customer features. Use this account to:
- Browse bakery products
- Add items to cart and place an order
- View order history and track shipping status
- Manage your delivery addresses

| Field       | Value                |
|-------------|----------------------|
| Name        | Testing Customer     |
| Email       | `zahid@gmail.com`|
| Password    | `Customer@123`       |

> **💡 Tip:** Login as **Customer** first to add items to your cart and checkout. Then use the **Admin** account to process the order, update the shipping status, and view the impact on the analytics dashboard.

---

### Pre-configured Customer Accounts

The database is pre-seeded with dozens of realistic customer accounts spanning multiple years (2024 - 2026). All pre-configured dummy customer accounts use the same standard password for easy testing:

| Role        | Standard Password | Note                                                                 |
|-------------|-------------------|----------------------------------------------------------------------|
| Customer    | `Customer@123`    | Applies to all 50+ pre-generated test customers currently in the DB  |

---

## Usage Guide

### Getting Started

1. **Start your local server** (Laragon, XAMPP, or MAMP)
2. **Access the application** at: `http://localhost/mybake` or `http://mybake.test`

### For Administrators

1. **Login** with admin credentials
2. From the navigation, you can:
   - **Dashboard** - View real-time revenue, orders, and product trend charts filterable by year
   - **Orders** - View all incoming customer orders, generate tracking numbers, update statuses to "Shipping", and print packing slips
   - **Sales Management** - Add manual offline sales for walk-in customers and generate comprehensive PDF sales reports
   - **Stock Management** - Instantly view stock levels (color-coded for low/high), toggle product availability, and restock items

### For Customers (Using Testing Account)

1. **Login** with the testing account
2. **Explore Features:**
   - **Shop** - Browse traditional cookies, cakes, and snacks
   - **Cart** - Adjust quantities and proceed to checkout
   - **Checkout** - Provide delivery details and confirm the order
   - **Order History** - Track your active orders and view past purchases

### Workflow Example

#### Processing an Order (Admin)

1. Login as admin
2. Navigate to **Orders**
3. Locate an order with the status **Preparing**
4. Click **Ship Order**, select the courier, and input a tracking number
5. The order status updates to **Shipping** and the customer can now see the tracking details

#### Restocking a Product (Admin)

1. Login as admin
2. Navigate to **Stock Management**
3. Locate a product that has a red `Low Stock` badge
4. Click the **+ Restock** button, enter the received quantity, and confirm
5. The stock level and color-coded badge will update immediately

---

## Project Structure

```
mybake/
├── config/              # Configuration files
│   ├── app.php          # Main application config
│   ├── app_local.php    # Local environment config
│   └── routes.php       # URL routing configuration
├── src/
│   ├── Controller/      # Application controllers (AdminController, SalesController, etc.)
│   ├── Model/           # Database models (Tables & Entities)
│   └── View/            # View helpers
├── templates/           # Template files (Views)
│   ├── Admin/           # Admin dashboard, stock, and general admin views
│   ├── Sales/           # Sales management and report generation views
│   ├── Orders/          # Customer and admin order management views
│   ├── Products/        # E-commerce storefront product views
│   ├── Users/           # User authentication and profile views
│   ├── Pages/           # Static pages (home, about, contact)
│   ├── layout/          # Layout templates (default, admin layout)
│   └── element/         # Reusable UI elements (navbar, footer, flash messages)
├── webroot/             # Publicly accessible files
│   ├── css/             # Stylesheets (mybake.css, admin.css)
│   ├── js/              # JavaScript files
│   ├── img/             # Images and product photos
│   └── font/            # Fonts
├── tests/               # Unit and integration tests
├── logs/                # Application logs
├── tmp/                 # Temporary files and cache
└── vendor/              # Composer dependencies
```

---

## Running the Application

### Using Laragon (Recommended for Windows)

1. Place the project in `C:\laragon\www\mybake`
2. Start Laragon
3. Access via `http://mybake.test` or `http://localhost/mybake`

### Using Built-in CakePHP Server

```bash
bin/cake server -p 8765
```

Then visit `http://localhost:8765`

### Using PHP Built-in Server

```bash
php -S localhost:8000 -t webroot
```

Then visit `http://localhost:8000`

---

## Troubleshooting

### Common Issues

1. **Database Connection Error**
   - Verify `config/app_local.php` has correct database credentials
   - Ensure MySQL/MariaDB service is running
   - Check if the `mybake` database exists

2. **Permission Denied Errors**
   - Ensure `logs/` and `tmp/` directories are writable
   - On Linux: `chmod -R 777 logs tmp`

3. **White Screen / 500 Error**
   - Check `logs/error.log` for detailed error messages
   - Enable debug mode in `config/app_local.php`: `'debug' => true`

4. **CSS/JS Not Loading**
   - Check your `.htaccess` file in the root and `webroot/` directories
   - Ensure mod_rewrite is enabled in Apache

---

## License

This project is developed for educational purposes as part of a university assignment.

---

## Author

**Muhammad Zahid Hanafi**
- Email: zahidhanafi52@gmail.com
- GitHub: [Zahid-Hanafi](https://github.com/Zahid-Hanafi)

---

## Acknowledgments

- [CakePHP Framework](https://cakephp.org/)
- [Laragon](https://laragon.org/)
- All contributors and testers
