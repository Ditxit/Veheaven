<?php
    
    if(!isset($_GET['id']) || $_GET['id'] < 1){
        setcookie('toast_message', "Unknown vehicle", time()+60*60, "/");
        header('Location: ../explore');
        exit;
    }

    $PAGE_NAME = "Vehicle";

    // Bug
    include_once '../include/header.ui.php'; 

    // Including toast
    include_once '../include/toast.php';

?>

<!DOCTYPE html>
<html lang="en">

<head> <?php include_once '../include/header.ui.php';?> </head>

<body class="custom-bg-gray">  

    <?php
        // Including navbar
        include_once '../include/navbar.ui.php';

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

        // Prepare the profile image of vehicle seller
        $userProfileImage = file_get_contents(API_ENDPOINT.'/user/' . $vehicle['seller']['id'] . '/image');
        $userProfileImage = json_decode($userProfileImage, TRUE);
        $userProfileImage = $userProfileImage['content'];
        $userProfileImage = $userProfileImage ? SERVER_NAME . '/api/storage/' . $userProfileImage['name'] : SERVER_NAME . '/assets/avatars/default.jpg';

        if(!$vehicle || $vehicle['status'] == "removed"){
            /*
            *   Redirect with no such vehicle exist message  
            */
            setcookie('toast_message', "No such vehicle exist", time()+60*60, "/");
            header('Location: ../explore');
            exit;
        }
    ?>

        <div class="outer-container">
            <div class="width-80 float-center" phone="width-95">
            <div class="row has-gap-20 margin-y-30" phone="-has-gap-20">

                <!-- Left panel -- start -->
                <div class="col-70" phone="col-100">

                    <!-- Left panel row -- start -->
                    <div class="row">

                        <!-- Vehicle General Detail Column -- start -->
                        <div class="col-100">

                            <div id="vehicle-info-section" class="is-white custom-border radius-15">
                                <div class="row">
                                    <div class="col-100 padding-10">
                                        <a href="../profile/?id=<?=$vehicle['seller']['id']?>" on-hover="custom-text-blue">
                                            <img class="float-left radius-circle" style="height:44px; width:44px;" src="<?=$userProfileImage?>" alt="seller image">
                                            <p class="float-left padding-left-15 padding-y-15"><?=$vehicle['seller']['first_name'].' '.$vehicle['seller']['last_name']?></p>
                                        </a>
                                    </div>
                                    <!-- vehicle image column -->
                                    <div class="col-100">
                                        <div class="custom-slider is-black" id="vehicle-image-gallery">
                                            <?php
                                            foreach($vehicle['images'] as $image){
                                                echo '
                                                    <div class="custom-slide">
                                                        <img style="object-fit: contain; aspect-ratio: 16 / 9;" src="../api/storage/'.$image['name'].'" alt="'.$image['name'].'"/>
                                                    </div>
                                                ';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-100">
                                        <div class="row">
                                            <div class="col-20" phone="-col-20 col-0 display-none">
                                                <a id="vehicle-image-gallery-previous" class="float-left custom-border padding-10 margin-10 radius-10">
                                                    <img src="../assets/icons/svg/arrow-left.svg" alt="previous">
                                                </a>
                                            </div>
                                            <div class="col-60" phone="col-100 padding-20">
                                                <p class="h6 text-center padding-top-25" phone="-padding-top-25 -text-center"><?=$vehicle['name']?></p>
                                                <p class="display-none custom-text-blue margin-top-5" phone="-display-none small bold">NPR <?=$vehicle['price']?></p>
                                            </div>
                                            <div class="col-20" phone="-col-20 col-0 display-none">
                                                <a id="vehicle-image-gallery-next" class="float-right custom-border padding-10 margin-10 radius-10">
                                                    <img src="../assets/icons/svg/arrow-right.svg" alt="next">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- Vehicle General Detail Column -- end -->
                        <script>
                            const vehicleImageGallery = document.getElementById("vehicle-image-gallery");
                            const vehicleImageGalleryWidth = vehicleImageGallery.querySelector(".custom-slide").clientWidth;
                            document.getElementById("vehicle-image-gallery-previous").addEventListener("click", ()=>{
                                vehicleImageGallery.scrollBy(-vehicleImageGalleryWidth, 0);
                            });
                            document.getElementById("vehicle-image-gallery-next").addEventListener("click", ()=>{
                                vehicleImageGallery.scrollBy(vehicleImageGalleryWidth, 0);
                            });
                        </script>

                        <!-- Vehicle Overview Container Column -- start -->
                        <div class="col-100">
                            <p class="h5 margin-top-40 margin-bottom-10">Quick Glance</p>
                            <div class="row is-white custom-border radius-15">
                            
                                <div class="col-20 custom-border-right custom-border-bottom" phone="col-50">
                                    <div class="row">
                                        <div class="col-100 padding-x-80 padding-top-20 padding-bottom-10">
                                            <img src="../assets/icons/png/speedometer.png" alt="">
                                        </div>
                                        <div class="col-100 text-center margin-bottom-15"><?=$vehicle['mileage']?> Km/ltr</div>
                                    </div>
                                </div>
        
                                <div class="col-20 custom-border-right custom-border-bottom" phone="col-50 -custom-border-right">
                                    <div class="row">
                                        <div class="col-100 padding-x-80 padding-top-20 padding-bottom-10">
                                            <img src="../assets/icons/png/chain.png" alt="">
                                        </div>
                                        <div class="col-100 text-center margin-bottom-15"><?=$vehicle['engine']?> cc</div>
                                    </div>
                                </div>
        
                                <div class="col-20 custom-border-right custom-border-bottom" phone="col-50">
                                    <div class="row">
                                        <div class="col-100 padding-x-80 padding-top-20 padding-bottom-10">
                                            <img src="../assets/icons/png/power.png" alt="">
                                        </div>
                                        <div class="col-100 text-center margin-bottom-15"><?=$vehicle['bhp']?> bhp</div>
                                    </div>
                                </div>
        
                                <div class="col-20 custom-border-right custom-border-bottom" phone="col-50 -custom-border-right">
                                    <div class="row">
                                        <div class="col-100 padding-x-80 padding-top-20 padding-bottom-10">
                                            <img src="../assets/icons/png/gear-box.png" alt="">
                                        </div>
                                        <div class="col-100 text-center margin-bottom-15"><?=$vehicle['transmission']['transmission']?></div>
                                    </div>
                                </div>
        
                                <div class="col-20 custom-border-bottom" phone="col-50 custom-border-right">
                                    <div class="row">
                                        <div class="col-100 padding-x-80 padding-top-20 padding-bottom-10">
                                            <img src="../assets/icons/png/seat.png" alt="">
                                        </div>
                                        <div class="col-100 text-center margin-bottom-15"><?=$vehicle['seat']?> seater</div>
                                    </div>
                                </div>
        
                                <div class="col-20 custom-border-right" phone="col-50 -custom-border-right custom-border-bottom">
                                    <div class="row">
                                        <div class="col-100 padding-x-80 padding-top-20 padding-bottom-10">
                                            <img src="../assets/icons/png/gas-station.png" alt="">
                                        </div>
                                        <div class="col-100 text-center margin-bottom-15"><?=$vehicle['fuel']['fuel']?></div>
                                    </div>
                                </div>
        
                                <div class="col-20 custom-border-right" phone="col-50 custom-border-bottom">
                                    <div class="row">
                                        <div class="col-100 padding-x-80 padding-top-20 padding-bottom-10">
                                            <img src="../assets/icons/png/petrol.png" alt="">
                                        </div>
                                        <div class="col-100 text-center margin-bottom-15"><?=$vehicle['fuel_capacity']?> ltr</div>
                                    </div>
                                </div>
        
                                <div class="col-20 custom-border-right" phone="col-50 -custom-border-right custom-border-bottom">
                                    <div class="row">
                                        <div class="col-100 padding-x-80 padding-top-20 padding-bottom-10">
                                            <img src="../assets/icons/png/speed.png" alt="">
                                        </div>
                                        <div class="col-100 text-center margin-bottom-15"><?=$vehicle['top_speed']?> Km/hr</div>
                                    </div>
                                </div>
        
                                <div class="col-20 custom-border-right" phone="col-50">
                                    <div class="row">
                                        <div class="col-100 padding-x-80 padding-top-20 padding-bottom-10">
                                            <img src="../assets/icons/png/color.png" alt="">
                                        </div>
                                        <div class="col-100 text-center margin-bottom-15">   
                                            <div class="row margin-x-50 radius-100 margin-top-5 custom-border">
                                                <?php foreach ($vehicle['colors'] as $color) { ?>
                                                    <div class="col padding-10" title="<?=$color['color']?>" style="background-color: <?=$color['hexcode']?>;"></div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php if ($vehicle['condition']['condition'] == 'Used') { ?>
                                    <div class="col-20" phone="col-50">
                                        <div class="row">
                                            <div class="col-100 padding-x-80 padding-top-20 padding-bottom-10">
                                                <img src="../assets/icons/png/person.png" alt="">
                                            </div>
                                            <div class="col-100 text-center margin-bottom-10"><?=$vehicle['used_vehicle']['owners']?> owners</div>
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <div class="col-20" phone="col-50">
                                        <div class="row">
                                            <div class="col-100 padding-x-80 padding-top-20 padding-bottom-10">
                                                <img src="../assets/icons/png/new.png" alt="">
                                            </div>
                                            <div class="col-100 text-center margin-bottom-10">Brand new</div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <!-- Vehicle Overview Container Column -- end -->

                        <!-- Vehicle Specification Container -- start --> 
                        <div class="col-100">
                            <p class="h5 margin-top-40 margin-bottom-10">Specification</p>
                            <div class="row is-white custom-border radius-15">
                                <div class="col">
                                        
                                    <div class="row custom-border-bottom padding-20">
                                        <div class="col-50">Name</div>
                                        <div class="col-50"><?=$vehicle['name']?></div>
                                    </div>

                                    <div class="row custom-border-bottom padding-20">
                                        <div class="col-50">Price</div>
                                        <div class="col-50">NPR <?=$vehicle['price']?></div>
                                    </div>

                                    <div class="row custom-border-bottom padding-20">
                                        <div class="col-50">Condition & Type</div>
                                        <div class="col-50"><?=$vehicle['condition']['condition'].' '.$vehicle['type']['type']?></div>
                                    </div>

                                    <div class="row custom-border-bottom padding-20">
                                        <div class="col-50">Make & Model</div>
                                        <div class="col-50"><?=$vehicle['model']['brand'].' '.$vehicle['model']['model'].' ('.$vehicle['model']['year'].')'?></div>
                                    </div>

                                    <div class="row custom-border-bottom padding-20">
                                        <div class="col-50">Body Structure</div>
                                        <div class="col-50"><?=$vehicle['body']['body']?></div>
                                    </div>

                                    <div class="row custom-border-bottom padding-20">
                                        <div class="col-50">Mileage</div>
                                        <div class="col-50"><?=$vehicle['mileage']?> Km/ltr</div>
                                    </div>

                                    <div class="row custom-border-bottom padding-20">
                                        <div class="col-50">Engine Cubic Capacity</div>
                                        <div class="col-50"><?=$vehicle['engine']?> cc</div>
                                    </div>

                                    <div class="row custom-border-bottom padding-20">
                                        <div class="col-50">Break Horse Power</div>
                                        <div class="col-50"><?=$vehicle['bhp']?> bhp</div>
                                    </div>

                                    <div class="row custom-border-bottom padding-20">
                                        <div class="col-50">Turn Radius</div>
                                        <div class="col-50"><?=$vehicle['turn_radius']?> meter</div>
                                    </div>

                                    <div class="row custom-border-bottom padding-20">
                                        <div class="col-50">Top Speed</div>
                                        <div class="col-50"><?=$vehicle['top_speed']?> Km/hr</div>
                                    </div>

                                    <div class="row custom-border-bottom padding-20">
                                        <?php
                                            $colorString = [];
                                            foreach($vehicle['colors'] as $color){ $colorString[] = $color['color']; }
                                            $colorString = implode(", ",$colorString);
                                        ?>
                                        <div class="col-50">Color</div>
                                        <div class="col-50"><?=$colorString?></div>
                                    </div>

                                    <div class="row custom-border-bottom padding-20">
                                        <div class="col-50">Fuel</div>
                                        <div class="col-50"><?=$vehicle['fuel']['fuel']?></div>
                                    </div>

                                    <div class="row custom-border-bottom padding-20">
                                        <div class="col-50">Transmission</div>
                                        <div class="col-50"><?=$vehicle['transmission']['transmission']?></div>
                                    </div>

                                    <div class="row custom-border-bottom padding-20">
                                        <div class="col-50">Seat Capacity</div>
                                        <div class="col-50"><?=$vehicle['seat']?> seater</div>
                                    </div>

                                    <div class="row custom-border-bottom padding-20">
                                        <div class="col-50">Tyres</div>
                                        <div class="col-50">Front: <?=$vehicle['front_tyre']['tyre'].', Rear: '.$vehicle['rear_tyre']['tyre']?></div>
                                    </div>

                                    <div class="row custom-border-bottom padding-20">
                                        <div class="col-50">Brakes</div>
                                        <div class="col-50">Front: <?=$vehicle['front_break']['break'].' brake, Rear: '.$vehicle['rear_break']['break']?> brake</div>
                                    </div>

                                    <div class="row custom-border-bottom padding-20">
                                        <div class="col-50">Suspensions</div>
                                        <div class="col-50">Front: <?=$vehicle['front_suspension']['suspension'].', Rear: '.$vehicle['rear_suspension']['suspension']?></div>
                                    </div>

                                    <div class="row padding-20">
                                        <div class="col-50">Last Updated</div>
                                        <div class="col-50"><?=date("F jS, Y", strtotime($vehicle['last_updated']))?></div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- Vehicle Specification Container -- end -->

                        <!-- Vehicle Features Container -- start --> 
                        <div class="col-100">
                            <p class="h5 margin-top-40 margin-bottom-10">Features</p>
                            <div class="row is-white custom-border radius-15">
                                <div class="col">
                                    <?php foreach($vehicle['features'] as $index => $feature){ ?>
                                        <?php 
                                            $class = 'row padding-20';
                                            $class .= ($index == 0) ? '' : ' custom-border-top';
                                        ?>
                                        <div class="<?=$class?>">
                                            <div class="col-100"><?=$feature['feature']?></div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <!-- Vehicle Features Container -- end --> 

                    </div>
                    <!-- Left panel row -- end -->

                </div>
                <!-- Left panel -- end -->
                
                <!-- Right panel -- start -->
                <div class="col-30" phone="order-first col-100">
                    
                    <!-- Sticky top -- start -->
                    <div class="sticky top" style="top: 86px; z-index: 0;" phone="-top">

                        <div class="custom-border radius-15 is-white" phone="display-none"> 

                            <div class="row padding-20 custom-border-bottom">
                                <div class="col-100 h5 custom-text-blue">
                                    <span>NPR </span>
                                    <span><?=$vehicle['price']?></span>
                                </div>
                            </div>

                            <div class="row padding-20 has-gap-10">
                                <div class="col-100">
                                    <a href="../profile/?id=<?=$vehicle['seller']['id']?>" on-hover="custom-text-blue">
                                        <img class="float-left radius-circle" style="height:44px; width:44px;" src="<?=$userProfileImage?>" alt="seller image">
                                        <p class="float-left padding-left-15 padding-y-15"><?=$vehicle['seller']['first_name'].' '.$vehicle['seller']['last_name']?></p>
                                    </a>
                                </div>
                            </div>

                            <div class="row padding-x-20 padding-y-10" on-hover="is-white-95">
                                <div class="col-100">
                                    <a on-hover="text-blue" href="mailto:'.$vehicle['seller']['email'].'">
                                        <span class="float-left"><img style="height:24px; width:auto;" src="../assets/icons/png/email.png"></span>
                                        <span class="float-left padding-left-10"><?=$vehicle['seller']['email']?></span>
                                    </a>
                                </div>
                            </div>

                            <div class="row padding-x-20 padding-y-10 margin-bottom-15" on-hover="is-white-95">
                                <div class="col-100">
                                    <a on-hover="text-blue" href="tel:'.$vehicle['seller']['phone'].'">
                                        <span class="float-left"><img style="height:24px; width:auto;" src="../assets/icons/png/phone.png"></span>
                                        <span class="float-left padding-left-10"><?=$vehicle['seller']['phone']?></span>
                                    </a>
                                </div>
                            </div>

                        </div>

                        <?php if (isset($payload['id']) && $payload['id'] == $vehicle['seller']['id']) { ?>
                            <div class="custom-border radius-15 is-white margin-top-25" phone="-margin-top-25 margin-bottom-25">
                                <div class="row">
                                    <div class="col-100 custom-border-bottom" phone="-col-100 col-50 -custom-border-bottom custom-border-right">
                                        <a onclick="showModal('edit_vehicle_modal')" class="padding-20 width-100" on-hover="text-green">Edit Post</a>
                                    </div>
                                    <div class="col-100" phone="-col-100 col-50">
                                        <a onclick="showModal('delete_vehicle_modal')" class="padding-20 width-100" on-hover="text-red">Delete Post</a>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <!-- Sticky top -- end -->

                </div>
                <!-- Right panel -- end -->
            </div>
        </div>
    </div>

    <?php if (isset($payload['id']) && $payload['id'] == $vehicle['seller']['id']) { ?>
        <!-- Edit vehicle model -- start -->
        <div class="modal" id="edit_vehicle_modal">
            <div class="outer-container">
                <div class="inner-container">
                    <form action="../controller/vehicle.php" method="POST">
                        <div class="card float-center width-40 is-white radius-15 margin-y-100 shadow-100" on-hover="-shadow-100 shadow-70" phone="width-100 -margin-y-100 -radius-20 radius-0">
                            <div class="row custom-border margin-15 radius-20">
                                <div class="col-100">
                                    <div class="row is-white-95 custom-border-bottom">
                                        <div class="col-auto is-white custom-border-right" title="Name">
                                            <span style="width: 70px;" class="padding-x-10 padding-top-15 h6 text-center">Name</span>
                                        </div>
                                        <div class="col">
                                            <input id="edit-vehicle-name" name="vehicle-name" type="text" value="<?=$vehicle['name']?>" class="padding-15 is-transparent custom-border-none">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-100">
                                    <div class="row is-white-95">
                                        <div class="col-auto is-white custom-border-right" title="Nepalese rupee">
                                            <span style="width: 70px;" class="padding-x-10 padding-top-15 h6 text-center">NPR</span>
                                        </div>
                                        <div class="col">
                                            <input id="edit-vehicle-price" name="vehicle-price" type="text" inputmode="decimal" value="<?=$vehicle['price']?>" class="padding-15 is-transparent custom-border-none">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row custom-border-top">
                                <div class="col-50 custom-border-right">
                                    <a class="close button width-100 is-white padding-y-5">Cancel</a>
                                </div>
                                <div class="col-50">
                                    <input type="hidden" name="token" value="<?=$_COOKIE['token']?>">
                                    <input type="hidden" name="vehicle-id" value="<?=$_GET['id']?>">
                                    <input class="button width-100 is-white text-green padding-y-5" type="submit" name="vehicle-edit" value="Save">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Edit vehicle model -- end -->

        <!-- Confirm delete model -- start -->
        <div class="modal" id="delete_vehicle_modal">
            <div class="outer-container">
                <div class="inner-container">
                    <div class="card float-center width-40 is-white radius-15 margin-y-100 shadow-100" on-hover="-shadow-100 shadow-70" phone="width-100 -margin-y-100 -radius-20 radius-0">
                        <div class="row padding-20 custom-border-bottom">
                            <div class="col-15 padding-15">
                                <img src="../assets/icons/svg/alert-triangle.svg" alt="Alert">
                            </div>
                            <div class="col-85 padding-y-15">
                                <p id="card-title" class="h6">Delete Vehicle</p>
                                <p class="small">This action cannot be undone</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-50 custom-border-right">
                                <a class="close button width-100 is-white padding-y-5">Cancel</a>
                            </div>
                            <div class="col-50">
                                <form action="../controller/vehicle.php" method="POST">
                                    <input type="hidden" name="token" value="<?=$_COOKIE['token']?>">
                                    <input type="hidden" name="vehicle-id" value="<?=$_GET['id']?>">
                                    <input class="button width-100 is-white text-red padding-y-5" type="submit" name="vehicle-remove" value="Delete">
                                </form>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Confirm delete model -- end -->
    <?php } ?>

    <!-- Footer -- start -->
    <?php include_once '../include/footer.ui.php'; ?>
    <!-- Footer -- end -->

    <!-- JavaScript -- start -->
    <script>

        function addCurrentVehicleToSeenHistory() {

            let _key = 'seenVehicleHistory';
            let _vehicleId = <?=$_GET['id']?>;
            let _limit = 10;

            if (!LocalStorage.has(_key)) {

                LocalStorage.set(_key, [_vehicleId]);

            } else {

                let _value = LocalStorage.get(_key);

                //if(_value.includes(_vehicleId)) return;

                // Push at the beginning of array
                _value.unshift(_vehicleId);

                // Remove the duplicated
                _value = [...new Set(_value)];

                // Limit the size of array
                _value = _value.slice(0, _limit);

                LocalStorage.set(_key, _value);

            }
        } addCurrentVehicleToSeenHistory();

    </script>
    <!-- JavaScript -- end -->

</body>
</html>