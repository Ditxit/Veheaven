
<?php

    include 'doodle/doodle.php';

    /* 
    * Some common/utility functions 
    */

    // function to get all possible typo in the word
    function get_word_typos($str) {
  
        $typosArr = array();
          
          $strArr = str_split($str);
                 
          //Proximity of keys on keyboard
          $arr_prox = array();
          $arr_prox['a'] = array('q', 'w', 'z', 'x');
          $arr_prox['b'] = array('v', 'f', 'g', 'h', 'n');
          $arr_prox['c'] = array('x', 's', 'd', 'f', 'v');
          $arr_prox['d'] = array('x', 's', 'w', 'e', 'r', 'f', 'v', 'c');
          $arr_prox['e'] = array('w', 's', 'd', 'f', 'r');
          $arr_prox['f'] = array('c', 'd', 'e', 'r', 't', 'g', 'b', 'v');
          $arr_prox['g'] = array('r', 'f', 'v', 't', 'b', 'y', 'h', 'n');
          $arr_prox['h'] = array('b', 'g', 't', 'y', 'u', 'j', 'm', 'n');
          $arr_prox['i'] = array('u', 'j', 'k', 'l', 'o');
          $arr_prox['j'] = array('n', 'h', 'y', 'u', 'i', 'k', 'm');
          $arr_prox['k'] = array('u', 'j', 'm', 'l', 'o');
          $arr_prox['l'] = array('p', 'o', 'i', 'k', 'm');
          $arr_prox['m'] = array('n', 'h', 'j', 'k', 'l');
          $arr_prox['n'] = array('b', 'g', 'h', 'j', 'm');
          $arr_prox['o'] = array('i', 'k', 'l', 'p');
          $arr_prox['p'] = array('o', 'l');
          $arr_prox['q'] = array('w', 'a','s');
          $arr_prox['r'] = array('e', 'd', 'f', 'g', 't');
          $arr_prox['s'] = array('q', 'w', 'e', 'z', 'x', 'c');
          $arr_prox['t'] = array('r', 'f', 'g', 'h', 'y');
          $arr_prox['u'] = array('y', 'h', 'j', 'k', 'i');
          $arr_prox['v'] = array('', 'c', 'd', 'f', 'g', 'b');    
          $arr_prox['w'] = array('q', 'a', 's', 'd', 'e');
          $arr_prox['x'] = array('z', 'a', 's', 'd', 'c');
          $arr_prox['y'] = array('t', 'g', 'h', 'j', 'u');
          $arr_prox['z'] = array('x', 's', 'a');
          $arr_prox['1'] = array('2','q', 'w');
          $arr_prox['2'] = array('1','3','q', 'w', 'e');
          $arr_prox['3'] = array('2','4','w', 'e', 'r');
          $arr_prox['4'] = array('3','5','e', 'r', 't');
          $arr_prox['5'] = array('4','6','r', 't', 'y');
          $arr_prox['6'] = array('5','7','t', 'y', 'u');
          $arr_prox['7'] = array('6','8','y', 'u', 'i');
          $arr_prox['8'] = array('7','9','u', 'i', 'o');
          $arr_prox['9'] = array('8','0','i', 'o', 'p');
          $arr_prox['0'] = array('9','o', 'p');
                                                   
          foreach($strArr as $key=>$value){
              $temp = $strArr;
              foreach ($arr_prox[$value] as $proximity){
                  $temp[$key] = $proximity;
                  $typosArr[] = join("", $temp);
              }
          }   
    
          return $typosArr;
      }

    // function to verify token
    function verify_token($token){
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

    // Function to get single vehicle details from passed id
    function get_vehicle_details($vehicle_id){
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
            $vehicle['used_vehicle'] = Database::query($sql,$vehicle_id)[0];
        }  

        return $vehicle;
    }

    /* Token Debug*/
    Api::get('/user-token/verify'.API::STRING,function($token){

        verify_token($token);
        
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

        verify_token($token);

        Api::send([
            "success" => TRUE,
            "payload" => Token::getPayload($token)
        ]);

    });

    Api::get('/hash'.Api::STRING, function($str){
        Api::send([
            "string" => $str,
            "hash" => password_hash($str, PASSWORD_DEFAULT)
        ]);
    });


    /* General Login API */
    Api::post('/login',function(){

        $sql = "SELECT 
                id, 
                first_name, 
                last_name, 
                email,
                password,
                phone, 
                user.type AS user_type 
                FROM user  
                WHERE user.email=? AND user.status=?";

        $data = Database::query($sql, $_POST['email'], "verified");

        if(!$data) Api::send([
            "success" => FALSE,
            "message" => "User not found"
        ]);

        $data = $data[0];

        if(!password_verify($_POST['password'], $data['password'])) Api::send([
            "success" => FALSE,
            "message" => "Incorrect password"
        ]);

        unset($data['password']);
        
        // Getting user profile image
        $sql = "SELECT 
                    user_image.image_id AS id,
                    image.name AS name
                FROM user_image
                INNER JOIN image
                    ON image.id = user_image.image_id
                WHERE user_image.user_id = ?;
                ";

        $image = Database::query($sql, $data['id']);

        $data['image'] = $image;
        
        // Creating user token to return
        $data['token'] = Token::create($data);

        // Send the token back
        Api::send([
            "success" => TRUE,
            "content" => $data
        ]);

    });

    /* Get User Vehicles */
    Api::get(Api::INTEGER.'/vehicles',function($user_id){
        $sql = "SELECT user_vehicle.vehicle_id AS id
                FROM user_vehicle 
                WHERE user_vehicle.user_id=? AND user_vehicle.status!=?
                ORDER BY user_vehicle.vehicle_id DESC;
                ";

        $vehicle_ids = Database::query($sql, $user_id, "removed");

        $data = [];
        foreach($vehicle_ids as $vehicle_id){
            array_push($data, get_vehicle_details($vehicle_id['id'])); 
        }

        Api::send($data);
    });

    /* Get Single Vehicle Detail */
    Api::get('/vehicle'.Api::INTEGER,function($vehicle_id){

        Api::send(get_vehicle_details($vehicle_id));

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
        verify_token($_POST['token']);

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

        verify_token($_POST['token']);

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

        verify_token($_POST['token']);

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

        verify_token($_POST['token']);

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

        verify_token($_POST['token']);

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
                $data['name'] = $name;
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

        verify_token($_POST['token']);

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

        verify_token($_POST['token']);

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

        verify_token($_POST['token']);

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
    * Returns vehicles with matching keywords
    */
    // NOTE: search by features, colors and provience is missing
    Api::get('/search'.Api::INTEGER.Api::STRING, function($limit, $search_term){

        // Preparing Keywords
        $keywords = explode("-", $search_term);

        $keyword_typos = [];
        foreach($keywords as $keyword){
            $keyword_typos += get_word_typos($keyword);
        }
        $keywords += $keyword_typos;

        // Preparing SQLs
        $sql = "SELECT 
                vehicle.id AS id,
                CONCAT(
                        user.first_name,' ',
                        user.last_name,' ',
                        user.email,' ',
                        vehicle.name,' ',
                        vehicle.price,' ',
                        vehicle_condition.condition,' ',
                        vehicle_type.type,' ',
                        vehicle_body.body,' ',
                        vehicle_transmission.transmission,' ',
                        front_vehicle_tyre.tyre,' ',
                        rear_vehicle_tyre.tyre,' ',
                        vehicle_fuel.fuel,' ',
                        front_vehicle_break.break,' ',
                        rear_vehicle_break.break,' ',
                        vehicle_model.model,' ',
                        vehicle_brand.brand
                    ) AS full_text
            FROM vehicle 
                INNER JOIN user_vehicle 
                    ON user_vehicle.vehicle_id = vehicle.id 
                INNER JOIN user
                    ON user_vehicle.user_id = user.id
                INNER JOIN vehicle_condition
                    ON vehicle.vehicle_condition_id = vehicle_condition.id
                INNER JOIN vehicle_type
                    ON vehicle.vehicle_type_id = vehicle_type.id
                INNER JOIN vehicle_body
                    ON vehicle.vehicle_body_id = vehicle_body.id
                INNER JOIN vehicle_transmission
                    ON vehicle.vehicle_transmission_id = vehicle_transmission.id
                INNER JOIN vehicle_tyre front_vehicle_tyre
                    ON vehicle.front_vehicle_tyre_id = front_vehicle_tyre.id
                INNER JOIN vehicle_tyre rear_vehicle_tyre
                    ON vehicle.rear_vehicle_tyre_id = rear_vehicle_tyre.id 
                INNER JOIN vehicle_fuel
                    ON vehicle.vehicle_fuel_id = vehicle_fuel.id 
                INNER JOIN vehicle_break front_vehicle_break
                    ON vehicle.front_vehicle_break_id = front_vehicle_break.id 
                INNER JOIN vehicle_break rear_vehicle_break
                    ON vehicle.rear_vehicle_break_id = rear_vehicle_break.id 
                INNER JOIN vehicle_model
                    ON vehicle.vehicle_model_id = vehicle_model.id
                INNER JOIN vehicle_brand
                    ON vehicle_model.vehicle_brand_id = vehicle_brand.id 
            WHERE user_vehicle.status=? AND (
        ";

        foreach($keywords as $index => $keyword){
            $sql .= "CONCAT(
                        user.first_name,' ',
                        user.last_name,' ',
                        user.email,' ',
                        vehicle.name,' ',
                        vehicle.price,' ',
                        vehicle_condition.condition,' ',
                        vehicle_type.type,' ',
                        vehicle_body.body,' ',
                        vehicle_transmission.transmission,' ',
                        front_vehicle_tyre.tyre,' ',
                        rear_vehicle_tyre.tyre,' ',
                        vehicle_fuel.fuel,' ',
                        front_vehicle_break.break,' ',
                        rear_vehicle_break.break,' ',
                        vehicle_model.model,' ',
                        vehicle_brand.brand
                    ) 
                    LIKE '%".$keyword."%'";

            $sql .= ($index != count($keywords) - 1) ? " OR " : ")";
        }

        $sql .= " LIMIT ?;";

        /* @return
            [
                [
                    "id" => "...",
                    "full_text" => "..."
                ]
                ...
            ]
        */
        $vehicle_datas = Database::query($sql,"public",$limit*5);

        // Order the result by similarity percentage
        $sorted_vehicle_datas = [];
        foreach($vehicle_datas as $vehicle_data){
            similar_text(
                strtolower($vehicle_data['full_text']),
                str_replace("-", " ", $search_term),
                $score
            );
            $sorted_vehicle_datas[] = ['id'=>$vehicle_data['id'], 'score'=>$score];
        }

        usort($sorted_vehicle_datas, function ($one, $two) {
            return $two['score'] <=> $one['score'];
        });

        // Only selecting the first {$limit} ids
        $sorted_vehicle_datas = array_slice($sorted_vehicle_datas, 0, $limit); //array, from_index, to_index

        // Preparing return data
        $data = [];
        foreach($sorted_vehicle_datas as $vehicle_data){
            $data[] = get_vehicle_details($vehicle_data['id']);
        }
        Api::send($data);
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
            array_push($data, get_vehicle_details($vehicle_id['id'])); 
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

        verify_token($_POST['token']);

        $user = Token::getPayload($_POST['token']);

        $sql = "INSERT INTO user_image (user_id, image_id) VALUES (?, ?);";

        $data = Database::query($sql, $user['id'], $_POST['imageId']);

        Api::send([
            "success" => TRUE,
            "content" => $data
        ]);

    });

    /*
        Api to get user profile image
        Requires userId
        Returns image id & image name as ['id' => '...', 'name'=> '...']
    */
    Api::get(Api::INTEGER.'/image', function($userId){

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

