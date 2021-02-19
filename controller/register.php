<?php
    if(isset($_POST['registerButton'])){

        include_once '../include/config.php';

        if(
            !isset($_POST['firstName']) || !$_POST['firstName'] ||
            !isset($_POST['lastName']) || !$_POST['lastName'] ||
            !isset($_POST['email']) || !$_POST['email']
        ){
            setcookie('toast_message', "Empty fields found", time()+60*60, "/");
            header('Location: ../register/');
            exit;
        }

        if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
            setcookie('toast_message', "Invalid email address", time()+60*60, "/");
            header('Location: ../register/');
            exit;
        }

        $emailExist = json_decode(
            file_get_contents(API_ENDPOINT.'/exist/user/email/'.$_POST['email']),
            TRUE
        );

        if($emailExist){
            setcookie('toast_message', "Email already registered", time()+60*60, "/");
            header('Location: ../login/');
            exit;
        }

        /* Add unverified user to the 'user' table */
        $cURLConnection = curl_init(API_ENDPOINT.'/register/seller');
        curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, $_POST);
        curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
        
        $apiResponse = curl_exec($cURLConnection);
        curl_close($cURLConnection);
        $apiResponse = json_decode($apiResponse,TRUE);

        /* Check or verify the response data */
        if(isset($apiResponse) && $apiResponse && isset($apiResponse['inserted_id']) && $apiResponse['inserted_id'] > 0){

            /* Send user verification code to the user */
            $post = ["user_id" => $apiResponse['inserted_id']];

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

        }else{

            setcookie('toast_message', "Something went wrong", time()+60*60, "/");
            header('Location: ../register/');
            exit;

        }

    }