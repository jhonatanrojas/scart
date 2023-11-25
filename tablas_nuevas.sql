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


CREATE TABLE `sc_tipo_tarjetas` (
  `id`  bigint(20)  NOT NULL AUTO_INCREMENT,
  `tipo` varchar(50) NOT NULL,
  `monto_limite` decimal(15,2) DEFAULT '0.00',
    `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
    UNIQUE KEY `id` (`id`) 
) 
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


CREATE TABLE `sc_tarjetas` ( `id` bigint(20) NOT NULL AUTO_INCREMENT, `customer_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL, `nro_tarjeta` varchar(50) NOT NULL, `tipo_tarjeta_id` bigint(20), `fecha_de_entrega` date NULL DEFAULT NULL, `fecha_de_vencimiento` date NULL DEFAULT NULL, `monto_limite` decimal(15,2) DEFAULT '0.00', `periodo_pago` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL, `codigo_seguridad` varchar(50) DEFAULT '' , `fecha_pagos` date NULL DEFAULT NULL, `nro_coutas` int NOT NULL DEFAULT '0', `activa` BOOLEAN NOT NULL DEFAULT true, `created_at` timestamp NULL DEFAULT NULL, `updated_at` timestamp NULL DEFAULT NULL, UNIQUE KEY `id` (`id`) );


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


CREATE TABLE `sc_rol_estatus_pedido` (
`id`  bigint(20)  NOT NULL AUTO_INCREMENT,
  `admin_role_id`  bigint(20), 
  `shop_order_status_id`  bigint(20) ,
  `modificar`   BOOLEAN NOT NULL DEFAULT 'false',
    `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `sc_modalidad_venta` ( `id` bigint(20) NOT NULL AUTO_INCREMENT, `descripcion` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL, `activo` BOOLEAN NOT NULL DEFAULT true, `created_at` timestamp NULL DEFAULT NULL, `updated_at` timestamp NULL DEFAULT NULL, UNIQUE KEY `id` (`id`) );

 tarjatas_modalidad de compra
 id,
 id_tarjeta
 id_modalidad
 limite
CREATE TABLE `sc_monto_tarjetas_modalidad` (
    `id` bigint(20) NOT NULL AUTO_INCREMENT,
    `tarjeta_id`  bigint(20), 
     `modalida_venta_id`  bigint(20),  
   `monto` decimal(15,2) DEFAULT '0.00',
    `activo` BOOLEAN NOT NULL DEFAULT true,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    UNIQUE KEY `id` (`id`)
);
transacciones_tarjetas
id_tarjeta, 
id_modalidad_compra,
tipo_movimineto,(movimiento/debito)
monto
fecha
id_solicitud


CREATE TABLE `sc_transacciones_tarjetas` (
    `id` bigint(20) NOT NULL AUTO_INCREMENT,
    `tarjeta_id`  bigint(20), 
      `order_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,

     `modalidad_venta_id`  bigint(20),  
   `monto` decimal(15,2) DEFAULT '0.00',
     `tipo_movimiento` varchar(50) COLLATE utf8mb4_unicode_ci,
    `descripcion` varchar(250) DEFAULT '',

    `activo` BOOLEAN NOT NULL DEFAULT true,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    UNIQUE KEY `id` (`id`)
);
INSERT INTO `sc_modalidad_venta` (`id`, `descripcion`, `activo`, `created_at`, `updated_at`) VALUES ('0', 'Al contado', '1', NULL, NULL), ('1', 'Financiamiento Convenio', '1', NULL, NULL);
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

//estandar 



CREATE TABLE `sc_metodos_pagos` (
  `id` int UNSIGNED NOT NULL PRIMARY KEY,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `sc_tarjetas` (
  `id` int UNSIGNED NOT NULL PRIMARY KEY,
  `tipo_tarjeta_id`  bigint(20), 
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

 ALTER TABLE sc_historial_pagos ADD COLUMN telefono_origen   varchar(160)  DEFAULT '';
 ALTER TABLE sc_historial_pagos ADD COLUMN cedula_origen   varchar(160)  DEFAULT '';
 ALTER TABLE sc_historial_pagos ADD COLUMN codigo_banco   varchar(160)  DEFAULT '';
 ALTER TABLE sc_historial_pagos ADD COLUMN observacion   varchar(255)  DEFAULT '';
  ALTER TABLE sc_historial_pagos ADD COLUMN id_pago   varchar(150)  DEFAULT '';

 ALTER TABLE sc_shop_order ADD modalidad_pago VARCHAR(100)

  ALTER TABLE sc_shop_order ADD modalidad_pago VARCHAR(100)

 ALTER TABLE sc_shop_order ADD cedula VARCHAR(100) DEFAULT '';

 ALTER TABLE sc_shop_order ADD usuario_id char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci  DEFAULT '0';

 ALTER TABLE sc_shop_order_status ADD area_trabajo VARCHAR(100) DEFAULT '';
  ALTER TABLE sc_historial_pagos ADD COLUMN id_pago   varchar(150)  DEFAULT '';
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

          CREATE TABLE `sc_rol_estatus_pedido` ( `admin_role_id` bigint(20), 
          `shop_order_status_id` bigint(20) , `modificar` BOOLEAN NOT NULL DEFAULT false, `created_at` timestamp NULL DEFAULT NULL, `updated_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
CREATE TABLE `sc_auditoria` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `add_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



--redes sociales 
ALTER TABLE `sc_shop_customer` ADD `re_facebook` VARCHAR(255) NULL DEFAULT NULL AFTER `nivel`, ADD `re_Twitter` VARCHAR(255) NULL DEFAULT NULL AFTER `re_facebook`, ADD `re_Instagram` VARCHAR(255) NULL DEFAULT NULL AFTER `re_Twitter`, ADD `LinkedIn` VARCHAR(255) NULL DEFAULT NULL AFTER `re_Instagram`;
--redes sociales 