# Shop API Backend (Laravel 11)

Minimalist backend for e-commerce, focused on Cart and Order management.

## API Endpoints

### Cart
- `GET /api/cart?user_id=1` - View cart
- `POST /api/cart` - Add to cart
- `DELETE /api/cart?user_id=1` - Clear cart

### Order
- `POST /api/checkout` - Place order (Cart -> Order)

## Setup
1. `composer install`
2. `cp .env.example .env` (Configure your MySQL `shopdb`)
3. `php artisan key:generate`
4. `php artisan serve`

## Notes
- Database: MySQL (`shopdb`)
- Framework: Laravel 11 (Headless API)
