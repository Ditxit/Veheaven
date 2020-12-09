
<?php

    include 'doodle/doodle.php';

    /* Token Debug*/
    Api::get('/token/verify'.API::STRING,function($token){
        Api::send(Token::verify($token));
    });

    /*General Token*/
    Api::get('/visitor/token/create',function(){
        Api::send(Token::create([
            'user_type' => 'visitor'
        ]));
    });
    
    /*Admin Login*/
    Api::post('/admin/login',function(){

        $admin_type_id = Database::query("SELECT id FROM user_type WHERE type='admin';");

        if(empty($admin_type_id)){
            Api::send([
                'success' => FALSE,
                'message' => 'Admin user-type is not found.'
            ]);
        }

        $sql = "SELECT id, first_name, last_name, email FROM user WHERE user_type_id=? AND email=? AND password=?;";
        $data = Database::query($sql,$admin_type_id[0]['id'],$_POST['email'],$_POST['password']);

        if(!empty($data)){
            $data = $data[0]; 
            $data['user_type'] = 'admin'; 

            $data['token'] = Token::create($data);
        }

        Api::send($data);
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

