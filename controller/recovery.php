<?php

    if(isset($_POST['recovery_info'])){

        include_once '../include/config.php';

        if(!isset($_POST['email']) || !isset($_POST['confirm_email'])){
            setcookie('toast_message', "All fields not found", time()+60*60, "/");
            header('Location: ../recovery/');
            exit;
        }

        if(empty($_POST['email']) || empty($_POST['confirm_email'])){
            setcookie('toast_message', "Empty fields found", time()+60*60, "/");
            header('Location: ../recovery/');
            exit;
        }

        if($_POST['email'] != $_POST['confirm_email']){
            setcookie('toast_message', "Emails does not match", time()+60*60, "/");
            header('Location: ../recovery/');
            exit;
        }

        if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
            setcookie('toast_message', "Invalid email address", time()+60*60, "/");
            header('Location: ../recovery/');
            exit;
        }

        $emailExist = json_decode(
            file_get_contents('http://localhost/Veheaven/api/exist/user/email/'.$_POST['email']),
            TRUE
        );

        if(!$emailExist){
            setcookie('toast_message', "Email is not registered", time()+60*60, "/");
            header('Location: ../recovery/');
            exit;
        }

        /* Send user verification code to the user */
        $post = ["email" => $_POST['email']];

        $cURLConnection = curl_init(API_ENDPOINT.'/user/send/verification');
        curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, $post);
        curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
        
        $apiResponse = curl_exec($cURLConnection);
        curl_close($cURLConnection);
        $apiResponse = json_decode($apiResponse,TRUE);

        if(isset($apiResponse) && $apiResponse && isset($apiResponse['success'])){

            if($apiResponse['success']){

                setcookie('toast_message', "Please check your email", time()+60*60, "/");
                header('Location: ../explore/');
                exit;

            }else{

                setcookie('toast_message', $apiResponse['message'], time()+60*60, "/");
                header('Location: ../explore/');
                exit;

            }

        }

    }