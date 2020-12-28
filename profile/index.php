<?php 
    /*
    *   This includes must be kept at top
    *   If not, this might introduce a security risk
    */

    include_once '../include/verification.php';

    /*
    *   Setting the page name
    *   It is good practice setting PAGE_NAME before doing other things in the page
    */
    $PAGE_NAME = "Profile";

    // Bug
    include_once '../include/header.ui.php'; 

?>

<!DOCTYPE html>
<html lang="en">
<head> <?php include_once '../include/header.ui.php';?> </head>
<body class="is-white-95" style="overflow-y:scroll;">  

    <?php
        // Including navbar
        include_once '../include/navbar.ui.php';

        // Including toast
        include_once '../include/toast.php';
    ?>

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
                                        <div class="card float-center width-60 is-white radius-20 margin-y-100 shadow-100" on-hover="-shadow-100 shadow-70" phone="width-100 -margin-y-100 -radius-20 radius-0">
                                            <!-- Card Header -- start -->
                                            <div id="card-header" class="shadow-10 sticky top">
                                                <div class="row padding-x-10 padding-y-10">
                                                    <div class="col-25">
                                                        <div class="float-left" style="display:none;">
                                                        <a class="button text-deep-purple radius-10" on-hover="is-white-95">Save Draft</a>
                                                        </div>
                                                    </div>
                                                    <div class="col-50">
                                                        <p id="card-title" class="h6 text-center padding-10">Bike or Car</p>
                                                    </div>
                                                    <div class="col-25">
                                                        <div class="float-right">
                                                            <a class="is-white-95 padding-5 radius-circle close">
                                                                <img src="../assets/icons/close.svg" alt="close">
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-100" id="card-error-panel">
                                                        <!-- content will be added in javascript -->
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Card Header -- end -->

                                            <!-- Card Body -- start -->
                                            <div class="row">

                                                <!-- Card Body Content Container -- start -->
                                                <div class="col-100" id="add-vehicle-form">
                                                    <form action="../controller/vehicle.php" method="POST" enctype="multipart/form-data" class="padding-x-20 padding-40" style="min-height:auto; max-height:65vh; overflow-y:scroll;">

                                                        <!-- Vehicle Type Content -- start -->
                                                        <div id="type-tab" class="tab" title="Bike or Car" data-tab-index="0" style="display:block;">
                                                            <div class="row">
                                                                <div class="col-60 padding-y-10">
                                                                    <p class="h6">What are you selling ?</p>
                                                                    <p class="small">Select an option between mortorbike and car</p>
                                                                </div>
                                                                <div class="col-40">
                                                                    <div class="row radius-20 custom-border">
                                                                        <div class="col-50">
                                                                            <label class="custom-radio">
                                                                                <input type="radio" name="vehicle-type" value="1">
                                                                                <img class="custom-radio-option padding-x-50 padding-y-10" src="../assets/icons/vehicle/svg/005-motorbike.svg" alt="bike">
                                                                            </label>
                                                                        </div>
                                                                        <div class="col-50 custom-border-left">
                                                                            <label class="custom-radio">
                                                                                <input type="radio" name="vehicle-type" value="2">
                                                                                <img class="custom-radio-option padding-x-50 padding-y-10" src="../assets/icons/vehicle/svg/002-car.svg" alt="car">
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Vehicle Type Content -- end -->

                                                        <!-- Vehicle Condition Content -- start -->
                                                        <?php 
                                                        if($payload['user_type'] == 'admin'){
                                                            echo '
                                                            <div id="condition-tab" class="tab" title="New or Used" data-tab-index="1" style="display:none;">
                                                                <div class="row">
                                                                    <div class="col-60 padding-y-10">
                                                                        <p class="h6">What is the vehicle condition ?</p>
                                                                        <p class="small">Select an option between new and used</p>
                                                                    </div>
                                                                    <div class="col-40">
                                                                        <div class="row radius-20 custom-border">
                                                                            <div class="col-50">
                                                                                <label class="custom-radio">
                                                                                    <input type="radio" name="vehicle-condition" value="1">
                                                                                    <p class="custom-radio-option text-center padding-y-20">New</p>
                                                                                </label>
                                                                            </div>
                                                                            <div class="col-50 custom-border-left">
                                                                                <label class="custom-radio">
                                                                                    <input type="radio" name="vehicle-condition" value="2">
                                                                                    <p class="custom-radio-option text-center padding-y-20">Used</p>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            ';
                                                        }
                                                        ?>
                                                        <!-- Vehicle Condition Content -- end -->

                                                        <!-- General Tab Content -- start -->
                                                        <div id="general-tab" class="tab" title="General Detail" data-tab-index="2" style="display:none;">

                                                            <div class="row has-gap-20"> <!-- First Row -- start -->
                                                                <div class="col-50 padding-y-10">
                                                                    <p class="h6">Enter name of vehicle</p>
                                                                    <p class="small">Try to enter the name that make sense</p>
                                                                </div>
                                                                <div class="col-50">
                                                                    <input id="vehicle-name" name="vehicle-name" type="text" placeholder="2020 Jaguar Diesel Prestige" class="padding-20 radius-20">
                                                                </div>
                                                            </div> <!-- First Row -- end -->

                                                            <hr class="margin-y-30">

                                                            <div class="row has-gap-20"> <!-- Second Row -- start -->
                                                                <div class="col-50 padding-y-10">
                                                                    <p class="h6">Enter selling price of vehicle</p>
                                                                    <p class="small">Price should be in Nepalese Rupee (NRs.)</p>
                                                                </div>
                                                                <div class="col-50">
                                                                    <input id="vehicle-price" name="vehicle-price" type="number" placeholder="Nrs." class="padding-20 radius-20">
                                                                </div>
                                                            </div> <!-- Second Row -- end -->

                                                        </div>
                                                        <!-- General Tab Content -- end -->

                                                        <!-- Manufacturer & Modal Tab Content -- start -->
                                                        <div id="manufacturer-tab" class="tab" title="Make and Model" data-tab-index="3" style="display:none;">
                                                            <div class="row has-gap-20"> <!-- First Row -- start -->
                                                                <div class="col-50 padding-y-10">
                                                                    <p class="h6">Manufacturer</p>
                                                                    <p class="small">Select the manufacturer from the list</p>
                                                                </div>
                                                                <div class="col-50">
                                                                    <select id="vehicle-brand" name="vehicle-brand" class="padding-20 radius-20 cursor-pointer">
                                                                        <!-- Options will be added in JS -->
                                                                    </select>
                                                                </div>
                                                            </div> <!-- First Row -- end -->

                                                            <hr class="margin-y-30">

                                                            <div class="row has-gap-20"> <!-- Second Row -- start -->
                                                                <div class="col-50 padding-y-10">
                                                                    <p class="h6">Model</p>
                                                                    <p class="small">Select the modal from the list</p>
                                                                </div>
                                                                <div class="col-50">
                                                                    <select id="vehicle-model" name="vehicle-model" class="padding-20 radius-20 cursor-pointer">
                                                                        <!-- Options will be added in JS -->
                                                                    </select>
                                                                </div>
                                                            </div> <!-- Second Row -- end -->
                                                        </div>
                                                        <!-- Suspension Tab Content -- end -->

                                                        <!-- Owner Detail Tab Content -- start -->
                                                        <div id="owner-detail-tab" class="tab" title="Owner Detail" data-tab-index="4" style="display:none;">

                                                            <div class="row"> <!-- First Row -- start -->
                                                                <div class="col-50 padding-y-10">
                                                                    <p class="h6">Total number of owners</p>
                                                                    <p class="small">Do not forget to count yourself</p>
                                                                </div>
                                                                <div class="col-50">
                                                                    <div class="row radius-20 custom-border">
                                                                        <div class="col">
                                                                            <label class="custom-radio">
                                                                                <input type="radio" name="vehicle-owners" value="1">
                                                                                <p class="custom-radio-option text-center padding-y-20">1</p>
                                                                            </label>
                                                                        </div>
                                                                        <div class="col custom-border-left">
                                                                            <label class="custom-radio">
                                                                                <input type="radio" name="vehicle-owners" value="2">
                                                                                <p class="custom-radio-option text-center padding-y-20">2</p>
                                                                            </label>
                                                                        </div>
                                                                        <div class="col custom-border-left">
                                                                            <label class="custom-radio">
                                                                                <input type="radio" name="vehicle-owners" value="3">
                                                                                <p class="custom-radio-option text-center padding-y-20">3</p>
                                                                            </label>
                                                                        </div>
                                                                        <div class="col custom-border-left">
                                                                            <label class="custom-radio">
                                                                                <input type="radio" name="vehicle-owners" value="4">
                                                                                <p class="custom-radio-option text-center padding-y-20">4</p>
                                                                            </label>
                                                                        </div>
                                                                        <div class="col custom-border-left">
                                                                            <label class="custom-radio">
                                                                                <input type="radio" name="vehicle-owners" value="5">
                                                                                <p class="custom-radio-option text-center padding-y-20">5</p>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div> <!-- First Row -- end -->

                                                            <hr class="margin-y-30">

                                                            <div class="row has-gap-20"> <!-- Second Row -- start -->
                                                                <div class="col-50 padding-y-10">
                                                                    <p class="h6">Vehicle Registration Date</p>
                                                                    <p class="small">Try to enter correct registration date</p>
                                                                </div>
                                                                <div class="col-50">
                                                                    <input id="vehicle-registered-year" name="vehicle-registered-year" type="month" placeholder="YYYY" min="1900" max="2100" class="padding-20 radius-20 cursor-pointer">
                                                                </div>
                                                            </div> <!-- Second Row -- end -->

                                                            <hr class="margin-y-30">

                                                            <div class="row has-gap-20"> <!-- Third Row -- start -->
                                                                <div class="col-50 padding-y-10">
                                                                    <p class="h6">Vehicle Registred Province</p>
                                                                    <p class="small">Select an provience from dropdown</p>
                                                                </div>
                                                                <div class="col-50">
                                                                    <select id="vehicle-province" name="vehicle-province" class="padding-20 radius-20 cursor-pointer">
                                                                        <?php 
                                                                            $provinces = file_get_contents(API_ENDPOINT.'/province');
                                                                            $provinces = json_decode($provinces,TRUE);

                                                                            foreach ($provinces as $province){
                                                                                echo "<option value='".$province['id']."'>".$province['province']."</option>";
                                                                            }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div> <!-- Third Row -- end -->

                                                            <hr class="margin-y-30">

                                                            <div class="row has-gap-20"> <!-- Fourth Row -- start -->
                                                                <div class="col-100 padding-y-10">
                                                                    <p class="h6">Your Message</p>
                                                                    <p class="small">Write a brief description about the vehicle</p>
                                                                </div>
                                                                <div class="col-100">
                                                                    <textarea id="vehicle-owner-message" name="vehicle-owner-message" placeholder="Message..." class="padding-20 radius-20"></textarea>
                                                                </div>
                                                            </div> <!-- Fourth Row -- end -->

                                                        </div>
                                                        <!-- Owner Detail Tab Contnet -- end -->

                                                        <!-- Body Tab Content -- start -->
                                                        <div id="body-tab" class="tab" title="Body Detail" data-tab-index="5" style="display:none;">

                                                            <div class="row has-gap-20"> <!-- First Row -- start -->
                                                                <div class="col-50 padding-y-10">
                                                                    <p class="h6">Vehicle body</p>
                                                                    <p class="small">Body type of your vehicle</p>
                                                                </div>
                                                                <div class="col-50">
                                                                    <select id="vehicle-body" name="vehicle-body" class="padding-20 radius-20 cursor-pointer">
                                                                        <!-- Options will be added in JS -->
                                                                    </select>
                                                                </div>
                                                            </div> <!-- First Row -- end -->

                                                            <hr class="margin-y-30">

                                                            <div class="row has-gap-20"> <!-- Second Row -- start -->
                                                                <div class="col-50 padding-y-10">
                                                                    <p class="h6">Total number of seats</p>
                                                                    <p class="small">How many seats your vehicle have ?</p>
                                                                </div>
                                                                <div class="col-50">
                                                                    <input id="vehicle-seat" name="vehicle-seat" type="number" placeholder="1,2,3 ..." class="padding-20 radius-20">
                                                                </div>
                                                            </div> <!-- Second Row -- end -->
                                        
                                                        </div>
                                                        <!-- Body Tab Content -- end -->

                                                        <!-- Engine Tab Content -- start -->
                                                        <div id="engine-tab" class="tab" title="Engine Detail" data-tab-index="6" style="display:none;">

                                                            <div class="row has-gap-20"> <!-- First Row -- start -->
                                                                <div class="col-50 padding-y-10">
                                                                    <p class="h6">Cubic capacity (CC)</p>
                                                                    <p class="small">Enter the cubic capatity of engine</p>
                                                                </div>
                                                                <div class="col-50">
                                                                    <input id="vehicle-cc" name="vehicle-cc" type="number" placeholder="CC" class="padding-20 radius-20">
                                                                </div>
                                                            </div> <!-- First Row -- end -->

                                                            <hr class="margin-y-30">

                                                            <div class="row has-gap-20"> <!-- Second Row -- start -->
                                                                <div class="col-50 padding-y-10">
                                                                    <p class="h6">Brake Horse Power (BHP)</p>
                                                                    <p class="small">Enter the break horse power of engine</p>
                                                                </div>
                                                                <div class="col-50">
                                                                    <input id="vehicle-bhp" name="vehicle-bhp" type="number" placeholder="BHP" class="padding-20 radius-20">
                                                                </div>
                                                            </div> <!-- Second Row -- end -->

                                                        </div>
                                                        <!-- Engine Tab Content -- end -->

                                                        <!-- Fuel Tab Content -- start -->
                                                        <div id="fuel-tab" class="tab" title="Fuel Detail" data-tab-index="7" style="display:none;">

                                                            <div class="row has-gap-20"> <!-- First Row -- start -->
                                                                <div class="col-50 padding-y-10">
                                                                    <p class="h6">Fuel type</p>
                                                                    <p class="small">Select the fuel used by vehicle</p>
                                                                </div>
                                                                <div class="col-50">
                                                                    <select id="vehicle-fuel" name="vehicle-fuel" class="padding-20 radius-20 cursor-pointer">
                                                                        <!-- Options will be added in JS -->
                                                                    </select>
                                                                </div>
                                                            </div> <!-- First Row -- end -->

                                                            <hr class="margin-y-30">

                                                            <div class="row has-gap-20"> <!-- Second Row -- start -->
                                                                <div class="col-50 padding-y-10">
                                                                    <p class="h6">Fuel Capacity (Liter)</p>
                                                                    <p class="small">Enter the fuel capacity of tank</p>
                                                                </div>
                                                                <div class="col-50">
                                                                    <input id="vehicle-fuel-capacity" name="vehicle-fuel-capacity" type="number" placeholder="liter" class="padding-20 radius-20">
                                                                </div>
                                                            </div> <!-- Second Row -- end -->

                                                        </div>
                                                        <!-- Fuel Tab Content -- end -->

                                                        <!-- Transmission Content -- start -->
                                                        <div id="transmission-tab" class="tab" title="Transmission" data-tab-index="8" style="display:none;">
                                                            <div class="row">
                                                                <div class="col-50 padding-y-10">
                                                                    <p class="h6">Vehicle transmission type</p>
                                                                    <p class="small">Select the transmission type of vehicle</p>
                                                                </div>
                                                                <div class="col-50">
                                                                    <div class="row radius-20 custom-border">
                                                                        <div class="col">
                                                                            <label class="custom-radio">
                                                                                <input type="radio" name="vehicle-transmission" value="1">
                                                                                <p class="custom-radio-option text-center padding-y-20">Automatic</p>
                                                                            </label>
                                                                        </div>
                                                                        <div class="col custom-border-left">
                                                                            <label class="custom-radio">
                                                                                <input type="radio" name="vehicle-transmission" value="2">
                                                                                <p class="custom-radio-option text-center padding-y-20">Manual</p>
                                                                            </label>
                                                                        </div>
                                                                        <div class="col custom-border-left">
                                                                            <label class="custom-radio">
                                                                                <input type="radio" name="vehicle-transmission" value="3">
                                                                                <p class="custom-radio-option text-center padding-y-20">Other</p>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Transmission Content -- end -->

                                                        <!-- Tyre Tab Content -- start -->
                                                        <div id="tyre-tab" class="tab" title="Tyres" data-tab-index="9" style="display:none;">

                                                            <div class="row"> <!-- First Row -- start -->
                                                                <div class="col-50 padding-y-10">
                                                                <p class="h6">Front tyre</p>
                                                                    <p class="small">Tyre type of the font wheel(s)</p>
                                                                </div>
                                                                <div class="col-50">
                                                                    <div class="row radius-20 custom-border">
                                                                        <div class="col">
                                                                            <label class="custom-radio">
                                                                                <input type="radio" name="vehicle-front-tyre" value="1">
                                                                                <p class="custom-radio-option text-center padding-y-20">Tubed</p>
                                                                            </label>
                                                                        </div>
                                                                        <div class="col custom-border-left">
                                                                            <label class="custom-radio">
                                                                                <input type="radio" name="vehicle-front-tyre" value="2">
                                                                                <p class="custom-radio-option text-center padding-y-20">Tubeless</p>
                                                                            </label>
                                                                        </div>
                                                                        <div class="col custom-border-left">
                                                                            <label class="custom-radio">
                                                                                <input type="radio" name="vehicle-front-tyre" value="3">
                                                                                <p class="custom-radio-option text-center padding-y-20">Other</p>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div> <!-- First Row -- end -->

                                                            <hr class="margin-y-30">

                                                            <div class="row"> <!-- Second Row -- start -->
                                                                <div class="col-50 padding-y-10">
                                                                    <p class="h6">Rear tyre</p>
                                                                    <p class="small">Tyre type of the rear wheel(s)</p>
                                                                </div>
                                                                <div class="col-50">
                                                                    <div class="row radius-20 custom-border">
                                                                        <div class="col">
                                                                            <label class="custom-radio">
                                                                                <input type="radio" name="vehicle-rear-tyre" value="1">
                                                                                <p class="custom-radio-option text-center padding-y-20">Tubed</p>
                                                                            </label>
                                                                        </div>
                                                                        <div class="col custom-border-left">
                                                                            <label class="custom-radio">
                                                                                <input type="radio" name="vehicle-rear-tyre" value="2">
                                                                                <p class="custom-radio-option text-center padding-y-20">Tubeless</p>
                                                                            </label>
                                                                        </div>
                                                                        <div class="col custom-border-left">
                                                                            <label class="custom-radio">
                                                                                <input type="radio" name="vehicle-rear-tyre" value="3">
                                                                                <p class="custom-radio-option text-center padding-y-20">Other</p>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div> <!-- Second Row -- end -->

                                                        </div>
                                                        <!-- Tyre Tab Content -- end -->

                                                        <!-- Break Tab Content -- start -->
                                                        <div id="break-tab" class="tab" title="Breaks" data-tab-index="10" style="display:none;">

                                                            <div class="row"> <!-- First Row -- start -->
                                                                <div class="col-50 padding-y-10">
                                                                <p class="h6">Front break</p>
                                                                    <p class="small">Break type of the font wheel(s)</p>
                                                                </div>
                                                                <div class="col-50">
                                                                    <div class="row radius-20 custom-border">
                                                                        <div class="col">
                                                                            <label class="custom-radio">
                                                                                <input type="radio" name="vehicle-front-break" value="1">
                                                                                <p class="custom-radio-option text-center padding-y-20">Disk</p>
                                                                            </label>
                                                                        </div>
                                                                        <div class="col custom-border-left">
                                                                            <label class="custom-radio">
                                                                                <input type="radio" name="vehicle-front-break" value="2">
                                                                                <p class="custom-radio-option text-center padding-y-20">Drum</p>
                                                                            </label>
                                                                        </div>
                                                                        <div class="col custom-border-left">
                                                                            <label class="custom-radio">
                                                                                <input type="radio" name="vehicle-front-break" value="3">
                                                                                <p class="custom-radio-option text-center padding-y-20">Other</p>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div> <!-- First Row -- end -->

                                                            <hr class="margin-y-30">

                                                            <div class="row"> <!-- Second Row -- start -->
                                                                <div class="col-50 padding-y-10">
                                                                <p class="h6">Rear break</p>
                                                                    <p class="small">Break type of the rear wheel(s)</p>
                                                                </div>
                                                                <div class="col-50">
                                                                    <div class="row radius-20 custom-border">
                                                                        <div class="col">
                                                                            <label class="custom-radio">
                                                                                <input type="radio" name="vehicle-rear-break" value="1">
                                                                                <p class="custom-radio-option text-center padding-y-20">Disk</p>
                                                                            </label>
                                                                        </div>
                                                                        <div class="col custom-border-left">
                                                                            <label class="custom-radio">
                                                                                <input type="radio" name="vehicle-rear-break" value="2">
                                                                                <p class="custom-radio-option text-center padding-y-20">Drum</p>
                                                                            </label>
                                                                        </div>
                                                                        <div class="col custom-border-left">
                                                                            <label class="custom-radio">
                                                                                <input type="radio" name="vehicle-rear-break" value="3">
                                                                                <p class="custom-radio-option text-center padding-y-20">Other</p>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div> <!-- Second Row -- end -->

                                                        </div>
                                                        <!-- Break Tab Content -- end -->

                                                        <!-- Suspension Tab Content -- start -->
                                                        <div id="suspension-tab" class="tab" title="Suspensions" data-tab-index="11" style="display:none;">
                                                            <div class="row has-gap-20"> <!-- First Row -- start -->
                                                                <div class="col-50 padding-y-10">
                                                                    <p class="h6">Front suspension</p>
                                                                    <p class="small">Select the front wheel(s) suspension</p>
                                                                </div>
                                                                <div class="col-50">
                                                                    <select id="vehicle-front-suspension" name="vehicle-front-suspension" class="padding-20 radius-20 cursor-pointer">
                                                                        <!-- Options will be added in JS -->
                                                                    </select>
                                                                </div>
                                                            </div> <!-- First Row -- end -->

                                                            <hr class="margin-y-30">

                                                            <div class="row has-gap-20"> <!-- Second Row -- start -->
                                                                <div class="col-50 padding-y-10">
                                                                    <p class="h6">Rear suspension</p>
                                                                    <p class="small">Select the rear wheel(s) suspension</p>
                                                                </div>
                                                                <div class="col-50">
                                                                    <select id="vehicle-rear-suspension" name="vehicle-rear-suspension" class="padding-20 radius-20 cursor-pointer">
                                                                        <!-- Options will be added in JS -->
                                                                    </select>
                                                                </div>
                                                            </div> <!-- Second Row -- end -->
                                                        </div>
                                                        <!-- Suspension Tab Content -- end -->

                                                        <!-- Performance Tab Content -- start -->
                                                        <div id="performance-tab" class="tab" title="Performance" data-tab-index="12" style="display:none;">

                                                            <div class="row has-gap-20"> <!-- First Row -- start -->
                                                                <div class="col-50 padding-y-10">
                                                                    <p class="h6">Mileage (Km/litre)</p>
                                                                    <p class="small">Enter the mileage of the vehicle</p>
                                                                </div>
                                                                <div class="col-50">
                                                                    <input id="vehicle-mileage" name="vehicle-mileage" type="number" placeholder="kilometer" class="padding-20 radius-20"/>
                                                                </div>
                                                            </div> <!-- First Row -- end -->

                                                            <hr class="margin-y-30">

                                                            <div class="row has-gap-20"> <!-- Second Row -- start -->
                                                                <div class="col-50 padding-y-10">
                                                                    <p class="h6">Top Speed (Km/hour)</p>
                                                                    <p class="small">Enter the top speed of the vehicle</p>
                                                                </div>
                                                                <div class="col-50">
                                                                    <input id="vehicle-top-speed" name="vehicle-top-speed" type="number" placeholder="kilometer" class="padding-20 radius-20"/>
                                                                </div>
                                                            </div> <!-- Second Row -- end -->

                                                            <hr class="margin-y-30">

                                                            <div class="row has-gap-20"> <!-- Third Row -- start -->
                                                                <div class="col-50 padding-y-10">
                                                                    <p class="h6">Turn Radius (meter)</p>
                                                                    <p class="small">Enter the turn radius of the vehicle</p>
                                                                </div>
                                                                <div class="col-50">
                                                                    <input id="vehicle-turn-radius" name="vehicle-turn-radius" type="number" placeholder="meter" class="padding-20 radius-20"/>
                                                                </div>
                                                            </div> <!-- Third Row -- end -->

                                                        </div>
                                                        <!-- Performance Tab Content -- end -->

                                                        <!-- Color Tab Content -- start -->
                                                        <div id="color-tab" class="tab" title="Colors" data-tab-index="13" style="display:none;">
                                                            <div class="row">
                                                            <?php 
                                                                function textColor($hexcolor){
                                                                    return (hexdec($hexcolor) > 0xffffff/2) ? '#000000':'#FFFFFF';
                                                                }
                                                                $colors = file_get_contents(API_ENDPOINT.'/colors');
                                                                $colors = json_decode($colors,TRUE);

                                                                foreach ($colors as $color){
                                                                    echo '
                                                                        <div class="col-25">
                                                                            <div class="custom-checkbox margin-5" title="'.$color['color'].'">
                                                                                <input id="'.$color['color'].'-'.$color['id'].'" type="checkbox" name="vehicle-color[]" value="'.$color['id'].'">
                                                                                <label for="'.$color['color'].'-'.$color['id'].'" class="padding-5 radius-100 cursor-pointer">
                                                                                    <span class="padding-10 radius-100 width-100 text-center shadow-20" style="background-color:'.$color['hexcode'].'; color:'.textColor($color['hexcode']).'">'.$color['color'].'</span>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    ';
                                                                }
                                                            ?>
                                                            </div>
                                                        </div>
                                                        <!-- Color Tab Content -- end -->

                                                        <!-- Feature Tab Content -- start -->
                                                        <div id="feature-tab" class="tab" title="Features" data-tab-index="14" style="display:none;">
                                                            <div id="vehicle-feature-row" class="row">
                                                                <!-- Columns will be added in JS -->
                                                            </div>
                                                        </div>
                                                        <!-- Feature Tab Content -- end -->

                                                        <!-- Photo Tab Content -- start -->
                                                        <div id="photo-tab" class="tab" title="Photos" data-tab-index="15" style="display:none;">
                                                            <div id="vehicle-image-row" class="row">

                                                                <div id="vehicle-image-row-add-image-column" class="col-25 padding-5">
                                                                    <div class="custom-image-input">
                                                                        <input id="vehicle-image" type="file" name="vehicle-image[]" accept=".png, .jpg, .jpeg" onchange="showImagePreview();" multiple/>
                                                                        <label for="vehicle-image">
                                                                            <img src="../assets/icons/image.svg" class="padding-50 is-blue-5 cursor-pointer radius-20" on-hover="is-blue-10" alt="Add vehicle image">
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <!-- More columns will be added in JS -->
                                                            </div>
                                                        </div>
                                                        <script>
                                                            var vehicleImageRow = document.getElementById('vehicle-image-row');
                                                            var vehicleImageRowAddImageColumn = document.getElementById('vehicle-image-row-add-image-column');
                                                            var fileVehicleImage = document.getElementById('vehicle-image');

                                                            var dataTransfer = new DataTransfer();
                                                            
                                                            var div = document.createElement('div');

                                                            function removeImagePreview(event) {
                                                                let allFiles = [];

                                                                for(let file of dataTransfer.files){
                                                                    if(event.target.alt != file.name){
                                                                        allFiles.push(file);
                                                                    }
                                                                }

                                                                dataTransfer.items.clear();

                                                                for(let file of allFiles){
                                                                    dataTransfer.items.add(file);
                                                                }

                                                                // Re-setting the value
                                                                fileVehicleImage.files = dataTransfer.files;

                                                                // Removing Html DOMS
                                                                let deleteColumn = vehicleImageRow.querySelectorAll('[data-image-name="'+event.target.alt+'"]')[0];
                                                                deleteColumn.parentNode.removeChild(deleteColumn);

                                                            }

                                                            function showImagePreview(){

                                                                // Initializing some local vars
                                                                let seenNames = [], newFiles = [], oldFiles = [];

                                                                // Check old files first
                                                                for(let file of dataTransfer.files){
                                                                    if(!seenNames.includes(file.name)){
                                                                        oldFiles.push(file);
                                                                        seenNames.push(file.name);
                                                                    }
                                                                }

                                                                // Check new files second
                                                                for(let file of fileVehicleImage.files){
                                                                    if(!seenNames.includes(file.name)){
                                                                        newFiles.push(file);
                                                                        seenNames.push(file.name);
                                                                    }
                                                                }

                                                                dataTransfer.items.clear();

                                                                for(let file of newFiles.concat(oldFiles)){
                                                                    dataTransfer.items.add(file);
                                                                }

                                                                // Re-setting the value
                                                                fileVehicleImage.files = dataTransfer.files;

                                                                for(file of newFiles){
                                                                    let src = URL.createObjectURL(file); // creating blob from File object
                                                                    div.innerHTML = '<div class="col-25 padding-5" data-image-name="'+file.name+'"><div class="radius-20"><img style="object-fit: cover;" class="width-100 height-100 is-white-90" src="'+src+'" alt="'+file.name+'" onclick="removeImagePreview(event);"></div></div>';
                                                                    vehicleImageRowAddImageColumn.after(div.firstChild); // add new element after #vehicle-image-row-add-image-column
                                                                }

                                                            }
                                                        </script>
                                                        <!-- Photo Tab Content -- end -->

                                                        <!-- Submit Tab Content -- start -->
                                                        <div id="submit-tab" class="tab" title="Publish" data-tab-index="16" style="display:none;">
                                                            <div class="row shadow-15 radius-20"> <!-- First Row -- start -->
                                                                <div class="col padding-20">
                                                                    <img src="../assets/backgrounds/vehicle-publish.svg" alt="Publish Vehicle">
                                                                </div>
                                                                <div class="col padding-20">
                                                                        <div class="row">
                                                                            <div class="col-100">
                                                                                <p class="h6">Publish Now ?</p>
                                                                                <p class="small">We reached the end of the form, click publish to post</p>
                                                                            </div>
                                                                            <div class="col-100">
                                                                                <input type="hidden" name="token" value="<?=$_COOKIE['token'];?>">
                                                                                <input id="vehicle-add" name="vehicle-add" type="submit" value="Publish" class="is-deep-purple-50 radius-10 padding-15 margin-y-15 width-60" on-hover="is-deep-purple-60">
                                                                            </div>
                                                                        </div>
                                                                </div>
                                                            </div> <!-- First Row -- end -->
                                                        </div>
                                                        <!-- Submit Tab Content -- end -->

                                                    </form>
                                                </div>
                                                <!-- Card Body Content Container -- end -->

                                            </div>
                                            <!-- Card Body -- end -->

                                            <!-- Card Footer -- start -->
                                            <div class="row card-footer padding-x-10 padding-y-10 shadow-20">
                                                <div class="col-30">
                                                    <div class="float-left">
                                                        <a id="card-previous-button" class="button text-deep-purple radius-10" on-hover="is-white-95">Prev</a>
                                                    </div>
                                                </div>
                                                <div class="col-40 padding-10" style="margin-top:6px;">
                                                    <div id="card-progress-bar-container" class="row radius-10 is-white-70">
                                                        <div id="card-progress-bar" class="is-deep-purple display-block padding-y-5 radius-10"></div>
                                                    </div>
                                                </div>
                                                <div class="col-30">
                                                    <div class="float-right">
                                                        <a  id="card-next-button" class="button text-deep-purple radius-10" on-hover="is-white-95">Next</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Card Footer -- end -->
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

    <!-- JavaScript -- start -->
    <script type="text/javascript">

        /* Js for making tabs work */
        var cardTitle = document.getElementById('card-title');
        var cardErrorPanel = document.getElementById('card-error-panel');
        var previousButton = document.getElementById('card-previous-button');
        var nextButton = document.getElementById('card-next-button');
        var progressBar = document.getElementById('card-progress-bar');
        
        // Selecting tabs 
        var tabs = document.getElementById("add-vehicle-form").querySelectorAll(".tab");

        function getCurrentTabIndex(){
            for (var i = 0; i < tabs.length; i++) {
               if(tabs[i].style.display == 'block') return i; 
            }
            return 0;
        }

        /* Vaiables holding all the form input fields */
        var radioVehicleType = document.getElementsByName('vehicle-type');
        
        <?php
            if($payload['user_type'] == 'admin'){
                echo "var radioVehicleCondition = document.getElementsByName('vehicle-condition');";
            }
        ?>

        var textVehicleName = document.getElementById('vehicle-name');
        var numberVehiclePrice = document.getElementById('vehicle-price');

        var selectVehicleBrand = document.getElementById('vehicle-brand');
        var selectVehicleModel = document.getElementById('vehicle-model');

        var radioVehicleOwners = document.getElementsByName('vehicle-owners');
        var dateVehicleRegisteredYear = document.getElementById('vehicle-registered-year');
        var selectVehicleProvince = document.getElementById('vehicle-province');
        var textareaOwnerMessage = document.getElementById('vehicle-owner-message');

        var selectVehicleBody = document.getElementById('vehicle-body');
        var numberVehicleSeat = document.getElementById('vehicle-seat');

        var numberVehicleEngine = document.getElementById('vehicle-cc');
        var numberVehicleBHP = document.getElementById('vehicle-bhp');

        var selectVehicleFuel = document.getElementById('vehicle-fuel');
        var numberVehicleFuelCapacity = document.getElementById('vehicle-fuel-capacity');

        var radioVehicleTransmission = document.getElementsByName('vehicle-transmission');

        var radioVehicleFrontTyre = document.getElementsByName('vehicle-front-tyre');
        var radioVehicleRearTyre = document.getElementsByName('vehicle-rear-tyre');

        var radioVehicleFrontBreak = document.getElementsByName('vehicle-front-break');
        var radioVehicleRearBreak = document.getElementsByName('vehicle-rear-break');

        var selectVehicleFrontSuspension = document.getElementById('vehicle-front-suspension');
        var selectVehicleRearSuspension = document.getElementById('vehicle-rear-suspension')

        var numberVehicleMileage = document.getElementById('vehicle-mileage');
        var numberVehicleTopSpeed = document.getElementById('vehicle-top-speed');
        var numberVehicleTurnRadius = document.getElementById('vehicle-turn-radius');

        function getSelectedRadioValueOf(radioElementObject){
            for(var i = 0; i < radioElementObject.length; i++){
                if(radioElementObject[i].checked){
                    return radioElementObject[i].value;
                }
            }
            return null;
        }

        function validateVehicleType(){

            if(getSelectedRadioValueOf(radioVehicleType) == null){

                return {success: false, message : "Please select the type of vehicle"};

            }else{

                return {success: true};

            }
        }

        function validateVehicleCondition(){

            var value = getSelectedRadioValueOf(radioVehicleCondition);

            <?php
                if($payload['user_type'] == 'admin'){
                    echo '
                        var ownerDetailTab = document.getElementById("owner-detail-tab");
                        if(value == "1") {
                            ownerDetailTab.classList.remove("tab");
                            tabs = document.getElementById("add-vehicle-form").querySelectorAll(".tab");
                        }
                    ';
                }
            ?>

            if(value == null){

                return {success: false, message : "Please select the condition of vehicle"};

            }else{

                return {success: true};

            }

        }

        function validateVehicleName(){

            var name = textVehicleName.value.trim();

            if(name == ""){

                return {success: false, message : "Please enter the name of vehicle"};

            }else if(name.length < 8){

                return {success: false, message : "Vehicle name is too short, minimum 8 characters required"};

            }else{

                return {success: true};

            }

        }

        function validateVehiclePrice(){

            var price = numberVehiclePrice.value.trim();

            if(price == ""){

                return {success: false, message : "Please enter the price of vehicle"};

            }else if(isNaN(parseFloat(price)) || !isFinite(price)){

                return {success: false, message : "Please enter valid price"};
            
            }else if(parseFloat(price) <= 0){

                return {success: false, message : "Price cannot be negative or zero"};

            }else{

                return {success: true};

            }

        }

        function validateVehicleOwners(){

            if(getSelectedRadioValueOf(radioVehicleOwners) == null){

                return {success: false, message : "Please select number of owners of vehicle"};

            }else{

                return {success: true};

            }

        }

        function validateVehicleRegisteredYear(){

            var date = dateVehicleRegisteredYear.value

            if(date == ""){

                return {success: false, message : "Please enter the registered date of vehicle"};

            }else if((new Date(date) === "Invalid Date") || isNaN(new Date(date))){

                return {success: false, message : "Please enter valid registered date of vehicle"};

            }else{

                return {success: true};

            }

        }

        function validateVehicleSeat(){

            var seat = numberVehicleSeat.value.trim();

            if(seat == ""){

                return {success: false, message : "Please enter the number of seats of vehicle"};

            }else if(isNaN(parseInt(seat)) || !isFinite(seat) || parseFloat(seat) !== parseInt(seat)){

                return {success: false, message : "Value in seat count field is not a valid seat count"};
            
            }else if(parseInt(seat) <= 0){

                return {success: false, message : "Vehicle seat count cannot be negative or zero"};

            }else{

                return {success: true};

            }
        }

        function validateVehicleEngine(){

            var cc = numberVehicleEngine.value.trim();

            if(cc == ""){

                return {success: false, message : "Please enter cubic capicity of engine"};

            }else if(isNaN(parseInt(cc)) || !isFinite(cc) || parseFloat(cc) !== parseInt(cc)){

                return {success: false, message : "Value in cubic capacity field is not valid"};

            }else if(parseInt(cc) <= 0){

                return {success: false, message : "Cubic capacity cannot be negative or zero"};

            }else{

                return {success: true};

            }
        }

        function validateVehicleBHP(){
            var BHP = numberVehicleBHP.value.trim();

            if(BHP == ""){

                return {success: false, message : "Please enter Break Horse Power of engine"};

            }else if(isNaN(parseInt(BHP)) || !isFinite(BHP) || parseFloat(BHP) !== parseInt(BHP)){

                return {success: false, message : "Value in Break Horse Power field is not valid"};

            }else if(parseInt(BHP) <= 0){

                return {success: false, message : "Break Horse Power cannot be negative or zero"};

            }else{

                return {success: true};

            }
        }

        function validateVehicleFuelCapacity(){

            var capacity = numberVehicleFuelCapacity.value.trim();

            if(capacity == ""){

                return {success: false, message : "Please enter the fuel capacity of vehicle"};

            }else if(isNaN(parseFloat(capacity)) || !isFinite(capacity)){

                return {success: false, message : "Please enter valid fuel capacity"};
            
            }else if(parseFloat(capacity) <= 0){

                return {success: false, message : "Fuel capacity cannot be negative or zero"};

            }else{

                return {success: true};

            }

        }

        function validateVehicleTransmission(){

            if(getSelectedRadioValueOf(radioVehicleTransmission) == null){

                return {success: false, message : "Please select the transmission of vehicle"};

            }else{

                return {success: true};

            }

        }

        function validateVehicleFrontTyre(){

            if(getSelectedRadioValueOf(radioVehicleFrontTyre) == null){

                return {success: false, message : "Please select the front tyre of vehicle"};

            }else{

                return {success: true};

            }

        }

        function validateVehicleRearTyre(){

            if(getSelectedRadioValueOf(radioVehicleRearTyre) == null){

                return {success: false, message : "Please select the rear tyre of vehicle"};

            }else{

                return {success: true};

            }

        }

        function validateVehicleFrontBreak(){

            if(getSelectedRadioValueOf(radioVehicleFrontBreak) == null){

                return {success: false, message : "Please select the front break of vehicle"};

            }else{

                return {success: true};

            }

        }

        function validateVehicleRearBreak(){

            if(getSelectedRadioValueOf(radioVehicleRearBreak) == null){

                return {success: false, message : "Please select the rear break of vehicle"};

            }else{

                return {success: true};

            }

        }

        function validateVehicleMileage(){

            var mileage = numberVehicleMileage.value.trim();

            if(mileage == ""){

                return {success: false, message : "Please enter the mileage of vehicle"};

            }else if(isNaN(parseFloat(mileage)) || !isFinite(mileage)){

                return {success: false, message : "Please enter valid mileage"};
            
            }else if(parseFloat(mileage) <= 0){

                return {success: false, message : "Mileage cannot be negative or zero"};

            }else{

                return {success: true};

            }

        }

        function validateVehicleTopSpeed(){

            var speed = numberVehicleTopSpeed.value.trim();

            if(speed == ""){

                return {success: false, message : "Please enter the top speed of vehicle"};

            }else if(isNaN(parseFloat(speed)) || !isFinite(speed)){

                return {success: false, message : "Please enter valid top speed"};

            }else if(parseFloat(speed) <= 0){

                return {success: false, message : "Top speed cannot be negative or zero"};

            }else{

                return {success: true};

            }

        }

        function validateVehicleTurnRadius(){

            var radius = numberVehicleTurnRadius.value.trim();

            if(radius == ""){

                return {success: false, message : "Please enter the turn radius of vehicle"};

            }else if(isNaN(parseFloat(radius)) || !isFinite(radius)){

                return {success: false, message : "Please enter valid turn radius"};

            }else if(parseFloat(radius) <= 0){

                return {success: false, message : "Turn radius cannot be negative or zero"};

            }else{

                return {success: true};

            }

        }

        function updateButtonsState(){
            var index = getCurrentTabIndex(); 
            cardTitle.innerText = tabs[index].title;
            previousButton.style.display = (index == 0) ? 'none' : 'block';
            nextButton.innerText = (index == tabs.length-1) ? 'Post' : 'Next';
            progressBar.style.minWidth = ''+index/Math.max(1, tabs.length-1)*100+'%';
        }

        function setErrorMessage(text=null){
            if(text==null){
                cardErrorPanel.innerText = '';
            }else{
                cardErrorPanel.innerHTML = '<div id="error-text" class="is-red-40 padding-10 width-100">'+text+'</div>';
            }
        }

        function nextTab(){

            setErrorMessage(); // set error message to null
  
            var index = getCurrentTabIndex(); // Current Index
            var tabIndex = tabs[index].getAttribute('data-tab-index');

            if(tabIndex == 0){

                var validation = validateVehicleType();

                if(!validation.success){
                    setErrorMessage(validation.message);
                    return;
                }

            }else if(tabIndex == 1){

                var validation = validateVehicleCondition();

                if(!validation.success){
                    setErrorMessage(validation.message);
                    return;
                }

            }else if(tabIndex == 2){

                var validation = validateVehicleName();

                if(!validation.success){
                    setErrorMessage(validation.message);
                    return;
                }

                validation = validateVehiclePrice();

                if(!validation.success){
                    setErrorMessage(validation.message);
                    return;
                }

            }else if(tabIndex == 3){
                // Ignore
            }else if(tabIndex == 4){

                var validation = validateVehicleOwners();

                if(!validation.success){
                    setErrorMessage(validation.message);
                    return;
                }

                validation = validateVehicleRegisteredYear();

                if(!validation.success){
                    setErrorMessage(validation.message);
                    return;
                }
                
            }else if(tabIndex == 5){
                var validation = validateVehicleSeat();

                if(!validation.success){
                    setErrorMessage(validation.message);
                    return;
                }
            }else if(tabIndex == 6){

                var validation = validateVehicleEngine();

                if(!validation.success){
                    setErrorMessage(validation.message);
                    return;
                }

                validation = validateVehicleBHP();

                if(!validation.success){
                    setErrorMessage(validation.message);
                    return;
                }

            }else if(tabIndex == 7){

                var validation = validateVehicleFuelCapacity();

                if(!validation.success){
                    setErrorMessage(validation.message);
                    return;
                }

            }else if(tabIndex == 8){

                var validation = validateVehicleTransmission();

                if(!validation.success){
                    setErrorMessage(validation.message);
                    return;
                }

            }else if(tabIndex == 9){

                var validation = validateVehicleFrontTyre();

                if(!validation.success){
                    setErrorMessage(validation.message);
                    return;
                }
                
                validation = validateVehicleRearTyre();

                if(!validation.success){
                    setErrorMessage(validation.message);
                    return;
                }

            }else if(tabIndex == 10){

                var validation = validateVehicleFrontBreak();

                if(!validation.success){
                    setErrorMessage(validation.message);
                    return;
                }

                validation = validateVehicleRearBreak();

                if(!validation.success){
                    setErrorMessage(validation.message);
                    return;
                }

            }else if(tabIndex == 11){
                // Ignore
            }else if(tabIndex == 12){

                var validation = validateVehicleMileage();

                if(!validation.success){
                    setErrorMessage(validation.message);
                    return;
                }

                validation = validateVehicleTopSpeed();

                if(!validation.success){
                    setErrorMessage(validation.message);
                    return;
                }

                validation = validateVehicleTurnRadius();

                if(!validation.success){
                    setErrorMessage(validation.message);
                    return;
                }

            }

            if(tabs.length - 1 != index){ // if index is not last index

                tabs[index].style.display = 'none';
                tabs[index + 1].style.display = 'block';

            }
            updateButtonsState();

        }

        function previousTab(){
            setErrorMessage(); // set error message to null

            var index = getCurrentTabIndex(); 

            if(index > 0){ // if index is not first index

                tabs[index].style.display = 'none';
                tabs[index - 1].style.display = 'block';

            }
            updateButtonsState();

        }

        previousButton.addEventListener("click", previousTab);
        nextButton.addEventListener("click", nextTab);
        updateButtonsState();


        /* Js for fetching and applying appropriate data according to vehicle type (bike/car) */
        function getSelectedVehicleTypeValue(){
            for(var i = 0; i < radioVehicleType.length; i++){
                if(radioVehicleType[i].checked){
                    return radioVehicleType[i].value;
                }
            }
            return null;
        }

        async function changeDataAccordingToVehicleType(){

            var id = getSelectedVehicleTypeValue();

            if(id != null){

                // Vehicle body
                await fetch('<?=API_ENDPOINT.'/body';?>'+'\/'+id)
                .then(response => response.json())
                .then(data => {

                    selectVehicleBody.options.length = 0;

                    for(var i = 0; i<data.length; i++){
                        var option = document.createElement("option");
                        option.text = data[i].body;
                        option.value = data[i].id;
                        selectVehicleBody.append(option);
                    }
                
                });

                // Vehicle brand
                await fetch('<?=API_ENDPOINT.'/brand';?>'+'\/'+id)
                .then(response => response.json())
                .then(data => {

                    selectVehicleBrand.options.length = 0;

                    for(var i = 0; i<data.length; i++){
                        var option = document.createElement("option");
                        option.text = data[i].brand;
                        option.value = data[i].id;
                        selectVehicleBrand.append(option);
                    }
                
                });

                // Vehicle model
                await fetch('<?=API_ENDPOINT.'/model';?>'+'\/'+id+'\/'+selectVehicleBrand.value)
                .then(response => response.json())
                .then(data => {

                    selectVehicleModel.options.length = 0;

                    for(var i = 0; i<data.length; i++){
                        var option = document.createElement("option");
                        option.text = data[i].model;
                        option.value = data[i].id;
                        selectVehicleModel.append(option);
                    }
                });
                
                // Vehicle fuel
                await fetch('<?=API_ENDPOINT.'/fuel';?>'+'\/'+id)
                .then(response => response.json())
                .then(data => {

                    selectVehicleFuel.options.length = 0;

                    for(var i = 0; i<data.length; i++){
                        var option = document.createElement("option");
                        option.text = data[i].fuel;
                        option.value = data[i].id;
                        selectVehicleFuel.append(option);
                    }
                
                });

                // Vehicle suspension
                await fetch('<?=API_ENDPOINT.'/suspension';?>'+'\/'+id)
                .then(response => response.json())
                .then(data => {

                    selectVehicleFrontSuspension.options.length = 0;
                    selectVehicleRearSuspension.options.length = 0;

                    for(var i = 0; i<data.length; i++){
                        var option1 = document.createElement("option");
                        var option2 = document.createElement("option");

                        option1.text = option2.text = data[i].suspension;
                        option1.value = option2.value = data[i].id;

                        selectVehicleFrontSuspension.append(option1);
                        selectVehicleRearSuspension.append(option2);
                    }
                
                });

                // Vehicle Features
                await fetch('<?=API_ENDPOINT.'/features';?>'+'\/'+id)
                .then(response => response.json())
                .then(features => {

                    var vehicleFeatureContainer = document.getElementById('vehicle-feature-row');
                    vehicleFeatureContainer.innerText = ''; // clearing vehicle feature row

                    var div = document.createElement('div'); // reused
                    
                    for(feature of features){
                        div.innerHTML = '<div class="col-auto"><div class="custom-checkbox margin-5"><input id="feature-'+feature.id+'" type="checkbox" name="vehicle-feature[]" value="'+feature.id+'"><label for="feature-'+feature.id+'" class="padding-5 radius-100 cursor-pointer is-white-90" title="'+feature.category+'"><span class="padding-10 radius-100 width-100">'+feature.feature+'</span></label></div></div>';
                        vehicleFeatureContainer.append(div.firstChild);
                    }
                
                });
            }

        }

        async function changeDataAccordingToVehicleBrand(){
            var id = getSelectedVehicleTypeValue();

            if(id != null){

                // Vehicle model
                await fetch('<?=API_ENDPOINT.'/model';?>'+'\/'+id+'\/'+selectVehicleBrand.value)
                .then(response => response.json())
                .then(data => {

                    selectVehicleModel.options.length = 0;

                    for(var i = 0; i<data.length; i++){
                        var option = document.createElement("option");
                        option.text = data[i].model;
                        option.value = data[i].id;
                        selectVehicleModel.append(option);
                    }
                });

            }

        }       

        // Adding events
        for(var i = 0; i < radioVehicleType.length; i++){
            radioVehicleType[i].addEventListener("change", changeDataAccordingToVehicleType);
        }
        
        selectVehicleBrand.addEventListener("click", changeDataAccordingToVehicleBrand);

    </script>
    
