<?php
    /*
    * This code checks if the user is already login or not
    * If the user is already logged it redirects user to the 'explore' page
    * If the user is not logged.. it does not affect the flow i.e. it allows users to login
    */

    if(isset($_COOKIE['token'])){
        
        // Including global constants
        include_once 'config.php';

        $token = json_decode(
            file_get_contents(API_ENDPOINT.'/user-token/verify/'.$_COOKIE['token']),
            TRUE
        );

        if(isset($token) && $token['success']){

            setcookie('toast_message', "Already logged in", time()+60*60, "/");
            header('Location: ../explore');
            exit;

        }
    }