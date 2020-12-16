<?php

    /*
    * This code checks if the user-token is still valid or not
    * If the user-token is missing, empty, invalid or tampered, it redirects user to the 'login' page
    * If the user is logged in and token is valid... it does not affect the flow i.e. it allows users to continue
    */

    if(isset($_COOKIE['token'])){

        // Including global constants
        include_once 'config.php';

        $token = file_get_contents(API_ENDPOINT.'/user-token/verify/'.$_COOKIE['token']);

        $token = json_decode($token,TRUE);

        if(!isset($token['success'])){

            setcookie('toast_message', "Fatal error in API", time()+60*60, "/");
            header('Location: ../login/');
            exit;

        }else if($token['success'] == FALSE){

            setcookie('toast_message', $token['message'], time()+60*60, "/");
            header('Location: ../login/');
            exit;

        }else{ /* ignore */ } 

    }else{
        setcookie('toast_message', "Login required", time()+60*60, "/");
        header('Location: ../login/');
        exit;
    }