ALTER TABLE `reservation_rooms` ADD `tariff_id` INT NULL AFTER `room_type_id`;

ALTER TABLE `reservations` CHANGE `arrival_time` `arrival_time` VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL;
ALTER TABLE `room_guests` ADD `isPrimary` INT NULL DEFAULT NULL AFTER `id_number`;