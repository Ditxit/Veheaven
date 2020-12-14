<?php

    // This code checks if the user is already login or not
    // If the user is already logged it redirects user to the 'explore' page
    // If the user is not logged.. it does not affect the flow i.e. it allows users to login

    if(isset($_COOKIE['token'])){
        
        $accesstoken = json_decode(
            file_get_contents('http://localhost/Veheaven/api/token/verify/'.$_COOKIE['token']),
            TRUE
        );

        if(isset($accesstoken['user_type'])){

            setcookie('toast_message', "Already logged in", time()+60*60, "/");
            header('Location: ../explore');
            exit;

        }
    }