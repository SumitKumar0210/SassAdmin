ALTER TABLE `room_numbers`
DROP `room_category`,
DROP `roomtype_id`,
DROP `roomtype_name`,
DROP `room_specification_id`,
DROP `booked_date`,
DROP `previous_status`,
DROP `c_status_date_from`,
DROP `c_status_date_to`;

DROP TABLE `accesories`;

DROP TABLE `roomclose_dates`;

ALTER TABLE `room_types`
DROP `room_category_id`,
DROP `roomtype_name_id`,
DROP `roomtype_name`,
DROP `internal_roomtype`,
DROP `room_amount`,
DROP `extra_person_charge`,
DROP `bed_type`,
DROP `bedtype_count`,
DROP `room_category_types`,
DROP `file_name`,
DROP `file_path`;

DROP TABLE `room_type_names`;

DROP TABLE `settings`;

ALTER TABLE `tariffs` DROP `roomtype_name_id`;

DROP TABLE `room_categories`;