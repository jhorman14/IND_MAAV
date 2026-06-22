# Base de Datos - IND_MAAV E-Commerce

El esquema de base de datos se define en las migraciones de Laravel dentro de `backend/database/migrations`.
Las tablas usan nombres internos en inglés y campos en `snake_case`.

## Tablas principales

### users
- `id` UUID PK
- `name` VARCHAR
- `email` VARCHAR UNIQUE
- `password` VARCHAR
- `phone` VARCHAR
- `mobile` VARCHAR
- `physical_address` VARCHAR
- `role` ENUM('customer','admin','vendor')
- `status` ENUM('active','inactive','blocked')
- `email_verified` BOOLEAN
- `email_verified_at` TIMESTAMP
- `last_login_at` TIMESTAMP
- `password_reset_token` VARCHAR
- `password_reset_expires_at` TIMESTAMP
- `created_at` TIMESTAMP
- `updated_at` TIMESTAMP
- `deleted_at` TIMESTAMP

### user_addresses
- `id` UUID PK
- `user_id` UUID FK -> users(id)
- `type` ENUM('shipping','billing','other')
- `address_name` VARCHAR
- `address` VARCHAR
- `city` VARCHAR
- `state` VARCHAR
- `postal_code` VARCHAR
- `country` VARCHAR
- `is_default` BOOLEAN
- `notes` TEXT
- `created_at` TIMESTAMP
- `updated_at` TIMESTAMP

### categories
- `id` SERIAL PK
- `name` VARCHAR UNIQUE
- `slug` VARCHAR UNIQUE
- `description` TEXT
- `icon` VARCHAR
- `image` VARCHAR
- `parent_category_id` INT FK -> categories(id)
- `order` INT
- `status` ENUM('active','inactive')
- `created_at` TIMESTAMP
- `updated_at` TIMESTAMP

### products
- `id` SERIAL PK
- `name` VARCHAR
- `slug` VARCHAR UNIQUE
- `description` TEXT
- `long_description` TEXT
- `category_id` INT FK -> categories(id)
- `brand` VARCHAR
- `sku` VARCHAR UNIQUE
- `price` DECIMAL
- `original_price` DECIMAL
- `available_quantity` INT
- `min_purchase_quantity` INT
- `average_rating` DECIMAL
- `reviews_count` INT
- `status` ENUM('active','inactive','discontinued')
- `visible_public` BOOLEAN
- `weight_kg` DECIMAL
- `dimensions_width_mm` INT
- `dimensions_depth_mm` INT
- `dimensions_height_mm` INT
- `material` VARCHAR
- `finish` VARCHAR
- `created_at` TIMESTAMP
- `updated_at` TIMESTAMP
- `deleted_at` TIMESTAMP

### product_images
- `id` SERIAL PK
- `product_id` INT FK -> products(id)
- `url` VARCHAR
- `is_primary` BOOLEAN
- `position` INT
- `alt_text` VARCHAR
- `created_at` TIMESTAMP

### product_specifications
- `id` SERIAL PK
- `product_id` INT FK -> products(id)
- `specification_name` VARCHAR
- `specification_value` VARCHAR
- `position` INT

### cart_items
- `id` UUID PK
- `user_id` UUID FK -> users(id)
- `product_id` INT FK -> products(id)
- `quantity` INT
- `price_snapshot` DECIMAL
- `created_at` TIMESTAMP
- `updated_at` TIMESTAMP

### promotions
- `id` SERIAL PK
- `code` VARCHAR UNIQUE
- `name` VARCHAR
- `description` TEXT
- `discount_type` ENUM('percentage','fixed_amount','free_shipping')
- `discount_value` DECIMAL
- `max_uses` INT
- `uses_count` INT
- `minimum_purchase` DECIMAL
- `starts_at` DATE
- `ends_at` DATE
- `is_active` BOOLEAN
- `created_at` TIMESTAMP
- `updated_at` TIMESTAMP

### promotion_items
- `id` SERIAL PK
- `promotion_id` INT FK -> promotions(id)
- `order_id` UUID FK -> orders(id)
- `discount_amount` DECIMAL
- `created_at` TIMESTAMP
- `updated_at` TIMESTAMP

### user_coupons
- `id` SERIAL PK
- `user_id` UUID FK -> users(id)
- `promotion_id` INT FK -> promotions(id)
- `used` BOOLEAN
- `used_at` TIMESTAMP
- `order_id` UUID FK -> orders(id)
- `created_at` TIMESTAMP

### orders
- `id` UUID PK
- `order_number` VARCHAR UNIQUE
- `user_id` UUID FK -> users(id)
- `customer_name` VARCHAR
- `customer_email` VARCHAR
- `status` ENUM('pending_payment','paid','processing','shipped','delivered','cancelled','refunded')
- `subtotal` DECIMAL
- `tax` DECIMAL
- `discount` DECIMAL
- `shipping_cost` DECIMAL
- `total` DECIMAL
- `billing_address` VARCHAR
- `billing_city` VARCHAR
- `billing_state` VARCHAR
- `shipping_type` VARCHAR
- `created_at` TIMESTAMP
- `updated_at` TIMESTAMP

