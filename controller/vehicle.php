<?php
    if(isset($_POST['vehicle-add'])){

        // Including global constants
        include_once '../include/config.php';

        // echo "<pre>";
        //     var_dump($_POST);
        //     var_dump($_FILES);
        // echo "</pre>";
        // exit;

        /* 
        *   Handling image saving & database recording first
        */
        $imageIdArray = [];

        // Opening curl connection
        $cURLConnection = curl_init(API_ENDPOINT.'/image/save');

        // Loopin each image file
        for($i = 0; $i < count($_FILES["vehicle-image"]["tmp_name"]); $i++){

            // Creating new curl file object for each file
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


        /* 
        *   Adding vehicle data in vehicle table
        */
        $data = [];
        $data['token'] = $_POST['token'];
        $data['vehicle-name'] = $_POST['vehicle-name'];
        $data['vehicle-price'] = $_POST['vehicle-price'];
        $data['vehicle-mileage'] = $_POST['vehicle-mileage'];
        $data['vehicle-cc'] = $_POST['vehicle-cc'];
        $data['vehicle-bhp'] = $_POST['vehicle-bhp'];
        $data['vehicle-turn-radius'] = $_POST['vehicle-turn-radius'];
        $data['vehicle-seat'] = $_POST['vehicle-seat'];
        $data['vehicle-top-speed'] = $_POST['vehicle-top-speed'];
        $data['vehicle-condition'] = isset($_POST['vehicle-condition']) ? $_POST['vehicle-condition'] : 2;
        $data['vehicle-type'] = $_POST['vehicle-type'];
        $data['vehicle-body'] = $_POST['vehicle-body'];
        $data['vehicle-transmission'] = $_POST['vehicle-transmission'];
        $data['vehicle-front-tyre'] = $_POST['vehicle-front-tyre'];
        $data['vehicle-rear-tyre'] = $_POST['vehicle-rear-tyre'];
        $data['vehicle-fuel'] = $_POST['vehicle-fuel'];
        $data['vehicle-fuel-capacity'] = $_POST['vehicle-fuel-capacity'];
        $data['vehicle-front-break'] = $_POST['vehicle-front-break'];
        $data['vehicle-rear-break'] = $_POST['vehicle-rear-break'];
        $data['vehicle-front-suspension'] = $_POST['vehicle-front-suspension'];
        $data['vehicle-rear-suspension'] = $_POST['vehicle-rear-suspension'];
        $data['vehicle-model'] = $_POST['vehicle-model'];

        $cURLConnection = curl_init(API_ENDPOINT.'/vehicle/add');
        curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, $data);
        curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
        
        $apiResponse = curl_exec($cURLConnection);
        curl_close($cURLConnection);
        $apiResponse = json_decode($apiResponse,TRUE);

        // if error inserting in vehicle table redirect with error message
        if(!isset($apiResponse) || !isset($apiResponse['inserted_id'])){
            setcookie('toast_message', "Error adding vehicle", time()+60*60, "/");
            header('Location: ../explore');
            exit;
        }

        $vehicleId = $apiResponse['inserted_id'];

        /*
        *   Adding data in vehicle_image table  
        */
        $data = [];
        $data['token'] = $_POST['token'];
        $data['vehicle-id'] = $vehicleId;
        $data['image-id'] = json_encode($imageIdArray);

        $cURLConnection = curl_init(API_ENDPOINT.'/vehicle/image/add');
        curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, $data);
        curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
        
        $apiResponse = curl_exec($cURLConnection);
        curl_close($cURLConnection);
        $apiResponse = json_decode($apiResponse,TRUE);

        /*
        *   Adding data in used_vehicle table  
        */
        if(!isset($_POST['vehicle-condition']) || $_POST['vehicle-condition'] == 2){
            $data = [];
            $data['token'] = $_POST['token'];
            $data['vehicle-id'] = $vehicleId;
            $data['vehicle-owners'] = $_POST['vehicle-owners'];
            $data['vehicle-owner-message'] = $_POST['vehicle-owner-message'];
            $data['vehicle-travelled-distance'] = $_POST['vehicle-travelled-distance'];
            $data['vehicle-registered-year'] = $_POST['vehicle-registered-year'];
            $data['vehicle-province'] = $_POST['vehicle-province'];

            $cURLConnection = curl_init(API_ENDPOINT.'/used/vehicle/add');
            curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, $data);
            curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);

            $apiResponse = curl_exec($cURLConnection);
            curl_close($cURLConnection);
            $apiResponse = json_decode($apiResponse,TRUE);
        }

        /*
        *   Adding data in vehicle_color_list table  
        */
        $data = [];
        $data['token'] = $_POST['token'];
        $data['vehicle-id'] = $vehicleId;
        $data['color-id'] = json_encode($_POST['vehicle-color']);

        $cURLConnection = curl_init(API_ENDPOINT.'/vehicle/color/add');
        curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, $data);
        curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);

        $apiResponse = curl_exec($cURLConnection);
        curl_close($cURLConnection);
        $apiResponse = json_decode($apiResponse,TRUE);

        /*
        *   Adding data in vehicle_feature_list table  
        */
        $data = [];
        $data['token'] = $_POST['token'];
        $data['vehicle-id'] = $vehicleId;
        $data['feature-id'] = json_encode($_POST['vehicle-feature']);

        $cURLConnection = curl_init(API_ENDPOINT.'/vehicle/feature/add');
        curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, $data);
        curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);

        $apiResponse = curl_exec($cURLConnection);
        curl_close($cURLConnection);
        $apiResponse = json_decode($apiResponse,TRUE);


        /*
        *   Adding data in user_vehicle table  
        */
        $data = [];
        $data['token'] = $_POST['token'];
        $data['vehicle-id'] = $vehicleId;
        $data['status'] = 'public';

        $cURLConnection = curl_init(API_ENDPOINT.'/user/vehicle/add');
        curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, $data);
        curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);

        $apiResponse = curl_exec($cURLConnection);
        curl_close($cURLConnection);
        $apiResponse = json_decode($apiResponse,TRUE);

        /*
        *   Redirect with success message  
        */
        setcookie('toast_message', "Vehicle added successfully", time()+60*60, "/");
        header('Location: ../profile');
        exit;

    }else if(isset($_POST['vehicle-remove'])){

        // Including global constants
        include_once '../include/config.php';

        //var_dump($_POST);

        $cURLConnection = curl_init(API_ENDPOINT.'/user/vehicle/remove');
        curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, $_POST);
        curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, TRUE);

        $apiResponse = curl_exec($cURLConnection);
        curl_close($cURLConnection);
        $apiResponse = json_decode($apiResponse,TRUE);

        if($apiResponse && $apiResponse['success'] == TRUE){
            setcookie('toast_message', "Vehicle deleted successfully", time()+60*60, "/");
        }else{
            setcookie('toast_message', $apiResponse['message'], time()+60*60, "/");
        }

        header('Location: ../profile');
        exit;

    }