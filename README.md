# Inventory & Warehouse Management API

## Objective
This project is a **Laravel-based RESTful API** for managing inventory items and stock levels across multiple warehouses. It ensures clean code principles, caching, validation, event-driven notifications, and secure authenticated access.

---

## ✅ Features

### 📦 Inventory Management:
- **List Inventory Items**:
    - Supports searching by `name` or `SKU`
    - Supports filtering by `price range`
    - Supports sorting by `name`, `price` or `id`
    - Uses efficient **cursor pagination**
- **View Warehouse Inventory**:
    - Fetch all stocks for a specific warehouse with caching for faster retrieval.

### 🔄 Stock Transfers:
- **Transfer Stock**:
    - Transfer items from one warehouse to another.
    - Checks stock availability and prevents over-transfer.
    - Updates stock quantities atomically.
    - Fires **LowStockDetected** event if quantity falls below a threshold.

### 📡 Caching:
- Warehouse inventory is cached for faster repeated reads.
- Cache is invalidated automatically when stock is transferred.

### 🛡️ Security:
- Uses **Sanctum API tokens** for authentication.
- Only authenticated users can create stock transfers or view warehouse inventory.

### 📧 Notifications:
- When **LowStockDetected**, an event is triggered.
- A dummy notification is queued for the admin email (no real email sending).

---

## 🗂️ API Endpoints

| Method | Endpoint | Description                                    |
|--------|----------|------------------------------------------------|
| POST   | `/api/v1/auth/login` | User login                                     |
| POST   | `/api/v1/auth/logout` | Logout                                         |
| GET    | `/api/v1/inventory` | List inventory items with filters & pagination |
| GET    | `/api/v1/warehouses` | List all warehouses                            |
| GET    | `/api/v1/warehouses/{id}/inventory` | Get stocks for a specific warehouse            |
| GET    | `/api/v1/stock-transfers` | Get all transfers                              |
| POST   | `/api/v1/stock-transfers` | Transfer stock between warehouses              |

---

## 🗃️ Tech Stack

- **Framework**: Laravel 12
- **Database**: MySQL 8
- **Auth**: Laravel Sanctum
- **Design Pattern**: Repository-Service Pattern

---

## 📌 API Documentation

- ✅ [View Online Postman Docs](https://documenter.getpostman.com/view/46893943/2sB34kEJpH)

---

## ⚙️ Setup Instructions

### Requirements
- **PHP**: 8.1+
- **MySQL**: 8+
- **Composer**: 2+

---

### Installation

```bash
# 1️⃣ Clone the repo
git clone https://github.com/anssrabie/InventoryWarehouseAPI.git
cd InventoryWarehouseAPI

# 2️⃣ Install dependencies
composer install

# 3️⃣ Copy env
cp .env.example .env

# 4️⃣ Generate key
php artisan key:generate

# 5️⃣ Run migrations
php artisan migrate:fresh --seed

# 6️⃣ Run the server
php artisan serve
