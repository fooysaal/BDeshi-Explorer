# Bdeshi Explorer - Travel Booking Platform

## 🚀 Getting Started

### Prerequisites

-   PHP 8.2+
-   MySQL/MariaDB
-   Composer
-   Node.js & npm

### Installation

1. **Install PHP Dependencies**

    ```bash
    composer install
    ```

2. **Install Node Dependencies**

    ```bash
    npm install
    ```

3. **Setup Environment**

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4. **Configure Database** (in `.env`)

    ```
    DB_DATABASE=bdeshi_explorer
    DB_USERNAME=root
    DB_PASSWORD=
    ```

5. **Run Migrations & Seeders**

    ```bash
    php artisan migrate:fresh --seed
    ```

6. **Build Frontend Assets**

    ```bash
    npm run build
    ```

7. **Start Development Server**
    ```bash
    php artisan serve
    ```

Visit: `http://localhost:8000`

---

## 👥 Default Login Credentials

| Role      | Email                         | Password |
| --------- | ----------------------------- | -------- |
| Admin     | admin@bdeshi-explorer.com     | password |
| Moderator | moderator@bdeshi-explorer.com | password |
| Explorer  | explorer@example.com          | password |

---

## 🎯 Key Features

### ✨ Landing Page

-   **Hero Section**: Full-screen banner with CTA buttons
-   **About Section**: Company info with 4 key features
-   **Tours Section**: 6 sample tours with filtering by category
-   **Events Section**: Auto-playing carousel
-   **Testimonials Section**: Customer reviews grid
-   **CTA Section**: Parallax call-to-action
-   **Footer**: Comprehensive links and social media

### 🎨 Design System

-   **Colors**: Emerald Green (#2ECC71), Sky Blue (#00BFFF)
-   **Typography**: Poppins (headings), Inter (body)
-   **Framework**: Vue 3 + Tailwind CSS v4 + AOS animations

### 🔐 User Roles

-   **Admin**: Full system access (CMS, Tours, Bookings)
-   **Moderator**: Limited admin access (Tours, Bookings)
-   **Explorer**: Book tours, manage own bookings

### 📦 Booking System

-   Payment Methods: Bank Transfer, MFS (bKash/Nagad/Rocket), Pay Later
-   Auto capacity management
-   Booking workflow: pending → in_process → approved → completed

---

## 📡 API Endpoints

### Public APIs

```
GET  /api/v1/public/tours
GET  /api/v1/public/events
GET  /api/v1/public/testimonials
```

### Explorer APIs (Auth Required)

```
POST /api/v1/bookings           - Create booking
GET  /api/v1/bookings           - My bookings
POST /api/v1/bookings/{id}/cancel
```

### Admin APIs (Admin/Moderator)

```
/api/v1/admin/cms               - CMS management
/api/v1/admin/tours             - Tour management
/api/v1/admin/bookings          - Booking management
```

**Full API documentation**: See `BACKEND_DOCUMENTATION.md`

---

## 🗄️ Database

### Seeded Data

-   1 Admin, 1 Moderator, 6 Explorers
-   6 Tours (Sundarbans, Cox's Bazar, Sylhet, etc.)
-   4 CMS sections (Hero, About, CTA, Contact)

### Key Tables

-   users, tours, bookings, events, testimonials, c_m_s_contents

---

## 📁 Project Structure

```
├── app/Http/Controllers/
│   ├── Api/                    # Public APIs
│   ├── Admin/                  # Admin controllers
│   └── BookingController.php
├── app/Models/                 # Eloquent models
├── database/migrations/        # Database schema
├── resources/js/components/    # 8 Vue components
└── routes/api.php              # API routes
```

---

## 🔧 Development Commands

```bash
npm run dev          # Frontend dev mode
npm run build        # Build for production
php artisan serve    # Start server
php artisan migrate:fresh --seed  # Reset database
```

---

## 📚 Documentation

-   `README.md` - Quick start guide (this file)
-   `BACKEND_DOCUMENTATION.md` - Complete API reference

---

## 💡 Tips

-   Default password for all seeded users: `password`
-   Tours have upcoming dates (15-30 days from today)
-   CMS content is fully editable via API
-   Bookings use soft deletes for audit trail

---

**Built with ❤️ for Bdeshi Explorer**
