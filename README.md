# Nhom3 Ecommerce Web

Du an duoc tach thanh 2 phan:

- `frontend/`: giao dien HTML, CSS, JS
- `backend/`: Laravel API

## Chay backend

```powershell
cd backend
php artisan serve
```

## Frontend

Mo:

- `frontend/index.html`
- `frontend/admin.html`

Frontend goi API thong qua `frontend/js/config.js`.

## Railway MySQL

Laravel backend da duoc chinh de nhan bien moi truong Railway:

- `MYSQL_URL`
- `MYSQLHOST`
- `MYSQLPORT`
- `MYSQLDATABASE`
- `MYSQLUSER`
- `MYSQLPASSWORD`

Neu deploy tren Railway, chi can gan service Laravel voi service MySQL va cap bien moi truong.
