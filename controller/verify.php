<?php
    if(!isset($_POST['password']) || !isset($_POST['confirmPassword']) || !isset($_POST['code'])){

        setcookie('toast_message', "Error: All data not found", time()+60*60, "/");
        header('Location: ../explore/');
        exit;

    }else{

        include_once '../include/config.php';

        /* Update the new password for the user */
        $cURLConnection = curl_init(API_ENDPOINT.'/user/verify/verification');
        curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, $_POST);
        curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
        
        $apiResponse = curl_exec($cURLConnection);
        curl_close($cURLConnection);
        $apiResponse = json_decode($apiResponse,TRUE);

        /* Check or verify the response data */
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
            header('Location: ../verify?code='.$_POST['code']);
            exit;
    
        }

    }