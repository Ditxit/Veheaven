<?php 
    /*
    *   This includes must be kept at top
    *   If not, this might result in security risk
    */

    include_once '../include/verification.php';

    /*
    *   Setting the page name
    *   It is good practice setting PAGE_NAME before doing other things in the page
    */
    $PAGE_NAME = "Profile";

?>

<!DOCTYPE html>
<html lang="en">
<head> <?php include '../include/header.ui.php';?> </head>
<body class="is-white-95" style="overflow-y:scroll;">  

    <!-- Cookie Message -- start -->
    <?php include '../include/toast.php'; ?>
    <!-- Cookie Message -- end -->

    <!-- Navigation Bar -- start -->
    <?php include '../include/navbar.ui.php';?>
    <!-- Navigation Bar -- end -->

    <?php
        /*
        *   Including, Global Constants
        */
        include_once '../include/config.php';

        /*
        *   Since, verification.php is already included,
        *   we can call the api without worrying.
        */
        $payload = file_get_contents(API_ENDPOINT.'/token/payload/'.$_COOKIE['token']);
        $payload = json_decode($payload,TRUE);
        $payload = $payload['payload'];

        $vehicles = file_get_contents(API_ENDPOINT.'/'.$payload['id'].'/vehicles');
        $vehicles = json_decode($vehicles,TRUE);
    ?>
    
    <div class="outer-container">
        <div class="inner-container margin-y-40">
            <div class="row has-gap-30">
                <div class="col-30">

                    <div class="row padding-20 radius-20 is-white-100 shadow-15" on-hover="shadow-30">
                        <div class="col-100">
                            <div class="margin-bottom-20 radius-20 shadow-10" on-hover="shadow-20">
                                <img src="../assets/avatars/default.jpg" alt="User Image" style="width:100%;height:280px;object-fit:cover;">
                            </div>
                        </div>
                        <div class="col-100">
                            <div class="h5 cursor-default">
                                <?=$payload['first_name']." ".$payload['last_name']?>
                            </div>
                        </div>
                        <div class="col-100">
                            <div class="small cursor-default">
                                <?=$payload['email']?>
                            </div>
                        </div>
                        <div class="col-100">
                            <div class="small margin-bottom-10 cursor-default">
                                <?php if(isset($payload['phone'])) echo $payload['phone'];?>
                            </div>
                        </div>
                        <div class="col-100">
                            <div class="small margin-bottom-10 cursor-default">
                                <?php if(isset($payload['phone'])) echo 'Total Vehicles: '.count($vehicles);?>
                            </div>
                        </div>
                        <div class="col-100">
                            <hr>
                            <a href="../controller/logout.php" class="padding-top-10 text-red">Logout</a>
                        </div>
                    </div>
                </div>
                <div class="col-70">
                    <div class="row is-white-100 radius-20 shadow-15" on-hover="shadow-30">
                        <div class="col-100">
                            <?php
                                if(count($vehicles) == 0){
                                    echo '<div class="row">';
                                        echo '<div class="col-40">';
                                            echo '<div class="padding-50">';
                                                echo '<img src="../assets/backgrounds/not-found.svg" alt="Vehicles not found">';
                                            echo '</div>';
                                        echo '</div>';
                                        echo '<div class="col-60">';
                                            echo '<div class="padding-50">';
                                                echo '<p class="h4">Looks like you are yet to add your first vehicle</p>';
                                                echo '<p class="small">Click on the button to fill the vehicle detail form</p>';
                                                echo '<a onclick="showModal(\'add_vehicle_modal\')" class="button is-deep-purple-50 radius-10 padding-10 margin-y-25 display-block width-60" on-hover="is-deep-purple-60">Add a Vehicle</a>';
                                            echo '</div>';
                                        echo '</div>';
                                    echo '</div>';
                                }
                            ?>

                            <div class="modal" id="add_vehicle_modal">
                                <div class="outer-container">
                                    <div class="inner-container">
                                        <div class="card float-center width-50 is-white radius-20 shadow-15 padding-20 margin-top-100" on-hover="shadow-30">
                                            <form action="">
                                                <div class="row has-gap-15">
                                                    <div class="col-50">
                                                    <label for="vehicle-name" class="small">Name</label>
                                                        <input id="vehicle-name" type="text" placeholder="Enter vehicle name" class="padding-15 margin-bottom-15 radius-5">
                                                    </div>
                                                    <div class="col-50">
                                                        <label for="vehicle-price" class="small">Price (NRs.)</label>
                                                        <input id="vehicle-price" type="number" placeholder="Enter vehicle price" class="padding-15 margin-bottom-15 radius-5">
                                                    </div>
                                                </div>
                                                <div class="row has-gap-15">
                                                    <div class="col-50">
                                                        <label class="small" for="vehicle-manufacturer">Manufacturer</label>
                                                        <select name="vehile-manufacturer" id="vehicle-manufacturer" class="padding-15 margin-bottom-15 radius-5 cursor-pointer">
                                                            <option value="any">Any</option>
                                                            <option value="new">Toyota</option>
                                                            <option value="used">Hyundai</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-50">
                                                        <label class="small" for="vehicle-model">Model</label>
                                                        <select name="vehile-type" id="vehicle-model" class="padding-15 margin-bottom-15 radius-5 cursor-pointer">
                                                            <option value="any">Any</option>
                                                            <option value="new">Sedan</option>
                                                            <option value="used">Hatchback</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <a class="button close padding-y-10 padding-x-15 is-white-95">Cancel</a>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>

<!--

    1. Overview
        1.1 Condition
        1.2 Type
        1.3 Name
        1.4 Price
        1.5 Body

    2. Experience
        3.1 Engine
        3.2 Mileage
        3.3 Turn Radius
        3.4 Top Speed
        3.5 BHP
        3.6 Fuel
        3.7 Seat
        3.8 Transmission

    3. Mechanics
        5.1 Front Tyre, Rear Tyre
        5.2 Front Break, Rear Break
        5.3 Front Suspension, Rear Suspension

    4. Photos

    5. Colors

    6. Features

-->