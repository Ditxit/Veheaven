
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
                user_vehicle.vehicle_id, 
                user_vehicle.added_date,
                user_vehicle.last_updated,
                vehicle.name,
                vehicle.price,
                vehicle.mileage,
                vehicle.engine,
                vehicle.bhp,
                vehicle.turn_radius,
                vehicle.seat,
                vehicle.top_speed
                FROM user_vehicle
                INNER JOIN vehicle
                    ON user_vehicle.vehicle_id = vehicle.id
                WHERE user_vehicle.user_id=?;
                ";
        
        $data = Database::query($sql,$user_id);
        Api::send($data);
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

