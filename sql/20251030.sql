ALTER TABLE `reservations` ADD `company_pincode` VARCHAR(11) NULL AFTER `company_address`, ADD `company_state` VARCHAR(11) NULL AFTER `company_pincode`;

ALTER TABLE `customers` ADD `company_pincode` VARCHAR(11) NULL AFTER `company_address`, ADD `company_state` VARCHAR(11) NULL AFTER `company_pincode`;

ALTER TABLE `customers` ADD `proof_type` VARCHAR(30) NULL AFTER `id_proof`;

UPDATE `items` SET `name` = 'Palak plane' WHERE `items`.`id` = 326;

UPDATE `items` SET `name` = 'Shahi Toast ' WHERE `items`.`id` = 273;

-- 31-10-2025

ALTER TABLE `banquet_bookings` ADD `company_address` TEXT NULL AFTER `company_gst`;

ALTER TABLE `banquet_bookings` ADD `document` VARCHAR(121) NULL AFTER `created_by`;