</body>
</html>
<!--
    0. Blue Book, Run_Distance, 


    1. Type
        1.1 Bike
        1.2 Car
    
    2. Condition (Only for admin)
        2.1 New 
        2.2 Old

    3. General
        3.1 Name
        3.2 Price
    
    4. Owners Detail (Only for used vehicles)
        3.3 Number of previous owners (only for used vehicles)
        3.4 Owner Message (only for used vehicles)
        3.5 Registered Year (only for used vehicles)
        3.6 Registered Province (only for used vehicles)

    4. Body
        4.1 Body Type
            4.1.1 Sedan
            4.1.2 Hatchback
            4.1.3 ...
        4.2 Seat Count

    5. Engine Details
        3.1 CC
        3.2 BHP

    6. Fuel Type
        Type
            3.1 Petrol
            3.2 Diesel
            3.3 Electric
            3.4 CNG
        Capacity
    
    7. Transmission
        3.1 Automatic
        3.2 Manual
        3.3 Others

    8. Tyre
        4.1 Front
            4.1.1 Tubed
            4.1.2 Tubeless
        4.2 Rear
            4.2.1 Tubed
            4.2.2 Tubeless
    
    9. Break
        5.1 Front
            5.1.1 Disk
            5.1.2 Drum
        5.2 Rear
            5.2.1 Disk
            5.2.2 Drum
    
    10. Suspension
        5.1 Front
            5.1.1 Blah...
            5.1.2 Blah...
        5.2 Rear
            5.2.1 Blah...
            5.2.2 Blah...

    11. Performance
        11.1 Mileage
        11.2 Top Speed
        11.3 Turn Radius

    11. Colors

    12. Features

    13. Photos

-->