# 📅 AppointBook – Online Appointment Booking System

A full-featured web-based appointment booking system built with **Laravel**, **Bootstrap 5**, **MySQL**, and **jQuery/AJAX**.

---

## 🧩 Features

| Role | Capabilities |
|------|-------------|
| **Admin** | Manage users, services, view all appointments system-wide |
| **Staff/Provider** | Set availability slots, view & update assigned bookings |
| **Customer** | Browse services, book appointments via AJAX slot picker, cancel bookings |

- Role-based access control (middleware-enforced)
- Anti-double-booking with DB transactions
- AJAX-powered slot loading (no page reload)
- Responsive sidebar layout (Bootstrap 5 + custom CSS)
- Status badge updates via AJAX (staff panel)

---

## ⚙️ Installation & Setup

### Requirements
- PHP >= 8.2
- Composer
- MySQL 5.7+ or MariaDB

---

### Step 1 – Extract & Enter the Project

```bash
cd quantum-voyager
```

---

### Step 2 – Install PHP Dependencies

```bash
composer install
```

---

### Step 3 – Configure Environment

```bash
cp .env.example .env
```

Edit `.env` — update the database block:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=appointment_booking
DB_USERNAME=root
DB_PASSWORD=your_password_here
```

---

### Step 4 – Generate Application Key

```bash
php artisan key:generate
```

---

### Step 5 – Create the Database

```bash
mysql -u root -p -e "CREATE DATABASE appointment_booking CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

---

### Step 6 – Run Migrations & Seeders

```bash
php artisan migrate --seed
```

To reset and re-seed:

```bash
php artisan migrate:fresh --seed
```

---

### Step 7 – Set Permissions & Start Server

```bash
php artisan storage:link
php artisan serve
```

Open: **http://localhost:8000**

---

## 🔐 Default Login Credentials  (password for all: `password`)

| Role | Email |
|------|-------|
| Admin | admin@booking.com |
| Staff | staff@booking.com |
| Staff 2 | staff2@booking.com |
| Customer | customer@booking.com |
| Customer 2 | customer2@booking.com |

---

## 🛠️ Useful Commands

```bash
php artisan optimize:clear        # clear all caches
php artisan migrate:fresh --seed  # reset DB + reseed
php artisan serve --port=8080     # custom port
composer dump-autoload            # fix class not found errors
```
