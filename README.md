# IND_MAAV — Enterprise-Grade Management System

[![Project Status: WIP](https://img.shields.io/badge/Project%20Status-Work%20In%20Progress-orange.svg)](https://github.com/jhorman14/IND_MAAV)
[![Backend](https://img.shields.io/badge/Backend-Laravel%2013-red.svg)](https://laravel.com)
[![Frontend](https://img.shields.io/badge/Frontend-React%2019-blue.svg)](https://react.dev)
[![Database](https://img.shields.io/badge/Database-PostgreSQL-darkblue.svg)](https://www.postgresql.org)

**IND_MAAV** es la plataforma oficial de comercio electrónico para la venta de muebles industriales. Con fuerte enfoque en backend, integridad de datos y diseño de APIs, está diseñada para gestionar el catálogo, el cálculo de envíos y el flujo de órdenes de una tienda online con una experiencia sólida y escalable.

---

## 📋 Contenido

- [Estado Actual](#-estado-actual)
- [Problema que resuelve](#-problema-que-resuelve)
- [Decisiones Técnicas](#-decisiones-técnicas)
- [Stack Tecnológico](#-stack-tecnológico)
- [Preview](#-preview)
- [Ejemplo de API](#-ejemplo-de-api)
- [Lo que demuestra este proyecto](#-lo-que-demuestra-este-proyecto)
- [Estructura del Proyecto](#-estructura-del-proyecto)
- [Requisitos](#-requisitos)
- [Instalación](#-instalación)
- [Documentación](#-documentación)
- [Roadmap](#-roadmap)
- [Contribución](#-contribución)
- [Sobre el desarrollador](#-sobre-el-desarrollador)
- [Licencia](#-licencia)

---

## 🚧 Estado Actual

*Progreso estimado:* ~20% de la visión global.

*Fase actual:* Configuración de proyecto, modelado de dominio y migraciones de base de datos.

**Progreso por capa:**
- Modelado de datos y migraciones: 40% de la capa backend.
- Proyecto Laravel base y configuración: 20%.
- Diseño de API y documentación técnica: 20%.
- Frontend React/Vite inicial: 5%.
- Endpoints funcionales, autenticación y UI real: 0%.

> El código actual incluye el esqueleto Laravel + React y el esquema de dominio en migraciones, pero todavía no tiene rutas API definidas ni controladores funcionales para las operaciones de negocio.

---

## 🖥️ Preview

> En progreso: capturas de pantalla y documentación visual del sistema.

---

## 🧩 Problema que resuelve

IND_MAAV es una tienda online de muebles industriales que busca digitalizar su catálogo, gestión de inventario y proceso de compra. El objetivo es ofrecer una experiencia de venta clara, eficiente y con control de envíos y pagos.

- Catálogo de productos y categorías con inventario controlado.
- Gestión de órdenes y seguimiento de envíos.
- Cálculo de tarifas de envío con zonas y reglas.
- Integración de pagos seguros para el checkout.
- Administración del catálogo y pedidos desde el backend.

### Usuario objetivo

- Clientes que buscan muebles industriales en línea.
- Operaciones internas de IND_MAAV para gestionar pedidos y envíos.

---

## 🏗️ Decisiones Técnicas

**Stack principal:** Laravel 13 + React 19 + PostgreSQL.

### Enfoque arquitectónico
- API-first con controladores delgados.
- Validación basada en Form Requests.
- Respuestas JSON normalizadas con API Resources.
- Eloquent tipado y relaciones claras.
- Separación fuerte entre lógica de negocio y transporte.

### Principios aplicados
- Integridad referencial y modelo relacional normalizado.
- Evitar `N+1` usando eager loading.
- Manejo de errores consistente y códigos HTTP semánticos.
- Seguridad sobre conveniencia: autenticación stateless y CORS controlado.

---

## 🛠️ Stack Tecnológico

| Capa | Tecnología | Comentario |
|------|------------|------------|
| **Backend** | PHP 8.3 / Laravel 13 | Proyecto base configurado |
| **Frontend** | React 19 | Plantilla Vite inicial |
| **Base de datos** | PostgreSQL | Modelo relacional con migraciones |
| **Autenticación** | Diseño para JWT | No implementada aún |
| **Pagos** | MercadoPago | Diseño documental existente |
| **Contenedores** | Docker | Opcional para desarrollo |

---

## 🔌 Ejemplo de API

### POST /api/v1/auth/login

Request:

```json
{
  "email": "user@example.com",
  "password": "Secret123!"
}
```

Response:

```json
{
  "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...",
  "user": {
    "id": 1,
    "name": "Juan Perez",
    "email": "user@example.com"
  }
}
```

### GET /api/v1/products

Response:

```json
[
  {
    "id": 12,
    "name": "Mesa industrial acero",
    "price": 1249000,
    "stock": 18,
    "category": "Mobiliario"
  }
]
```

### POST /api/v1/orders

Request:

```json
{
  "user_id": 1,
  "items": [
    { "product_id": 12, "quantity": 2 }
  ],
  "shipping_zone_id": 3,
  "payment_method": "mercadopago"
}
```

Response:

```json
{
  "id": 101,
  "status": "pending",
  "total": 2498000,
  "shipping_cost": 42000,
  "items_count": 2
}
```

---

## 🧠 Lo que demuestra este proyecto

- Modelado relacional en PostgreSQL con un esquema de dominio extensivo.
- Estructura de proyecto Laravel y React configurada.
- Documentación de diseño de API, flujos y base de datos.
- Migraciones iniciales para catálogo, órdenes, pagos, envíos, promociones y auditoría.
- En desarrollo: endpoints funcionales, autenticación JWT y UI real.

---

## 📁 Estructura del Proyecto

```text
backend/app/
├── Http/
│   ├── Controllers/
│   ├── Requests/
│   └── Resources/
├── Models/
└── Providers/
```

- `backend/`: backend Laravel, API y modelo de datos.
- `frontend/`: SPA React consumiendo la API.
- `docs/`: documentación técnica y de despliegue.

---

## 📦 Requisitos

- PHP 8.3+
- Composer 2+
- Node.js 18+
- npm 8+
- PostgreSQL 13+
- Git

---

## 🚀 Instalación

### Backend

```bash
cd backend
composer install
cp .env.example .env
php artisan key:generate
```

Configura la conexión a PostgreSQL en `.env`:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=ind_maav_db
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contrasena
```

```bash
php artisan migrate
php artisan serve
```

### Frontend

```bash
cd frontend
npm install
npm run dev
```

---

## 📚 Documentación

La documentación está en `/docs/`.

- `docs/API.md` — Endpoints REST.
- `docs/DATABASE.md` — Esquema y ER.
- `docs/MERCADOPAGO.md` — Integración de pagos.
- `docs/SETUP.md` — Guía de instalación.
- `docs/FLUJOS.md` — Flujos operativos.
- `docs/LEGAL.md` — Normativa y cumplimiento.
- `docs/DEPLOYMENT.md` — Despliegue en producción.

---

## 🎯 Roadmap

### Fase 1: Fundaciones
- [x] Configuración de entorno local.
- [x] Modelado de datos y migraciones.
- [x] Core de autenticación.
- [ ] Endpoints CRUD base.
- [ ] Pruebas iniciales.

### Fase 2: Consolidación Backend
- [ ] Control de acceso por roles (RBAC).
- [ ] Auditoría y logs estructurados.
- [ ] Optimización de queries.
- [ ] Cobertura de pruebas.

### Fase 3: Frontend & Integración
- [ ] Axios + interceptores de token.
- [ ] Estado global en React.
- [ ] Checkout completo.
- [ ] UI/UX responsive.

---

## 🤝 Contribución

1. Abre un issue describiendo tu propuesta.
2. Haz fork del repositorio.
3. Envía un pull request con cambios documentados.

---

## 👨‍💻 Sobre el desarrollador

Desarrollador en formación con enfoque en backend y diseño de APIs REST. Tengo experiencia práctica con Laravel, Spring Boot y entornos reales de desarrollo. Este proyecto refleja mi interés por construir sistemas escalables, bien estructurados y orientados a resolver problemas reales de negocio.

---

## 📄 Licencia

MIT.
