ALTER TABLE sc_shop_order_detail
ADD COLUMN nro_coutas int NOT NULL DEFAULT '0' AFTER name;

ALTER TABLE sc_shop_order_detail
ADD COLUMN abono_inicial decimal(15,2) DEFAULT '0.00';

DROP TABLE sc_historial_pagos;
CREATE TABLE `sc_historial_pagos` (
  `id`  bigint(20)  NOT NULL AUTO_INCREMENT,
  `customer_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `producto_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_detail_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `modalidad_pago_id` int NOT NULL DEFAULT '0',
 `metodo_pago_id` int NOT NULL DEFAULT '0',
  `fecha_venciento` timestamp NULL DEFAULT NULL,
  `nro_coutas` int NOT NULL DEFAULT '0',
  `referencia` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comprobante` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `importe_couta` decimal(15,2) DEFAULT '0.00',
  `fecha_pago` timestamp NULL DEFAULT NULL,
  `payment_status` int NOT NULL DEFAULT '1',
  `importe_pagado` decimal(15,2) DEFAULT '0.00',
  `moneda` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tasa_cambio` decimal(15,2) DEFAULT NULL,
  `comment` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_method` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,

  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
    UNIQUE KEY `id` (`id`) 
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




CREATE TABLE `sc_modalidad_pagos` (
  `id` int UNSIGNED NOT NULL PRIMARY KEY,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


INSERT INTO `sc_modalidad_pagos` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Semanal', NULL, NULL),
(2, 'Quincenal', NULL, NULL),
(3, 'Mensual', NULL, NULL),




CREATE TABLE `sc_metodos_pagos` (
  `id` int UNSIGNED NOT NULL PRIMARY KEY,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


INSERT INTO `sc_metodos_pagos` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Efectivo', NULL, NULL),
(2, 'Transferencia', NULL, NULL),
(3, 'Debito', NULL, NULL),
(4, 'Pago Movil', NULL, NULL),
(5, 'Monedero Digital', NULL, NULL),


 ALTER TABLE sc_historial_pagos ADD COLUMN observacion   varchar(255)  DEFAULT '';
 ALTER TABLE sc_shop_order ADD modalidad_pago VARCHAR(100)


