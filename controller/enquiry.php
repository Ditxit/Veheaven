<?php

    if($_POST && isset($_POST)){

        // Including global constants
        include_once '../include/config.php';

        if(isset($_POST['email']) && isset($_POST['enquiry'])){

            $cURLConnection = curl_init(API_ENDPOINT.'/enquiry');
            curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, $_POST);
            curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
            
            $apiResponse = curl_exec($cURLConnection);
            curl_close($cURLConnection);
            $apiResponse = json_decode($apiResponse,TRUE);
            
            $toast_message = "";

            if(!$apiResponse || $apiResponse['inserted_id'] < 0)
                $toast_message = "Something went wrong";
            else
                $toast_message = "Enquiry is submitted";
            

            setcookie('toast_message', $toast_message, time()+60*60, "/");
            unset($cURLConnection);
            unset($apiResponse);
            unset($toast_message);

            header('Location: ../explore/');
            exit;

        }

    }