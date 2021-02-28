<?php
    /*
    *   /user/{userId}/image
    *   Api to get user's image providing user's id
    */
    Api::get('/user'.Api::INTEGER.'/image', function($userId){

        if($userId < 1) Api::send([
            "success" => FALSE, 
            "message" => "Invalid: userId"
        ]);

        $sql = "SELECT 
                    image.id AS id,
                    image.name AS name
                FROM image
                INNER JOIN user_image
                    ON user_image.image_id = image.id
                INNER JOIN user
                    ON user.id = user_image.user_id
                WHERE user.id = ?
                ORDER BY image.id DESC
                LIMIT ?;
                ";
        
        $data = Database::query($sql, $userId, 1);

        $data = $data ? $data[0] : [];

        Api::send([
            "success" => TRUE,
            "content" => $data
        ]);
    });

    /*
    *   /user/{userId}/name
    *   Api to get user's name providing user's id
    */
    Api::get('/user'.Api::INTEGER.'/name', function($userId){

        if($userId < 1) Api::send([
            "success" => FALSE, 
            "message" => "Invalid: userId"
        ]);
        
        $sql = "SELECT 
                    user.first_name AS firstName,
                    user.last_name AS lastName,
                    CONCAT(user.first_name, ' ', user.last_name) AS fullName
                FROM user
                WHERE user.id = ?;
                ";
        
        $data = Database::query($sql, $userId);

        $data = $data ? $data[0] : [];

        Api::send([
            "success" => TRUE,
            "content" => $data
        ]);

    });

    /*
    *   /user/{userId}/email
    *   Api to get user's email providing user's id
    */
    Api::get('/user'.Api::INTEGER.'/email', function($userId){

        if($userId < 1) Api::send([
            "success" => FALSE, 
            "message" => "Invalid: userId"
        ]);
        
        $sql = "SELECT 
                    user.email AS email
                FROM user
                WHERE user.id = ?;
                ";
        
        $data = Database::query($sql, $userId);

        $data = $data ? $data[0] : [];

        Api::send([
            "success" => TRUE,
            "content" => $data
        ]);

    });

    /*
    *   /user/{userId}/phone
    *   Api to get user's phone providing user's id
    */
    Api::get('/user'.Api::INTEGER.'/phone', function($userId){

        if($userId < 1) Api::send([
            "success" => FALSE, 
            "message" => "Invalid: userId"
        ]);
        
        $sql = "SELECT 
                    user.phone AS phone
                FROM user
                WHERE user.id = ?;
                ";
        
        $data = Database::query($sql, $userId);

        $data = $data ? $data[0] : [];

        Api::send([
            "success" => TRUE,
            "content" => $data
        ]);

    });

    /*
    *   /user/{userId}/details
    *   Api to get user's information providing user's id
    */
    Api::get('/user'.Api::INTEGER.'/info', function($userId){

        if($userId < 1) Api::send([
            "success" => FALSE, 
            "message" => "Invalid: userId"
        ]);

        $data = getUserById($userId);

        Api::send([
            "success" => TRUE,
            "content" => $data
        ]);
        
    });

    /*
    *   /user/{userId}/vehicles
    *   Api to get user's phone providing user's id
    */
    Api::get(Api::INTEGER.'/vehicles', function($userId){

        $sql = "SELECT user_vehicle.vehicle_id AS id
                FROM user_vehicle 
                WHERE user_vehicle.user_id=? AND user_vehicle.status!=?
                ORDER BY user_vehicle.vehicle_id DESC;
                ";

        $vehicleIds = Database::query($sql, $userId, "removed");

        $data = [];
        foreach($vehicleIds as $vehicleId){
            array_push($data, getVehicleById($vehicleId['id'])); 
        }

        Api::send($data);

    });

