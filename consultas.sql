-- CAMBIOS VERSION 2
ALTER TABLE orders
ADD COLUMN `invoice_number` VARCHAR(100) NULL AFTER `quotation_id`;

INSERT INTO `deposflc_dev`.`quotation_templates` (`name`, `currency_type_id`) VALUES ('Plantilla general SOLES', '1');
INSERT INTO `deposflc_dev`.`quotation_templates` (`name`, `currency_type_id`) VALUES ('Plantilla general DÓLARES', '2');

