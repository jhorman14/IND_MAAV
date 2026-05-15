# API REST - IND_MAAV E-Commerce

**Versión:** 1.0  
**Base URL:** `https://api.indmaav.com/api/v1` (Producción) o `http://localhost:8000/api/v1` (Desarrollo)  
**Formato de respuesta:** JSON  
**Autenticación:** JWT (JSON Web Token)

---

## Tabla de Contenidos

1. [Autenticación](#autenticación)
2. [Usuarios](#usuarios)
3. [Productos](#productos)
4. [Categorías](#categorías)
5. [Carrito](#carrito)
6. [Órdenes](#órdenes)
7. [Pagos](#pagos)
8. [Envíos](#envíos)
9. [Admin](#admin)
10. [Códigos de Error](#códigos-de-error)

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
  "telefono": "+57 300 1234567",
  "password": "Segura1234!",
  "password_confirmation": "Segura1234!"
}
```

**Response (201):**
```json
{
  "success": true,
  "message": "Usuario registrado exitosamente",
  "data": {
    "id": "550e8400-e29b-41d4-a716-446655440000",
    "nombre": "Juan Pérez",
    "email": "juan@example.com",
    "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...",
    "token_type": "Bearer",
    "expires_in": 86400
  }
}
```

**Errores:**
- `400` - Email ya registrado
- `422` - Datos inválidos (validación fallida)

---

### Login

**POST** `/auth/login`

Autentica un usuario y retorna un token JWT.

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
- `404` - Usuario no encontrado

---

### Logout

**POST** `/auth/logout`

Cierra la sesión del usuario (requiere autenticación).

**Headers:**
```
Authorization: Bearer {token}
```

**Response (200):**
```json
{
  "success": true,
  "message": "Sesión cerrada exitosamente"
}
```

---

### Refresh Token

**POST** `/auth/refresh`

Obtiene un nuevo token JWT utilizando el token actual.

**Headers:**
```
Authorization: Bearer {token}
```

**Response (200):**
```json
{
  "success": true,
  "data": {
    "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...",
    "token_type": "Bearer",
    "expires_in": 86400
  }
}
```

---

## Usuarios

### Obtener Perfil Actual

**GET** `/usuarios/me`

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
    "telefono": "+57 300 1234567",
    "movil": "+57 310 5678901",
    "ubicacion_fisica": "Calle 10 #5-50, Bogotá",
    "direccion_envio": "Carrera 7 #50-20, Apto 501, Bogotá",
    "ciudad": "Bogotá",
    "departamento": "Cundinamarca",
    "codigo_postal": "110111",
    "pais": "Colombia",
    "creado_en": "2024-01-15T10:30:00Z",
    "actualizado_en": "2024-01-20T14:45:00Z"
  }
}
```

---

### Actualizar Perfil

**PUT** `/usuarios/me`

Actualiza la información del usuario autenticado.

**Headers:**
```
Authorization: Bearer {token}
Content-Type: application/json
```

**Request:**
```json
{
  "nombre": "Juan Carlos Pérez",
  "telefono": "+57 300 9876543",
  "movil": "+57 320 1234567",
  "ubicacion_fisica": "Oficina 502, Calle 10",
  "direccion_envio": "Carrera 7 #50-20, Apto 501",
  "ciudad": "Bogotá",
  "departamento": "Cundinamarca",
  "codigo_postal": "110111"
}
```

**Response (200):**
```json
{
  "success": true,
  "message": "Perfil actualizado exitosamente",
  "data": {
    "id": "550e8400-e29b-41d4-a716-446655440000",
    "nombre": "Juan Carlos Pérez",
    "telefono": "+57 300 9876543",
    "movil": "+57 320 1234567"
  }
}
```

---

### Cambiar Contraseña

**POST** `/usuarios/cambiar-password`

Cambia la contraseña del usuario autenticado.

**Headers:**
```
Authorization: Bearer {token}
```

**Request:**
```json
{
  "password_actual": "Segura1234!",
  "password_nueva": "NuevaSegura5678!",
  "password_confirmacion": "NuevaSegura5678!"
}
```

**Response (200):**
```json
{
  "success": true,
  "message": "Contraseña cambiada exitosamente"
}
```

**Errores:**
- `401` - Contraseña actual incorrecta
- `422` - Validación fallida

---

## Productos

### Listar Productos

**GET** `/productos`

Lista todos los productos con paginación y filtros.

**Query Parameters:**
| Parámetro | Tipo | Descripción |
|-----------|------|-------------|
| `page` | integer | Página (por defecto: 1) |
| `per_page` | integer | Items por página (por defecto: 12, máx: 100) |
| `categoria_id` | integer | Filtrar por categoría |
| `precio_min` | float | Precio mínimo |
| `precio_max` | float | Precio máximo |
| `buscar` | string | Búsqueda por nombre o descripción |
| `ordenar` | string | Ordenar por: `nombre`, `precio`, `creado_en` |
| `direccion` | string | Dirección: `asc`, `desc` |
| `disponible` | boolean | Solo productos disponibles |

**Ejemplo:**
```
GET /productos?page=1&per_page=12&categoria_id=1&precio_min=50000&precio_max=500000&ordenar=precio&direccion=asc
```

**Response (200):**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "nombre": "Escritorio Industrial Acero",
      "slug": "escritorio-industrial-acero",
      "descripcion": "Escritorio de acero con acabado negro mate",
      "precio": 185000,
      "precio_original": 220000,
      "descuento_porcentaje": 15.91,
      "cantidad_disponible": 25,
      "categoria_id": 1,
      "categoria_nombre": "Escritorios",
      "imagen_principal": "https://cdn.indmaav.com/productos/escritorio-industrial-1.jpg",
      "imagenes": [
        "https://cdn.indmaav.com/productos/escritorio-industrial-1.jpg",
        "https://cdn.indmaav.com/productos/escritorio-industrial-2.jpg"
      ],
      "calificacion_promedio": 4.8,
      "numero_resenas": 125,
      "disponible": true,
      "creado_en": "2024-01-10T08:00:00Z"
    }
  ],
  "pagination": {
    "total": 156,
    "per_page": 12,
    "current_page": 1,
    "last_page": 13,
    "from": 1,
    "to": 12
  }
}
```

---

### Obtener Producto por ID

**GET** `/productos/{id}`

Obtiene los detalles de un producto específico.

**Response (200):**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "nombre": "Escritorio Industrial Acero",
    "slug": "escritorio-industrial-acero",
    "descripcion": "Escritorio de acero con acabado negro mate, dimensiones 1.5m x 0.75m",
    "descripcion_detallada": "El escritorio industrial está fabricado con...",
    "precio": 185000,
    "precio_original": 220000,
    "descuento_porcentaje": 15.91,
    "cantidad_disponible": 25,
    "categoria_id": 1,
    "categoria_nombre": "Escritorios",
    "marca": "IND-Premium",
    "sku": "ESC-IND-001",
    "especificaciones": {
      "ancho": "1500 mm",
      "profundidad": "750 mm",
      "alto": "750 mm",
      "peso": "45 kg",
      "material": "Acero ASTM A36",
      "acabado": "Negro Mate"
    },
    "imagen_principal": "https://cdn.indmaav.com/productos/escritorio-industrial-1.jpg",
    "imagenes": [
      "https://cdn.indmaav.com/productos/escritorio-industrial-1.jpg",
      "https://cdn.indmaav.com/productos/escritorio-industrial-2.jpg",
      "https://cdn.indmaav.com/productos/escritorio-industrial-3.jpg"
    ],
    "calificacion_promedio": 4.8,
    "numero_resenas": 125,
    "resenas": [
      {
        "id": 1001,
        "usuario_nombre": "Carlos M.",
        "calificacion": 5,
        "titulo": "Excelente calidad",
        "comentario": "Producto de muy buena calidad, entrega rápida",
        "creado_en": "2024-01-20T10:00:00Z"
      }
    ],
    "disponible": true,
    "creado_en": "2024-01-10T08:00:00Z",
    "actualizado_en": "2024-01-25T12:30:00Z"
  }
}
```

---

### Buscar Productos

**GET** `/productos/buscar`

Búsqueda avanzada de productos.

**Query Parameters:**
| Parámetro | Tipo | Descripción |
|-----------|------|-------------|
| `q` | string | Término de búsqueda |
| `categorias` | string | IDs de categorías (separadas por comas) |
| `precio_min` | float | Precio mínimo |
| `precio_max` | float | Precio máximo |
| `disponible` | boolean | Solo disponibles |

**Response (200):**
```json
{
  "success": true,
  "data": {
    "resultados": 45,
    "productos": [
      {
        "id": 1,
        "nombre": "Escritorio Industrial Acero",
        "precio": 185000,
        "imagen_principal": "https://cdn.indmaav.com/productos/escritorio-industrial-1.jpg",
        "disponible": true
      }
    ],
    "sugerencias": [
      "Escritorio industrial",
      "Escritorio acero inoxidable"
    ]
  }
}
```

---

## Categorías

### Listar Categorías

**GET** `/categorias`

Lista todas las categorías disponibles.

**Response (200):**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "nombre": "Escritorios",
      "slug": "escritorios",
      "descripcion": "Escritorios industriales de acero",
      "icono": "fa-table",
      "imagen": "https://cdn.indmaav.com/categorias/escritorios.jpg",
      "numero_productos": 45,
      "orden": 1
    },
    {
      "id": 2,
      "nombre": "Estanterías",
      "slug": "estanterias",
      "descripcion": "Estanterías de almacenamiento",
      "icono": "fa-bars",
      "imagen": "https://cdn.indmaav.com/categorias/estanterias.jpg",
      "numero_productos": 32,
      "orden": 2
    }
  ]
}
```

---

## Carrito

### Obtener Carrito

**GET** `/carrito`

Obtiene el carrito del usuario autenticado.

**Headers:**
```
Authorization: Bearer {token}
```

**Response (200):**
```json
{
  "success": true,
  "data": {
    "id": "cart-001",
    "usuario_id": "550e8400-e29b-41d4-a716-446655440000",
    "items": [
      {
        "id": "cart-item-001",
        "producto_id": 1,
        "nombre_producto": "Escritorio Industrial Acero",
        "precio_unitario": 185000,
        "cantidad": 2,
        "subtotal": 370000,
        "imagen": "https://cdn.indmaav.com/productos/escritorio-industrial-1.jpg"
      }
    ],
    "subtotal": 370000,
    "impuesto_iva": 70300,
    "costo_envio": 0,
    "descuentos": 0,
    "total": 440300,
    "actualizado_en": "2024-01-25T14:30:00Z"
  }
}
```

---

### Agregar al Carrito

**POST** `/carrito/agregar`

Agrega un producto al carrito.

**Headers:**
```
Authorization: Bearer {token}
```

**Request:**
```json
{
  "producto_id": 1,
  "cantidad": 2
}
```

**Response (201):**
```json
{
  "success": true,
  "message": "Producto agregado al carrito",
  "data": {
    "id": "cart-item-001",
    "producto_id": 1,
    "cantidad": 2,
    "subtotal": 370000,
    "carrito_total": 440300
  }
}
```

**Errores:**
- `404` - Producto no encontrado
- `400` - Cantidad no disponible
- `422` - Datos inválidos

---

### Actualizar Item del Carrito

**PUT** `/carrito/items/{item_id}`

Actualiza la cantidad de un item en el carrito.

**Headers:**
```
Authorization: Bearer {token}
```

**Request:**
```json
{
  "cantidad": 3
}
```

**Response (200):**
```json
{
  "success": true,
  "message": "Item actualizado",
  "data": {
    "id": "cart-item-001",
    "cantidad": 3,
    "subtotal": 555000,
    "carrito_total": 625300
  }
}
```

---

### Eliminar Item del Carrito

**DELETE** `/carrito/items/{item_id}`

Elimina un item del carrito.

**Headers:**
```
Authorization: Bearer {token}
```

**Response (200):**
```json
{
  "success": true,
  "message": "Item eliminado del carrito",
  "data": {
    "carrito_total": 440300
  }
}
```

---

### Limpiar Carrito

**DELETE** `/carrito`

Vacía completamente el carrito.

**Headers:**
```
Authorization: Bearer {token}
```

**Response (200):**
```json
{
  "success": true,
  "message": "Carrito vaciado"
}
```

---

## Órdenes

### Crear Orden

**POST** `/ordenes`

Crea una nueva orden a partir del carrito.

**Headers:**
```
Authorization: Bearer {token}
```

**Request:**
```json
{
  "direccion_envio": "Carrera 7 #50-20, Apto 501",
  "ciudad_envio": "Bogotá",
  "departamento_envio": "Cundinamarca",
  "codigo_postal_envio": "110111",
  "telefono_contacto": "+57 300 1234567",
  "notas": "Dejar en portería después de las 2 PM",
  "tipo_envio": "express",
  "metodo_pago": "mercadopago"
}
```

**Response (201):**
```json
{
  "success": true,
  "message": "Orden creada exitosamente",
  "data": {
    "id": "ORD-2024-001001",
    "numero_orden": "001001",
    "usuario_id": "550e8400-e29b-41d4-a716-446655440000",
    "estado": "pendiente_pago",
    "subtotal": 370000,
    "impuesto_iva": 70300,
    "costo_envio": 25000,
    "total": 465300,
    "items": [
      {
        "id": 1,
        "producto_id": 1,
        "nombre_producto": "Escritorio Industrial Acero",
        "precio_unitario": 185000,
        "cantidad": 2,
        "subtotal": 370000
      }
    ],
    "direccion_envio": "Carrera 7 #50-20, Apto 501",
    "ciudad_envio": "Bogotá",
    "departamento_envio": "Cundinamarca",
    "tipo_envio": "express",
    "metodo_pago": "mercadopago",
    "preferencia_mp_id": "123456789",
    "creado_en": "2024-01-25T15:00:00Z"
  }
}
```

**Errores:**
- `400` - Carrito vacío
- `422` - Datos de envío inválidos
- `401` - Usuario no autenticado

---

### Listar Órdenes del Usuario

**GET** `/ordenes`

Lista todas las órdenes del usuario autenticado.

**Headers:**
```
Authorization: Bearer {token}
```

**Query Parameters:**
| Parámetro | Tipo | Descripción |
|-----------|------|-------------|
| `page` | integer | Página (por defecto: 1) |
| `per_page` | integer | Items por página (por defecto: 10) |
| `estado` | string | Filtrar por estado |

**Response (200):**
```json
{
  "success": true,
  "data": [
    {
      "id": "ORD-2024-001001",
      "numero_orden": "001001",
      "estado": "enviado",
      "total": 465300,
      "numero_items": 2,
      "fecha_creacion": "2024-01-25T15:00:00Z",
      "fecha_envio": "2024-01-26T10:30:00Z"
    }
  ],
  "pagination": {
    "total": 5,
    "per_page": 10,
    "current_page": 1,
    "last_page": 1
  }
}
```

---

### Obtener Orden por ID

**GET** `/ordenes/{id}`

Obtiene los detalles de una orden específica.

**Headers:**
```
Authorization: Bearer {token}
```

**Response (200):**
```json
{
  "success": true,
  "data": {
    "id": "ORD-2024-001001",
    "numero_orden": "001001",
    "usuario_id": "550e8400-e29b-41d4-a716-446655440000",
    "estado": "enviado",
    "subtotal": 370000,
    "impuesto_iva": 70300,
    "costo_envio": 25000,
    "total": 465300,
    "items": [
      {
        "id": 1,
        "producto_id": 1,
        "nombre_producto": "Escritorio Industrial Acero",
        "precio_unitario": 185000,
        "cantidad": 2,
        "subtotal": 370000
      }
    ],
    "direccion_envio": "Carrera 7 #50-20, Apto 501",
    "ciudad_envio": "Bogotá",
    "pago": {
      "id": "PAG-2024-001",
      "estado": "aprobado",
      "metodo": "mercadopago",
      "referencia_mp": "1234567890",
      "fecha_aprobacion": "2024-01-25T15:15:00Z"
    },
    "envio": {
      "tipo": "express",
      "numero_seguimiento": "TRK-2024-001001",
      "transportista": "Coordinadora",
      "estado": "en_transito",
      "fecha_envio": "2024-01-26T10:30:00Z"
    },
    "creado_en": "2024-01-25T15:00:00Z",
    "actualizado_en": "2024-01-26T12:00:00Z"
  }
}
```

---

### Cambiar Estado de Orden (Admin)

**PATCH** `/admin/ordenes/{id}/estado`

Cambia el estado de una orden (solo para administradores).

**Headers:**
```
Authorization: Bearer {token}
```

**Request:**
```json
{
  "estado": "enviado",
  "notas": "Orden ha sido enviada con Coordinadora",
  "numero_seguimiento": "TRK-2024-001001"
}
```

**Response (200):**
```json
{
  "success": true,
  "message": "Estado de orden actualizado",
  "data": {
    "id": "ORD-2024-001001",
    "estado": "enviado",
    "actualizado_en": "2024-01-26T10:30:00Z"
  }
}
```

---

## Pagos

### Crear Preferencia de Pago (MercadoPago)

**POST** `/pagos/crear-preferencia`

Crea una preferencia de pago en MercadoPago para una orden.

**Headers:**
```
Authorization: Bearer {token}
```

**Request:**
```json
{
  "orden_id": "ORD-2024-001001"
}
```

**Response (201):**
```json
{
  "success": true,
  "data": {
    "id": "1234567890",
    "init_point": "https://www.mercadopago.com/checkout/v1/redirect?pref_id=1234567890",
    "sandbox_init_point": "https://sandbox.mercadopago.com/checkout/v1/redirect?pref_id=1234567890",
    "items": [
      {
        "id": 1,
        "title": "Escritorio Industrial Acero",
        "quantity": 2,
        "unit_price": 185000,
        "currency_id": "COP",
        "picture_url": "https://cdn.indmaav.com/productos/escritorio-industrial-1.jpg"
      }
    ],
    "total": 465300,
    "additional_info": "Orden: ORD-2024-001001",
    "external_reference": "ORD-2024-001001"
  }
}
```

---

### Webhook de MercadoPago (IPN)

**POST** `/webhooks/mercadopago`

Endpoint para recibir notificaciones de MercadoPago.

**Request Headers:**
```
Content-Type: application/json
User-Agent: MercadoPago
```

**Request Body:**
```json
{
  "id": "12345",
  "live_mode": true,
  "type": "payment",
  "date_created": "2024-01-25T15:15:00Z",
  "user_id": 123456,
  "api_version": "v1",
  "action": "payment.created",
  "data": {
    "id": "1234567890"
  }
}
```

**Response (200):**
```json
{
  "success": true,
  "message": "Notificación procesada"
}
```

---

### Obtener Estado de Pago

**GET** `/pagos/{pago_id}/estado`

Obtiene el estado de un pago específico.

**Headers:**
```
Authorization: Bearer {token}
```

**Response (200):**
```json
{
  "success": true,
  "data": {
    "id": "PAG-2024-001",
    "orden_id": "ORD-2024-001001",
    "monto": 465300,
    "estado": "aprobado",
    "metodo": "mercadopago",
    "referencia_mp": "1234567890",
    "tipo_pago": "credit_card",
    "ultimos_4_digitos": "0123",
    "fecha_pago": "2024-01-25T15:15:00Z",
    "fecha_conciliacion": "2024-01-25T16:00:00Z"
  }
}
```

---

## Envíos

### Calcular Costo de Envío

**POST** `/envios/calcular-costo`

Calcula el costo de envío según destino y peso.

**Request:**
```json
{
  "ciudad_destino": "Bogotá",
  "departamento_destino": "Cundinamarca",
  "codigo_postal_destino": "110111",
  "peso_total_kg": 45,
  "tipo_envio": "express"
}
```

**Response (200):**
```json
{
  "success": true,
  "data": {
    "ciudad": "Bogotá",
    "departamento": "Cundinamarca",
    "peso_kg": 45,
    "tipo_envio": "express",
    "costo_base": 15000,
    "costo_por_kg_adicional": 250,
    "costo_total": 25000,
    "dias_entrega_estimados": 1,
    "transportista_disponibles": [
      {
        "nombre": "Coordinadora",
        "costo": 25000,
        "dias_entrega": 1
      },
      {
        "nombre": "TCC",
        "costo": 28000,
        "dias_entrega": 2
      }
    ]
  }
}
```

---

### Listar Zonas de Envío

**GET** `/envios/zonas`

Lista todas las zonas de envío disponibles.

**Response (200):**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "nombre": "Bogotá y área metropolitana",
      "departamento": "Cundinamarca",
      "ciudades": ["Bogotá", "Soacha", "Zipaquirá"],
      "costo_base_express": 15000,
      "costo_base_estandar": 12000,
      "dias_express": 1,
      "dias_estandar": 2
    }
  ]
}
```

---

## Admin

### Dashboard

**GET** `/admin/dashboard`

Obtiene estadísticas generales del e-commerce (solo admin).

**Headers:**
```
Authorization: Bearer {token_admin}
```

**Response (200):**
```json
{
  "success": true,
  "data": {
    "periodo": "2024-01",
    "metricas": {
      "ingresos_totales": 15450000,
      "ingresos_mes": 2850000,
      "ordenes_totales": 1250,
      "ordenes_mes": 156,
      "ordenes_pendientes": 12,
      "ordenes_completadas": 144,
      "clientes_totales": 890,
      "clientes_nuevos_mes": 45,
      "producto_mas_vendido": {
        "id": 1,
        "nombre": "Escritorio Industrial Acero",
        "unidades_vendidas": 245
      },
      "ticket_promedio": 18240,
      "tasa_conversion": 3.45
    }
  }
}
```

---

### Listar Órdenes (Admin)

**GET** `/admin/ordenes`

Lista todas las órdenes del sistema (solo admin).

**Query Parameters:**
| Parámetro | Tipo | Descripción |
|-----------|------|-------------|
| `page` | integer | Página (por defecto: 1) |
| `per_page` | integer | Items por página |
| `estado` | string | Filtrar por estado |
| `fecha_desde` | date | Fecha de inicio (YYYY-MM-DD) |
| `fecha_hasta` | date | Fecha de fin (YYYY-MM-DD) |
| `usuario_email` | string | Filtrar por email |

**Response (200):**
```json
{
  "success": true,
  "data": [
    {
      "id": "ORD-2024-001001",
      "numero_orden": "001001",
      "usuario": {
        "id": "550e8400-e29b-41d4-a716-446655440000",
        "nombre": "Juan Pérez",
        "email": "juan@example.com"
      },
      "total": 465300,
      "estado": "enviado",
      "metodo_pago": "mercadopago",
      "creado_en": "2024-01-25T15:00:00Z"
    }
  ],
  "pagination": {
    "total": 1250,
    "per_page": 10,
    "current_page": 1,
    "last_page": 125
  }
}
```

---

### Reportes de Ventas (Admin)

**GET** `/admin/reportes/ventas`

Genera reportes de ventas por período.

**Query Parameters:**
| Parámetro | Tipo | Descripción |
|-----------|------|-------------|
| `tipo` | string | `diario`, `semanal`, `mensual`, `anual` |
| `fecha_desde` | date | Fecha de inicio |
| `fecha_hasta` | date | Fecha de fin |
| `formato` | string | `json`, `csv`, `pdf` |

**Response (200):**
```json
{
  "success": true,
  "data": {
    "tipo": "mensual",
    "periodo": "2024-01",
    "datos": [
      {
        "fecha": "2024-01-01",
        "ordenes": 12,
        "ingresos": 185000,
        "promedio_orden": 15416
      }
    ],
    "totales": {
      "ordenes": 156,
      "ingresos": 2850000,
      "promedio_orden": 18270,
      "ticket_promedio_cierre": 18270
    }
  }
}
```

---

## Códigos de Error

| Código | Significado | Descripción |
|--------|-------------|-------------|
| `200` | OK | Solicitud exitosa |
| `201` | Created | Recurso creado exitosamente |
| `204` | No Content | Solicitud exitosa sin contenido |
| `400` | Bad Request | Solicitud mal formada o datos inválidos |
| `401` | Unauthorized | Autenticación requerida o token inválido |
| `403` | Forbidden | Acceso denegado (sin permisos) |
| `404` | Not Found | Recurso no encontrado |
| `409` | Conflict | Conflicto (ej: email duplicado) |
| `422` | Unprocessable Entity | Validación fallida |
| `429` | Too Many Requests | Demasiadas solicitudes (rate limit) |
| `500` | Internal Server Error | Error interno del servidor |
| `502` | Bad Gateway | Gateway inválido |
| `503` | Service Unavailable | Servicio no disponible |

---

## Headers Estándar

Todos los endpoints deben incluir estos headers en las request:

```
Accept: application/json
Content-Type: application/json
User-Agent: IND-MAAV-Client/1.0
X-Request-ID: {unique_id}
```

## Rate Limiting

- **Límite general:** 1000 requests por hora
- **Límite por endpoint:** 100 requests por minuto
- **Headers de respuesta:**
  ```
  X-RateLimit-Limit: 1000
  X-RateLimit-Remaining: 987
  X-RateLimit-Reset: 1706192400
  ```

---

**Última actualización:** 25 de enero de 2024  
**Versión de API:** 1.0