### order_items
- `id` SERIAL PK
- `order_id` UUID FK -> orders(id)
- `product_id` INT FK -> products(id)
- `quantity` INT
- `unit_price` DECIMAL
- `subtotal` DECIMAL
- `created_at` TIMESTAMP
- `updated_at` TIMESTAMP

### payments
- `id` UUID PK
- `order_id` UUID FK -> orders(id)
- `customer_email` VARCHAR
- `amount` DECIMAL
- `currency` VARCHAR
- `status` ENUM('pending','approved','rejected','cancelled','refunded')
- `payment_method` VARCHAR
- `external_reference` VARCHAR
- `mercadopago_reference` VARCHAR
- `last_four` VARCHAR
- `bank` VARCHAR
- `paid_at` TIMESTAMP
- `reconciled_at` TIMESTAMP
- `error_note` TEXT
- `created_at` TIMESTAMP
- `updated_at` TIMESTAMP

### shipping_zones
- `id` SERIAL PK
- `name` VARCHAR UNIQUE
- `description` TEXT
- `geographic_coverage` TEXT
- `is_active` BOOLEAN
- `created_at` TIMESTAMP
- `updated_at` TIMESTAMP

### shipping_rates
- `id` SERIAL PK
- `zone_id` INT FK -> shipping_zones(id)
- `cost` DECIMAL
- `minimum_weight` DECIMAL
- `maximum_weight` DECIMAL
- `delivery_time_days` INT
- `is_active` BOOLEAN
- `created_at` TIMESTAMP
- `updated_at` TIMESTAMP

### shipments
- `id` UUID PK
- `order_id` UUID FK -> orders(id)
- `tracking_number` VARCHAR UNIQUE
- `courier` VARCHAR
- `shipping_status` ENUM('pending','in_transit','delivered','returned','delayed')
- `delivery_address` VARCHAR
- `delivery_city` VARCHAR
- `delivery_state` VARCHAR
- `shipped_at` TIMESTAMP
- `estimated_delivery_at` TIMESTAMP
- `delivered_at` TIMESTAMP
- `notes` TEXT
- `created_at` TIMESTAMP
- `updated_at` TIMESTAMP

### returns
- `id` UUID PK
- `order_id` UUID FK -> orders(id)
- `user_id` UUID FK -> users(id)
- `reason` VARCHAR
- `description` TEXT
- `status` ENUM('requested','approved','rejected','received','processed')
- `requested_at` TIMESTAMP
- `received_at` TIMESTAMP
- `processed_at` TIMESTAMP
- `refund_amount` DECIMAL
- `admin_notes` TEXT
- `created_at` TIMESTAMP
- `updated_at` TIMESTAMP

### reviews
- `id` SERIAL PK
- `product_id` INT FK -> products(id)
- `user_id` UUID FK -> users(id)
- `order_id` UUID FK -> orders(id)
- `rating` INT
- `title` VARCHAR
- `comment` TEXT
- `verified_purchase` BOOLEAN
- `created_at` TIMESTAMP
- `updated_at` TIMESTAMP

### order_state_history
- `id` SERIAL PK
- `order_id` UUID FK -> orders(id)
- `previous_status` VARCHAR
- `new_status` VARCHAR
- `user_id` UUID FK -> users(id)
- `comment` TEXT
- `created_at` TIMESTAMP
- `updated_at` TIMESTAMP

### inventory_movements
- `id` SERIAL PK
- `product_id` INT FK -> products(id)
- `previous_quantity` INT
- `new_quantity` INT
- `moved_quantity` INT
- `reason` ENUM('purchase','return','manual_adjustment','loss','stock_entry')
- `reference_id` VARCHAR
- `reference_type` VARCHAR
- `user_id` UUID FK -> users(id)
- `notes` TEXT
- `created_at` TIMESTAMP
- `updated_at` TIMESTAMP

### wishlists
- `id` UUID PK
- `user_id` UUID FK -> users(id)
- `product_id` INT FK -> products(id)
- `created_at` TIMESTAMP
- `updated_at` TIMESTAMP

### activity_logs
- `id` SERIAL PK
- `user_id` UUID FK -> users(id)
- `activity_type` VARCHAR
- `description` TEXT
- `entity_type` VARCHAR
- `entity_id` VARCHAR
- `client_ip` VARCHAR
- `user_agent` TEXT
- `created_at` TIMESTAMP
- `updated_at` TIMESTAMP

### audit_logs
- `id` SERIAL PK
- `user_id` UUID FK -> users(id)
- `table_name` VARCHAR
- `record_id` VARCHAR
- `operation_type` VARCHAR
- `previous_data` JSON
- `new_data` JSON
- `client_ip` VARCHAR
- `user_agent` TEXT
- `created_at` TIMESTAMP
- `updated_at` TIMESTAMP

## Relaciones principales

- `users` 1:N `user_addresses`
- `users` 1:N `orders`
- `users` 1:N `cart_items`
- `users` 1:N `reviews`
- `users` 1:N `wishlists`
- `categories` 1:N `products`
- `products` 1:N `product_images`
- `products` 1:N `product_specifications`
- `products` 1:N `order_items`
- `orders` 1:N `order_items`
- `orders` 1:1 `payments`
- `orders` 1:1 `shipments`
- `orders` 1:N `order_state_history`
- `promotions` 1:N `promotion_items`
- `promotions` 1:N `user_coupons`
- `shipping_zones` 1:N `shipping_rates`
