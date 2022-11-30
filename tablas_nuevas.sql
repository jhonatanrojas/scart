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


DROP TABLE sc_convenios;
CREATE TABLE `sc_convenios` (
  `id`  bigint(20)  NOT NULL AUTO_INCREMENT,
  `order_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nro_convenio` varchar(50) NOT NULL,
   `convenio` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ,
    `garantia` varchar(50) DEFAULT '',
   `lote` varchar(50) DEFAULT '' ,
  `fecha_pagos` date NULL DEFAULT NULL,
  `nro_coutas` int NOT NULL DEFAULT '0',
  `total` decimal(15,2) DEFAULT '0.00',
  `inicial` decimal(15,2) DEFAULT '0.00',
  `modalidad` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,

  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
    UNIQUE KEY `id` (`id`) 
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `sc_plantilla_convenio` (
`id`  bigint(20)  NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contenido` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,

  `status` tinyint(4) NOT NULL DEFAULT 0,
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
  ALTER TABLE sc_historial_pagos ADD COLUMN id_pago   varchar(150)  DEFAULT '';

 ALTER TABLE sc_shop_order ADD modalidad_pago VARCHAR(100)

 ALTER TABLE sc_shop_order ADD cedula VARCHAR(100) DEFAULT '';

 ALTER TABLE sc_shop_order ADD usuario_id char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci  DEFAULT '0';

 ALTER TABLE sc_shop_customer ADD estado_civil VARCHAR(100) DEFAULT 'SOLTERO(A)';
  ALTER TABLE sc_shop_order_status ADD COLUMN mensaje   varchar(255)  DEFAULT '';
  UPDATE sc_shop_order_status SET name=   'SOLICTUD REALIZADA' WHERE id =1;
  UPDATE sc_shop_order_status SET name= 'DOCUMENTOS PENDIENTES', mensaje="PENDIENTE CARGA DE DOUMENTOS PARA CONTINUAR EVALUACIÓN"  WHERE id =2;
  UPDATE sc_shop_order_status SET name= 'DOCUMENTOS CARGADOS', mensaje=""  WHERE id =3;
  UPDATE sc_shop_order_status SET name= 'REVISIÓN COMERCIAL ', mensaje="EN COMITÉ DE APROBACIONES"  WHERE id =4;
    UPDATE sc_shop_order_status SET name= 'FINANCIAMIENTO APROBADO', mensaje="FINACIAMIENTO APROBADO CONTACTE AL VENDEDOR"  WHERE id =5;
    UPDATE sc_shop_order_status SET name= 'FINANCIAMIENTO NO APROBADO', mensaje="CONTACTE AL VENDEDOR"  WHERE id =6;
    INSERT INTO `sc_shop_order_status`(`id`, `name`,`mensaje`) VALUES ('7','EN ESPERA DE FIRMA DE CONVENIO','ESPERANDO PRIMER PAGO PARA
PROCEDER CON LA FIRMA');
    INSERT INTO `sc_shop_order_status`(`id`, `name`,`mensaje`) VALUES ('8','CONVENIO FIRMADO','ATENTO AL PAGO DE SU
SIGUIENTE CUOTA');

    INSERT INTO `sc_shop_order_status`(`id`, `name`,`mensaje`) VALUES ('9','EN ESPERA DE FECHA DE ENTREGA','ESPERANDO LA FECHA DE
ENTRGA DE SU PRODUCTO ');
        INSERT INTO `sc_shop_order_status`(`id`, `name`,`mensaje`) VALUES ('10','PRODUCTO ENTREGADO','COMPRA FINALIZADA');
        
        INSERT INTO `sc_shop_order_status`(`id`, `name`,`mensaje`) VALUES ('11','SOLICITUD DE COMPRA CANCELADA','');
         INSERT INTO `sc_shop_order_status`(`id`, `name`,`mensaje`) VALUES ('12','PAGO PENDIENTE','EN ESPERA DE PAGO');
          INSERT INTO `sc_shop_order_status`(`id`, `name`,`mensaje`) VALUES ('13','PEDIDO ENVIADO','SU PEDIDO A SIDO ENVIADA');