ALTER TABLE `banquet_bookings` ADD `event_end_date` DATE NULL AFTER `start_time`;

ALTER TABLE `banquet_bookings` ADD `reference_number` VARCHAR(50) NULL AFTER `payment_mode`;

ALTER TABLE `banquet_bookings` ADD `address` VARCHAR(190) NULL AFTER `client_name`;

ALTER TABLE `banquet_accesories` ADD `accesories_rate` DOUBLE NULL DEFAULT '0' AFTER `accesories_name`;

ALTER TABLE `banquet_bookings` ADD `adjustment` DOUBLE NULL AFTER `gst_amount`;

ALTER TABLE `payment_receiveds` ADD `received_by` INT NULL AFTER `amount`;