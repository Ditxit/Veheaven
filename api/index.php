
<?php

    include 'doodle/doodle.php';

    $files = glob('public/*');
    $apis = preg_grep('/\.api.php$/i', $files);
    $utilities = preg_grep('/\.utility.php$/i', $files);

    foreach ($utilities as $utility) { include_once $utility; }
    foreach ($apis as $api) { include_once $api; }

    /* 
    * Some common/utility functions 
    */

    // function to verify token
    function verifyToken($token){
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
    }

    /* Token Debug*/
    Api::get('/user-token/verify'.API::STRING,function($token){

        verifyToken($token);
        
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

        verifyToken($token);

        Api::send([
            "success" => TRUE,
            "payload" => Token::getPayload($token)
        ]);

    });

    /* Get Single Vehicle Detail */
    Api::get('/vehicle'.Api::INTEGER,function($vehicle_id){

        Api::send(getVehicleById($vehicle_id));

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
        verifyToken($_POST['token']);

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

        verifyToken($_POST['token']);

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

        verifyToken($_POST['token']);

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

        verifyToken($_POST['token']);

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

        verifyToken($_POST['token']);

        $sql = "INSERT INTO `vehicle_image` (`vehicle_id`,`image_id`) VALUES (?,?);";
        $image_ids = json_decode($_POST['image-id'],TRUE);

        foreach ($image_ids as $image_id) {
            $data = Database::query($sql,$_POST['vehicle-id'],$image_id);
        }

        Api::send([
            "success" => TRUE
        ]);

    });

    /* 
    *   Add data to user_vehicle table 
    *   $_POST = [
            'token'='...',
            'vehicle-id'='...',
        ]

    */
    Api::post('/user/vehicle/add',function(){

        verifyToken($_POST['token']);

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

        verifyToken($_POST['token']);

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

    Api::post('/user/vehicle/edit', function(){

        verifyToken($_POST['token']);

        $payload = Token::getPayload($_POST['token']);

        $sql = "UPDATE vehicle
            SET name=?, price=?
            WHERE id=?;";

        $data = Database::query($sql,$_POST['vehicle-name'],$_POST['vehicle-price'],$_POST['vehicle-id']);

        if(!$data){
            Api::send([
                "success" => FALSE,
                "message" => "Error removing vehicle"
            ]);
        }

        $sql = "UPDATE user_vehicle SET last_updated=? WHERE vehicle_id=?";

        // Getting current nepal local time
        date_default_timezone_set("Asia/Kathmandu");
        $datetime = date("Y-m-d H:i:s");

        $data = Database::query($sql, $datetime, $_POST['vehicle-id']);

        Api::send([
            "success" => TRUE
        ]);

    });

    /*
    * Returns the {limit} data of recent vehicle {type}
    * /recent/car/5
    * /recent/bike/10
    */
    Api::get('/recent'.Api::STRING.Api::STRING,function($type,$limit){
        $type_id = Database::query("SELECT `id` FROM `vehicle_type` WHERE UPPER(`type`)=?;", strtoupper($type));
        $type_id ? $type_id = $type_id[0]['id'] : Api::send(null);

        $sql = "SELECT vehicle.id AS id
                    FROM vehicle
                INNER JOIN
                    user_vehicle ON user_vehicle.vehicle_id=vehicle.id 
                WHERE 
                    vehicle_type_id=? AND
                    user_vehicle.status=?
                ORDER BY user_vehicle.added_date DESC 
                LIMIT ?;";

        $vehicle_ids = Database::query($sql, $type_id, "public", $limit);

        $data = [];
        foreach($vehicle_ids as $vehicle_id){
            array_push($data, getVehicleById($vehicle_id['id'])); 
        }

        Api::send($data);
    });

    /* User Feedback or Enquiry */
    Api::post('/enquiry',function(){
        $sql = "INSERT INTO user_enquiry(email,enquiry) VALUES(?,?);";
        $data = Database::query($sql,$_POST['email'],$_POST['enquiry']);
        Api::send($data);
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

    /* Add unverified user to the 'user' table */
    Api::post('/register/seller', function(){
        $sql = "INSERT INTO user(first_name,last_name,email,phone,created_date,status,type) VALUES(?,?,?,?,?,?,?);";

        // Getting current nepal local time
        date_default_timezone_set("Asia/Kathmandu");
        $datetime = date("Y-m-d H:i:s");

        $data = Database::query($sql, $_POST['firstName'], $_POST['lastName'], $_POST['email'], $_POST['phoneNumber'], $datetime, 'unverified', 'seller');
        Api::send($data);
    });

    /*Insert or Create User Verification Code*/
    Api::post('/user/send/verification', function(){

        if(!isset($_POST['email'])) Api::send([
            "success" => FALSE,
            "message" => "Missing: email"
        ]);

        if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) Api::send([
            "success" => FALSE,
            "message" => "Invalid: email"
        ]);

        $sql = "SELECT id FROM user WHERE email=? AND status!=?;";
        $data = Database::query($sql, $_POST['email'], "banned");

        if(!$data) Api::send([
            "success" => FALSE,
            "message" => "Error: User does not exist"
        ]);

        $user_id = $data[0]['id'];

        // Getting current nepal local time
        date_default_timezone_set("Asia/Kathmandu");
        $expiry = date("Y-m-d H:i:s", strtotime('+5 minutes'));

        /* Create a verification code */
        $verification_code = time().bin2hex(random_bytes(10));

        /* Check if the user_id is already present in user_verification table */
        $sql = "SELECT user_id FROM user_verification WHERE user_id=?;";
        $data = Database::query($sql, $user_id);

        /* If user_id already exist in user_verification table */
        if($data){
            $sql = "UPDATE user_verification SET code=?, expiry=? WHERE user_id=?;";
            $data = Database::query($sql, $verification_code, $expiry, $user_id);
        }else{
            $sql = "INSERT INTO user_verification(user_id,code,expiry) VALUES(?,?,?);";
            $data = Database::query($sql, $user_id, $verification_code, $expiry);
        }

        if(!$data) Api::send([
            "success" => FALSE,
            "message" => "Error: Something went wrong"
        ]);

        /* Prepare and send the mail */
        /*
        $receiver = $_POST['email']; // Receiver Email
        $sender= 'gau.manish777@gmail.com'; // Sender Email
        $subject= 'Veheaven - Account Verification'; // Email Subject

        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= "From: " . $sender . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        $message ='
            <html>
                <body>
                    <h1>'.$subject.'</h1><br>
                    <a href="'.SERVER_NAME.'/verify/?code='.$verification_code.'">Click to continue</a>
                </body>
            </html>
        ';

        $mail = @mail($receiver, $sender, $message, $headers);

        if(!$mail) Api::send([
            "success" => FALSE,
            "message" => "Error: Something went wrong"
        ]);
        */

        Api::send([
            "success" => TRUE
        ]);
        
    });

    /* Verify User Verification Code */
    Api::post('/user/verify/verification', function(){

        if(!isset($_POST['password'])) Api::send([
            "success" => FALSE,
            "message" => "Missing: password"
        ]);

        if(!isset($_POST['confirmPassword'])) Api::send([
            "success" => FALSE,
            "message" => "Missing: confirmPassword"
        ]);

        if($_POST['password'] != $_POST['confirmPassword']) Api::send([
            "success" => FALSE,
            "message" => "Error: Passwords do not match"
        ]);

        if(strlen($_POST['password']) < 8) Api::send([
            "success" => FALSE,
            "message" => "Error: Passwords is less than 8 characters"
        ]);

        if(!isset($_POST['code'])) Api::send([
            "success" => FALSE,
            "message" => "Missing: code"
        ]);

        // Getting current nepal local time
        date_default_timezone_set("Asia/Kathmandu");
        $datetime = date("Y-m-d H:i:s");

        $sql = "SELECT user_id FROM user_verification WHERE code=? AND expiry>=?;";
        $data = Database::query($sql, $_POST['code'], $datetime);

        if(!$data) Api::send([
            "success" => FALSE,
            "message" => "Error: Something went wrong"
        ]);

        $user_id = $data[0]['user_id'];

        $sql = "UPDATE user SET password=?, last_login=?, status=? WHERE id=?;";
        $password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $data = Database::query($sql, $password_hash, $datetime, "verified", $user_id);

        if(!$data) Api::send([
            "success" => FALSE,
            "message" => "Error: Something went wrong"
        ]);

        $sql = "SELECT 
                id, 
                first_name, 
                last_name, 
                email, 
                phone, 
                user.type AS user_type 
                FROM user  
                WHERE user.id=? AND user.status=?";

        $data = Database::query($sql, $user_id, "verified");

        if(!$data) Api::send([
            "success" => FALSE,
            "message" => "Error: Something went wrong"
        ]);

        $data = $data[0];
        $data['token'] = Token::create($data);

        Api::send([
            "success" => TRUE,
            "content" => $data
        ]);

    });


    // Needs token & imageId keys in $_POST[]
    // Returns inserted_id on success
    Api::post('/user/add/image', function(){

        verifyToken($_POST['token']);

        $user = Token::getPayload($_POST['token']);

        $sql = "INSERT INTO user_image (user_id, image_id) VALUES (?, ?);";

        $data = Database::query($sql, $user['id'], $_POST['imageId']);

        Api::send([
            "success" => TRUE,
            "content" => $data
        ]);

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