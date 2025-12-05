ALTER TABLE `reservation_payments` CHANGE `payment_Date` `payment_date` VARCHAR(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;

ALTER TABLE `reservation_payments` ADD `recorded_by` INT NULL AFTER `guest_email`, ADD `status` INT NULL DEFAULT '1' AFTER `recorded_by`;

ALTER TABLE `reservation_payments` ADD `module` VARCHAR(30) NULL DEFAULT 'Room' AFTER `payment_type`;

ALTER TABLE `reservation_rooms` ADD `random` INT NULL AFTER `checkedout_at`;