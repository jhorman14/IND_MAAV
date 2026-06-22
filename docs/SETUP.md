# Guía de Instalación y Configuración - IND_MAAV E-Commerce

**Versión:** 1.0  
**Última actualización:** 25 de enero de 2024

---

## Tabla de Contenidos

1. [Requisitos Previos](#requisitos-previos)
2. [Instalación del Backend](#instalación-del-backend)
3. [Instalación del Frontend](#instalación-del-frontend)
4. [Configuración de Base de Datos](#configuración-de-base-de-datos)
5. [Variables de Entorno](#variables-de-entorno)
6. [Iniciar Servidores](#iniciar-servidores)
7. [Testing Básico](#testing-básico)
8. [Troubleshooting](#troubleshooting)

---

## Requisitos Previos

### Software Requerido

| Software | Versión | Descripción |
|----------|---------|-------------|
| **PHP** | 8.3+ | Motor de backend |
| **Node.js** | 18.0+ | Runtime para npm y frontend |
| **npm** | 8.0+ | Gestor de paquetes JavaScript |
| **PostgreSQL** | 13.0+ | Base de datos |
| **Composer** | 2.0+ | Gestor de paquetes PHP |
| **Git** | 2.0+ | Control de versiones |

### Verificar Instalaciones

```bash
# PHP
php -v
# Debe mostrar: PHP X.X.X

# Node.js
node --version
# Debe mostrar: vX.X.X

# npm
npm --version
# Debe mostrar: X.X.X

# PostgreSQL
psql --version
# Debe mostrar: psql (PostgreSQL) X.X.X

// Testing en Frontend

```javascript
// En la consola del navegador
fetch('http://localhost:8000/api/v1/products')
composer --version
# Debe mostrar: Composer X.X.X

# Git
git --version
# Debe mostrar: git version X.X.X
```

### Instalación de Requisitos

#### Windows

**PHP 8:**
1. Descargar desde [php.net/downloads](https://www.php.net/downloads)
2. Extraer en `C:\php`
3. Agregar a `PATH`

**Node.js:**
1. Descargar desde [nodejs.org](https://nodejs.org/)
2. Instalar versión LTS
3. Verificar en PowerShell/CMD

**PostgreSQL:**
1. Descargar desde [postgresql.org](https://www.postgresql.org/download/)
2. Instalar con opciones por defecto
3. Recordar contraseña de `postgres`

**Composer:**
```bash
# Descargar e instalar
https://getcomposer.org/Composer-Setup.exe
```

#### macOS

```bash
# Usando Homebrew
brew install php@8.2
brew install node
brew install postgresql
brew install composer
```

#### Linux (Ubuntu/Debian)

```bash
# PHP
sudo apt-get update
sudo apt-get install php8.2 php8.2-fpm php8.2-pgsql php8.2-xml php8.2-curl

# Node.js
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt-get install -y nodejs

# PostgreSQL
sudo apt-get install postgresql postgresql-contrib

# Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```

---

## Instalación del Backend

### 1. Clonar Repositorio

```bash
# Clonar proyecto
git clone https://github.com/tuempresa/ind-maav-backend.git
cd ind-maav-backend

# O inicializar nuevo proyecto
mkdir ind-maav-backend
cd ind-maav-backend
git init
```

### 2. Crear Proyecto Laravel

```bash
# Si es un proyecto nuevo con Laravel
composer create-project laravel/laravel . --prefer-dist

# O instalar dependencias existentes
composer install
```

### 3. Configurar Archivo .env

```bash
# Copiar archivo de ejemplo
cp .env.example .env

# Generar APP_KEY
php artisan key:generate
```

### 4. Configurar .env (Valores Iniciales)

```env
APP_NAME="IND-MAAV"
APP_ENV=local
APP_KEY=base64:xxxxxxxxxxxxxxxxxxxxxxxxxxxxx
APP_DEBUG=true
APP_URL=http://localhost:8000

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

# Database
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=ind_maav
DB_USERNAME=postgres
DB_PASSWORD=password

# Mail
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=xxxxx
MAIL_PASSWORD=xxxxx
MAIL_FROM_ADDRESS=noreply@indmaav.com
MAIL_FROM_NAME="${APP_NAME}"

# Laravel Sanctum
# Laravel Sanctum se usa para autenticación de API token Bearer.
# No se requieren variables JWT adicionales en el `.env`.

# MercadoPago
MERCADOPAGO_ACCESS_TOKEN=APP_USR_XXXX
MERCADOPAGO_PUBLIC_KEY=APP_USR_XXXX
MERCADOPAGO_MODE=sandbox
MERCADOPAGO_WEBHOOK_URL=http://localhost:8000/api/v1/webhooks/mercadopago

# Frontend
FRONTEND_URL=http://localhost:3000
FRONTEND_CALLBACK_URL=http://localhost:3000/auth/callback

# AWS S3 (Opcional)
AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=ind-maav-uploads
```

### 5. Instalar Paquetes PHP

```bash
# Instalar dependencias de composer
composer install

# Laravel Sanctum ya está incluido en `backend/composer.json`
```

### 6. Estructura de Directorios Backend

```
backend/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php
│   │   │   ├── ProductController.php
│   │   │   ├── OrderController.php
│   │   │   ├── PaymentController.php
│   │   │   └── AdminController.php
│   │   ├── Middleware/
│   │   │   ├── Authenticate.php
│   │   │   └── CheckAdmin.php
│   │   └── Requests/
│   ├── Models/
│   │   ├── User.php
│   │   ├── Product.php
│   │   ├── Order.php
│   │   ├── Payment.php
│   │   └── ...
│   └── Services/
│       ├── MercadoPagoService.php
│       ├── PaymentService.php
│       └── ShippingService.php
├── database/
│   ├── migrations/
│   └── seeders/
├── routes/
│   └── api.php
├── storage/
├── .env
├── .env.example
└── composer.json
```

### 7. Migrar Base de Datos

Se verá en la siguiente sección.

---

## Instalación del Frontend

### 1. Crear Proyecto React

```bash
# Usar Vite (más rápido que CRA)
npm create vite@latest ind-maav-frontend -- --template react
cd ind-maav-frontend

# O usar Create React App
npx create-react-app ind-maav-frontend
cd ind-maav-frontend
```

### 2. Instalar Dependencias

```bash
npm install

# Dependencias principales
npm install axios react-router-dom zustand

# UI y Estilos
npm install @headlessui/react tailwindcss postcss autoprefixer

# Utilidades
npm install clsx date-fns js-cookie

# MercadoPago
npm install @mercadopago/sdk-js

# Desarrollo
npm install -D vite @vitejs/plugin-react
```

### 3. Configurar Tailwind CSS

```bash
# Instalar Tailwind
npm install -D tailwindcss postcss autoprefixer
npx tailwindcss init -p
```

**tailwind.config.js:**
```javascript
export default {
  content: [
    "./index.html",
    "./src/**/*.{js,jsx}",
  ],
  theme: {
    extend: {
      colors: {
        primary: '#2c3e50',
        secondary: '#e74c3c',
      },
    },
  },
  plugins: [],
}
```

### 4. Estructura de Directorios Frontend

```
frontend/
├── src/
│   ├── components/
│   │   ├── Navbar.jsx
│   │   ├── Footer.jsx
│   │   ├── ProductCard.jsx
│   │   ├── CartSidebar.jsx
│   │   └── ...
│   ├── pages/
│   │   ├── Home.jsx
│   │   ├── Products.jsx
│   │   ├── ProductDetail.jsx
│   │   ├── Cart.jsx
│   │   ├── Checkout.jsx
│   │   ├── Auth/
│   │   │   ├── Login.jsx
│   │   │   └── Register.jsx
│   │   └── ...
│   ├── services/
│   │   ├── api.js
│   │   ├── authService.js
│   │   ├── productService.js
│   │   └── paymentService.js
│   ├── stores/
│   │   ├── authStore.js
│   │   ├── cartStore.js
│   │   └── uiStore.js
│   ├── App.jsx
│   ├── main.jsx
│   └── index.css
├── public/
├── .env
├── .env.example
├── package.json
└── vite.config.js
```

### 5. Configurar Variables de Entorno Frontend

**.env:**
```env
VITE_API_URL=http://localhost:8000/api/v1
VITE_MERCADOPAGO_PUBLIC_KEY=APP_USR_XXXX
VITE_APP_NAME=IND-MAAV
```

---

## Configuración de Base de Datos

### 1. Crear Base de Datos

```bash
# Conectar a PostgreSQL
psql -U postgres

# En la consola de PostgreSQL
CREATE DATABASE ind_maav;
CREATE DATABASE ind_maav_test;

# Salir
\q
```

### 2. Ejecutar Migraciones

```bash
# En la carpeta del backend
php artisan migrate

# Con seed (datos iniciales)
php artisan migrate --seed

# O solo seed
php artisan db:seed
```

### 3. Crear Usuario Admin

```bash
# Ejecutar comando artisan
php artisan make:seeder AdminSeeder
```

**database/seeders/AdminSeeder.php:**
```php
<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'nombre' => 'Administrador',
            'email' => 'admin@indmaav.com',
            'password_hash' => Hash::make('admin123456'),
            'rol' => 'admin',
            'estado' => 'activo',
            'email_verificado' => true,
            'email_verificado_en' => now(),
        ]);
    }
}
?>
```

```bash
php artisan db:seed --class=AdminSeeder
```

---

## Variables de Entorno

### Backend (.env)

```env
# Aplicación
APP_NAME="IND-MAAV"
APP_ENV=local
APP_KEY=base64:xxxxx
APP_DEBUG=true
APP_URL=http://localhost:8000

# Base de Datos
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=ind_maav
DB_USERNAME=postgres
DB_PASSWORD=password

# Laravel Sanctum
# Laravel Sanctum se usa para autenticación de API token Bearer.
# No se requieren variables `JWT_*` en el `.env` cuando se usa Sanctum.

# Mail
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=xxxxx
MAIL_PASSWORD=xxxxx
MAIL_FROM_ADDRESS=noreply@indmaav.com

# MercadoPago
MERCADOPAGO_MODE=sandbox
MERCADOPAGO_ACCESS_TOKEN=APP_USR_XXXX
MERCADOPAGO_PUBLIC_KEY=APP_USR_XXXX
MERCADOPAGO_WEBHOOK_URL=http://localhost:8000/api/v1/webhooks/mercadopago

# Frontend
FRONTEND_URL=http://localhost:3000
CORS_ALLOWED_ORIGINS=http://localhost:3000
```

### Frontend (.env)

```env
VITE_API_URL=http://localhost:8000/api/v1
VITE_MERCADOPAGO_PUBLIC_KEY=APP_USR_XXXX
VITE_APP_NAME=IND-MAAV
VITE_STORAGE_URL=https://cdn.indmaav.com
```

---

## Iniciar Servidores

### Servidor Backend (PHP)

**Opción 1: Servidor incorporado de PHP**
```bash
# En la carpeta backend
php artisan serve

# Acceder a: http://localhost:8000
```

**Opción 2: Servidor con puerto específico**
```bash
php artisan serve --port=8001 --host=0.0.0.0
```

**Opción 3: Con Nginx o Apache**
```bash
# Ver documentación de Laravel
# https://laravel.com/docs/deployment
```

### Servidor Frontend (Node.js/React)

**Desarrollo con Vite:**
```bash
# En la carpeta frontend
npm run dev

# Acceder a: http://localhost:5173
```

**Desarrollo con Create React App:**
```bash
# En la carpeta frontend
npm start

# Acceder a: http://localhost:3000
```

### Comandos Útiles en Terminal

```bash
# Backend (en otra terminal/pestaña)
cd backend
php artisan serve

# Frontend (en otra terminal/pestaña)
cd frontend
npm run dev

# Base de datos (acceso psql)
psql -U postgres -d ind_maav
```

---

## Testing Básico

### 1. Registrar Usuario

```bash
curl -X POST http://localhost:8000/api/v1/auth/register \
  -H "Content-Type: application/json" \
  -d '{
    "nombre": "Juan Pérez",
    "email": "juan@example.com",
    "telefono": "+57 300 1234567",
    "password": "Segura1234!",
    "password_confirmation": "Segura1234!"
  }'
```

### 2. Login

```bash
curl -X POST http://localhost:8000/api/v1/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "juan@example.com",
    "password": "Segura1234!"
  }'
```

Guardar el token retornado.

### 3. Obtener Perfil

```bash
curl -X GET http://localhost:8000/api/v1/users/me \
  -H "Authorization: Bearer {token}"
```

### 4. Listar Productos

```bash
curl -X GET "http://localhost:8000/api/v1/products?page=1&per_page=12"
```

### 5. Crear producto de prueba (requiere autenticación)

```bash
curl -X POST http://localhost:8000/api/v1/products \
  -H "Authorization: Bearer {token}" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Producto de prueba",
    "description": "Descripción breve",
    "price": 125000,
    "weight_kg": 1.5,
    "dimensions_width_mm": 300,
    "dimensions_depth_mm": 200,
    "dimensions_height_mm": 150,
    "available_quantity": 10,
    "slug": "producto-de-prueba",
    "visible_public": true,
    "category_id": 1
  }'
```

### Testing en Frontend

```javascript
// En la consola del navegador
fetch('http://localhost:8000/api/v1/products')
  .then(r => r.json())
  .then(data => console.log(data))
```

---

## Troubleshooting

### Error: "SQLSTATE[08006]"

**Problema:** No puede conectarse a PostgreSQL  
**Soluciones:**
```bash
# Verificar que PostgreSQL esté corriendo
# Windows
# Services > PostgreSQL Database Server

# macOS
brew services list
brew services start postgresql

# Linux
sudo systemctl start postgresql
sudo systemctl status postgresql

# Verificar credenciales en .env
# Probar conexión
psql -U postgres -d ind_maav
```

### Error: "Port 8000 already in use"

```bash
# Cambiar puerto
php artisan serve --port=8001

# O matar el proceso (macOS/Linux)
lsof -ti:8000 | xargs kill -9

# O en Windows
netstat -ano | findstr :8000
taskkill /PID <PID> /F
```

### Error: "npm: command not found"

```bash
# Verificar instalación de Node.js
node --version
npm --version

# Si no está instalado, descargar desde nodejs.org
# O reinstalar
```

### Error: "Permission denied" en archivos

```bash
# macOS/Linux
chmod -R 755 storage bootstrap
chmod -R 777 storage/logs storage/framework

# o
sudo chown -R $USER:$USER .
```

### Error: "CORS error" entre frontend y backend

En **backend/config/cors.php:**
```php
'allowed_origins' => ['http://localhost:3000', 'http://localhost:5173'],
'allowed_methods' => ['*'],
'allowed_headers' => ['*'],
'exposed_headers' => [],
'max_age' => 0,
'supports_credentials' => true,
```

---

**Última actualización:** 25 de enero de 2024
