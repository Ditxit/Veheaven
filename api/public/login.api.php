<?php

    /* 
    *   /login : POST{email,password}
        @TODO: Only return id and user_type
    */
    Api::post('/login',function(){

        if (!isset($_POST['email']) || !isset($_POST['password'])) Api::send([
            "success" => FALSE,
            "message" => "Email and password required",
        ]);

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
        
        // Creating user token to return
        $data['token'] = Token::create($data);

        // Send the token back
        Api::send([
            "success" => TRUE,
            "content" => $data
        ]);

    });