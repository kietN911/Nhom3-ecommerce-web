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

## Deploy backend len Render

Repo da co san `Dockerfile` o root va trong `backend/` de Render build backend Laravel.

- Service type: `Web Service`
- Branch: `main`
- Runtime: `Docker`
- Neu `Root Directory = backend` thi van dung duoc vi da co `backend/Dockerfile`

Bien moi truong can co tren Render:

- `APP_KEY`
- `APP_ENV=production`
- `APP_DEBUG=false`
- `APP_URL=https://<ten-service>.onrender.com`
- `DB_CONNECTION=mysql`
- `MYSQLHOST=<public-host-tu-railway>`
- `MYSQLPORT=<public-port-tu-railway>`
- `MYSQLDATABASE=<db-name>`
- `MYSQLUSER=<db-user>`
- `MYSQLPASSWORD=<db-password>`
