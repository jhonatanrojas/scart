ALTER TABLE sc_shop_product ADD COLUMN nro_coutas int NOT NULL DEFAULT '0';


ALTER TABLE sc_shop_customer_address ADD cod_estado TEXT NULL DEFAULT NULL AFTER cedula, ADD cod_municipio TEXT NULL DEFAULT NULL AFTER cod_estado, ADD cod_parroquia TEXT NULL DEFAULT NULL AFTER cod_municipio;

INSERT INTO sc_languages (id, code, text, position, location, created_at, updated_at) VALUES (NULL, 'customer.municipio', 'Municipio', 'customer', 'es', NULL, NULL); 
INSERT INTO sc_languages (id, code, text, position, location, created_at, updated_at) VALUES (NULL, 'customer.parroquia', 'Parroquia', 'customer', 'es', NULL, NULL);
INSERT INTO sc_languages (id, code, text, position, location, created_at, updated_at) VALUES (NULL, 'customer.estado', 'Estado', 'customer', 'es', NULL, NULL);

ALTER TABLE sc_shop_product ADD COLUMN id_modalidad_pagos int NOT NULL DEFAULT '0';

INSERT INTO `sc_admin_config` (`id`, `group`, `code`, `key`, `value`, `security`, `store_id`, `sort`, `detail`, `created_at`, `updated_at`) VALUES (NULL, '', 'customer_config_attribute_required', 'customer_nacionalidad_required', '1', '0', '1', '0', '', NULL, NULL);

INSERT INTO `sc_admin_config` (`id`, `group`, `code`, `key`, `value`, `security`, `store_id`, `sort`, `detail`, `created_at`, `updated_at`) VALUES (NULL, '', 'customer_config_attribute_required', 'customer_municipio_required', '1', '0', '1', '1', '', NULL, NULL);

ALTER TABLE sc_shop_order_detail ADD COLUMN modalidad_de_compra int NOT NULL DEFAULT '0';
ALTER TABLE sc_shop_order_detail ADD COLUMN fecha_primer_pago date DEFAULT null;
 chown www-data:www-data 

 ALTER TABLE sc_historial_pagos ADD COLUMN observacion  text NOT NULL DEFAULT '';
> Jhonatan Rojas:
ALTER TABLE sc_shop_order_detail
ADD COLUMN abono_inicial decimal(15,2) DEFAULT '0.00';
ALTER TABLE sc_shop_order_detail ADD COLUMN id_modalidad_pago int NOT NULL DEFAULT '0';

 ALTER TABLE sc_shop_order_detail ADD COLUMN modalidad_pago VARCHAR(100)

ALTER TABLE sc_shop_order ADD COLUMN modalidad_de_compra int NOT NULL DEFAULT '0';

ALTER TABLE sc_shop_order_detail ADD COLUMN modalidad_de_compra int NOT NULL DEFAULT '0';
ALTER TABLE sc_shop_order ADD COLUMN fecha_primer_pago date DEFAULT NULL;

  `fecha_venciento` timestamp NULL DEFAULT NULL,

ALTER TABLE sc_shop_order ADD confiabilidad int  DEFAULT '0';

ALTER TABLE sc_shop_order ADD confiabilidad2 int  DEFAULT '0';

ALTER TABLE sc_shop_order ADD confiabilidad3 int  DEFAULT '0';

ALTER TABLE sc_shop_customer ADD rif VARCHAR(100) NULL DEFAULT NULL AFTER razon_social;

  ALTER TABLE sc_shop_customer ADD razon_social VARCHAR(200) NOT NULL AFTER id;

  ALTER TABLE sc_shop_customer ADD `natural_jurídica` VARCHAR(2) NULL DEFAULT NULL AFTER id;

  INSERT INTO sc_admin_config (id, group, code, key, value, security, store_id, sort, detail, created_at, updated_at) VALUES (NULL, '', 'customer_config_attribute', 'customer_rif', '1', '0', '1', '0', 'customer.config_manager.rif', NULL, NULL);

  INSERT INTO sc_admin_config (id, group, code, key, value, security, store_id, sort, detail, created_at, updated_at) VALUES (NULL, '', 'customer_config_attribute', 'customer_razon_social', '1', '0', '1', '0', 'customer.config_manager.razon_social', NULL, NULL);

  INSERT INTO sc_admin_config (id, group, code, key, value, security, store_id, sort, detail, created_at, updated_at) VALUES (NULL, '', 'customer_config_attribute', 'customer_natural_jurídica', '1', '0', '1', '0', 'customer.config_manager.natural_jurídica', NULL, NULL);
  ALTER TABLE sc_shop_order ADD COLUMN vendedor_id   varchar(36)  DEFAULT '';

  ALTER TABLE sc_shop_customer ADD nos_conocio VARCHAR(100) NULL DEFAULT NULL AFTER last_name_kana;
ALTER TABLE sc_shop_order ADD COLUMN fecha_maxima_entrega date DEFAULT NULL;

ALTER TABLE sc_shop_product ADD COLUMN precio_de_cuota BOOLEAN NOT NULL DEFAULT 'false';
ALTER TABLE sc_shop_product ADD COLUMN monto_inicial  decimal(15,2) DEFAULT '0.00';
ALTER TABLE sc_shop_order_detail ADD COLUMN monto_cuota_entrega  decimal(15,2) DEFAULT '0.00'; 

ALTER TABLE sc_shop_product ADD COLUMN monto_cuota_entrega  decimal(15,2) DEFAULT '0.00';     
     INSERT INTO sc_shop_order_status(id, name,mensaje) VALUES ('14','VERIFICACIÓN LEGAL','EN VERIFICACIÓN LEGAL');
          INSERT INTO sc_shop_order_status(id, name,mensaje) VALUES ('15','VERIFICACIÓN FINANCIERA','EN VERIFICACIÓN FINANCIERA');
                    INSERT INTO sc_shop_order_status(id, name,mensaje) VALUES ('16','PAGO RETRASADO','AGRADECEMOS REALIZAR SU PAGO A LA BREVEDAD,SU PAGO TIENE RETRASO ');
                                        INSERT INTO sc_shop_order_status(id, name,mensaje) VALUES ('17','ENTREGA DE FINIQUITO','HA CANCELADO SU TOTALIDAD DE CUOTAS, SE ENTREGARÁ FINIQUITO PROXIMAMENTE');