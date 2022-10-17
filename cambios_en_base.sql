ALTER TABLE sc_shop_product ADD COLUMN nro_coutas int NOT NULL DEFAULT '0';


ALTER TABLE sc_shop_customer_address ADD cod_estado TEXT NULL DEFAULT NULL AFTER cedula, ADD cod_municipio TEXT NULL DEFAULT NULL AFTER cod_estado, ADD cod_parroquia TEXT NULL DEFAULT NULL AFTER cod_municipio;

INSERT INTO sc_languages (id, code, text, position, location, created_at, updated_at) VALUES (NULL, 'customer.municipio', 'Municipio', 'customer', 'es', NULL, NULL); 
INSERT INTO sc_languages (id, code, text, position, location, created_at, updated_at) VALUES (NULL, 'customer.parroquia', 'Parroqui', 'customer', 'es', NULL, NULL);
INSERT INTO sc_languages (id, code, text, position, location, created_at, updated_at) VALUES (NULL, 'customer.estado', 'Estado', 'customer', 'es', NULL, NULL);

ALTER TABLE sc_shop_product ADD COLUMN id_modalidad_pagos int NOT NULL DEFAULT '0';
