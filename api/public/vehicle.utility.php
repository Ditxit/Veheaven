<?php

    // Function to get single vehicle details from passed id
    function getVehicleById($vehicleId){
        $sql = "SELECT 
                user_vehicle.user_id AS seller,
                user_vehicle.status AS status,
                user_vehicle.added_date AS added_date,
                user_vehicle.last_updated AS last_updated,
                vehicle.id AS id,
                vehicle.name AS name,
                vehicle.price AS price,
                vehicle.mileage AS mileage,
                vehicle.engine AS engine,
                vehicle.bhp AS bhp,
                vehicle.turn_radius AS turn_radius,
                vehicle.seat AS seat,
                vehicle.top_speed AS top_speed,
                vehicle.vehicle_condition_id AS \"condition\",
                vehicle.vehicle_type_id AS type,
                vehicle.vehicle_body_id AS body,
                vehicle.vehicle_transmission_id AS transmission,
                vehicle.front_vehicle_tyre_id AS front_tyre,
                vehicle.rear_vehicle_tyre_id AS rear_tyre,
                vehicle.vehicle_fuel_id AS fuel,
                vehicle.vehicle_fuel_capacity AS fuel_capacity,
                vehicle.front_vehicle_break_id AS front_break,
                vehicle.rear_vehicle_break_id AS rear_break,
                vehicle.front_vehicle_suspension_id AS front_suspension,
                vehicle.rear_vehicle_suspension_id AS rear_suspension,
                vehicle.vehicle_model_id AS model
            FROM user_vehicle
            INNER JOIN vehicle
                ON user_vehicle.vehicle_id = vehicle.id
            WHERE user_vehicle.vehicle_id=?;
        ";

        $vehicle = Database::query($sql, $vehicleId);

        if(count($vehicle) < 1) {
            Api::send([
                "success" => FALSE,
                "message" => "No vehicle found with id: " . $vehicleId,
            ]);
        }

        $vehicle = $vehicle[0];

        // For seller data
        $sql = "SELECT
                    user.id AS id,
                    user.first_name AS first_name,
                    user.last_name AS last_name,
                    user.email AS email,
                    user.phone AS phone
                FROM user
                WHERE user.id=?;
                ";
        $vehicle['seller'] = Database::query($sql, $vehicle['seller'])[0];

        // For vehicle condition
        $sql = "SELECT 
                vehicle_condition.id AS id, 
                vehicle_condition.condition AS \"condition\"
                FROM vehicle_condition
                INNER JOIN vehicle
                    ON vehicle_condition.id = vehicle.vehicle_condition_id
                WHERE vehicle.vehicle_condition_id = ?;
                ";

        $vehicle['condition'] = Database::query($sql, $vehicle['condition'])[0];

        // For vehicle type
        $sql = "SELECT 
                vehicle_type.id AS id, 
                vehicle_type.type AS type
                FROM vehicle_type
                INNER JOIN vehicle
                    ON vehicle_type.id = vehicle.vehicle_type_id
                WHERE vehicle.vehicle_type_id = ?;
                ";

        $vehicle['type'] = Database::query($sql, $vehicle['type'])[0];

        // For vehicle body
        $sql = "SELECT 
                vehicle_body.id AS id, 
                vehicle_body.body AS body
                FROM vehicle_body
                INNER JOIN vehicle
                    ON vehicle_body.id = vehicle.vehicle_body_id
                WHERE vehicle.vehicle_body_id = ?;
                ";

        $vehicle['body'] = Database::query($sql, $vehicle['body'])[0];

        // For vehicle transmission
        $sql = "SELECT 
                vehicle_transmission.id AS id, 
                vehicle_transmission.transmission AS transmission
                FROM vehicle_transmission
                INNER JOIN vehicle
                    ON vehicle_transmission.id = vehicle.vehicle_transmission_id
                WHERE vehicle.vehicle_transmission_id = ?;
                ";

        $vehicle['transmission'] = Database::query($sql, $vehicle['transmission'])[0];

        // For vehicle front tyre
        $sql = "SELECT 
                vehicle_tyre.id AS id, 
                vehicle_tyre.tyre AS tyre
                FROM vehicle_tyre
                INNER JOIN vehicle
                    ON vehicle_tyre.id = vehicle.front_vehicle_tyre_id
                WHERE vehicle.front_vehicle_tyre_id = ?;
                ";

        $vehicle['front_tyre'] = Database::query($sql, $vehicle['front_tyre'])[0];

        // For vehicle rear tyre
        $sql = "SELECT 
                vehicle_tyre.id AS id, 
                vehicle_tyre.tyre AS tyre
                FROM vehicle_tyre
                INNER JOIN vehicle
                    ON vehicle_tyre.id = vehicle.rear_vehicle_tyre_id
                WHERE vehicle.rear_vehicle_tyre_id = ?;
                ";

        $vehicle['rear_tyre'] = Database::query($sql, $vehicle['rear_tyre'])[0];

        // For vehicle fuel
        $sql = "SELECT 
                vehicle_fuel.id AS id, 
                vehicle_fuel.fuel AS fuel
                FROM vehicle_fuel
                INNER JOIN vehicle
                    ON vehicle_fuel.id = vehicle.vehicle_fuel_id
                WHERE vehicle.vehicle_fuel_id = ?;
                ";

        $vehicle['fuel'] = Database::query($sql, $vehicle['fuel'])[0];

        // For vehicle front break
        $sql = "SELECT 
                vehicle_break.id AS id, 
                vehicle_break.break AS break
                FROM vehicle_break
                INNER JOIN vehicle
                    ON vehicle_break.id = vehicle.front_vehicle_break_id
                WHERE vehicle.front_vehicle_break_id = ?;
                ";

        $vehicle['front_break'] = Database::query($sql, $vehicle['front_break'])[0];

        // For vehicle rear break
        $sql = "SELECT 
                vehicle_break.id AS id, 
                vehicle_break.break AS break
                FROM vehicle_break
                INNER JOIN vehicle
                    ON vehicle_break.id = vehicle.rear_vehicle_break_id
                WHERE vehicle.rear_vehicle_break_id = ?;
                ";

        $vehicle['rear_break'] = Database::query($sql, $vehicle['rear_break'])[0];

        // For vehicle front suspension
        $sql = "SELECT 
                vehicle_suspension.id AS id, 
                vehicle_suspension.suspension AS suspension
                FROM vehicle_suspension
                INNER JOIN vehicle
                    ON vehicle_suspension.id = vehicle.front_vehicle_suspension_id
                WHERE vehicle.front_vehicle_suspension_id = ?;
                ";

        $vehicle['front_suspension'] = Database::query($sql, $vehicle['front_suspension'])[0];

        // For vehicle rear suspension
        $sql = "SELECT 
                vehicle_suspension.id AS id, 
                vehicle_suspension.suspension AS suspension
                FROM vehicle_suspension
                INNER JOIN vehicle
                    ON vehicle_suspension.id = vehicle.rear_vehicle_suspension_id
                WHERE vehicle.rear_vehicle_suspension_id = ?;
                ";

        $vehicle['rear_suspension'] = Database::query($sql, $vehicle['rear_suspension'])[0];

        // For vehicle make & model
        $sql = "SELECT 
                vehicle_model.id AS id, 
                vehicle_model.model AS model,
                vehicle_model.year AS \"year\",
                vehicle_brand.brand AS brand
                FROM vehicle_model
                INNER JOIN vehicle_brand
                    ON vehicle_model.vehicle_brand_id = vehicle_brand.id
                INNER JOIN vehicle
                    ON vehicle_model.id = vehicle.vehicle_model_id
                WHERE vehicle.vehicle_model_id = ?;
                ";

        $vehicle['model'] = Database::query($sql, $vehicle['model'])[0];

        // For vehicle images
        $sql = "SELECT 
                vehicle_image.image_id AS id,
                image.name AS name
                FROM vehicle_image
                    INNER JOIN image
                    ON image.id = vehicle_image.image_id
                WHERE vehicle_image.vehicle_id=?;
            ";
        $vehicle['images'] = Database::query($sql, $vehicleId);

        // For vehicle features
        $sql = "SELECT 
                vehicle_feature_list.vehicle_feature_id AS id,
                vehicle_feature.feature AS feature,
                vehicle_feature_category.category AS category
                FROM vehicle_feature_category
                    INNER JOIN vehicle_feature
                    ON vehicle_feature_category.id = vehicle_feature.vehicle_feature_category_id
                    INNER JOIN vehicle_feature_list
                    ON vehicle_feature.id = vehicle_feature_list.vehicle_feature_id
                WHERE vehicle_feature_list.vehicle_id=?;
            ";
        $vehicle['features'] = Database::query($sql, $vehicleId);

        // For vehicle colors
        $sql = "SELECT 
                vehicle_color.id AS id,
                vehicle_color.color AS color,
                vehicle_color.hexcode AS hexcode
                FROM vehicle_color
                    INNER JOIN vehicle_color_list
                    ON vehicle_color.id = vehicle_color_list.vehicle_color_id
                WHERE vehicle_color_list.vehicle_id=?;
            ";
        $vehicle['colors'] = Database::query($sql, $vehicleId);

        // For used vehicle specific datas
        if($vehicle['condition']['condition'] == 'Used'){
            $sql = "SELECT
                used_vehicle.owners AS owners,
                used_vehicle.owners_message AS \"message\",
                used_vehicle.distance AS distance,
                used_vehicle.registered_date AS registered_date,
                vehicle_province.province AS province
                FROM used_vehicle
                    INNER JOIN vehicle_province
                    ON used_vehicle.vehicle_province_id = vehicle_province.id
                WHERE used_vehicle.vehicle_id=?;
            ";
            $vehicle['used_vehicle'] = Database::query($sql, $vehicleId)[0];
        }  

        return $vehicle;
    }