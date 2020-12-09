<?php

    $cURLConnection = curl_init('http://localhost/Veheaven/api/admin/login');
    curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, $_POST);
    curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
    
    $apiResponse = curl_exec($cURLConnection);
    curl_close($cURLConnection);
    $apiResponse = json_decode($apiResponse,TRUE);

    if(isset($apiResponse) && isset($apiResponse['token'])){

        setcookie('token', $apiResponse['token'], time()+24*60*60, "/");
        header('Location: ../dashboard');

    }

    header('Location: ../login/?error=Invalid details');


