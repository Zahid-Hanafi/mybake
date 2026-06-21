# MyPMH - Postgraduate Management Hub

![CakePHP](https://img.shields.io/badge/CakePHP-4.x-red?style=flat-square&logo=cakephp)
![PHP](https://img.shields.io/badge/PHP-8.0+-blue?style=flat-square&logo=php)
![MySQL](https://img.shields.io/badge/MySQL-Database-orange?style=flat-square&logo=mysql)

**MyPMH (My Postgraduate Management Hub)** is a comprehensive web application for managing postgraduate student applications, programs, and administrative tasks. Built with CakePHP 4.x framework.

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

- **User Authentication** - Secure login/logout system with role-based access
- **Application Management** - Submit, review, accept, and reject postgraduate applications
- **Program Management** - Browse and manage available postgraduate programs
- **User Profile Management** - Update profile information and change passwords
- **Product/Merchandise Management** - View and order university merchandise
- **Order Management** - Track and manage orders
- **Reviews System** - Leave and manage reviews
- **Admin Dashboard** - Comprehensive admin panel for system management

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
git clone https://github.com/Zahid-Hanafi/mypmh.git
cd mypmh
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
           'database' => 'mypmh',    // Database name
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
CREATE DATABASE mypmh CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### Step 2: Import Database Schema

Import the database SQL file provided with the project:

```bash
mysql -u root -p mypmh < database/mypmh.sql
```

Or using phpMyAdmin:
1. Open phpMyAdmin (http://localhost/phpmyadmin)
2. Select the `mypmh` database
3. Click **Import**
4. Choose the SQL file and click **Go**

---

## Test Accounts

### Administrator Account

Use this account to access the admin panel and manage users, applications, programs, and products.

| Field    | Value           |
|----------|-----------------|
| Username | `ADMIN01`       |
| Password | `Password@123`  |

---

### Testing Account (Recommended for New Users)

This is the **primary testing account** for exploring the application features. Use this account to:
- Submit new applications
- Edit profile and change password
- Browse programs and merchandise
- Experience the full student workflow

| Field       | Value                |
|-------------|----------------------|
| Name        | Testing              |
| Matric No   | `2025123456`         |
| Email       | `testing@gmail.com`  |
| Password    | `Password@123`       |

> **💡 Tip:** Login as **Admin** first to add applications and configure the system. Then use the **Testing** account to experience the student features.

---

### Student Accounts

The following student accounts are pre-configured for testing different scenarios:

| No. | Name                   | Matric No      | Email                    | Password       | Program ID | CGPA |
|-----|------------------------|----------------|--------------------------|----------------|------------|------|
| 1   | Jamal Abdillah         | `2025111222`   | student01@gmail.com      | Password@123   | 1          | 3.50 |
| 2   | Siti Ramlah            | `2025222333`   | student02@gmail.com      | Password@123   | 2          | 3.60 |
| 3   | Abdul Wahab            | `2025333444`   | student03@gmail.com      | Password@123   | 3          | 3.70 |
| 4   | Wafiq Jamaludin        | `2025444555`   | student04@gmail.com      | Password@123   | 4          | 3.80 |
| 5   | Mahathir Razak         | `2025555666`   | student05@gmail.com      | Password@123   | 1          | 3.90 |
| 6   | Anwar Yassin           | `2025666777`   | student06@gmail.com      | Password@123   | 2          | 3.95 |
| 7   | Hadi Sanusi            | `2025777888`   | student07@gmail.com      | Password@123   | 3          | 3.40 |
| 8   | Jokowi Trump           | `2025888999`   | student08@gmail.com      | Password@123   | 4          | 3.30 |
| 9   | Nur Bainun             | `2025999000`   | student09@gmail.com      | Password@123   | 1          | 3.20 |
| 10  | Rosmah Norhaliza       | `2025000111`   | student10@gmail.com      | Password@123   | 2          | 3.10 |
| 11  | Muhammad Zahid Hanafi  | `2025127713`   | zahidhanafi52@gmail.com  | Password@123   | -          | 4.00 |

---

## Usage Guide

### Getting Started

1. **Start your local server** (Laragon, XAMPP, or MAMP)
2. **Access the application** at: `http://localhost/mypmh` or `http://mypmh.test`

### For Administrators

1. **Login** with admin credentials (`ADMIN01` / `Password@123`)
2. From the dashboard, you can:
   - **Manage Users** - View, add, edit, or delete user accounts
   - **Manage Programs** - Add or modify postgraduate programs
   - **Review Applications** - Accept or reject student applications
   - **Manage Products** - Add or edit merchandise items
   - **View Orders** - Track and manage orders

### For Students (Using Testing Account)

1. **Login** with the testing account (`testing@gmail.com` / `Password@123`)
2. **Explore Features:**
   - **Submit Application** - Apply for a postgraduate program
   - **View Application Status** - Check if your application is pending, accepted, or rejected
   - **Edit Profile** - Update your personal information
   - **Change Password** - Secure your account with a new password
   - **Browse Programs** - Explore available postgraduate programs
   - **Browse Merchandise** - View and order university merchandise

### Workflow Example

#### Submitting an Application (Student)

1. Login as a student (e.g., `testing@gmail.com`)
2. Navigate to **Applications** → **Submit New Application**
3. Fill in the required details
4. Submit the application
5. Your application status will show as **Pending**

#### Reviewing Applications (Admin)

1. Login as admin (`ADMIN01`)
2. Navigate to **Applications** → **All Applications**
3. Click on a pending application
4. Review the details
5. Click **Accept** or **Reject**

#### Profile Management (Student)

1. Login as a student
2. Click on your profile name in the navigation
3. Select **Edit Profile** to update information
4. Select **Change Password** to update your password

---

## Project Structure

```
mypmh/
├── config/              # Configuration files
│   ├── app.php          # Main application config
│   ├── app_local.php    # Local environment config
│   └── routes.php       # URL routing configuration
├── src/
│   ├── Controller/      # Application controllers
│   ├── Model/           # Database models (Tables & Entities)
│   └── View/            # View helpers
├── templates/           # Template files (Views)
│   ├── Applications/    # Application management views
│   ├── Users/           # User management views
│   ├── Programs/        # Program management views
│   ├── Products/        # Product/merchandise views
│   ├── Orders/          # Order management views
│   ├── Pages/           # Static pages (home, about, contact)
│   ├── layout/          # Layout templates
│   └── element/         # Reusable UI elements
├── webroot/             # Publicly accessible files
│   ├── css/             # Stylesheets
│   ├── js/              # JavaScript files
│   ├── img/             # Images
│   └── font/            # Fonts
├── tests/               # Unit and integration tests
├── logs/                # Application logs
├── tmp/                 # Temporary files and cache
└── vendor/              # Composer dependencies
```

---

## Running the Application

### Using Laragon (Recommended for Windows)

1. Place the project in `C:\laragon\www\mypmh`
2. Start Laragon
3. Access via `http://mypmh.test` or `http://localhost/mypmh`

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
   - Check if the `mypmh` database exists

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

## Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/new-feature`)
3. Commit your changes (`git commit -m 'Add new feature'`)
4. Push to the branch (`git push origin feature/new-feature`)
5. Open a Pull Request

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
