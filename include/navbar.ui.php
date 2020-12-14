
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
                include 'config.php';

                // Checking user exist or not
                if (isset($_COOKIE['token'])) {
                    
                    $token = file_get_contents(API_ENDPOINT.'/token/verify/'.$_COOKIE['token']);

                    //if($token)

                }

                //var_dump($accesstoken);

                $CURRENT_PAGE = isset($PAGE_NAME) ? $PAGE_NAME : "";

                if($PAGE_NAME == "Explore"){
                    echo '<a class="button padding-15 text-deep-purple">Explore</a>';
                }else{
                    echo '<a href="../explore" class="button padding-15" on-hover="text-deep-purple">Explore</a>';
                }

                if($PAGE_NAME == "Login"){
                    echo '<a class="button padding-15 text-deep-purple">Login</a>';
                }else{
                    echo '<a href="../login" class="button padding-15" on-hover="text-deep-purple">Login</a>';
                }

                if($PAGE_NAME == "Profile"){
                    echo '<a class="button padding-15 text-deep-purple">Logout</a>';
                }else{
                    echo '<a href="../controller/logout.php" class="button padding-15" on-hover="text-deep-purple">Logout</a>';
                }

                unset($CURRENT_PAGE);
                
            ?>

        </div>
    </div>
</div>