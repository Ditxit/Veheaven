<?php
    if(isset($_POST['vehicle-add'])){
        // Including global constants
        include_once '../include/config.php';

        $cURLConnection = curl_init(API_ENDPOINT.'/vehicle/add');
        curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, $_POST);
        curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
        
        $apiResponse = curl_exec($cURLConnection);
        curl_close($cURLConnection);
        $apiResponse = json_decode($apiResponse,TRUE);

        if(isset($apiResponse) && isset($apiResponse['inserted_id'])){
            $vehicleId = $apiResponse['inserted_id'];
            setcookie('toast_message', "Vehicle added successfully", time()+60*60, "/");
            header('Location: ../profile');
            exit;
        }else{
            setcookie('toast_message', "Error adding vehicle", time()+60*60, "/");
            header('Location: ../explore');
            exit;
        }
    }