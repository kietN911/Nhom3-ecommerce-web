# FKFOOD Laravel Backend

Backend moi duoc tao bang Laravel tai thu muc `backend`.

## Chay backend

```powershell
cd C:\Users\Dang Khoi\Documents\Codex\2026-04-22-files-mentioned-by-the-user-fkfood-2\backend
php artisan serve
```

Mac dinh frontend dang goi API:

```text
http://127.0.0.1:8000/api
```

## Database

File `.env` local da duoc doi sang MySQL.

Khi deploy Railway, ban co the dung truc tiep cac bien moi truong Railway MySQL:

- `MYSQL_URL`
- `MYSQLHOST`
- `MYSQLPORT`
- `MYSQLDATABASE`
- `MYSQLUSER`
- `MYSQLPASSWORD`

Laravel da duoc cap nhat de uu tien doc cac bien nay neu `DB_*` khong duoc set.

Mac dinh `.env.example` da map san:

- `DB_DATABASE=fk_food`
- `DB_USERNAME=root`
- `DB_PASSWORD=`

Neu can tao/cap nhat schema:

```powershell
php artisan migrate
```

## API chinh

- `POST /api/login`
- `POST /api/register`
- `GET /api/products`
- `POST /api/checkout`
- `GET /api/admin/dashboard`
- `GET /api/admin/products`
- `POST /api/admin/products`
- `POST /api/admin/products/{id}`
- `DELETE /api/admin/products/{id}`
- `GET /api/admin/users`
- `PATCH /api/admin/users/{id}/toggle`
- `GET /api/admin/orders`
- `PATCH /api/admin/orders/{id}/confirm`

## Frontend da cap nhat

Frontend HTML dang dung file:

- `frontend/index.html`
- `frontend/admin.html`
- `frontend/js/config.js`

`config.js` dang tro toi Laravel API bang bien `window.API_BASE`.
