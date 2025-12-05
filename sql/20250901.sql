ALTER TABLE `tables` ADD `qr_code` VARCHAR(80) NULL AFTER `area`;

ALTER TABLE `room_numbers` ADD `qr_code` VARCHAR(80) NULL AFTER `room_number`;

ALTER TABLE `room_numbers` ADD `random_code` VARCHAR(91) NULL AFTER `qr_code`;

ALTER TABLE `kots` ADD `menu_type` VARCHAR(10) NULL AFTER `id`, ADD `menu_id` VARCHAR(50) NULL AFTER `menu_type`;

ALTER TABLE `tables` ADD `random_code` VARCHAR(91) NULL AFTER `status`;

ALTER TABLE `kots` CHANGE `discount_value` `discount_value` INT NULL DEFAULT '0';

ALTER TABLE `kots` ADD `cancel_at` TIMESTAMP NULL AFTER `order_status`, ADD `cancel_reason` VARCHAR(91) NULL AFTER `cancel_at`;

ALTER TABLE `room_types` CHANGE `description` `description` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;

ALTER TABLE `room_types` ADD `status` INT NULL DEFAULT '1' AFTER `file_path`;