ALTER TABLE `hotlr_configurations` ADD `add_item_status` INT NOT NULL DEFAULT '1' AFTER `item_add`;

ALTER TABLE `hotlr_configurations` ADD `notification_status` INT NOT NULL DEFAULT '1' AFTER `notification`;

ALTER TABLE `features` ADD `icon` VARCHAR(91) NULL DEFAULT 'fa-user' AFTER `name`;

ALTER TABLE `kots` CHANGE `reference_number` `reference_number` VARCHAR(255) NULL DEFAULT NULL;

ALTER TABLE `kots` ADD `bill_number` VARCHAR(191) NULL AFTER `narration`, ADD `bill_date` DATE NULL AFTER `bill_number`, ADD `generated_bill_by` INT NULL AFTER `bill_date`;

ALTER TABLE `kots` ADD `cancel_bill_by` INT NULL AFTER `generated_bill_by`, ADD `cancel_bill_reason` VARCHAR(255) NULL AFTER `cancel_bill_by`;

ALTER TABLE `kot_invoices` ADD `kots` VARCHAR(50) NULL AFTER `id`;

ALTER TABLE `kot_invoices` ADD `guest_name` VARCHAR(50) NULL AFTER `invoice_date`, ADD `guest_gst` VARCHAR(30) NULL AFTER `guest_name`;

ALTER TABLE `kot_invoices` ADD `deleted_at` TIMESTAMP NULL AFTER `updated_at`;

INSERT INTO `module_permissions` (`id`, `module_id`, `module`, `module_option`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES (NULL, '2', 'Kot', 'Kot Cancel', '1', '2025-11-20 15:06:36', '2025-11-20 15:06:36', NULL);

ALTER TABLE `kots` ADD `is_urgent` INT NULL DEFAULT '0' AFTER `order_status`;

ALTER TABLE `kots` ADD `cancel_by` INT NULL AFTER `cancel_at`;

ALTER TABLE `advance_amounts` ADD `mode` INT NULL AFTER `amount`, ADD `reference` VARCHAR(50) NULL AFTER `mode`;