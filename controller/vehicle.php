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

        echo"<pre>";
        var_dump($apiResponse);
        echo"</pre>";
        exit;
    }