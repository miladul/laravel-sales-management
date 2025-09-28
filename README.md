# 🛠️ Sales  Management System
---
## 🚀 Requirements

- PHP ^8.2
- Composer
- Laravel Framework (compatible with PHP 8.2)
- MySQL or any other supported database


## 📦 Installation

```bash
git clone https://github.com/miladul/laravel-sales-management.git
cd laravel-sales-management
composer install
cp .env.example .env
```

Update `.env` with DB credentials.

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=db_username
DB_PASSWORD=db_password

```

```
php artisan key:generate
php artisan migrate --seed
```

## Run server 
```
php artisan serve
```

## Test the application:
```
Visit /sales to view the sales list
Visit /sales/create to create a new sale
Visit /sales/trash to view and restore deleted sales
```


