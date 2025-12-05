ALTER TABLE `room_guests` ADD `id_proof` VARCHAR(50) NULL AFTER `id_number`;

ALTER TABLE `purchase_inward_logs` ADD `expiry_date` DATE NULL AFTER `total_qty`;

ALTER TABLE `stocks` CHANGE `stock_id` `expiry_date` DATE NULL DEFAULT NULL;

ALTER TABLE `inventory_management` ADD `expiry_date` DATE NULL AFTER `department_id`;

ALTER TABLE `inventory_management` ADD `status` INT NULL DEFAULT '1' AFTER `balance`;

ALTER TABLE `store_requests` ADD `expiry_date` DATE NULL AFTER `department_id`;

ALTER TABLE `store_return_requests` ADD `expiry_date` DATE NULL AFTER `department_id`;

ALTER TABLE `customers` ADD `proof` VARCHAR(255) NULL AFTER `proof_type`;

ALTER TABLE `users` ADD `usertype_id` INT NULL AFTER `mobile`, ADD `address` VARCHAR(50) NULL AFTER `usertype_id`, ADD `city` VARCHAR(50) NULL AFTER `address`, ADD `state` VARCHAR(50) NULL AFTER `city`, ADD `pincode` VARCHAR(6) NULL AFTER `state`, ADD `country` VARCHAR(25) NULL DEFAULT 'India' AFTER `pincode`;

ALTER TABLE `users` ADD `id_proof_type` VARCHAR(25) NULL AFTER `designation`, ADD `id_proof_other` VARCHAR(25) NULL AFTER `id_proof_type`, ADD `id_number` VARCHAR(25) NULL AFTER `id_proof_other`, ADD `profile` VARCHAR(255) NULL AFTER `id_number`;

ALTER TABLE `users` ADD `status` INT NULL DEFAULT '1' AFTER `remember_token`;

ALTER TABLE `hotlr_configurations` ADD `item_add` VARCHAR(255) NULL AFTER `einvoice_authtoken`, ADD `notification` VARCHAR(255) NULL AFTER `item_add`;

ALTER TABLE `hotlr_configurations` CHANGE `item_add` `item_add` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT 'add.mp3';
ALTER TABLE `hotlr_configurations` CHANGE `notification` `notification` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT 'notification.mp3';

ALTER TABLE `reservation_rooms` CHANGE `checkin` `checkin` DATETIME NULL DEFAULT NULL;
ALTER TABLE `reservation_rooms` CHANGE `checkout` `checkout` DATETIME NULL DEFAULT NULL;