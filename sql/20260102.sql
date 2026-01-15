ALTER TABLE `advance_amounts` ADD `recorded_by` INT NULL AFTER `type`;

ALTER TABLE `tables` ADD `occupancy_status` INT NULL DEFAULT '0' AFTER `qr_code`;

ALTER TABLE `reservations` ADD `booking_madeby` VARCHAR(15) NULL AFTER `bill_generated_at`, ADD `booker_name` VARCHAR(25) NULL AFTER `booking_madeby`, ADD `booker_email` VARCHAR(30) NULL AFTER `booker_name`, ADD `booker_mobile` VARCHAR(20) NULL AFTER `booker_email`, ADD `remark` VARCHAR(191) NULL AFTER `booker_mobile`;

ALTER TABLE `invoices` ADD `booking_type` VARCHAR(25) NULL DEFAULT 'Single' AFTER `booking_id`;

ALTER TABLE `reservations` ADD `booking_type` VARCHAR(15) NULL DEFAULT 'Single' AFTER `reservation_id`;

ALTER TABLE `reservations` CHANGE `company_address` `company_address` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL;

ALTER TABLE `invoice_room_details` ADD `tariff_type` VARCHAR(50) NULL AFTER `room_category`, ADD `adult` INT NULL AFTER `tariff_type`;

ALTER TABLE `companies` CHANGE `address` `address` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;

ALTER TABLE `customers` ADD `company_id` INT NULL AFTER `pincode`;