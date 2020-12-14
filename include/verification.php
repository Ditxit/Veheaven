<?php

    if(isset($_COOKIE['token'])){

        $accesstoken = file_get_contents('http://localhost/Veheaven/api/token/verify/'.$_COOKIE['token']);

        $accesstoken = json_decode($accesstoken,TRUE);

        if($accesstoken != FALSE){

            if(isset($accesstoken['user_type'])){

                if($accesstoken['user_type'] != 'admin'){
                    setcookie('toast_message', "Token user is not admin", time()+60*60, "/");
                    header('Location: ../login/');
                    exit;
                }
    
            }else{
                setcookie('toast_message', "Token does not have user type", time()+60*60, "/");
                header('Location: ../login/');
                exit;
            }

        }else{
            setcookie('toast_message', "Token is invalid or expired", time()+60*60, "/");
            header('Location: ../login/');
            exit;
        }

    }else{
        setcookie('toast_message', "Token not found in the cookie", time()+60*60, "/");
        header('Location: ../login/');
        exit;
    }