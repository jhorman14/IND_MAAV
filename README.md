# IND-MAAV | E-Commerce Muebles Industriales

**Una plataforma de comercio electrónico moderna, segura y escalable para la venta de muebles industriales en Colombia.**

![Version](https://img.shields.io/badge/version-1.0.0-blue.svg)
![License](https://img.shields.io/badge/license-MIT-green.svg)
![PHP](https://img.shields.io/badge/PHP-8.0%2B-777BB4.svg)
![React](https://img.shields.io/badge/React-18%2B-61DAFB.svg)
![PostgreSQL](https://img.shields.io/badge/PostgreSQL-13%2B-336791.svg)

---

## 📋 Tabla de Contenidos

- [Descripción](#-descripción)
- [Características](#-características)
- [Stack Tecnológico](#-stack-tecnológico)
- [Requisitos](#-requisitos)
- [Instalación Rápida](#-instalación-rápida)
- [Documentación](#-documentación)
- [Roadmap](#-roadmap)
- [Contribución](#-contribución)
- [Licencia](#-licencia)
- [Contacto](#-contacto)

---

## 📝 Descripción

**IND-MAAV** es una plataforma completa de e-commerce diseñada específicamente para la comercialización de muebles industriales en Colombia. Integra todas las funcionalidades necesarias para una operación de venta en línea profesional:

✅ Catálogo dinámico de productos  
✅ Carrito de compras inteligente  
✅ Integración con MercadoPago  
✅ Gestión de órdenes y entregas  
✅ Cálculo automático de envíos  
✅ Panel administrativo completo  
✅ Cumplimiento normativo colombiano  
✅ Responsive y moderno  

---

## ⭐ Características

### Para Clientes
- 🔐 Registro y autenticación segura con JWT
- 🛍️ Búsqueda avanzada y filtros de productos
- 🛒 Carrito persistente
- 💳 Integración con MercadoPago (tarjeta, PSE, efectivo)
- 📦 Seguimiento de órdenes en tiempo real
- 🚚 Cálculo automático de envíos
- 👤 Gestión de perfil y direcciones
- 📧 Notificaciones por email

### Para Administradores
- 📊 Dashboard con métricas en tiempo real
- 📦 Gestión completa de productos y categorías
- 📋 Administración de órdenes
- 💰 Reportes de ventas
- 📈 Análisis de comportamiento del cliente
- 🚚 Gestión de zonas y tarifas de envío
- 🏷️ Promociones y códigos descuento
- 🔍 Auditoría de cambios

### Técnicas
- API REST completa y documentada
- Autenticación JWT
- Rate limiting
- Logging y auditoría
- Seguridad CORS
- Encriptación de datos sensibles
- Manejo de errores robusto

---

## 🛠️ Stack Tecnológico

| Capa | Tecnología | Versión |
|------|-----------|---------|
| **Backend** | PHP + Laravel | 8.0+ |
| **Frontend** | React | 18.0+ |
| **Base de Datos** | PostgreSQL | 13.0+ |
| **Pagos** | MercadoPago API | v1 |
| **Autenticación** | JWT | HS256 |
| **Servidor** | Nginx / Apache | Latest |
| **Contenedorización** | Docker | 20.0+ |

### Dependencias Principales

**Backend:**
- laravel/framework
- tymon/jwt-auth
- spatie/laravel-query-builder
- spatie/laravel-activitylog
- mercadopago/dx-php

**Frontend:**
- react
- react-router-dom
- axios
- zustand
- tailwindcss
- @mercadopago/sdk-js

---

## 📦 Requisitos

### Previos

- **PHP** 8.0 o superior
- **Node.js** 16.0 o superior
- **npm** 8.0 o superior
- **PostgreSQL** 13.0 o superior
- **Composer** 2.0 o superior
- **Git** 2.0 o superior

### Sistema Operativo

- ✅ Windows 10+
- ✅ macOS 10.14+
- ✅ Linux (Ubuntu 18.04+, Debian 10+)

---

## 🚀 Instalación Rápida

### 1. Clonar Repositorio

```bash
git clone https://github.com/tuempresa/ind-maav.git
cd ind-maav
```

### 2. Configurar Backend

```bash
cd backend

# Instalar dependencias
composer install

# Copiar archivo de configuración
cp .env.example .env

# Generar clave de aplicación
php artisan key:generate

# Configurar base de datos en .env
# DB_HOST=localhost
# DB_DATABASE=ind_maav
# DB_USERNAME=postgres
# DB_PASSWORD=tu_password

# Ejecutar migraciones
php artisan migrate

# Iniciar servidor
php artisan serve
```

**Backend disponible en:** `http://localhost:8000`

### 3. Configurar Frontend

```bash
cd frontend

# Instalar dependencias
npm install

# Crear archivo de configuración
cp .env.example .env

# Iniciar servidor de desarrollo
npm run dev
```

**Frontend disponible en:** `http://localhost:5173`

### 4. Verificar Instalación

```bash
# Probar registro
curl -X POST http://localhost:8000/api/v1/auth/register \
  -H "Content-Type: application/json" \
  -d '{"nombre":"Test","email":"test@test.com","password":"Test1234!"}'

# Probar productos
curl http://localhost:8000/api/v1/productos
```

**✅ ¡Listo!** La plataforma está lista para usar.

---

## 📚 Documentación

Toda la documentación técnica está en la carpeta `/docs/`:

### Documentos Principales

| Documento | Descripción |
|-----------|-------------|
| [**API.md**](docs/API.md) | 📡 Documentación completa de endpoints REST |
| [**DATABASE.md**](docs/DATABASE.md) | 🗄️ Schema PostgreSQL y diagramas ER |
| [**MERCADOPAGO.md**](docs/MERCADOPAGO.md) | 💳 Guía de integración de pagos |
| [**SETUP.md**](docs/SETUP.md) | ⚙️ Instrucciones de instalación paso a paso |
| [**FLUJOS.md**](docs/FLUJOS.md) | 🔄 Diagramas de procesos y flujos críticos |
| [**LEGAL.md**](docs/LEGAL.md) | ⚖️ Términos, políticas y normativa colombiana |
| [**DEPLOYMENT.md**](docs/DEPLOYMENT.md) | 🌍 Guía de despliegue en producción |

---

## 🎯 Roadmap

### Fase 1: MVP (Enero 2024) ✅
- [x] Autenticación de usuarios
- [x] Catálogo de productos
- [x] Carrito de compras
- [x] Integración MercadoPago
- [x] Gestión básica de órdenes
- [x] API REST documentada

### Fase 2: Mejoras (Febrero-Marzo 2024)
- [ ] Panel administrativo completo
- [ ] Reportes avanzados
- [ ] Sistema de promociones
- [ ] Notificaciones por SMS
- [ ] Calificaciones de productos
- [ ] Wishlist / Favoritos

### Fase 3: Escalabilidad (Abril 2024)
- [ ] Caché Redis
- [ ] Búsqueda con Elasticsearch
- [ ] CDN para imágenes
- [ ] Microservicios
- [ ] Kubernetes
- [ ] App móvil (React Native)

### Fase 4: Optimización (Mayo-Junio 2024)
- [ ] PWA
- [ ] Análitica avanzada
- [ ] Integración redes sociales
- [ ] Chatbot de soporte
- [ ] Inteligencia artificial
- [ ] Blockchain para verificación

---

## 🔧 Comandos Útiles

### Backend

```bash
# Migraciones
php artisan migrate              # Ejecutar migraciones
php artisan migrate:rollback     # Deshacer migraciones
php artisan db:seed              # Poblar base de datos

# Caché y compilación
php artisan cache:clear
php artisan route:clear
php artisan config:clear
php artisan view:clear

# Testing
php artisan test
php artisan test --coverage

# Logs
tail -f storage/logs/laravel.log
```

### Frontend

```bash
# Desarrollo
npm run dev                       # Iniciar servidor
npm run build                     # Compilar para producción
npm run preview                   # Previsualizar build
npm run lint                      # Verificar código

# Testing
npm run test
npm run test:coverage
```

---

## 📊 Estructura del Proyecto

```
ind-maav/
├── backend/                      # API REST (Laravel)
│   ├── app/
│   │   ├── Http/Controllers/
│   │   ├── Models/
│   │   └── Services/
│   ├── database/
│   │   ├── migrations/
│   │   └── seeders/
│   ├── routes/
│   └── storage/
├── frontend/                     # SPA (React)
│   ├── src/
│   │   ├── components/
│   │   ├── pages/
│   │   ├── services/
│   │   └── stores/
│   ├── public/
│   └── dist/
├── docs/                         # Documentación
│   ├── API.md
│   ├── DATABASE.md
│   ├── MERCADOPAGO.md
│   ├── SETUP.md
│   ├── FLUJOS.md
│   ├── LEGAL.md
│   └── DEPLOYMENT.md
├── docker/                       # Configuración Docker
├── .gitignore
└── README.md
```

---

## 🔐 Seguridad

Esta plataforma implementa múltiples capas de seguridad:

- ✅ **Autenticación JWT** - Tokens seguros con expiración
- ✅ **Encriptación HTTPS/SSL** - Todo el tráfico cifrado
- ✅ **Protección CORS** - Solo orígenes permitidos
- ✅ **Rate Limiting** - Prevención de ataques
- ✅ **Validación de Entrada** - Sanitización de datos
- ✅ **CSRF Protection** - Tokens anti-CSRF
- ✅ **SQL Injection Prevention** - ORM y prepared statements
- ✅ **Logging y Auditoría** - Registro de cambios críticos
- ✅ **Secrets Management** - Variables de entorno
- ✅ **Password Hashing** - Algoritmo bcrypt

---

## 📞 Contacto y Soporte

**IND-MAAV S.A.S.**
- 🌐 Website: [www.indmaav.com](https://www.indmaav.com)
- 📧 Email: contacto@indmaav.com
- 📞 Teléfono: +57 (1) 1234-5678
- 💬 WhatsApp: +57 320 1234567
- 🏢 Oficina: Bogotá, D.C., Colombia

### Horario de Atención
**Lunes a Viernes:** 8:00 AM - 5:00 PM  
**Sábados:** 9:00 AM - 1:00 PM  
**Domingos:** Cerrado

---

## 🤝 Contribución

Las contribuciones son bienvenidas. Por favor:

1. Fork el proyecto
2. Crea una rama (`git checkout -b feature/AmazingFeature`)
3. Commit cambios (`git commit -m 'Add AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abre un Pull Request

---

## 📄 Licencia

Este proyecto está bajo la licencia **MIT**. Ver archivo [LICENSE](LICENSE) para más detalles.

---

## ⚖️ Aviso Legal

Esta plataforma cumple con la normativa colombiana aplicable:

- ✅ Ley 1480/2011 - Estatuto del Consumidor
- ✅ Ley 1581/2012 - Protección de Datos Personales
- ✅ Decreto 1377/2013 - Reglamentación LPDP
- ✅ Ley 1831/2017 - Comercio Electrónico

Ver [LEGAL.md](docs/LEGAL.md) para términos y condiciones completos.

---

## 📈 Estadísticas del Proyecto

![GitHub Stars](https://img.shields.io/github/stars/tuempresa/ind-maav?style=social)
![GitHub Forks](https://img.shields.io/github/forks/tuempresa/ind-maav?style=social)
![GitHub Issues](https://img.shields.io/github/issues/tuempresa/ind-maav)
![GitHub Pull Requests](https://img.shields.io/github/pulls/tuempresa/ind-maav)

---

**Última actualización:** 25 de enero de 2024  
**Versión:** 1.0.0  
**Estado:** ✅ Producción
