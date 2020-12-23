DROP DATABASE IF EXISTS `veheaven`;

CREATE DATABASE IF NOT EXISTS `veheaven`;

USE `veheaven`;

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

CREATE TABLE `vehicle_brand_for_type` (
    `vehicle_brand_id` INT (11) NOT NULL,
    `vehicle_type_id` INT (11) NOT NULL,
    CONSTRAINT FOREIGN KEY (`vehicle_brand_id`) REFERENCES `vehicle_brand` (`id`),
    CONSTRAINT FOREIGN KEY (`vehicle_type_id`) REFERENCES `vehicle_type` (`id`)
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
    `mileage` DECIMAL(4,2) NOT NULL DEFAULT 0,
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
    `vehicle_fuel_capacity` DECIMAL(10,2) NOT NULL,
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

CREATE TABLE `vehicle_image` (
    `vehicle_id` INT (11) NOT NULL,
    `image_id` INT (11) NOT NULL,
    CONSTRAINT FOREIGN KEY (`vehicle_id`) REFERENCES `vehicle` (`id`),
    CONSTRAINT FOREIGN KEY (`image_id`) REFERENCES `image` (`id`)
);

CREATE TABLE `used_vehicle` (
    `vehicle_id` INT (11) NOT NULL,
    `owners` VARCHAR (15) NOT NULL,
    `owners_message` TEXT NULL,
    `distance` INT (5) NOT NULL,
    `registered_date` DATETIME NULL,
    `vehicle_province_id` INT (11) NOT NULL,
    CONSTRAINT FOREIGN KEY (`vehicle_id`) REFERENCES `vehicle` (`id`),
    CONSTRAINT FOREIGN KEY (`vehicle_province_id`) REFERENCES `vehicle_province` (`id`)
);

CREATE TABLE `vehicle_color_list` (
    `vehicle_id` INT (11) NOT NULL,
    `vehicle_color_id` INT (11) NOT NULL,
    CONSTRAINT FOREIGN KEY (`vehicle_id`) REFERENCES `vehicle` (`id`),
    CONSTRAINT FOREIGN KEY (`vehicle_color_id`) REFERENCES `vehicle_color` (`id`)
);

CREATE TABLE `vehicle_feature_list` (
    `vehicle_id` INT (11) NOT NULL,
    `vehicle_feature_id` INT (11) NOT NULL,
    CONSTRAINT FOREIGN KEY (`vehicle_id`) REFERENCES `vehicle` (`id`),
    CONSTRAINT FOREIGN KEY (`vehicle_feature_id`) REFERENCES `vehicle_feature` (`id`)
);

CREATE TABLE `user_vehicle` (
    `id` INT (11) NOT NULL,
    `user_id` INT (11) NOT NULL,
    `vehicle_id` INT (11) NOT NULL,
    `added_date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `last_updated` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
    CONSTRAINT FOREIGN KEY (`vehicle_id`) REFERENCES `vehicle` (`id`)
);


/* Data Insertion Part */

/* vehicle province */
INSERT INTO vehicle_province (number,province) VALUES (1,'Province No. 1');
INSERT INTO vehicle_province (number,province) VALUES (2,'Province No. 2');
INSERT INTO vehicle_province (number,province) VALUES (3,'Bagmati Province');
INSERT INTO vehicle_province (number,province) VALUES (4,'Gandaki Province');
INSERT INTO vehicle_province (number,province) VALUES (5,'Lumbini Province');
INSERT INTO vehicle_province (number,province) VALUES (6,'Karnali Province');
INSERT INTO vehicle_province (number,province) VALUES (7,'Sudurpashchim Province');


/* vehicle color */
INSERT INTO vehicle_color (color) VALUES ('Black');
INSERT INTO vehicle_color (color) VALUES ('Blue');
INSERT INTO vehicle_color (color) VALUES ('Brown');
INSERT INTO vehicle_color (color) VALUES ('Gold');
INSERT INTO vehicle_color (color) VALUES ('Gray');
INSERT INTO vehicle_color (color) VALUES ('Green');
INSERT INTO vehicle_color (color) VALUES ('Orange');
INSERT INTO vehicle_color (color) VALUES ('Purple');
INSERT INTO vehicle_color (color) VALUES ('Red');
INSERT INTO vehicle_color (color) VALUES ('Silver');
INSERT INTO vehicle_color (color) VALUES ('Tan');
INSERT INTO vehicle_color (color) VALUES ('White');
INSERT INTO vehicle_color (color) VALUES ('Yellow');
INSERT INTO vehicle_color (color) VALUES ('Other');

/* vehicle feature category */
INSERT INTO vehicle_feature_category (category) VALUES ('Safety');
INSERT INTO vehicle_feature_category (category) VALUES ('Braking & Traction');
INSERT INTO vehicle_feature_category (category) VALUES ('Locks & Security');
INSERT INTO vehicle_feature_category (category) VALUES ('Comfort & Convenience');
INSERT INTO vehicle_feature_category (category) VALUES ('Seats & Upholstery');
INSERT INTO vehicle_feature_category (category) VALUES ('Storage');
INSERT INTO vehicle_feature_category (category) VALUES ('Doors, Windows, Mirrors & Wipers');
INSERT INTO vehicle_feature_category (category) VALUES ('Exterior');
INSERT INTO vehicle_feature_category (category) VALUES ('Lighting');
INSERT INTO vehicle_feature_category (category) VALUES ('Instrumentation');
INSERT INTO vehicle_feature_category (category) VALUES ('Entertainment, Information & Communication');

/* vehicle feature */
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Airbags',1);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Middle rear three-point seatbelt',1);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Middle Rear Head Rest',1);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Tyre Pressure Monitoring System (TPMS)',1);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Child Seat Anchor Points',1);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Seat Belt Warning',1);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Anti-Lock Braking System (ABS)',2);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Brake Assist (BA)',2);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Four-Wheel-Drive',2);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Traction Control System (TC/TCS)',2);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Hill Descent Control',2);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Differential Lock',2);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Electronic Brake-force Distribution (EBD)',2);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Electronic Stability Program (ESP)',2);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Hill Hold Control',2);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Ride Height Adjustment',2);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Limited Slip Differential (LSD)',2);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Engine immobilizer',3);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Speed Sensing Door Lock',3);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Central Locking',3);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Child Safety Lock',3);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Air Conditioner',4);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Rear AC',4);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Heater',4);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Cabin-Boot Access',4);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Parking Assist',4);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Cruise Control',4);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Keyless Start/ Button Start',4);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('12V Power Outlets',4);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Front AC',4);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Third Row AC',4);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Vanity Mirrors on Sun Visors',4);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Anti-glare Mirrors',4);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Parking Sensors',4);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Headlight & Ignition On Reminder',4);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Steering Adjustment',4);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Driver Seat Adjustment',5);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Rear Row Seat Adjustment',5);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Fourth Row Seat Adjustment',5);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Leather-wrapped Steering Wheel',5);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Driver Armrest',5);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('3rd Row Seats Type',5);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Ventilated Seat Type',5);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Interior Colours',5);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Folding Rear Seat',5);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Split Third Row Seat',5);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Head-rests',5);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Front Passenger Seat Adjustment',5);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Third Row Seat Adjustment',5);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Seat Upholstery',5);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Leather-wrapped Gear Knob',5);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Rear Passenger Seats Type',5);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Ventilated Seats',5);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Interiors',5);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Rear Armrest',5);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Split Rear Seat',5);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Front Seatback Pockets',5);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Cup Holders',6);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Cooled Glove Box',6);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Third Row Cup Holders',6);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Driver Armrest Storage',6);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Sunglass Holder',6);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Power Windows',7);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('One Touch - Up',7);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Turn Indicators on ORVM',7);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Rear Wiper',7);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Rain-sensing Wipers',7);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Door Pockets',7);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Boot-lid Opener',7);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Outside Rear View Mirrors (ORVMs)',7);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('One Touch - Down',7);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Adjustable ORVM',7);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Rear Defogger',7);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Exterior Door Handles',7);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Interior Door Handles',7);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Side Window Blinds',7);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Rear Windshield Blind',7);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Sunroof / Moonroof',8);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Roof Mounted Antenna',8);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Chrome Finish Exhaust pipe',8);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Rub - Strips',8);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Roof rails',8);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Body-Coloured Bumpers',8);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Body Kit',8);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Daytime Running Lights',9);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Headlights',9);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Follow me home headlamps',9);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Cabin Lamps',9);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Glove Box Lamp',9);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Rear Reading Lamp',9);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Fog Lights',9);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Automatic Head Lamps',9);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Tail Lights',9);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Headlight Height Adjuster',9);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Lights on Vanity Mirrors',9);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Cornering Headlights',9);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Instrument Cluster',10);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Average Fuel Consumption',10);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Distance to Empty',10);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Low Fuel Level Warning',10);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Adjustable Cluster Brightness',10);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Shift Indicator',10);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Tachometer',10);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Trip Meter',10);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Average Speed',10);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Clock',10);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Door Ajar Warning',10);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Gear Indicator',10);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Heads Up Display (HUD)',10);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Instantaneous Consumption',10);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Gesture Control',11);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Integrated (in-dash) Music System',11);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Display',11);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('GPS Navigation System',11);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('USB Compatibility',11);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Bluetooth Compatibility',11);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('CD Player',11);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('AM/FM Radio',11);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Internal Hard-drive',11);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Voice Command',11);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Smart Connectivity',11);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Head Unit Size',11);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Display Screen for Rear Passengers',11);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Speakers',11);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Aux Compatibility',11);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('MP3 Playback',11);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('DVD Playback',11);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('iPod Compatibility',11);
INSERT INTO vehicle_feature (feature,vehicle_feature_category_id) VALUES ('Steering mounted controls',11);

/* vehicle condition */
INSERT INTO vehicle_condition (`condition`) VALUES ('New');
INSERT INTO vehicle_condition (`condition`) VALUES ('Used');

/* vehicle type */
INSERT INTO vehicle_type (type) VALUES ('Bike');
INSERT INTO vehicle_type (type) VALUES ('Car');

/* vehicle feature for type */
/* INSERT INTO vehicle_feature_for_type (vehicle_feature_id,vehicle_type_id) VALUES (1,1); */

/* vehicle body */
INSERT INTO vehicle_body (body) VALUES ('Standard');
INSERT INTO vehicle_body (body) VALUES ('Chopper');
INSERT INTO vehicle_body (body) VALUES ('Cruser');
INSERT INTO vehicle_body (body) VALUES ('Scooter');
INSERT INTO vehicle_body (body) VALUES ('Touring');
INSERT INTO vehicle_body (body) VALUES ('Off-road');

INSERT INTO vehicle_body (body) VALUES ('Sports');

INSERT INTO vehicle_body (body) VALUES ('Sedan');
INSERT INTO vehicle_body (body) VALUES ('SUV');
INSERT INTO vehicle_body (body) VALUES ('Compact');
INSERT INTO vehicle_body (body) VALUES ('Wagon');
INSERT INTO vehicle_body (body) VALUES ('Coupe');
INSERT INTO vehicle_body (body) VALUES ('Van');
INSERT INTO vehicle_body (body) VALUES ('Minivan');
INSERT INTO vehicle_body (body) VALUES ('Hatchback');
INSERT INTO vehicle_body (body) VALUES ('Pickup');
INSERT INTO vehicle_body (body) VALUES ('Convertable');

/* vehicle body for type */
INSERT INTO vehicle_body_for_type (vehicle_body_id,vehicle_type_id) VALUES (1,1);
INSERT INTO vehicle_body_for_type (vehicle_body_id,vehicle_type_id) VALUES (2,1);
INSERT INTO vehicle_body_for_type (vehicle_body_id,vehicle_type_id) VALUES (3,1);
INSERT INTO vehicle_body_for_type (vehicle_body_id,vehicle_type_id) VALUES (4,1);
INSERT INTO vehicle_body_for_type (vehicle_body_id,vehicle_type_id) VALUES (5,1);
INSERT INTO vehicle_body_for_type (vehicle_body_id,vehicle_type_id) VALUES (6,1);

INSERT INTO vehicle_body_for_type (vehicle_body_id,vehicle_type_id) VALUES (7,1);
INSERT INTO vehicle_body_for_type (vehicle_body_id,vehicle_type_id) VALUES (7,2);

INSERT INTO vehicle_body_for_type (vehicle_body_id,vehicle_type_id) VALUES (8,2);
INSERT INTO vehicle_body_for_type (vehicle_body_id,vehicle_type_id) VALUES (9,2);
INSERT INTO vehicle_body_for_type (vehicle_body_id,vehicle_type_id) VALUES (10,2);
INSERT INTO vehicle_body_for_type (vehicle_body_id,vehicle_type_id) VALUES (11,2);
INSERT INTO vehicle_body_for_type (vehicle_body_id,vehicle_type_id) VALUES (12,2);
INSERT INTO vehicle_body_for_type (vehicle_body_id,vehicle_type_id) VALUES (13,2);
INSERT INTO vehicle_body_for_type (vehicle_body_id,vehicle_type_id) VALUES (14,2);
INSERT INTO vehicle_body_for_type (vehicle_body_id,vehicle_type_id) VALUES (15,2);
INSERT INTO vehicle_body_for_type (vehicle_body_id,vehicle_type_id) VALUES (16,2);
INSERT INTO vehicle_body_for_type (vehicle_body_id,vehicle_type_id) VALUES (17,2);

/* vehicle transmission */
INSERT INTO vehicle_transmission (transmission) VALUES ('Automatic');
INSERT INTO vehicle_transmission (transmission) VALUES ('Manual');
INSERT INTO vehicle_transmission (transmission) VALUES ('Other');


/* vehicle transmission for type */
INSERT INTO vehicle_transmission_for_type (vehicle_transmission_id,vehicle_type_id) VALUES (1,1);
INSERT INTO vehicle_transmission_for_type (vehicle_transmission_id,vehicle_type_id) VALUES (2,1);
INSERT INTO vehicle_transmission_for_type (vehicle_transmission_id,vehicle_type_id) VALUES (3,1);

INSERT INTO vehicle_transmission_for_type (vehicle_transmission_id,vehicle_type_id) VALUES (1,2);
INSERT INTO vehicle_transmission_for_type (vehicle_transmission_id,vehicle_type_id) VALUES (2,2);
INSERT INTO vehicle_transmission_for_type (vehicle_transmission_id,vehicle_type_id) VALUES (3,2);

/* vehicle tyre */
INSERT INTO vehicle_tyre (tyre) VALUES ('Tubed');
INSERT INTO vehicle_tyre (tyre) VALUES ('Tubeless');
INSERT INTO vehicle_tyre (tyre) VALUES ('Other');

/* vehicle tyre for type */
INSERT INTO vehicle_tyre_for_type (vehicle_tyre_id,vehicle_type_id) VALUES (1,1);
INSERT INTO vehicle_tyre_for_type (vehicle_tyre_id,vehicle_type_id) VALUES (2,1);

INSERT INTO vehicle_tyre_for_type (vehicle_tyre_id,vehicle_type_id) VALUES (1,2);
INSERT INTO vehicle_tyre_for_type (vehicle_tyre_id,vehicle_type_id) VALUES (2,2);

/* vehicle fuel */
INSERT INTO vehicle_fuel (`fuel`) VALUES ('Petrol');
INSERT INTO vehicle_fuel (`fuel`) VALUES ('Diesel');
INSERT INTO vehicle_fuel (`fuel`) VALUES ('Ethanol');
INSERT INTO vehicle_fuel (`fuel`) VALUES ('Electric');
INSERT INTO vehicle_fuel (`fuel`) VALUES ('CNG');
INSERT INTO vehicle_fuel (`fuel`) VALUES ('Biodiesel');
INSERT INTO vehicle_fuel (`fuel`) VALUES ('Propane');
INSERT INTO vehicle_fuel (`fuel`) VALUES ('Hydrogen');

/* vehicle fuel for type */
INSERT INTO vehicle_fuel_for_type (vehicle_fuel_id,vehicle_type_id) VALUES (1,1);
INSERT INTO vehicle_fuel_for_type (vehicle_fuel_id,vehicle_type_id) VALUES (2,1);
INSERT INTO vehicle_fuel_for_type (vehicle_fuel_id,vehicle_type_id) VALUES (3,1);
INSERT INTO vehicle_fuel_for_type (vehicle_fuel_id,vehicle_type_id) VALUES (4,1);

INSERT INTO vehicle_fuel_for_type (vehicle_fuel_id,vehicle_type_id) VALUES (1,2);
INSERT INTO vehicle_fuel_for_type (vehicle_fuel_id,vehicle_type_id) VALUES (2,2);
INSERT INTO vehicle_fuel_for_type (vehicle_fuel_id,vehicle_type_id) VALUES (3,2);
INSERT INTO vehicle_fuel_for_type (vehicle_fuel_id,vehicle_type_id) VALUES (4,2);
INSERT INTO vehicle_fuel_for_type (vehicle_fuel_id,vehicle_type_id) VALUES (5,2);
INSERT INTO vehicle_fuel_for_type (vehicle_fuel_id,vehicle_type_id) VALUES (6,2);
INSERT INTO vehicle_fuel_for_type (vehicle_fuel_id,vehicle_type_id) VALUES (7,2);
INSERT INTO vehicle_fuel_for_type (vehicle_fuel_id,vehicle_type_id) VALUES (8,2);

/* vehicle break */
INSERT INTO vehicle_break (`break`) VALUES ('Disk');
INSERT INTO vehicle_break (`break`) VALUES ('Drum');
INSERT INTO vehicle_break (`break`) VALUES ('Other');

/* vehicle break for type */
INSERT INTO vehicle_break_for_type (vehicle_break_id,vehicle_type_id) VALUES (1,1);
INSERT INTO vehicle_break_for_type (vehicle_break_id,vehicle_type_id) VALUES (2,1);

INSERT INTO vehicle_break_for_type (vehicle_break_id,vehicle_type_id) VALUES (1,2);
INSERT INTO vehicle_break_for_type (vehicle_break_id,vehicle_type_id) VALUES (2,2);

/* vehicle suspension */
INSERT INTO vehicle_suspension (`suspension`) VALUES ('Telescopic Forks');
INSERT INTO vehicle_suspension (`suspension`) VALUES ('Shock absorbers');
INSERT INTO vehicle_suspension (`suspension`) VALUES ('Hossack Fork');
INSERT INTO vehicle_suspension (`suspension`) VALUES ('Single Sided');
INSERT INTO vehicle_suspension (`suspension`) VALUES ('Hub-center Steering');

INSERT INTO vehicle_suspension (`suspension`) VALUES ('Swing Axle');
INSERT INTO vehicle_suspension (`suspension`) VALUES ('Sliding Pillar');
INSERT INTO vehicle_suspension (`suspension`) VALUES ('MacPherson Strut');
INSERT INTO vehicle_suspension (`suspension`) VALUES ('Wishbone');
INSERT INTO vehicle_suspension (`suspension`) VALUES ('Double Wishbone');
INSERT INTO vehicle_suspension (`suspension`) VALUES ('Multi-link');
INSERT INTO vehicle_suspension (`suspension`) VALUES ('Semi-trailing Arm');
INSERT INTO vehicle_suspension (`suspension`) VALUES ('Swinging Arm');

/* vehicle suspension for type */
INSERT INTO vehicle_suspension_for_type (vehicle_suspension_id,vehicle_type_id) VALUES (1,1);
INSERT INTO vehicle_suspension_for_type (vehicle_suspension_id,vehicle_type_id) VALUES (2,1);
INSERT INTO vehicle_suspension_for_type (vehicle_suspension_id,vehicle_type_id) VALUES (3,1);
INSERT INTO vehicle_suspension_for_type (vehicle_suspension_id,vehicle_type_id) VALUES (4,1);
INSERT INTO vehicle_suspension_for_type (vehicle_suspension_id,vehicle_type_id) VALUES (5,1);

INSERT INTO vehicle_suspension_for_type (vehicle_suspension_id,vehicle_type_id) VALUES (6,2);
INSERT INTO vehicle_suspension_for_type (vehicle_suspension_id,vehicle_type_id) VALUES (7,2);
INSERT INTO vehicle_suspension_for_type (vehicle_suspension_id,vehicle_type_id) VALUES (8,2);
INSERT INTO vehicle_suspension_for_type (vehicle_suspension_id,vehicle_type_id) VALUES (9,2);
INSERT INTO vehicle_suspension_for_type (vehicle_suspension_id,vehicle_type_id) VALUES (10,2);
INSERT INTO vehicle_suspension_for_type (vehicle_suspension_id,vehicle_type_id) VALUES (11,2);
INSERT INTO vehicle_suspension_for_type (vehicle_suspension_id,vehicle_type_id) VALUES (12,2);
INSERT INTO vehicle_suspension_for_type (vehicle_suspension_id,vehicle_type_id) VALUES (13,2);

/* vehicle brand */
INSERT INTO vehicle_brand (`brand`) VALUES ('TVS');
INSERT INTO vehicle_brand (`brand`) VALUES ('Bajaj');
INSERT INTO vehicle_brand (`brand`) VALUES ('Ducati');
INSERT INTO vehicle_brand (`brand`) VALUES ('Harley-Davidson');
INSERT INTO vehicle_brand (`brand`) VALUES ('Hero');
INSERT INTO vehicle_brand (`brand`) VALUES ('Indian');
INSERT INTO vehicle_brand (`brand`) VALUES ('Kawasaki');
INSERT INTO vehicle_brand (`brand`) VALUES ('KTM');
INSERT INTO vehicle_brand (`brand`) VALUES ('Vespa');
INSERT INTO vehicle_brand (`brand`) VALUES ('Yahama');
INSERT INTO vehicle_brand (`brand`) VALUES ('Aprilia');
INSERT INTO vehicle_brand (`brand`) VALUES ('Benelli');
INSERT INTO vehicle_brand (`brand`) VALUES ('Cafe Racer');
INSERT INTO vehicle_brand (`brand`) VALUES ('CFMOTO');
INSERT INTO vehicle_brand (`brand`) VALUES ('MV Augusta');
INSERT INTO vehicle_brand (`brand`) VALUES ('Royal Enfield');
INSERT INTO vehicle_brand (`brand`) VALUES ('Scomadi');

INSERT INTO vehicle_brand (`brand`) VALUES ('BMW');
INSERT INTO vehicle_brand (`brand`) VALUES ('Suzuki');
INSERT INTO vehicle_brand (`brand`) VALUES ('Honda');

INSERT INTO vehicle_brand (`brand`) VALUES ('Audi');
INSERT INTO vehicle_brand (`brand`) VALUES ('Ford');
INSERT INTO vehicle_brand (`brand`) VALUES ('Hyundai');
INSERT INTO vehicle_brand (`brand`) VALUES ('Kia');
INSERT INTO vehicle_brand (`brand`) VALUES ('Mazda');
INSERT INTO vehicle_brand (`brand`) VALUES ('Mercedes-Benz');
INSERT INTO vehicle_brand (`brand`) VALUES ('Mitsubishi');
INSERT INTO vehicle_brand (`brand`) VALUES ('Nishan');
INSERT INTO vehicle_brand (`brand`) VALUES ('Subaru');
INSERT INTO vehicle_brand (`brand`) VALUES ('Toyota');
INSERT INTO vehicle_brand (`brand`) VALUES ('Volkswagen');
INSERT INTO vehicle_brand (`brand`) VALUES ('Austin');
INSERT INTO vehicle_brand (`brand`) VALUES ('Chevrolet');
INSERT INTO vehicle_brand (`brand`) VALUES ('Datsun');
INSERT INTO vehicle_brand (`brand`) VALUES ('Fiat');
INSERT INTO vehicle_brand (`brand`) VALUES ('Isuzu');
INSERT INTO vehicle_brand (`brand`) VALUES ('Jaguar');
INSERT INTO vehicle_brand (`brand`) VALUES ('Jeep');
INSERT INTO vehicle_brand (`brand`) VALUES ('Land Rover');
INSERT INTO vehicle_brand (`brand`) VALUES ('Range Rover');
INSERT INTO vehicle_brand (`brand`) VALUES ('Mahindra');
INSERT INTO vehicle_brand (`brand`) VALUES ('Renault');
INSERT INTO vehicle_brand (`brand`) VALUES ('Scoda');
INSERT INTO vehicle_brand (`brand`) VALUES ('Tesla');
INSERT INTO vehicle_brand (`brand`) VALUES ('TATA');
INSERT INTO vehicle_brand (`brand`) VALUES ('Volvo');

/* vehicle brand for type */
INSERT INTO vehicle_brand_for_type (vehicle_brand_id,vehicle_type_id) VALUES (1,1);
INSERT INTO vehicle_brand_for_type (vehicle_brand_id,vehicle_type_id) VALUES (2,1);
INSERT INTO vehicle_brand_for_type (vehicle_brand_id,vehicle_type_id) VALUES (3,1);
INSERT INTO vehicle_brand_for_type (vehicle_brand_id,vehicle_type_id) VALUES (4,1);
INSERT INTO vehicle_brand_for_type (vehicle_brand_id,vehicle_type_id) VALUES (5,1);
INSERT INTO vehicle_brand_for_type (vehicle_brand_id,vehicle_type_id) VALUES (6,1);
INSERT INTO vehicle_brand_for_type (vehicle_brand_id,vehicle_type_id) VALUES (7,1);
INSERT INTO vehicle_brand_for_type (vehicle_brand_id,vehicle_type_id) VALUES (8,1);
INSERT INTO vehicle_brand_for_type (vehicle_brand_id,vehicle_type_id) VALUES (9,1);
INSERT INTO vehicle_brand_for_type (vehicle_brand_id,vehicle_type_id) VALUES (10,1);
INSERT INTO vehicle_brand_for_type (vehicle_brand_id,vehicle_type_id) VALUES (11,1);
INSERT INTO vehicle_brand_for_type (vehicle_brand_id,vehicle_type_id) VALUES (12,1);
INSERT INTO vehicle_brand_for_type (vehicle_brand_id,vehicle_type_id) VALUES (13,1);
INSERT INTO vehicle_brand_for_type (vehicle_brand_id,vehicle_type_id) VALUES (14,1);
INSERT INTO vehicle_brand_for_type (vehicle_brand_id,vehicle_type_id) VALUES (15,1);
INSERT INTO vehicle_brand_for_type (vehicle_brand_id,vehicle_type_id) VALUES (16,1);
INSERT INTO vehicle_brand_for_type (vehicle_brand_id,vehicle_type_id) VALUES (17,1);

INSERT INTO vehicle_brand_for_type (vehicle_brand_id,vehicle_type_id) VALUES (18,1);
INSERT INTO vehicle_brand_for_type (vehicle_brand_id,vehicle_type_id) VALUES (19,1);
INSERT INTO vehicle_brand_for_type (vehicle_brand_id,vehicle_type_id) VALUES (20,1);
INSERT INTO vehicle_brand_for_type (vehicle_brand_id,vehicle_type_id) VALUES (18,2);
INSERT INTO vehicle_brand_for_type (vehicle_brand_id,vehicle_type_id) VALUES (19,2);
INSERT INTO vehicle_brand_for_type (vehicle_brand_id,vehicle_type_id) VALUES (20,2);

INSERT INTO vehicle_brand_for_type (vehicle_brand_id,vehicle_type_id) VALUES (21,2);
INSERT INTO vehicle_brand_for_type (vehicle_brand_id,vehicle_type_id) VALUES (22,2);
INSERT INTO vehicle_brand_for_type (vehicle_brand_id,vehicle_type_id) VALUES (23,2);
INSERT INTO vehicle_brand_for_type (vehicle_brand_id,vehicle_type_id) VALUES (24,2);
INSERT INTO vehicle_brand_for_type (vehicle_brand_id,vehicle_type_id) VALUES (25,2);
INSERT INTO vehicle_brand_for_type (vehicle_brand_id,vehicle_type_id) VALUES (26,2);
INSERT INTO vehicle_brand_for_type (vehicle_brand_id,vehicle_type_id) VALUES (27,2);
INSERT INTO vehicle_brand_for_type (vehicle_brand_id,vehicle_type_id) VALUES (28,2);
INSERT INTO vehicle_brand_for_type (vehicle_brand_id,vehicle_type_id) VALUES (29,2);
INSERT INTO vehicle_brand_for_type (vehicle_brand_id,vehicle_type_id) VALUES (30,2);
INSERT INTO vehicle_brand_for_type (vehicle_brand_id,vehicle_type_id) VALUES (31,2);
INSERT INTO vehicle_brand_for_type (vehicle_brand_id,vehicle_type_id) VALUES (32,2);
INSERT INTO vehicle_brand_for_type (vehicle_brand_id,vehicle_type_id) VALUES (33,2);
INSERT INTO vehicle_brand_for_type (vehicle_brand_id,vehicle_type_id) VALUES (34,2);
INSERT INTO vehicle_brand_for_type (vehicle_brand_id,vehicle_type_id) VALUES (35,2);
INSERT INTO vehicle_brand_for_type (vehicle_brand_id,vehicle_type_id) VALUES (36,2);
INSERT INTO vehicle_brand_for_type (vehicle_brand_id,vehicle_type_id) VALUES (37,2);
INSERT INTO vehicle_brand_for_type (vehicle_brand_id,vehicle_type_id) VALUES (38,2);
INSERT INTO vehicle_brand_for_type (vehicle_brand_id,vehicle_type_id) VALUES (39,2);
INSERT INTO vehicle_brand_for_type (vehicle_brand_id,vehicle_type_id) VALUES (40,2);
INSERT INTO vehicle_brand_for_type (vehicle_brand_id,vehicle_type_id) VALUES (41,2);
INSERT INTO vehicle_brand_for_type (vehicle_brand_id,vehicle_type_id) VALUES (42,2);
INSERT INTO vehicle_brand_for_type (vehicle_brand_id,vehicle_type_id) VALUES (43,2);
INSERT INTO vehicle_brand_for_type (vehicle_brand_id,vehicle_type_id) VALUES (44,2);
INSERT INTO vehicle_brand_for_type (vehicle_brand_id,vehicle_type_id) VALUES (45,2);
INSERT INTO vehicle_brand_for_type (vehicle_brand_id,vehicle_type_id) VALUES (46,2);

/* vehicle modal */
INSERT INTO `vehicle_model` (`model`,`year`,`vehicle_brand_id`) VALUES ('RC 200','2011',11);
INSERT INTO `vehicle_model` (`model`,`year`,`vehicle_brand_id`) VALUES ('RC 200','2011',8);
INSERT INTO `vehicle_model` (`model`,`year`,`vehicle_brand_id`) VALUES ('Duke 200','2011',8);
INSERT INTO `vehicle_model` (`model`,`year`,`vehicle_brand_id`) VALUES ('RC 390','2012',8);
INSERT INTO `vehicle_model` (`model`,`year`,`vehicle_brand_id`) VALUES ('Duke 390','2012',8);

/* user_type */
INSERT INTO user_type (type) VALUES ('admin');
INSERT INTO user_type (type) VALUES ('seller');
INSERT INTO user_type (type) VALUES ('visitor');

/* user */
INSERT INTO 
    user (first_name,last_name,email,password,phone,created_date,last_login,user_type_id) 
    VALUES ('Admin','Admin','admin@gmail.com','password','9063689659','2020-07-23 13:10:11','2020-07-23 13:10:11',1);

INSERT INTO 
    user (first_name,last_name,email,password,phone,created_date,last_login,user_type_id) 
    VALUES ('Seller','Seller','seller@gmail.com','password','9876543210','2020-07-23 13:10:11','2020-07-23 13:10:11',2);




