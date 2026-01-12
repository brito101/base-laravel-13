# 🚀 Base Laravel - Professional Template

[![Laravel](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-blue.svg)](https://php.net)
[![Docker](https://img.shields.io/badge/Docker-Ready-blue.svg)](https://docker.com)
[![License](https://img.shields.io/badge/License-MIT-yellow.svg)](LICENSE)

> **Laravel 12 as template** for rapid development of robust administrative systems with focus on security, scalability and user experience.

## 📋 Table of Contents

- [About the Project](#-about-the-project)
- [Features](#-features)
- [Tech Stack](#-tech-stack)
- [Architecture](#-architecture)
- [Installation](#-installation)
- [Configuration](#-configuration)
- [Usage](#-usage)
- [API](#-api)
- [Project Structure](#-project-structure)
- [Contributing](#-contributing)
- [License](#-license)

## 🎯 About the Project

This is a **Laravel 12mplate** developed to accelerate the development of robust administrative systems. The project incorporates best practices in development, security and architecture, being ideal for projects that require:

- **Advanced authentication system** with 2FA
- **Granular access control** (ACL)
- **Modern administrative interface**
- **Secure RESTful APIs**
- **Monitoring and analytics**
- **PWA (Progressive Web App)**

## ✨ Features

### 🔐 Security
- **Multi-factor Authentication** (Google 2FA)
- **Permission System** (Spatie Laravel Permission)
- **JWT Authentication** for APIs
- **Laravel Sanctum** for SPA
- **Soft Deletes** in all models
- **Robust data validation**

### 🎨 Interface
- **AdminLTE 3** - Modern administrative interface
- **Bootstrap 5** - Responsive CSS framework
- **DataTables Server-side** - Optimized tables
- **PWA Ready** - Progressive Web App

### 📊 Monitoring
- **Laravel Debugbar** - Development debugging
- **Visitor Tracking** - Visitor analytics
- **Changelog System** - Change logging
- **Error Tracking** - Error monitoring

### 🚀 Performance
- **Laravel Vite** - Optimized build tool
- **Asset Minification** - Resource optimization
- **Redis Cache** - High-performance cache
- **Meilisearch** - Fast search

## 🛠️ Tech Stack

### Backend
- **Laravel 12** - PHP framework
- **PHP 8.2ogramming language
- **MySQL 8** - Database
- **Redis** - Cache and sessions
- **Docker** - Containerization

### Frontend
- **Bootstrap 5** - CSS framework
- **AdminLTE 3** - Administrative template
- **Vite** - Build tool
- **SASS** - CSS preprocessor

### Development Tools
- **Laravel Sail** - Docker environment
- **Laravel Pint** - Code style fixer
- **PEST** - Testing framework
- **Laravel Debugbar** - Debug toolbar

## 🏗️ Architecture

```
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/          # Administrative controllers
│   │   ├── Api/            # REST APIs
│   │   └── Auth/           # Authentication
│   ├── Models/             # Eloquent models
│   └── Providers/          # Service providers
├── resources/
│   ├── views/              # Blade views
│   ├── js/                 # JavaScript
│   └── sass/               # SASS styles
├── routes/
│   ├── web.php             # Web routes
│   └── api.php             # API routes
└── database/
    ├── migrations/          # Migrations
    └── seeders/            # Seeders
```

## 🚀 Installation

### Prerequisites
- **Docker** and **Docker Compose**
- **Node.js** 18+ (for local development)
- **Composer** (for local development)

### Step by Step

1. **Clone the repository**
```bash
git clone <repository-url>
cd base-laravel
```

2re the environment**
```bash
cp .env.example .env
```

3. **Configure environment variables**
```bash
# Edit the .env file with your settings
nano .env
```

4. **Install dependencies**
```bash
composer install
npm install
```

5*Configure Laravel**
```bash
php artisan key:generate
php artisan jwt:secret
```

6. **Configure Docker (optional)**
```bash
# Alias for Laravel Sail
alias sail=[ -f sail ] && sh sail || sh vendor/bin/sail'
```

7. **Run migrations**
```bash
# With Docker
sail artisan migrate --seed

# Without Docker
php artisan migrate --seed
```

8. **Configure storage**
```bash
# With Docker
sail artisan storage:link

# Without Docker
php artisan storage:link
```

9. **Compile assets**
```bash
# Development
npm run dev

# Production
npm run build
```

## ⚙️ Configuration

### Important Environment Variables

```env
# Application
APP_NAME=Base Laravel"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

# Database
DB_CONNECTION=mysql
DB_HOST=127.000.1
DB_PORT=3306DB_DATABASE=base_laravel
DB_USERNAME=root
DB_PASSWORD=

# JWT
JWT_SECRET=your-jwt-secret
JWT_TTL=60

# Redis
REDIS_HOST=127.0.00.1EDIS_PASSWORD=null
REDIS_PORT=6379`

### Docker Compose

The project includes complete Docker configuration with:

- **Laravel Sail** - Main container
- **MySQL 8** - Database
- **Redis** - Cache and sessions
- **Meilisearch** - Search
- **Mailpit** - Email testing
- **Selenium** - Automated tests

## 🎮 Usage

### System Access

**Default credentials:**
- **Email:** programador@base.com
- **Password:** 12345678## Useful Commands

```bash
# Development
sail up -d                    # Start containers
sail artisan serve            # Development server
npm run dev                   # Compile assets (dev)

# Production
npm run build                 # Compile assets (prod)
php artisan config:cache      # Configuration cache
php artisan route:cache       # Route cache

# Maintenance
sail artisan migrate          # Run migrations
sail artisan db:seed          # Run seeders
sail artisan storage:link     # Storage symbolic link
```

## 🔌 API

### JWT Authentication

```bash
# Login
POST /api/v1/login
{
 email":user@example.com,password: ord"
}

# Register
POST /api/v1gister
{
    name": User Name",
 email":user@example.com,password: word"
}

# Refresh Token
POST /api/v1/refresh
Authorization: Bearer {token}
```

### Available Endpoints

- `GET /api/v1/admin/users` - List users
- `GET /api/v1in/profile` - User profile
- `POST /api/v1logout` - Logout

## 📁 Project Structure

### Main Directories

```
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/           # Administrative controllers
│   │   │   └── ACL/         # Access control
│   │   ├── Api/             # REST APIs
│   │   └── Auth/            # Authentication
│   ├── Models/              # Eloquent models
│   └── Providers/           # Service providers
├── resources/
│   ├── views/
│   │   ├── admin/           # Administrative views
│   │   ├── auth/            # Authentication views
│   │   └── layouts/         # Base layouts
│   ├── js/                  # JavaScript
│   └── sass/                # SASS styles
├── routes/
│   ├── web.php              # Web routes
│   └── api.php              # API routes
└── database/
    ├── migrations/           # Migrations
    └── seeders/             # Seeders
```

## 🤝 Contributing

### Code Standards

- **PSR-12HP** coding standard
- **Laravel Pint** - Code style fixer
- **PEST** - Testing framework
- **Conventional Commits** - Commit standard

## 📄 License

This project is licensed under the **MIT License** - see the [LICENSE](LICENSE) file for details.

## 🙏 Acknowledgments

- [Laravel](https://laravel.com) - PHP framework
- [AdminLTE](https://adminlte.io) - Administrative template
-Spatie](https://spatie.be) - Laravel packages

---

**Developed with ❤️ to accelerate the development of robust and secure systems.**
