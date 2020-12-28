<?php
    if(isset($_POST['vehicle-add'])){
        // Including global constants
        include_once '../include/config.php';

        echo "<pre>";
            var_dump($_POST);
            var_dump($_FILES);
            exit;
        echo "</pre>";

        // Handling Image Uploads First 
        $imageIdArray = [];

        // Opening curl connection
        $cURLConnection = curl_init('http://localhost/Veheaven/api/image/save');

        for($i = 0; $i < count($_FILES["vehicle-image"]["tmp_name"]); $i++){

            $file = array(
                'vehicle-image' => new CurlFile(
                    $_FILES["vehicle-image"]["tmp_name"][$i],
                    $_FILES["vehicle-image"]["type"][$i],
                    $_FILES["vehicle-image"]["name"][$i]
                )
            );

            curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, $file);
            curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);

            $apiResponse = curl_exec($cURLConnection);
            $apiResponse = json_decode($apiResponse,TRUE); // inserted_id

            // Storing inserted id
            array_push($imageIdArray,$apiResponse['inserted_id']);

        }
        // Closing curl connection
        curl_close($cURLConnection);


        // Adding vehicle table data
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