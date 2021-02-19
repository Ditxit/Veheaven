<?php

    // Including global constants
    include_once '../include/config.php';

    $cURLConnection = curl_init(API_ENDPOINT.'/login');
    curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, $_POST);
    curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
    
    $apiResponse = curl_exec($cURLConnection);
    curl_close($cURLConnection);
    $apiResponse = json_decode($apiResponse,TRUE);

    if(isset($apiResponse) && $apiResponse){

        if(!$apiResponse['success']) {

            setcookie('toast_message', $apiResponse['message'], time()+60*60, "/");
            header('Location: ../login/');
            exit;

        }   

        setcookie('token', $apiResponse['content']['token'], time()+24*60*60, "/");

        setcookie('toast_message', "Welcome ".$apiResponse['content']['first_name'], time()+60*60, "/");
  
        switch ($apiResponse['content']['user_type']) {
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
        
        setcookie('toast_message', "Some went wrong", time()+60*60, "/");
        header('Location: ../login/');
        exit;

    }


