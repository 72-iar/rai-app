<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Laravel Project Installation Guide

## Prerequisites
Ensure you have the following installed on your system:

- **XAMPP** (for Apache and MySQL)
- **Node.js**
- **Composer**

Once installed, open the **Start Menu**, search for **XAMPP Control Panel**, and launch it. Start **Apache** and **MySQL** services.

---

## Project Setup

### 1. Clone the Repository
Download the GitHub repository and extract the folder to your desired location.

Alternatively, you can clone it using Git:
```sh
git clone <repository_url>
cd <project_folder>
```

### 2. Open the Project
- Open **VS Code** (or your preferred code editor).
- Open the extracted/cloned project folder.

---

## Installation & Setup

### **Frontend Setup**
1. Open a terminal in VS Code and run:
   ```sh
   npm install
   ```
   _(Wait for it to finish)_  
2. Then, compile assets:
   ```sh
   npm run dev
   ```

### **Backend Setup**
1. Open another terminal (do not close the previous one) and run:
   ```sh
   composer install
   ```
   _(Wait for it to finish)_  
2. Generate the application key:
   ```sh
   php artisan key:generate
   ```
3. Run database migrations:
   ```sh
   php artisan migrate
   ```
   _(Allow migration if prompted)_  
4. Start the Laravel development server:
   ```sh
   php artisan serve
   ```

---

## Running the Application
Once the server starts, a link will appear, typically:
**[http://127.0.0.1:8000/](http://127.0.0.1:8000/)**

Press **Ctrl + Click** on the link to open it in your browser.

You're all set! 🚀

