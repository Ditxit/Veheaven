<?php
    
    if(!isset($_GET['id']) || $_GET['id'] < 1){
        setcookie('toast_message', "Unknown vehicle", time()+60*60, "/");
        header('Location: ../explore');
        exit;
    }

    $PAGE_NAME = "Vehicle";

    // Bug
    include_once '../include/header.ui.php'; 

?>

<!DOCTYPE html>
<html lang="en">

<head> <?php include_once '../include/header.ui.php';?> </head>

<body class="is-white-95">  

    <?php
        // Including navbar
        include_once '../include/navbar.ui.php';

        // Including toast
        include_once '../include/toast.php';
    ?>

    <?php
        // Including global constants
        include_once '../include/config.php';

        if(isset($_COOKIE['token'])){
    
            $token = file_get_contents(API_ENDPOINT.'/user-token/verify/'.$_COOKIE['token']);
    
            $token = json_decode($token,TRUE);
    
            if(isset($token['success']) && $token['success'] == TRUE){
                $payload = file_get_contents(API_ENDPOINT.'/token/payload/'.$_COOKIE['token']);
                $payload = json_decode($payload,TRUE);
                $payload = $payload['payload'];
            }
    
        }

        $vehicle = file_get_contents(API_ENDPOINT.'/vehicle/'.$_GET['id']);
        $vehicle = json_decode($vehicle,TRUE);

        // echo "<pre>";
        //     var_dump($vehicle);
        // echo "</pre>";

        echo '
        <div class="outer-container">
            <div class="width-80 float-center">
            <div class="row has-gap-20 margin-y-40">

                <!-- Left panel -- start -->
                <div class="col-70">

                    <!-- Left panel row -- start -->
                    <div class="row">

                        <!-- Vehicle General Detail Column -- start -->
                        <div class="col-100">

                            <div id="vehicle-info-section" class="is-white custom-border radius-15">
                                <div class="row">
                                    <!-- vehicle image column -->
                                    <div class="col-100">
                                        <div class="is-black">
                                            <img style="object-fit: contain; height:65vh;" src="../api/storage/'.$vehicle['images'][0]['name'].'" alt="Vehicle Image"/>
                                        </div>
                                    </div>
                                    <div class="col-100">
                                        <div class="row">
                                            <div class="col-25">
                                                <a class="float-left custom-border padding-10 margin-top-10 margin-left-20 margin-bottom-20 radius-10" href="">
                                                    <img src="../assets/icons/svg/arrow-left.svg" alt="previous">
                                                </a>
                                            </div>
                                            <div class="col-50">
                                                <p class="h6 text-center padding-top-30">'.$vehicle['name'].'</p>
                                            </div>
                                            <div class="col-25">
                                                <a class="float-right custom-border padding-10 margin-top-10 margin-right-20 margin-bottom-20 radius-10" href="">
                                                    <img src="../assets/icons/svg/arrow-right.svg" alt="next">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- Vehicle General Detail Column -- end -->

                        <!-- Vehicle Overview Container Column -- start -->
                        <div class="col-100">
                            <p class="h5 margin-top-40 margin-bottom-10">Quick Glance</p>
                            <div class="row is-white custom-border radius-15">
                            
                                <div class="col-20 custom-border-right custom-border-bottom">
                                    <div class="row">
                                        <div class="col-100 padding-x-80 padding-top-20 padding-bottom-10">
                                            <img src="../assets/icons/png/speedometer.png" alt="">
                                        </div>
                                        <div class="col-100 text-center margin-bottom-15">'.$vehicle['mileage'].' Km/ltr</div>
                                    </div>
                                </div>
        
                                <div class="col-20 custom-border-right custom-border-bottom">
                                    <div class="row">
                                        <div class="col-100 padding-x-80 padding-top-20 padding-bottom-10">
                                            <img src="../assets/icons/png/chain.png" alt="">
                                        </div>
                                        <div class="col-100 text-center margin-bottom-15">'.$vehicle['engine'].' cc</div>
                                    </div>
                                </div>
        
                                <div class="col-20 custom-border-right custom-border-bottom">
                                    <div class="row">
                                        <div class="col-100 padding-x-80 padding-top-20 padding-bottom-10">
                                            <img src="../assets/icons/png/power.png" alt="">
                                        </div>
                                        <div class="col-100 text-center margin-bottom-15">'.$vehicle['bhp'].' bhp</div>
                                    </div>
                                </div>
        
                                <div class="col-20 custom-border-right custom-border-bottom">
                                    <div class="row">
                                        <div class="col-100 padding-x-80 padding-top-20 padding-bottom-10">
                                            <img src="../assets/icons/png/gear-box.png" alt="">
                                        </div>
                                        <div class="col-100 text-center margin-bottom-15">'.$vehicle['transmission']['transmission'].'</div>
                                    </div>
                                </div>
        
                                <div class="col-20 custom-border-bottom">
                                    <div class="row">
                                        <div class="col-100 padding-x-80 padding-top-20 padding-bottom-10">
                                            <img src="../assets/icons/png/seat.png" alt="">
                                        </div>
                                        <div class="col-100 text-center margin-bottom-15">'.$vehicle['seat'].' seater</div>
                                    </div>
                                </div>
        
                                <div class="col-20 custom-border-right">
                                    <div class="row">
                                        <div class="col-100 padding-x-80 padding-top-20 padding-bottom-10">
                                            <img src="../assets/icons/png/gas-station.png" alt="">
                                        </div>
                                        <div class="col-100 text-center margin-bottom-15">'.$vehicle['fuel']['fuel'].'</div>
                                    </div>
                                </div>
        
                                <div class="col-20 custom-border-right">
                                    <div class="row">
                                        <div class="col-100 padding-x-80 padding-top-20 padding-bottom-10">
                                            <img src="../assets/icons/png/petrol.png" alt="">
                                        </div>
                                        <div class="col-100 text-center margin-bottom-15">'.$vehicle['fuel_capacity'].' ltr</div>
                                    </div>
                                </div>
        
                                <div class="col-20 custom-border-right">
                                    <div class="row">
                                        <div class="col-100 padding-x-80 padding-top-20 padding-bottom-10">
                                            <img src="../assets/icons/png/speed.png" alt="">
                                        </div>
                                        <div class="col-100 text-center margin-bottom-15">'.$vehicle['top_speed'].' Km/hr</div>
                                    </div>
                                </div>
        
                                <div class="col-20 custom-border-right">
                                    <div class="row">
                                        <div class="col-100 padding-x-80 padding-top-20 padding-bottom-10">
                                            <img src="../assets/icons/png/color.png" alt="">
                                        </div>
                                        <div class="col-100 text-center margin-bottom-15">';
                                        $color_string = [];
                                        foreach($vehicle['colors'] as $color){
                                            $color_string[] = $color['color'];
                                        }
                                        $color_string = implode(", ",$color_string);
                                        echo $color_string;
                                        echo '</div>
                                    </div>
                                </div>';
                                
                                if($vehicle['condition']['condition'] == 'Used'){
                                    echo '
                                        <div class="col-20">
                                            <div class="row">
                                                <div class="col-100 padding-x-80 padding-top-20 padding-bottom-10">
                                                    <img src="../assets/icons/png/person.png" alt="">
                                                </div>
                                                <div class="col-100 text-center margin-bottom-10">'.$vehicle['used_vehicle']['owners'].' owners</div>
                                            </div>
                                        </div>
                                    ';
                                }else{
                                    echo '
                                        <div class="col-20">
                                            <div class="row">
                                                <div class="col-100 padding-x-80 padding-top-20 padding-bottom-10">
                                                    <img src="../assets/icons/png/new.png" alt="">
                                                </div>
                                                <div class="col-100 text-center margin-bottom-10">Brand new</div>
                                            </div>
                                        </div>
                                    ';
                                }
        
                            echo '</div>
                        </div>
                        <!-- Vehicle Overview Container Column -- end -->

                        <!-- Vehicle Specification Container -- start --> 
                        <div class="col-100">
                            <p class="h5 margin-top-40 margin-bottom-10">Specification</p>
                            <div class="row is-white custom-border radius-15">
                                <div class="col">
                                        
                                    <div class="row custom-border-bottom padding-20">
                                        <div class="col-50">Name</div>
                                        <div class="col-50">'.$vehicle['name'].'</div>
                                    </div>

                                    <div class="row custom-border-bottom padding-20">
                                        <div class="col-50">Price</div>
                                        <div class="col-50">NRs. '.$vehicle['price'].'</div>
                                    </div>

                                    <div class="row custom-border-bottom padding-20">
                                        <div class="col-50">Condition & Type</div>
                                        <div class="col-50">'.$vehicle['condition']['condition'].' '.$vehicle['type']['type'].'</div>
                                    </div>

                                    <div class="row custom-border-bottom padding-20">
                                        <div class="col-50">Make & Model</div>
                                        <div class="col-50">'.$vehicle['model']['brand'].' '.$vehicle['model']['model'].' ('.$vehicle['model']['year'].')</div>
                                    </div>

                                    <div class="row custom-border-bottom padding-20">
                                        <div class="col-50">Body Structure</div>
                                        <div class="col-50">'.$vehicle['body']['body'].'</div>
                                    </div>

                                    <div class="row custom-border-bottom padding-20">
                                        <div class="col-50">Mileage</div>
                                        <div class="col-50">'.$vehicle['mileage'].' Km/ltr</div>
                                    </div>

                                    <div class="row custom-border-bottom padding-20">
                                        <div class="col-50">Engine Cubic Capacity</div>
                                        <div class="col-50">'.$vehicle['engine'].' cc</div>
                                    </div>

                                    <div class="row custom-border-bottom padding-20">
                                        <div class="col-50">Break Horse Power</div>
                                        <div class="col-50">'.$vehicle['bhp'].' bhp</div>
                                    </div>

                                    <div class="row custom-border-bottom padding-20">
                                        <div class="col-50">Turn Radius</div>
                                        <div class="col-50">'.$vehicle['turn_radius'].' meter</div>
                                    </div>

                                    <div class="row custom-border-bottom padding-20">
                                        <div class="col-50">Top Speed</div>
                                        <div class="col-50">'.$vehicle['top_speed'].' Km/hr</div>
                                    </div>

                                    <div class="row custom-border-bottom padding-20">
                                        <div class="col-50">Color</div>
                                        <div class="col-50">'.$color_string.'</div>
                                    </div>

                                    <div class="row custom-border-bottom padding-20">
                                        <div class="col-50">Fuel</div>
                                        <div class="col-50">'.$vehicle['fuel']['fuel'].'</div>
                                    </div>

                                    <div class="row custom-border-bottom padding-20">
                                        <div class="col-50">Transmission</div>
                                        <div class="col-50">'.$vehicle['transmission']['transmission'].'</div>
                                    </div>

                                    <div class="row custom-border-bottom padding-20">
                                        <div class="col-50">Seat Capacity</div>
                                        <div class="col-50">'.$vehicle['seat'].' seater</div>
                                    </div>

                                    <div class="row custom-border-bottom padding-20">
                                        <div class="col-50">Tyres</div>
                                        <div class="col-50"> Front: '.$vehicle['front_tyre']['tyre'].', Rear: '.$vehicle['rear_tyre']['tyre'].'</div>
                                    </div>

                                    <div class="row custom-border-bottom padding-20">
                                        <div class="col-50">Brakes</div>
                                        <div class="col-50"> Front: '.$vehicle['front_break']['break'].' brake, Rear: '.$vehicle['rear_break']['break'].' brake</div>
                                    </div>

                                    <div class="row custom-border-bottom padding-20">
                                        <div class="col-50">Suspensions</div>
                                        <div class="col-50"> Front: '.$vehicle['front_suspension']['suspension'].', Rear: '.$vehicle['rear_suspension']['suspension'].'</div>
                                    </div>

                                    <div class="row padding-20">
                                        <div class="col-50">Last Updated</div>
                                        <div class="col-50">'.date("F jS, Y", strtotime($vehicle['last_updated'])).'</div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- Vehicle Specification Container -- end -->

                        <!-- Vehicle Features Container -- start --> 
                        <div class="col-100">
                            <p class="h5 margin-top-40 margin-bottom-10">Features</p>
                            <div class="row is-white custom-border radius-15">
                                <div class="col">';
                                    
                                foreach($vehicle['features'] as $feature){
                                    echo '
                                        <div class="row custom-border-bottom padding-20">
                                            <div class="col-100">'.$feature['feature'].'</div>
                                        </div>
                                    ';
                                }

                                echo'</div>
                            </div>
                        </div>
                        <!-- Vehicle Features Container -- end --> 

                    </div>
                    <!-- Left panel row -- end -->

                </div>
                <!-- Left panel -- end -->
                
                <!-- Right panel -- start -->
                <div class="col-30">
                    
                    <!-- Sticky top -- start -->
                    <div class=" sticky top" style="top: 92px;">

                        <div class="custom-border radius-15 is-white"> 

                            <div class="row padding-20 custom-border-bottom">
                                <div class="col-100 h5 text-deep-purple">
                                    <span>NRs.&nbsp;</span>
                                    <span>'.$vehicle['price'].'</span>
                                </div>
                            </div>

                            <div class="row padding-20 has-gap-10">
                                <div class="col-100">
                                    <a href="" on-hover="text-blue">
                                        <img class="float-left" style="height:44px; width:44px;" src="../assets/avatars/default.jpg" alt="seller image">
                                        <p class="float-left padding-left-15 padding-y-15">'.$vehicle['seller']['first_name'].' '.$vehicle['seller']['last_name'].'</p>
                                    </a>
                                </div>
                            </div>

                            <div class="row padding-x-20 padding-y-10" on-hover="is-white-95">
                                <div class="col-100">
                                    <a on-hover="text-blue" href="mailto:'.$vehicle['seller']['email'].'">
                                        <span class="float-left"><img style="height:24px; width:auto;" src="../assets/icons/png/email.png"></span>
                                        <span class="float-left padding-left-10">'.$vehicle['seller']['email'].'</span>
                                    </a>
                                </div>
                            </div>

                            <div class="row padding-x-20 padding-y-10 margin-bottom-15" on-hover="is-white-95">
                                <div class="col-100">
                                    <a on-hover="text-blue" href="tel:'.$vehicle['seller']['phone'].'">
                                        <span class="float-left"><img style="height:24px; width:auto;" src="../assets/icons/png/phone.png"></span>
                                        <span class="float-left padding-left-10">'.$vehicle['seller']['phone'].'</span>
                                    </a>
                                </div>
                            </div>

                        </div>';
                        
                        if(isset($payload['id']) && $payload['id'] == $vehicle['seller']['id']){
                            echo '
                                <div class="custom-border radius-15 is-white margin-top-25">
                                    <div class="row">
                                        <div class="col-100 custom-border-bottom">
                                            <a href="" class="padding-20 width-100" on-hover="text-green">Edit Post</a>
                                        </div>
                                        <div class="col-100">
                                            <a href="" class="padding-20 width-100" on-hover="text-red">Delete Post</a>
                                        </div>
                                    </div>
                                </div>
                            ';
                        }

                    echo'</div>
                    <!-- Sticky top -- end -->

                </div>
                <!-- Right panel -- end -->
            </div>
        ';

    ?>


</body>