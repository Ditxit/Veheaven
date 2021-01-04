
<?php

    include 'doodle/doodle.php';

    /* Token Debug*/
    Api::get('/user-token/verify'.API::STRING,function($token){

        if(Token::isEmpty($token)){
            Api::send([
                "success" => FALSE,
                "message" => "Token was empty"
            ]);
        }else if(Token::isInvalid($token)){
            Api::send([
                "success" => FALSE,
                "message" => "Token was invalid"
            ]);
        }else if(Token::isExpired($token)){
            Api::send([
                "success" => FALSE,
                "message" => "Token was expired"
            ]);
        }else if(Token::isTampered($token)){
            Api::send([
                "success" => FALSE,
                "message" => "Token was tampered"
            ]);
        } else { /* ignore */ }
        
        $payload = Token::getPayload($token);

        if(!isset($payload['user_type'])) {
            Api::send([
                "success" => FALSE,
                "message" => "Token was not user token"
            ]);
        }else{
            Api::send([
                "success" => TRUE
            ]);
        }
        
    });

    Api::get('/token/payload'.API::STRING,function($token){

        if(Token::isTampered($token)){
            Api::send([
                "success" => FALSE,
                "message" => "Token was tampered"
            ]);
        } else {
            Api::send([
                "success" => TRUE,
                "payload" => Token::getPayload($token)
            ]);
        }
        
    });

     /* General Login API */
     Api::post('/login',function(){

        $sql = "SELECT 
                user.id, 
                user.first_name, 
                user.last_name, 
                user.email, 
                user.phone, 
                user_type.type AS user_type 
                FROM user 
                INNER JOIN user_type 
                    ON user.user_type_id = user_type.id 
                WHERE user.email=? AND user.password=?;";

        $data = Database::query($sql, $_POST['email'], $_POST['password']);

        if($data){
            $data = $data[0];
            $data['token'] = Token::create($data);
        }

        Api::send($data);

    });

    /* Get User Vehicles */
    Api::get(Api::INTEGER.'/vehicles',function($user_id){
        $sql = "SELECT 
                user_vehicle.vehicle_id AS id, 
                user_vehicle.status AS status, 
                user_vehicle.added_date AS added_date,
                user_vehicle.last_updated AS last_updated,
                vehicle.name AS name,
                vehicle.price AS price,
                vehicle.mileage AS mileage,
                vehicle.engine AS engine,
                vehicle.bhp AS bhp,
                vehicle.turn_radius AS turn_radius,
                vehicle.seat AS seat,
                vehicle.top_speed AS top_speed,
                vehicle.vehicle_fuel_capacity AS fuel_capacity
                FROM user_vehicle
                INNER JOIN vehicle
                    ON user_vehicle.vehicle_id = vehicle.id
                WHERE user_vehicle.user_id=? AND user_vehicle.status != 'removed' 
                ORDER BY user_vehicle.vehicle_id DESC;
                ";
        
        $vehicles = Database::query($sql,$user_id);

        foreach ($vehicles as $index=>$vehicle) {
            $sql = "SELECT 
                vehicle_image.image_id AS id,
                image.name AS name
                FROM vehicle_image
                    INNER JOIN image
                    ON image.id = vehicle_image.image_id
                WHERE vehicle_image.vehicle_id=?;
            ";
            $images = Database::query($sql,$vehicles[$index]['id']);
            $vehicles[$index]['images'] = $images;
        }

        Api::send($vehicles);
    });

    /* Get Single Vehicle Detail */
    Api::get('/vehicle'.Api::INTEGER,function($vehicle_id){

        $sql = "SELECT 
                user_vehicle.user_id AS seller,
                user_vehicle.status AS status,
                user_vehicle.added_date AS added_date,
                user_vehicle.last_updated AS last_updated,
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

        $vehicle = Database::query($sql,$vehicle_id)[0];

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
        $vehicle['images'] = Database::query($sql,$vehicle_id);

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
        $vehicle['features'] = Database::query($sql,$vehicle_id);

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
        $vehicle['colors'] = Database::query($sql,$vehicle_id);

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
        }
        $vehicle['used_vehicle'] = Database::query($sql,$vehicle_id)[0];

        Api::send($vehicle);

    });

    /* Get Provinces */
    Api::get('/province',function(){
        $sql = "SELECT `id`, `number`, `province` FROM `vehicle_province` ORDER BY `number` ASC;";
        $data = Database::query($sql);
        Api::send($data);
    });

    /* Get Vehicle Body */
    Api::get('/body'.Api::INTEGER,function($id){
        $sql = "SELECT 
                    vehicle_body.id AS id, 
                    vehicle_body.body AS body 
                FROM vehicle_body_for_type
                INNER JOIN vehicle_body
                    ON vehicle_body_for_type.vehicle_body_id = vehicle_body.id
                WHERE vehicle_body_for_type.vehicle_type_id=?
                ORDER BY vehicle_body.body ASC;
                ";
        $data = Database::query($sql,$id);
        Api::send($data);
    });

    /* Get Vehicle Brand */
    Api::get('/brand'.Api::INTEGER,function($id){
        $sql = "SELECT 
                    vehicle_brand.id AS id, 
                    vehicle_brand.brand AS brand 
                FROM vehicle_brand_for_type
                INNER JOIN vehicle_brand
                    ON vehicle_brand_for_type.vehicle_brand_id = vehicle_brand.id
                WHERE vehicle_brand_for_type.vehicle_type_id=? 
                ORDER BY vehicle_brand.brand ASC;
                ";
        $data = Database::query($sql,$id);
        Api::send($data);
    });

    /* Get Vehicle Model */
    Api::get('/model'.Api::INTEGER.Api::INTEGER,function($vehicle_type_id,$vehicle_brand_id){
        $sql = "SELECT 
                    vehicle_model.id AS id, 
                    vehicle_model.model AS model 
                FROM vehicle_model
                INNER JOIN vehicle_brand
                    ON vehicle_model.vehicle_brand_id = vehicle_brand.id
                INNER JOIN vehicle_brand_for_type
                    ON vehicle_brand.id = vehicle_brand_for_type.vehicle_brand_id
                WHERE vehicle_brand_for_type.vehicle_type_id=? 
                    AND vehicle_brand_for_type.vehicle_brand_id=?
                ORDER BY vehicle_model.model ASC;
                ";
        $data = Database::query($sql,$vehicle_type_id,$vehicle_brand_id);
        Api::send($data);
    });

    /* Get Vehicle Fuel */
    Api::get('/fuel'.Api::INTEGER,function($id){
        $sql = "SELECT 
                    vehicle_fuel.id AS id, 
                    vehicle_fuel.fuel AS fuel 
                FROM vehicle_fuel_for_type
                INNER JOIN vehicle_fuel
                    ON vehicle_fuel_for_type.vehicle_fuel_id = vehicle_fuel.id
                WHERE vehicle_fuel_for_type.vehicle_type_id=?
                ORDER BY vehicle_fuel.fuel ASC;
                ";
        $data = Database::query($sql,$id);
        Api::send($data);
    });

    /* Get Vehicle Suspension */
    Api::get('/suspension'.Api::INTEGER,function($id){
        $sql = "SELECT 
                    vehicle_suspension.id AS id, 
                    vehicle_suspension.suspension AS suspension 
                FROM vehicle_suspension_for_type
                INNER JOIN vehicle_suspension
                    ON vehicle_suspension_for_type.vehicle_suspension_id = vehicle_suspension.id
                WHERE vehicle_suspension_for_type.vehicle_type_id=?
                ORDER BY vehicle_suspension.suspension ASC;
                ";
        $data = Database::query($sql,$id);
        Api::send($data);
    });

    /* Get Vehicle Colors */
    Api::get('/colors',function(){
        $sql = "SELECT `id`, `color`, `hexcode` FROM `vehicle_color` ORDER BY `color` ASC;";
        $data = Database::query($sql);
        Api::send($data);
    });

    /* Get Vehicle Features */
    Api::get('/features'.Api::INTEGER,function($id){
        $sql = "
            SELECT vehicle_feature.id, vehicle_feature.feature, vehicle_feature_category.category FROM vehicle_feature_for_type INNER JOIN vehicle_feature ON vehicle_feature_for_type.vehicle_feature_id = vehicle_feature.id INNER JOIN vehicle_feature_category ON vehicle_feature_category.id = vehicle_feature.vehicle_feature_category_id WHERE vehicle_feature_for_type.vehicle_type_id = ?;
        ";
        $data = Database::query($sql,$id);
        Api::send($data);
    });

    /* Post Vehicle */
    Api::post('/vehicle/add',function(){
        if(isset($_POST['token']) && !Token::isTampered($_POST['token']) && !Token::isExpired($_POST['token'])){

            $payload = Token::getPayload($_POST['token']);

            if($payload['user_type'] == 'seller'){ $_POST['vehicle-condition'] = '2'; }

            $sql = "INSERT INTO `vehicle` (`name`, `price`, `mileage`, `engine`, `bhp`, `turn_radius`, `seat`, `top_speed`, `vehicle_condition_id`, `vehicle_type_id`, `vehicle_body_id`, `vehicle_transmission_id`, `front_vehicle_tyre_id`, `rear_vehicle_tyre_id`, `vehicle_fuel_id`, `vehicle_fuel_capacity`, `front_vehicle_break_id`, `rear_vehicle_break_id`, `front_vehicle_suspension_id`, `rear_vehicle_suspension_id`, `vehicle_model_id`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
            
            $data = Database::query(
                $sql,
                $_POST['vehicle-name'],
                $_POST['vehicle-price'],
                $_POST['vehicle-mileage'],
                $_POST['vehicle-cc'],
                $_POST['vehicle-bhp'],
                $_POST['vehicle-turn-radius'],
                $_POST['vehicle-seat'],
                $_POST['vehicle-top-speed'],
                $_POST['vehicle-condition'],
                $_POST['vehicle-type'],
                $_POST['vehicle-body'],
                $_POST['vehicle-transmission'],
                $_POST['vehicle-front-tyre'],
                $_POST['vehicle-rear-tyre'],
                $_POST['vehicle-fuel'],
                $_POST['vehicle-fuel-capacity'],
                $_POST['vehicle-front-break'],
                $_POST['vehicle-rear-break'],
                $_POST['vehicle-front-suspension'],
                $_POST['vehicle-rear-suspension'],
                $_POST['vehicle-model']
            );
            
            Api::send($data);
                
        }
        Api::send(['Token Error']);
    });

    /* 
    *   Add data to used_vehicle table 
    *   $_POST = [
            'token'='...',
            'vehicle-id'='...',
            'vehicle-owners'='...',
            'vehicle-owner-message'='...',
            'vehicle-travelled-distance'='...',
            'vehicle-registered-year'='...',
            'vehicle-province'='...'
        ]

    */

    Api::post('/used/vehicle/add',function(){

        if(!isset($_POST['token'])) {
            Api::send([
                "success" => FALSE,
                "message" => "Token not found"
            ]);
        }

        if(Token::isTampered($_POST['token'])) {
            Api::send([
                "success" => FALSE,
                "message" => "Token is tampered"
            ]);
        }

        if(Token::isExpired($_POST['token'])) {
            Api::send([
                "success" => FALSE,
                "message" => "Token is expired"
            ]);
        }

        $sql = "INSERT INTO 
                    `used_vehicle` (
                        `vehicle_id`,
                        `owners`,
                        `owners_message`,
                        `distance`,
                        `registered_date`,
                        `vehicle_province_id`
                    ) 
                    
                    VALUES (?,?,?,?,?,?);";
        
        $data = Database::query(
            $sql, 
            $_POST['vehicle-id'],
            $_POST['vehicle-owners'],
            $_POST['vehicle-owner-message'],
            $_POST['vehicle-travelled-distance'],
            $_POST['vehicle-registered-year'],
            $_POST['vehicle-province']
        );

        Api::send([
            "success" => TRUE
        ]);

    });

    /* 
    *   Add data to vehicle_color_list table 
    *   $_POST = [
            'token'='...',
            'vehicle-color'='...',
        ]

    */
    Api::post('/vehicle/color/add',function(){

        if(!isset($_POST['token'])) {
            Api::send([
                "success" => FALSE,
                "message" => "Token not found"
            ]);
        }

        if(Token::isTampered($_POST['token'])) {
            Api::send([
                "success" => FALSE,
                "message" => "Token is tampered"
            ]);
        }

        if(Token::isExpired($_POST['token'])) {
            Api::send([
                "success" => FALSE,
                "message" => "Token is expired"
            ]);
        }

        $sql = "INSERT INTO `vehicle_color_list` (`vehicle_id`,`vehicle_color_id`) VALUES (?,?);";
        $color_ids = json_decode($_POST['color-id'],TRUE);

        foreach ($color_ids as $color_id) {
            $data = Database::query($sql,$_POST['vehicle-id'],$color_id);
        }

        Api::send([
            "success" => TRUE
        ]);

    });


    /* 
    *   Add data to vehicle_color_list table 
    *   $_POST = [
            'token'='...',
            'vehicle-color'='...',
        ]

    */
    Api::post('/vehicle/feature/add',function(){

        if(!isset($_POST['token'])) {
            Api::send([
                "success" => FALSE,
                "message" => "Token not found"
            ]);
        }

        if(Token::isTampered($_POST['token'])) {
            Api::send([
                "success" => FALSE,
                "message" => "Token is tampered"
            ]);
        }

        if(Token::isExpired($_POST['token'])) {
            Api::send([
                "success" => FALSE,
                "message" => "Token is expired"
            ]);
        }

        $sql = "INSERT INTO `vehicle_feature_list` (`vehicle_id`,`vehicle_feature_id`) VALUES (?,?);";
        $feature_ids = json_decode($_POST['feature-id'],TRUE);

        foreach ($feature_ids as $feature_id) {
            $data = Database::query($sql,$_POST['vehicle-id'],$feature_id);
        }

        Api::send([
            "success" => TRUE
        ]);

    });


    /*
        $_POST format ==> ['token'='...','vehicle_id'='...',image_id=[..., ..., ...]]
    */
    Api::post('/vehicle/image/add',function(){

        if(!isset($_POST['token'])) {
            Api::send([
                "success" => FALSE,
                "message" => "Token not found"
            ]);
        }

        if(Token::isTampered($_POST['token'])) {
            Api::send([
                "success" => FALSE,
                "message" => "Token is tampered"
            ]);
        }

        if(Token::isExpired($_POST['token'])) {
            Api::send([
                "success" => FALSE,
                "message" => "Token is expired"
            ]);
        }

        $sql = "INSERT INTO `vehicle_image` (`vehicle_id`,`image_id`) VALUES (?,?);";
        $image_ids = json_decode($_POST['image-id'],TRUE);

        foreach ($image_ids as $image_id) {
            $data = Database::query($sql,$_POST['vehicle-id'],$image_id);
        }

        Api::send([
            "success" => TRUE
        ]);

    });

    /* Upload image file to server and save image name in 'image' table */
    Api::post('/image/save',function(){
        $valid = File::check('jpg','png','jpeg');
        if($valid == TRUE) {
            $name = File::save();
            if($name){
                $data = Database::query("INSERT INTO `image` (`name`) VALUES (?)",$name);
                Api::send($data);
            }else{
                Api::send(File::$error);
            }
        }else {
            Api::send(File::$error);
        }
    });

    /* 
    *   Add data to user_vehicle table 
    *   $_POST = [
            'token'='...',
            'vehicle-id'='...',
        ]

    */
    Api::post('/user/vehicle/add',function(){

        if(!isset($_POST['token'])) {
            Api::send([
                "success" => FALSE,
                "message" => "Token not found"
            ]);
        }

        if(Token::isTampered($_POST['token'])) {
            Api::send([
                "success" => FALSE,
                "message" => "Token is tampered"
            ]);
        }

        if(Token::isExpired($_POST['token'])) {
            Api::send([
                "success" => FALSE,
                "message" => "Token is expired"
            ]);
        }

        $payload = Token::getPayload($_POST['token']);

        // Getting current nepal local time
        date_default_timezone_set("Asia/Kathmandu");
        $datetime = date("Y-m-d H:i:s");

        $sql = "INSERT INTO `user_vehicle` (`user_id`,`vehicle_id`,`status`,`added_date`,`last_updated`) VALUES (?,?,?,?,?);";
        $data = Database::query($sql,$payload['id'],$_POST['vehicle-id'],$_POST['status'],$datetime,$datetime);

        Api::send([
            "success" => TRUE
        ]);

    });

    /* 
    *   Set user_vehicle status to 'removed' 
    *   $_POST = [
            'token'='...',
            'vehicle-id'='...',
        ]

    */
    Api::post('/user/vehicle/remove', function(){

        if(!isset($_POST['token'])) {
            Api::send([
                "success" => FALSE,
                "message" => "Token not found"
            ]);
        }

        if(Token::isTampered($_POST['token'])) {
            Api::send([
                "success" => FALSE,
                "message" => "Token is tampered"
            ]);
        }

        if(Token::isExpired($_POST['token'])) {
            Api::send([
                "success" => FALSE,
                "message" => "Token is expired"
            ]);
        }

        $payload = Token::getPayload($_POST['token']);

        $sql = "UPDATE user_vehicle
            SET status = 'removed'
            WHERE user_id=? AND vehicle_id=?;";

        $data = Database::query($sql,$payload['id'],$_POST['vehicle-id']);

        if(!$data){
            Api::send([
                "success" => FALSE,
                "message" => "Error removing vehicle"
            ]);
        }

        Api::send([
            "success" => TRUE
        ]);
        

    });

    /*General Token*/
    Api::get('/visitor/token/create',function(){
        Api::send(Token::create([
            'user_type' => 'visitor'
        ]));
    });

    /*User Email Verify*/
    Api::get('/exist/user/email'.Api::STRING, function($email){
        $data = Database::query("SELECT id FROM user WHERE email = ?;",$email);
        if($data){
            Api::send(TRUE);
        }else{
            Api::send(FALSE);
        }
    });

    Api::get(Api::DEFAULT,function(){
        Api::send([
            'success' => FALSE,
            'message' => 'This API end-point does not exist.'
        ]);
    });

    Api::post(Api::DEFAULT,function(){
        Api::send([
            'success' => FALSE,
            'message' => 'This API end-point does not exist.'
        ]);
    });

?>

