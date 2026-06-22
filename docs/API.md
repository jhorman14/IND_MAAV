# API REST - IND_MAAV E-Commerce

> Documentación actualizada con los endpoints implementados en `backend/routes/api.php`.
> El backend usa Laravel Sanctum para autenticación Bearer y nombres internos de campos en inglés.

**Versión:** 1.0  
**Base URL:** `http://localhost:8000/api/v1`  
**Formato de respuesta:** JSON  
**Autenticación:** Laravel Sanctum Bearer token

---

## Tabla de Contenidos

1. [Autenticación](#autenticación)
2. [Usuario autenticado](#usuario-autenticado)
3. [Productos](#productos)
4. [Notas generales](#notas-generales)

---

## Autenticación

### Registro de Usuario

**POST** `/auth/register`

Registra un nuevo usuario en el sistema.

**Request:**
```json
{
  "nombre": "Juan Pérez",
  "email": "juan@example.com",
  "password": "Segura1234!",
  "password_confirmation": "Segura1234!"
}
```

**Response (201):**
```json
{
  "success": true,
  "data": {
    "id": "550e8400-e29b-41d4-a716-446655440000",
    "nombre": "Juan Pérez",
    "email": "juan@example.com",
    "rol": "customer",
    "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...",
    "token_type": "Bearer",
    "expires_in": 86400
  }
}
```

**Errores:**
- `422` - Validación fallida
- `400` - Email ya registrado

---

### Login

**POST** `/auth/login`

Autentica un usuario y retorna un token Bearer.

**Request:**
```json
{
  "email": "juan@example.com",
  "password": "Segura1234!"
}
```

**Response (200):**
```json
{
  "success": true,
  "data": {
    "id": "550e8400-e29b-41d4-a716-446655440000",
    "nombre": "Juan Pérez",
    "email": "juan@example.com",
    "rol": "customer",
    "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...",
    "token_type": "Bearer",
    "expires_in": 86400
  }
}
```

**Errores:**
- `401` - Credenciales inválidas

---

### Logout

**POST** `/auth/logout`

Cierra la sesión del usuario autenticado.

**Headers:**
```
Authorization: Bearer {token}
```

**Response (200):**
```json
{
  "success": true,
  "message": "Sesión cerrada correctamente"
}
```

---

## Usuario autenticado

### Obtener perfil actual

**GET** `/users/me`

Obtiene la información del usuario autenticado.

**Headers:**
```
Authorization: Bearer {token}
```

**Response (200):**
```json
{
  "success": true,
  "data": {
    "id": "550e8400-e29b-41d4-a716-446655440000",
    "nombre": "Juan Pérez",
    "email": "juan@example.com",
    "rol": "customer",
    "telefono": "+57 300 1234567",
    "movil": "+57 310 5678901",
    "ubicacion_fisica": "Calle 10 #5-50, Bogotá"
  }
}
```

---

## Productos

### Listar productos

**GET** `/products`

Lista productos públicos paginados.

**Query params:**
- `per_page` (opcional, default `12`)

**Response (200):**
```json
{
  "data": [
    {
      "id": 1,
      "nombre": "Producto de ejemplo",
      "descripcion": "Descripción corta",
      "precio": 199900.00,
      "peso": 1.25,
      "dimensiones": {
        "ancho_mm": 300,
        "profundidad_mm": 200,
        "alto_mm": 150
      },
      "stock": 20,
      "seo_slug": "producto-de-ejemplo",
      "activo": true,
      "categoria": {
        "id": 2,
        "nombre": "Categoría"
      },
      "created_at": "2026-06-22T12:00:00",
      "updated_at": "2026-06-22T12:00:00"
    }
  ],
  "links": { ... },
  "meta": { ... }
}
```

### Ver producto

**GET** `/products/{product}`

Obtiene detalle de un producto.

**Response (200):**
```json
{
  "data": {
    "id": 1,
    "nombre": "Producto de ejemplo",
    "descripcion": "Descripción corta",
    "precio": 199900.00,
    "peso": 1.25,
    "dimensiones": {
      "ancho_mm": 300,
      "profundidad_mm": 200,
      "alto_mm": 150
    },
    "stock": 20,
    "seo_slug": "producto-de-ejemplo",
    "activo": true,
    "categoria": {
      "id": 2,
      "nombre": "Categoría"
    },
    "created_at": "2026-06-22T12:00:00",
    "updated_at": "2026-06-22T12:00:00"
  }
}
```

### Crear producto

**POST** `/products`

Requiere autenticación.

**Headers:**
```
Authorization: Bearer {token}
Content-Type: application/json
```

**Request:**
```json
{
  "name": "Nuevo producto",
  "description": "Descripción del producto",
  "price": 125000,
  "weight_kg": 1.5,
  "dimensions_width_mm": 300,
  "dimensions_depth_mm": 200,
  "dimensions_height_mm": 150,
  "available_quantity": 50,
  "slug": "nuevo-producto",
  "visible_public": true,
  "category_id": 2
}
```

**Response (201):**
```json
{
  "data": {
    "id": 10,
    "nombre": "Nuevo producto",
    "descripcion": "Descripción del producto",
    "precio": 125000.00,
    "peso": 1.5,
    "dimensiones": {
      "ancho_mm": 300,
      "profundidad_mm": 200,
      "alto_mm": 150
    },
    "stock": 50,
    "seo_slug": "nuevo-producto",
    "activo": true,
    "categoria": {
      "id": 2,
      "nombre": "Categoría"
    },
    "created_at": "2026-06-22T12:00:00",
    "updated_at": "2026-06-22T12:00:00"
  }
}
```

### Actualizar producto

**PUT** `/products/{product}`

Requiere autenticación.

**Request:**
```json
{
  "price": 130000,
  "available_quantity": 40
}
```

**Response (200):**
Devuelve el producto actualizado.

### Eliminar producto

**DELETE** `/products/{product}`

Requiere autenticación.

**Response (204):**
Sin contenido.

---

## Notas generales

- El backend utiliza Laravel Sanctum para autenticación de token Bearer.
- Internamente, la base de datos y los requests usan nombres de campos en inglés.
- Las respuestas JSON del frontend pueden mapear esos campos a claves en español para el frontend.
- Rutas implementadas: `/auth/register`, `/auth/login`, `/auth/logout`, `/users/me`, `/products`, `/products/{product}`.
