<?php
    if(isset($_COOKIE['token'])){
        
        $accesstoken = json_decode(
            file_get_contents('http://localhost/Veheaven/api/token/verify/'.$_COOKIE['token']),
            TRUE
        );

        if(isset($accesstoken['user_type'])){

            if($accesstoken['user_type'] == 'admin'){
                header('Location: ../dashboard');
                exit;
            }

        }
    }