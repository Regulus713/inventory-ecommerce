# Inventory E-Commerce System

A comprehensive inventory management system built as an e-commerce website using Laravel 12 with SQL database integration and authentication.

## Features

- **User Authentication**: Secure user registration and login system
- **Inventory Management**: Full CRUD operations for products
- **Category Management**: Organize products by categories
- **Order Processing**: Handle customer orders and order items
- **Admin Dashboard**: Administrative interface for managing inventory
- **SQL Database**: Robust database schema with migrations

## Tech Stack

- **Backend**: Laravel 12 (PHP ^8.2)
- **Database**: SQL (MySQL/PostgreSQL/SQLite)
- **Frontend**: Vite with JavaScript
- **Authentication**: Laravel's built-in authentication system
- **Testing**: PHPUnit

## Installation

1. Clone the repository
2. Install dependencies:
   ```bash
   composer install
   npm install
   ```

3. Copy environment file:
   ```bash
   cp .env.example .env
   ```

4. Generate application key:
   ```bash
   php artisan key:generate
   ```

5. Configure database in `.env` file

6. Run migrations:
   ```bash
   php artisan migrate
   ```

7. Build frontend assets:
   ```bash
   npm run build
   ```

8. Start development server:
   ```bash
   php artisan serve
   ```

## Development

### Running Tests
```bash
composer test
```

### Code Style
```bash
./vendor/bin/pint
```

### Development Server
```bash
php artisan serve
```

### Database Migrations
```bash
php artisan migrate
php artisan migrate:rollback
php artisan migrate:fresh --seed
```

## Project Structure

```
app/              - Application logic (Models, Controllers, etc.)
database/         - Database migrations, seeders, and factories
resources/        - Views, assets, and frontend components
routes/           - API and web routes
tests/            - PHPUnit tests
config/           - Configuration files
```

## Agent Handoff Documentation

For detailed development workflow and handoff procedures, see [AGENTS.md](AGENTS.md).

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
