
<div class="outer-container is-white-100 shadow-15 sticky top">
    <div class="inner-container">
        <div class="float-left">
            <a href="">
                <!--<img src="" alt="LOGO" class="padding-15"/>-->
                <p class="h3 bold padding-15">Veheaven</p>
            </a>
        </div>
        <div class="float-right">

            <?php

                // Including global constants
                include_once 'config.php';

                // Checking user exist or not
                if (isset($_COOKIE['token'])) {
                    $token = file_get_contents(API_ENDPOINT.'/user-token/verify/'.$_COOKIE['token']);
                    $token = json_decode($token,TRUE);
                    if(isset($token) && $token['success']){

                        $payload = file_get_contents(API_ENDPOINT.'/token/payload/'.$_COOKIE['token']);
                        $payload = json_decode($payload,TRUE);

                        if(isset($payload) && $payload['success']){   
                            $USER = [];
                            $USER['id'] = $payload['payload']['id'];
                            $USER['name'] = $payload['payload']['first_name'];
                        }
                    }
                }

                $CURRENT_PAGE = isset($PAGE_NAME) ? $PAGE_NAME : "";

                if($PAGE_NAME == "Explore"){
                    echo '<a class="button padding-15 text-deep-purple">Explore</a>';
                }else{
                    echo '<a href="../explore" class="button padding-15" on-hover="text-deep-purple">Explore</a>';
                }

                if(!isset($USER)){
                    if($PAGE_NAME == "Login"){
                        echo '<a class="button padding-15 text-deep-purple">Login</a>';
                    }else{
                        echo '<a href="../login" class="button padding-15" on-hover="text-deep-purple">Login</a>';
                    }
                }

                if(isset($USER)){
                    echo '<a href="../profile" class="button padding-15" on-hover="text-deep-purple">'.$USER['name'].'</a>';
                    echo '<a href="../controller/logout.php" class="button padding-15" on-hover="text-deep-purple">Logout</a>';
                }

                unset($CURRENT_PAGE);
                unset($USER);
                
            ?>

        </div>
    </div>
</div>