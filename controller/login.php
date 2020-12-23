<?php

    // Including global constants
    include_once '../include/config.php';

    $cURLConnection = curl_init(API_ENDPOINT.'/login');
    curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, $_POST);
    curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
    
    $apiResponse = curl_exec($cURLConnection);
    curl_close($cURLConnection);
    $apiResponse = json_decode($apiResponse,TRUE);

    if(isset($apiResponse) && isset($apiResponse['token'])){

        setcookie('token', $apiResponse['token'], time()+24*60*60, "/");

        setcookie('toast_message', "Welcome ".$apiResponse['first_name'], time()+60*60, "/");
  
        switch ($apiResponse['user_type']) {
            case "admin":
            case "seller":
                header('Location: ../explore');
                exit;
            default:
                # This comes handy when the user type is increased in future
                header('Location: ../explore');
                exit;
        }

    }else{
        
        setcookie('toast_message', "Invalid login details", time()+60*60, "/");
        header('Location: ../login/');
        exit;

    }


