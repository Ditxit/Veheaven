DROP DATABASE IF EXISTS `veheaven`;

CREATE DATABASE IF NOT EXISTS `veheaven`;

CREATE TABLE `vehicle_province` (
    `id` INT (11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `number` INT (11) NOT NULL,
    `province` VARCHAR (100) NOT NULL
);

CREATE TABLE `vehicle_color` (
    `id` INT (11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `color` VARCHAR (100) NOT NULL
);

CREATE TABLE `vehicle_feature_category` (
    `id` INT (11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `category` VARCHAR (100) NOT NULL
);

CREATE TABLE `vehicle_feature` (
    `id` INT (11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `feature` VARCHAR (255) NOT NULL,
    `vehicle_feature_category_id` INT (11) NOT NULL,
    CONSTRAINT FOREIGN KEY (`vehicle_feature_category_id`) REFERENCES `vehicle_feature_category` (`id`)
);

CREATE TABLE `vehicle_condition` (
    `id` INT (11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `condition` VARCHAR (100) NOT NULL
);

CREATE TABLE `vehicle_type` (
    `id` INT (11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `type` VARCHAR (100) NOT NULL
);

CREATE TABLE `vehicle_feature_for_type` (
    `vehicle_feature_id` INT (11) NOT NULL,
    `vehicle_type_id` INT (11) NOT NULL,
    CONSTRAINT FOREIGN KEY (`vehicle_feature_id`) REFERENCES `vehicle_feature` (`id`),
    CONSTRAINT FOREIGN KEY (`vehicle_type_id`) REFERENCES `vehicle_type` (`id`)
);

CREATE TABLE `vehicle_body` (
    `id` INT (11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `body` VARCHAR (100) NOT NULL
);

CREATE TABLE `vehicle_body_for_type` (
    `vehicle_body_id` INT (11) NOT NULL,
    `vehicle_type_id` INT (11) NOT NULL,
    CONSTRAINT FOREIGN KEY (`vehicle_body_id`) REFERENCES `vehicle_body` (`id`),
    CONSTRAINT FOREIGN KEY (`vehicle_type_id`) REFERENCES `vehicle_type` (`id`)
);

CREATE TABLE `vehicle_transmission` (
    `id` INT (11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `transmission` VARCHAR (100) NOT NULL
);

CREATE TABLE `vehicle_transmission_for_type` (
    `vehicle_transmission_id` INT (11) NOT NULL,
    `vehicle_type_id` INT (11) NOT NULL,
    CONSTRAINT FOREIGN KEY (`vehicle_transmission_id`) REFERENCES `vehicle_transmission` (`id`),
    CONSTRAINT FOREIGN KEY (`vehicle_type_id`) REFERENCES `vehicle_type` (`id`)
);

CREATE TABLE `vehicle_tyre` (
    `id` INT (11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `tyre` VARCHAR (100) NOT NULL
);

CREATE TABLE `vehicle_tyre_for_type` (
    `vehicle_tyre_id` INT (11) NOT NULL,
    `vehicle_type_id` INT (11) NOT NULL,
    CONSTRAINT FOREIGN KEY (`vehicle_tyre_id`) REFERENCES `vehicle_tyre` (`id`),
    CONSTRAINT FOREIGN KEY (`vehicle_type_id`) REFERENCES `vehicle_type` (`id`)
);

CREATE TABLE `vehicle_fuel` (
    `id` INT (11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `fuel` VARCHAR (100) NOT NULL
);

CREATE TABLE `vehicle_fuel_for_type` (
    `vehicle_fuel_id` INT (11) NOT NULL,
    `vehicle_type_id` INT (11) NOT NULL,
    CONSTRAINT FOREIGN KEY (`vehicle_fuel_id`) REFERENCES `vehicle_fuel` (`id`),
    CONSTRAINT FOREIGN KEY (`vehicle_type_id`) REFERENCES `vehicle_type` (`id`)
);

CREATE TABLE `vehicle_break` (
    `id` INT (11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `break` VARCHAR (100) NOT NULL
);

CREATE TABLE `vehicle_break_for_type` (
    `vehicle_break_id` INT (11) NOT NULL,
    `vehicle_type_id` INT (11) NOT NULL,
    CONSTRAINT FOREIGN KEY (`vehicle_break_id`) REFERENCES `vehicle_break` (`id`),
    CONSTRAINT FOREIGN KEY (`vehicle_type_id`) REFERENCES `vehicle_type` (`id`)
);

CREATE TABLE `vehicle_suspension` (
    `id` INT (11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `suspension` VARCHAR (100) NOT NULL
);

CREATE TABLE `vehicle_suspension_for_type` (
    `vehicle_suspension_id` INT (11) NOT NULL,
    `vehicle_type_id` INT (11) NOT NULL,
    CONSTRAINT FOREIGN KEY (`vehicle_suspension_id`) REFERENCES `vehicle_suspension` (`id`),
    CONSTRAINT FOREIGN KEY (`vehicle_type_id`) REFERENCES `vehicle_type` (`id`)
);

CREATE TABLE `image` (
    `id` INT (11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `directory` VARCHAR (255) NULL,
    `name` VARCHAR (255) NOT NULL,
    `caption` VARCHAR (255) NULL
);

CREATE TABLE `user_type` (
    `id` INT (11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `type` VARCHAR (100) NOT NULL
);

CREATE TABLE `user` (
    `id` INT (11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `first_name` VARCHAR (40) NOT NULL,
    `last_name` VARCHAR (40) NOT NULL,
    `email` VARCHAR (255) NOT NULL,
    `password` VARCHAR (255) NOT NULL,
    `phone` VARCHAR (20) NULL,
    `created_date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, 
    `last_login` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `user_type_id` INT (11) NOT NULL,
    CONSTRAINT FOREIGN KEY (`user_type_id`) REFERENCES `user_type` (`id`)
);

CREATE TABLE `user_verification` (
    `user_id` int (11) NOT NULL,
    `code` VARCHAR (10) NOT NULL,
    `expiry` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `is_verified` TINYINT (1) NOT NULL DEFAULT 0,
    CONSTRAINT FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
);

CREATE TABLE `user_image` (
    `user_id` INT (11) NOT NULL,
    `image_id` INT (11) NOT NULL,
    CONSTRAINT FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
    CONSTRAINT FOREIGN KEY (`image_id`) REFERENCES `image` (`id`)
);

CREATE TABLE `user_enquiry` (
    `id` INT (11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `email` VARCHAR (255) NOT NULL,
    `enquiry` TEXT NOT NULL
);

CREATE TABLE `vehicle_brand` (
    `id` INT (11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `brand` VARCHAR (100) NOT NULL
);

CREATE TABLE `vehicle_model` (
    `id` INT (11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `model` VARCHAR (100) NOT NULL,
    `year` INT (4) NOT NULL,
    `vehicle_brand_id` INT (11) NOT NULL,
    CONSTRAINT FOREIGN KEY (`vehicle_brand_id`) REFERENCES `vehicle_brand` (`id`)
);

CREATE TABLE `vehicle` (
    `id` INT (11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR (255) NOT NULL,
    `price` DECIMAL(10,2) NOT NULL,
    `mileage` INT (5) NOT NULL DEFAULT 0,
    `engine` INT (5) NOT NULL DEFAULT 0,
    `bhp` INT (5) NOT NULL DEFAULT 0,
    `turn_radius` DECIMAL(5,2) NOT NULL DEFAULT 0.00,
    `seat` INT (5) NOT NULL DEFAULT 0,
    `top_speed` INT (5) NOT NULL DEFAULT 0,
    `vehicle_condition_id` INT (11) NOT NULL,
    `vehicle_type_id` INT (11) NOT NULL,
    `vehicle_body_id` INT (11) NOT NULL,
    `vehicle_transmission_id` INT (11) NOT NULL,
    `front_vehicle_tyre_id` INT (11) NOT NULL,
    `rear_vehicle_tyre_id` INT (11) NOT NULL,
    `vehicle_fuel_id` INT (11) NOT NULL,
    `front_vehicle_break_id` INT (11) NOT NULL,
    `rear_vehicle_break_id` INT (11) NOT NULL,
    `front_vehicle_suspension_id` INT (11) NOT NULL,
    `rear_vehicle_suspension_id` INT (11) NOT NULL,
    `vehicle_model_id` INT (11) NOT NULL,
    CONSTRAINT FOREIGN KEY (`vehicle_condition_id`) REFERENCES `vehicle_condition` (`id`),
    CONSTRAINT FOREIGN KEY (`vehicle_type_id`) REFERENCES `vehicle_type` (`id`),
    CONSTRAINT FOREIGN KEY (`vehicle_body_id`) REFERENCES `vehicle_body` (`id`),
    CONSTRAINT FOREIGN KEY (`vehicle_transmission_id`) REFERENCES `vehicle_transmission` (`id`),
    CONSTRAINT FOREIGN KEY (`front_vehicle_tyre_id`) REFERENCES `vehicle_tyre` (`id`),
    CONSTRAINT FOREIGN KEY (`rear_vehicle_tyre_id`) REFERENCES `vehicle_tyre` (`id`),
    CONSTRAINT FOREIGN KEY (`vehicle_fuel_id`) REFERENCES `vehicle_fuel` (`id`),
    CONSTRAINT FOREIGN KEY (`front_vehicle_break_id`) REFERENCES `vehicle_break` (`id`),
    CONSTRAINT FOREIGN KEY (`rear_vehicle_break_id`) REFERENCES `vehicle_break` (`id`),
    CONSTRAINT FOREIGN KEY (`front_vehicle_suspension_id`) REFERENCES `vehicle_suspension` (`id`),
    CONSTRAINT FOREIGN KEY (`rear_vehicle_suspension_id`) REFERENCES `vehicle_suspension` (`id`),
    CONSTRAINT FOREIGN KEY (`vehicle_model_id`) REFERENCES `vehicle_model` (`id`)
);
/*
    --vehicle
    --vehicle_image
    --used_vehicle
    --vehicle_color_list
    --vehicle_feature_list
    --user_vehicle
*/

