# Guía de Despliegue - IND_MAAV E-Commerce

**Versión:** 1.0  
**Última actualización:** 25 de enero de 2024

---

## Tabla de Contenidos

1. [Opciones de Despliegue](#opciones-de-despliegue)
2. [Despliegue en Shared Hosting](#despliegue-en-shared-hosting)
3. [Despliegue en VPS](#despliegue-en-vps)
4. [Despliegue con Docker](#despliegue-con-docker)
5. [Configuración de Dominio](#configuración-de-dominio)
6. [SSL y HTTPS](#ssl-y-https)
7. [Backups y Recuperación](#backups-y-recuperación)
8. [Monitoreo y Logs](#monitoreo-y-logs)

---

## Opciones de Despliegue

### Comparación de Plataformas

| Aspecto | Shared Hosting | VPS | Docker | Kubernetes |
|--------|---|---|---|---|
| **Costo** | $5-20/mes | $10-50/mes | $20-100/mes | $50-300/mes |
| **Control** | Bajo | Alto | Muy Alto | Muy Alto |
| **Complejidad** | Baja | Media | Alta | Muy Alta |
| **Escalabilidad** | Limitada | Buena | Excelente | Excelente |
| **Mantenimiento** | Proveedor | Propio | Propio | Propio |
| **Recomendado para** | Inicio | Producción | Crecimiento | Enterprise |

---

## Despliegue en Shared Hosting

### Proveedores Recomendados

- **Bluehost:** $2.95-$13.95/mes (incluye dominio)
- **Hostinger:** $2.99-$12.99/mes
- **SiteGround:** $3.99-$7.99/mes
- **DreamHost:** $2.59-$5.95/mes

### Paso 1: Contratar Hosting

1. Elegir plan con PHP 8+ y PostgreSQL/MySQL
2. Registrar dominio o transferir existente
3. Recibir acceso FTP y cPanel/Plesk

### Paso 2: Preparar Aplicación

```bash
# Clonar proyecto en carpeta local
git clone https://github.com/tuempresa/ind-maav.git
cd ind-maav

# Instalar dependencias PHP
composer install --no-dev --optimize-autoloader

# Instalar dependencias JavaScript
npm install --production

# Compilar assets frontend
npm run build

# Crear archivo .env para producción
cp .env.example .env.production
```

### Paso 3: Subir Archivos por FTP

```bash
# Opción 1: Con FileZilla (GUI)
# Conectar a servidor FTP
# Subir carpetas: backend/, frontend/dist/, public/

# Opción 2: Con comando scp (SSH)
scp -r backend/ usuario@dominio.com:/public_html/
scp -r frontend/dist/* usuario@dominio.com:/public_html/
```

### Paso 4: Configurar Base de Datos

1. Ir a cPanel > phpmyadmin
2. Crear base de datos `ind_maav`
3. Crear usuario con permisos
4. Ejecutar SQL de schema (DATABASE.md)

### Paso 5: Configurar .env

```env
APP_ENV=production
APP_KEY=base64:xxxxx
DEBUG=false

DB_CONNECTION=mysql
DB_HOST=localhost
DB_DATABASE=ind_maav
DB_USERNAME=usuario_db
DB_PASSWORD=contraseña_db

APP_URL=https://indmaav.com
FRONTEND_URL=https://indmaav.com

# Usamos Laravel Sanctum para autenticación de tokens.
# No es necesario configurar un `JWT_SECRET` para Sanctum.

MERCADOPAGO_MODE=production
MERCADOPAGO_ACCESS_TOKEN=APP_USR_XXXX
```

### Paso 6: Ejecutar Migraciones

```bash
# Conectar por SSH
ssh usuario@dominio.com

# Navegar a carpeta
cd public_html/backend

# Ejecutar migraciones
php artisan migrate --force

# Crear usuario admin
php artisan db:seed --class=AdminSeeder
```

### Paso 7: Configurar Punto de Entrada

En cPanel, configurar **Document Root** a `/public_html/public/`

### Consideraciones para Shared Hosting

✅ **Ventajas:**
- Bajo costo
- No requiere conocimientos sysadmin
- Soporte técnico incluido
- SSL automático

❌ **Desventajas:**
- Recursos limitados
- No escalable
- Puede ser lento
- Límites de ejecución

---

## Despliegue en VPS

### Proveedores Recomendados

- **DigitalOcean:** $6-96/mes
- **Linode:** $5-96/mes
- **AWS EC2:** $5-50/mes
- **Vultr:** $6-768/mes
- **Azure:** $10-50/mes

### Paso 1: Crear VPS

**DigitalOcean:**
1. Crear Droplet (Ubuntu 20.04 LTS, 2GB RAM)
2. SSH directamente
3. Configurar firewall

### Paso 2: Instalación de Stack

```bash
# Conectar SSH
ssh root@IP_SERVIDOR

# Actualizar sistema
apt-get update && apt-get upgrade -y

# Instalar PHP
apt-get install -y php8.2 php8.2-fpm php8.2-pgsql php8.2-xml php8.2-curl php8.2-zip

# Instalar PostgreSQL
apt-get install -y postgresql postgresql-contrib

# Instalar Node.js
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
apt-get install -y nodejs

# Instalar Nginx
apt-get install -y nginx

# Instalar Composer
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer

# Instalar certbot (SSL)
apt-get install -y certbot python3-certbot-nginx
```

### Paso 3: Configurar PostgreSQL

```bash
# Conectar a PostgreSQL
sudo -u postgres psql

# Crear base de datos
CREATE DATABASE ind_maav;

# Crear usuario
CREATE USER ind_maav WITH PASSWORD 'contraseña_muy_segura';

# Asignar permisos
ALTER ROLE ind_maav SET client_encoding TO 'utf8';
ALTER ROLE ind_maav SET default_transaction_isolation TO 'read committed';
ALTER ROLE ind_maav SET default_transaction_deferrable TO on;
ALTER ROLE ind_maav SET default_transaction_read_committed TO on;
GRANT ALL PRIVILEGES ON DATABASE ind_maav TO ind_maav;

# Salir
\q
```

### Paso 4: Configurar Nginx

**/etc/nginx/sites-available/indmaav.com:**
```nginx
server {
    listen 80;
    listen [::]:80;
    server_name indmaav.com www.indmaav.com;

    # Redirigir a HTTPS
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    listen [::]:443 ssl http2;
    server_name indmaav.com www.indmaav.com;

    # SSL
    ssl_certificate /etc/letsencrypt/live/indmaav.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/indmaav.com/privkey.pem;
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers HIGH:!aNULL:!MD5;

    # Frontend (React)
    root /var/www/indmaav/frontend/dist;
    index index.html;

    # Arquivos estáticos
    location ~* \.(js|css|png|jpg|jpeg|gif|ico|svg|woff|woff2|ttf|eot)$ {
        expires 30d;
        add_header Cache-Control "public, immutable";
    }

    # API Backend
    location /api/ {
        proxy_pass http://127.0.0.1:8000;
        proxy_http_version 1.1;
        proxy_set_header Upgrade $http_upgrade;
        proxy_set_header Connection 'upgrade';
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
        proxy_cache_bypass $http_upgrade;
    }

    # React SPA routing
    location / {
        try_files $uri $uri/ /index.html;
    }

    # Logs
    access_log /var/log/nginx/indmaav_access.log;
    error_log /var/log/nginx/indmaav_error.log;
}
```

### Paso 5: Activar Nginx

```bash
# Verificar sintaxis
nginx -t

# Habilitar sitio
ln -s /etc/nginx/sites-available/indmaav.com /etc/nginx/sites-enabled/

# Reiniciar Nginx
systemctl restart nginx
```

### Paso 6: Configurar SSL

```bash
# Generar certificado Let's Encrypt
certbot certonly --nginx -d indmaav.com -d www.indmaav.com

# Renovación automática
systemctl enable certbot.timer
systemctl start certbot.timer
```

### Paso 7: Desplegar Backend

```bash
# Crear carpeta de aplicación
mkdir -p /var/www/indmaav
cd /var/www/indmaav

# Clonar repositorio
git clone https://github.com/tuempresa/ind-maav-backend.git backend
cd backend

# Instalar dependencias
composer install --no-dev

# Crear .env
cp .env.example .env

# Generar clave
php artisan key:generate

# Migrar BD
php artisan migrate --force

# Crear usuario admin
php artisan db:seed --class=AdminSeeder

# Dar permisos
chown -R www-data:www-data /var/www/indmaav
chmod -R 755 /var/www/indmaav
chmod -R 777 /var/www/indmaav/storage
```

### Paso 8: Configurar PHP-FPM

**/etc/php/8.2/fpm/pool.d/www.conf:**
```ini
listen = /run/php/php8.2-fpm.sock
user = www-data
group = www-data
pm = dynamic
pm.max_children = 20
pm.start_servers = 5
pm.min_spare_servers = 5
pm.max_spare_servers = 10
```

```bash
systemctl restart php8.2-fpm
```

### Paso 9: Desplegar Frontend

```bash
cd /var/www/indmaav

# Clonar repositorio frontend
git clone https://github.com/tuempresa/ind-maav-frontend.git frontend_build
cd frontend_build

# Instalar y compilar
npm install
npm run build

# Copiar a carpeta web
cp -r dist/* /var/www/indmaav/frontend/dist/

# Permisos
chown -R www-data:www-data /var/www/indmaav/frontend
```

### Paso 10: Configurar Supervisor (opcional pero recomendado)

**/etc/supervisor/conf.d/laravel.conf:**
```ini
[program:laravel-queue]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/indmaav/backend/artisan queue:work
autostart=true
autorestart=true
numprocs=1
redirect_stderr=true
stdout_logfile=/var/log/laravel-queue.log
```

---

## Despliegue con Docker

### Instalación de Docker

**Ubuntu/Debian:**
```bash
curl -fsSL https://get.docker.com -o get-docker.sh
sudo sh get-docker.sh
sudo usermod -aG docker $USER
newgrp docker
```

### Dockerfile Backend

```dockerfile
FROM php:8.2-fpm

# Instalar dependencias
RUN apt-get update && apt-get install -y \
    postgresql-client \
    libpq-dev \
    git \
    curl \
    && docker-php-ext-install pdo_pgsql

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin --filename=composer

WORKDIR /app

# Copiar proyecto
COPY backend/ .

# Instalar dependencias PHP
RUN composer install --no-dev

# Permisos
RUN chown -R www-data:www-data /app/storage

EXPOSE 9000

CMD ["php-fpm"]
```

### Dockerfile Frontend

```dockerfile
FROM node:18 AS build

WORKDIR /app
COPY frontend/ .

RUN npm install
RUN npm run build

FROM nginx:latest

COPY --from=build /app/dist /usr/share/nginx/html

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
```

### docker-compose.yml

```yaml
version: '3.8'

services:
  database:
    image: postgres:15
    volumes:
      - postgres_data:/var/lib/postgresql/data
    environment:
      POSTGRES_DB: ind_maav
      POSTGRES_USER: ind_maav
      POSTGRES_PASSWORD: secure_password
    ports:
      - "5432:5432"

  backend:
    build:
      context: .
      dockerfile: Dockerfile.backend
    depends_on:
      - database
    environment:
      DB_CONNECTION: pgsql
      DB_HOST: database
      DB_PORT: 5432
      DB_DATABASE: ind_maav
      DB_USERNAME: ind_maav
      DB_PASSWORD: secure_password
      APP_ENV: production
      APP_KEY: base64:xxxxx
    ports:
      - "8000:9000"
    volumes:
      - ./backend:/app

  frontend:
    build:
      context: .
      dockerfile: Dockerfile.frontend
    ports:
      - "80:80"
    depends_on:
      - backend
    environment:
      VITE_API_URL: http://backend:8000/api/v1

  nginx:
    image: nginx:latest
    ports:
      - "443:443"
    volumes:
      - ./nginx.conf:/etc/nginx/nginx.conf
      - ./ssl:/etc/nginx/ssl
    depends_on:
      - backend
      - frontend

volumes:
  postgres_data:
```

### Ejecutar con Docker

```bash
# Construir imágenes
docker-compose build

# Iniciar servicios
docker-compose up -d

# Ver logs
docker-compose logs -f

# Ejecutar migraciones
docker-compose exec backend php artisan migrate

# Parar servicios
docker-compose down
```

---

## Configuración de Dominio

### DNS Configuration

En tu proveedor de dominio (GoDaddy, Namecheap, etc.):

**Registros A (Apuntar a IP del servidor):**
```
@  A  123.45.67.89
www A  123.45.67.89
```

**Registros CNAME (Opcional):**
```
api  CNAME  indmaav.com
cdn  CNAME  d32j8uc0hf.cloudfront.net
```

**Registros MX (Email):**
```
@  MX  10  mail.indmaav.com
@  MX  20  mail2.indmaav.com
```

---

## SSL y HTTPS

### Obtener Certificado Let's Encrypt

```bash
# Instalar Certbot
sudo apt-get install certbot python3-certbot-nginx

# Generar certificado
sudo certbot certonly --nginx -d indmaav.com

# Renovación automática
sudo systemctl enable certbot.timer
sudo systemctl start certbot.timer
```

### Forzar HTTPS

En **nginx.conf:**
```nginx
server {
    listen 80;
    server_name indmaav.com;
    return 301 https://$server_name$request_uri;
}
```

---

## Backups y Recuperación

### Backup de Base de Datos

```bash
# Backup manual
pg_dump -U ind_maav -h localhost ind_maav > backup_$(date +%Y%m%d).sql

# Programar con cron (Diario a las 2 AM)
0 2 * * * pg_dump -U ind_maav -h localhost ind_maav > /backups/ind_maav_$(date +\%Y\%m\%d).sql

# Backup con compresión
pg_dump -U ind_maav -F c -f backup_$(date +%Y%m%d).dump ind_maav
```

### Backup de Archivos

```bash
# Backup de código y storage
tar -czf backup_$(date +%Y%m%d).tar.gz /var/www/indmaav/

# Script de backup completo
#!/bin/bash
BACKUP_DIR="/backups"
DATE=$(date +%Y%m%d_%H%M%S)

# Backup BD
pg_dump -U ind_maav -h localhost ind_maav | gzip > $BACKUP_DIR/db_$DATE.sql.gz

# Backup archivos
tar -czf $BACKUP_DIR/files_$DATE.tar.gz /var/www/indmaav/

# Limpiar backups anteriores a 30 días
find $BACKUP_DIR -mtime +30 -delete

echo "Backup completado: $DATE"
```

### Restaurar Backups

```bash
# Restaurar BD
gunzip -c backup_20240125.sql.gz | psql -U ind_maav -h localhost ind_maav

# Restaurar archivos
tar -xzf backup_20240125.tar.gz -C /var/www/indmaav/
```

---

## Monitoreo y Logs

### Logs de Aplicación

**Backend (Laravel):**
```bash
# Ver logs en tiempo real
tail -f /var/www/indmaav/backend/storage/logs/laravel.log

# Errores únicamente
grep ERROR /var/www/indmaav/backend/storage/logs/laravel.log
```

**Nginx:**
```bash
tail -f /var/log/nginx/indmaav_error.log
tail -f /var/log/nginx/indmaav_access.log
```

**PostgreSQL:**
```bash
tail -f /var/log/postgresql/postgresql.log
```

### Monitoreo con Supervisor

```bash
# Ver estado
sudo supervisorctl status

# Recargar configuración
sudo supervisorctl reread
sudo supervisorctl update

# Ver logs
tail -f /var/log/laravel-queue.log
```

### Monitoreo de Recursos

```bash
# CPU y Memoria
top

# Disco
df -h

# Procesos
ps aux | grep php

# Conexiones BD
ps aux | grep postgres
```

---

**Última actualización:** 25 de enero de 2024

*Para más información sobre despliegue, consulta la documentación oficial de cada plataforma.*
