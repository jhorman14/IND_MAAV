# Flujos y Procesos Críticos - IND_MAAV E-Commerce

**Versión:** 1.0  
**Última actualización:** 25 de enero de 2024

---

## Tabla de Contenidos

1. [Flujo de Registro de Usuario](#flujo-de-registro-de-usuario)
2. [Flujo de Compra](#flujo-de-compra)
3. [Flujo de Pago](#flujo-de-pago)
4. [Flujo de Cambio de Estado de Orden](#flujo-de-cambio-de-estado-de-orden)
5. [Flujo de Cálculo de Envíos](#flujo-de-cálculo-de-envíos)
6. [Flujo de Devolución y Reembolso](#flujo-de-devolución-y-reembolso)

---

## Flujo de Registro de Usuario

```mermaid
flowchart TD
    A[Usuario Accede a Registro] --> B[Completa Formulario]
    B --> C{Datos Válidos?}
    
    C -->|No| D[Mostrar Errores]
    D --> B
    
    C -->|Sí| E{Email ya Existe?}
    E -->|Sí| F[Mostrar: Email Duplicado]
    F --> B
    
    E -->|No| G[Hash Contraseña]
    G --> H[Crear Usuario en BD]
    H --> I{Creación Exitosa?}
    
    I -->|No| J[Error de Servidor]
    J --> K[Notificar Usuario]
    
    I -->|Sí| L[Generar token de acceso (Sanctum)]
    L --> M[Guardar Token en LocalStorage]
    M --> N[Enviar Email de Verificación]
    N --> O[Redirigir a Dashboard]
    O --> P[Usuario Registrado]
```

---

## Flujo de Compra

```mermaid
sequenceDiagram
    participant Usuario
    participant Frontend
    participant Backend
    participant BD
    
    Usuario->>Frontend: Navega a productos
    Frontend->>Backend: GET /products
    Backend->>BD: Consultar productos
    BD-->>Backend: Retorna listado
    Backend-->>Frontend: JSON (productos)
    Frontend-->>Usuario: Mostrar catálogo
    
    Usuario->>Frontend: Selecciona producto
    Frontend->>Backend: GET /products/1
    Backend->>BD: Consultar detalles
    BD-->>Backend: Datos producto
    Backend-->>Frontend: Detalles completos
    Frontend-->>Usuario: Mostrar detalles
    
    Usuario->>Frontend: Agrega al carrito
    Frontend->>Backend: (si existe) POST /cart/items
    Backend->>BD: Crear cart_item (si implementado)
    BD-->>Backend: Confirmación
    Backend-->>Frontend: Item agregado
    Frontend-->>Usuario: Carrito actualizado
    
    Usuario->>Frontend: Procede al checkout
    Frontend-->>Usuario: Mostrar resumen
    Usuario->>Frontend: Completa datos envío
    Frontend->>Backend: (si existe) POST /orders
    Backend->>BD: Crear orden
    Backend->>BD: Crear order_items
    BD-->>Backend: Orden creada
    Backend-->>Frontend: Número de orden
    Frontend-->>Usuario: Orden confirmada
```

---

## Flujo de Pago

```mermaid
graph LR
    A[Orden Creada] --> B[Estado: Pendiente Pago]
    B --> C[Usuario Hace Click Pagar]
    C --> D[Frontend Solicita Preferencia]
    D --> E[Backend Crea Preferencia MP]
    E --> F[MP Retorna Preference ID]
    F --> G[Frontend Abre Checkout MP]
    G --> H{Usuario Completa Pago?}
    
    H -->|Sí| I[MP Procesa Tarjeta]
    I --> J{Pago Aprobado?}
    
    J -->|Sí| K[MP Envía Webhook IPN]
    K --> L[Backend Recibe Notificación]
    L --> M[Obtiene Detalles de Pago]
    M --> N[Actualiza Estado: Pagado]
    N --> O[Registra en Payments]
    O --> P[Envía Email Confirmación]
    P --> Q[Usuario Redirigido a Éxito]
    
    J -->|No| R[Rechaza Pago]
    R --> S[Usuario Redirigido a Error]
    S --> T[Orden Sigue Pendiente]
    T --> U{Reintentar?}
    U -->|Sí| C
    U -->|No| V[Orden Cancelada]
    
    H -->|No| W[Usuario Abandona]
    W --> T
```

---

## Flujo de Cambio de Estado de Orden

```mermaid
stateDiagram-v2
    [*] --> pendiente_pago: Orden creada
    
    pendiente_pago --> pagado: Pago aprobado en MercadoPago
    
    pagado --> preparando: Admin inicia preparación
    pagado --> cancelado: Cliente solicita cancelación
    
    preparando --> enviado: Se genera envío/etiqueta
    preparando --> cancelado: Cliente solicita cancelación
    
    enviado --> entregado: Transportista confirma entrega
    
    entregado --> reembolsado: Cliente solicita devolución\n(Se procesa reembolso)
    
    cancelado --> reembolsado: Se procesa reembolso
    
    reembolsado --> [*]
    
    note right of pagado
        Estado inicial: Orden pagada y lista
        para preparación
    end note
    
    note right of preparando
        Se empacan productos
        Se generan etiquetas
    end note
    
    note right of enviado
        Transportista tiene paquete
        Cliente recibe número seguimiento
    end note
    
    note right of entregado
        Orden completada
        Puede solicitar devolución
    end note
```

---

## Transiciones de Estado (Detallado)

```mermaid
sequenceDiagram
    participant Admin
    participant Sistema
    participant Cliente
    
    Admin->>Sistema: PATCH /admin/ordenes/{id}/estado
    Sistema->>Sistema: Validar transición permitida
    
    alt Transición válida
        Sistema->>Sistema: Actualizar estado en BD
        Sistema->>Cliente: Enviar email con nuevo estado
        Sistema-->>Admin: 200 OK - Estado actualizado
        
    else Transición inválida
        Sistema-->>Admin: 400 - Transición no permitida
    end
```

---

## Flujo de Cálculo de Envíos

```mermaid
flowchart TD
    A[Usuario Ingresa Datos de Envío] --> B[Captura Ciudad, Departamento]
    B --> C[Calcula Peso Total del Carrito]
    C --> D[Solicita Costo: POST /envios/calcular-costo]
    
    D --> E[Backend Busca Zona de Envío]
    E --> F{¿Zona Encontrada?}
    
    F -->|No| G[Retorna Error: Zona No Cubierta]
    G --> H[Notifica al Usuario]
    
    F -->|Sí| I[Obtiene Tarifas de Zona]
    I --> J[Calcula: Costo Base + Kg Adicionales]
    
    J --> K[Valida Límites]
    K --> L{Peso Excede Máximo?}
    
    L -->|Sí| M[Retorna Error: Peso Excesivo]
    M --> H
    
    L -->|No| N[Cálculo Completado]
    N --> O[Retorna Opciones de Envío]
    O --> P[Express: Costo X, Días Y]
    O --> Q[Estándar: Costo Z, Días W]
    
    P --> R[Usuario Selecciona Tipo Envío]
    Q --> R
    R --> S[Actualiza Total de Carrito]
    S --> T[Continúa a Pago]
```

---

## Cálculo de Costos

```mermaid
graph TD
    A[Zona Destino] --> B[Búsqueda en shipping_zones]
    B --> C[Obtiene shipping_rates]
    
    C --> D{Tipo Envío}
    D -->|Express| E[Tarifa Express]
    D -->|Estándar| F[Tarifa Estándar]
    
    E --> G[Costo Unitario + Kg Extra]
    F --> G
    
    G --> H[Fórmula:<br/>Costo = Costo Base + Peso Total - Kg Base * Costo/kg]
    H --> I[Validar Peso Máximo]
    I --> J[Retornar Costo Final]
```

---

## Flujo de Devolución y Reembolso

```mermaid
sequenceDiagram
    participant Cliente
    participant Frontend
    participant Backend
    participant MP as MercadoPago
    
    Cliente->>Frontend: Solicita devolución
    Frontend->>Frontend: Muestra opciones
    
    Cliente->>Frontend: Ingresa motivo devolución
    Frontend->>Backend: POST /ordenes/{id}/devoluciones
    
    Backend->>Backend: Validar que orden fue entregada
    Backend->>Backend: Crear registro devolución
    Backend->>Backend: Cambiar estado a "En Devolución"
    Backend-->>Frontend: Devolución iniciada
    
    Frontend-->>Cliente: Mostrar instrucciones retorno
    Cliente->>Cliente: Retorna productos
    
    Cliente->>Frontend: Notifica que retornó
    Frontend->>Backend: PATCH /devoluciones/{id}/confirmar-retorno
    
    Backend->>Backend: Validar recepción
    Backend->>Backend: Cambiar estado a "Reembolso Pendiente"
    Backend->>MP: Crear reembolso
    MP-->>Backend: Reembolso procesado
    
    Backend->>Backend: Actualizar Payment estado reembolsado
    Backend->>Backend: Cambiar Order estado reembolsada
    Backend->>Cliente: Enviar email confirmación reembolso
    
    Backend-->>Frontend: 200 OK
    Frontend-->>Cliente: Reembolso completado
```

---

## Diagrama de Transacciones de BD

```mermaid
graph TD
    A[Crear Orden] --> B["Insert: orders"]
    B --> C["Insert: order_items"]
    C --> D["Create: cart_items deletion"]
    D --> E[Transacción Completada]
    
    F[Procesar Pago] --> G["Insert: payments"]
    G --> H["Update: orders estado"]
    H --> I["Update: activity_logs"]
    I --> J[Transacción Completada]
    
    K[Cancelar Orden] --> L["Update: orders estado = cancelado"]
    L --> M["Insert: audit_logs"]
    M --> N["Update: inventory"]
    N --> O[Transacción Completada]
```

---

## Estados y Eventos de Auditoría

| Evento | Tabla | Acción | Datos Registrados |
|--------|-------|--------|-------------------|
| Usuario Registrado | users | INSERT | nombre, email, rol |
| Pago Recibido | payments | INSERT | monto, estado, referencia_mp |
| Orden Actualizada | orders | UPDATE | estado anterior, nuevo estado |
| Producto Vendido | products | UPDATE | cantidad anterior, nueva cantidad |
| Devolución Iniciada | returns | INSERT | orden_id, motivo |

---

**Última actualización:** 25 de enero de 2024
