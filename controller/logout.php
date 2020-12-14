<?php

    if (isset($_COOKIE['token'])) {

        unset($_COOKIE['token']); 
        setcookie('token', null, -1, '/'); 

        setcookie('toast_message', "Logout Successful", time()+60*60, "/");

    }

    header('Location: ../explore');
    exit;

    
