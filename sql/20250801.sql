ALTER TABLE `companies` ADD `pincode` INT NULL AFTER `state`;
ALTER TABLE `companies` CHANGE `address` `address` VARCHAR(91) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;
ALTER TABLE `invoices` CHANGE `reserved_room_id` `reserved_room_id` VARCHAR(25) NULL DEFAULT NULL;