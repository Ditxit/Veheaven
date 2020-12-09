<?php

    if(isset($_COOKIE['token'])){

        $accesstoken = file_get_contents('http://localhost/Veheaven/api/token/verify/'.$_COOKIE['token']);

        $accesstoken = json_decode($accesstoken,TRUE);

        if($accesstoken != FALSE){

            if(isset($accesstoken['user_type'])){

                if($accesstoken['user_type'] != 'admin'){

                    header('Location: ../login?error=Token user is not admin.');

                }
    
            }else{

                header('Location: ../login?error=Token does not have user type.');

            }

        }else{

            header('Location: ../login?error=Token is invalid or expired.');

        }

    }else{

        header('Location: ../login?error=Token not found in the cookie.');

    }