<?php

    // endpoint = /vehicle/page/5/items/40
    Api::get('/vehicle/page' . Api::INTEGER . '/items' . Api::INTEGER, function($page, $items){

        if($page < 1) Api::send([
            "success" => FALSE,
            "message" => "Invalid: page",
        ]);

        if($items < 1) Api::send([
            "success" => FALSE,
            "message" => "Invalid: limit",
        ]);

        $rowCount = Database::query('SELECT count(*) AS "count" FROM user_vehicle WHERE status="public";')[0]['count'];
        $maxReach = $page * $items;

        $offSet = ($page - 1) * $items;

        if($page != 1 && $rowCount < $maxReach) Api::send([
            "success" => TRUE,
            "content" => [],
        ]);

        $sql = "SELECT
                    vehicle_id AS id
                FROM user_vehicle
                WHERE status=?
                ORDER BY added_date DESC
                LIMIT ?,?;
                ";

        $vehicleIds = Database::query($sql, "public", $offSet, $items);

        if(!$vehicleIds) Api::send([
            "success" => FALSE,
            "message" => "Unable to fetch enquiries",
        ]);

        $vehicles = [];
        foreach($vehicleIds as $vehicleId) {
            $vehicles[] = getVehicleById($vehicleId['id']);
        }

        Api::send([
            "success" => TRUE,
            "content" => $vehicles,
        ]);

    });