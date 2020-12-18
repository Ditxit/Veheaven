
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

    /* Count User Vehicles */
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

