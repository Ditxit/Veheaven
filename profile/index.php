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
                                        <div class="card float-center width-60 is-white radius-20 margin-y-100 shadow-100" on-hover="-shadow-100 shadow-70">

                                            <!-- Card Header -- start -->
                                            <div id="card-header" class="padding-x-10 padding-top-10 padding-bottom-0 shadow-10 sticky top">
                                                <div class="row">
                                                    <div class="col-25">
                                                        <div class="float-left">
                                                        <a class="button text-deep-purple radius-10 padding" on-hover="is-white-95">Save Draft</a>
                                                        </div>
                                                    </div>
                                                    <div class="col-50">
                                                        <p id="card-title" class="h6 text-center padding-10">Overview</p>
                                                    </div>
                                                    <div class="col-25">
                                                        <div class="float-right">
                                                            <a class="is-white-95 padding-5 radius-circle close">
                                                                <img src="../assets/icons/close.svg" alt="close">
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Card Header -- end -->

                                            <!-- Card Body -- start -->
                                            <div class="row is-white-95">

                                                <!-- Card Body Side Nav -- start -->
                                                <div class="col-0">
                                                    <div class="row">
                                                        <div class="col-100">
                                                            <a class="width-100 padding-y-10 padding-x-15" on-hover="is-white-90">Overview</a><hr>
                                                        </div>
                                                        <div class="col-100">
                                                            <a class="width-100 padding-y-10 padding-x-15" on-hover="is-white-90">Experience</a><hr>
                                                        </div>
                                                        <div class="col-100">
                                                            <a class="width-100 padding-y-10 padding-x-15" on-hover="is-white-90">Mechanics</a><hr>
                                                        </div>
                                                        <div class="col-100">
                                                            <a class="width-100 padding-y-10 padding-x-15" on-hover="is-white-90">Photos</a><hr>
                                                        </div>
                                                        <div class="col-100">
                                                            <a class="width-100 padding-y-10 padding-x-15" on-hover="is-white-90">Colors</a><hr>
                                                        </div>
                                                        <div class="col-100">
                                                            <a class="width-100 padding-y-10 padding-x-15" on-hover="is-white-90">Features</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Card Body Side Nav -- start -->

                                                <!-- Card Body Content Container -- start -->
                                                <div class="col-100 is-white-100" style="border-left: 1.2px solid #ddd;">
                                                    <form action="" class="padding-20" style="min-height:65vh; max-height: 65vh; overflow-y: scroll;">

                                                        <!-- Overview Tab Content -- start -->
                                                        <div id="overview-tab" style="display:block;">
                                                            <div class="row has-gap-15">
                                                                <div class="col-50">
                                                                    <label for="vehicle-type" class="small">Type</label>
                                                                    <select name="vehile-type" id="vehicle-type" class="padding-15 margin-bottom-15 radius-5 cursor-pointer">
                                                                        <option value="bike">Bike</option>
                                                                        <option value="car">Car</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-50">
                                                                    <label for="vehicle-condition" class="small">Condition</label>
                                                                    <select name="vehile-condition" id="vehicle-condition" class="padding-15 margin-bottom-15 radius-5 cursor-pointer">
                                                                        <option value="new">New</option>
                                                                        <option value="used">Used</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <!-- Second Row -->
                                                            <div class="row has-gap-15">
                                                                <div class="col-100">
                                                                    <label for="vehicle-name" class="small">Name</label>
                                                                    <input id="vehicle-name" type="text" placeholder="Enter vehicle name" class="padding-15 margin-bottom-15 radius-5">
                                                                </div>
                                                            </div>

                                                            <!-- Third Row -->
                                                            <div class="row has-gap-15">
                                                                <div class="col-50">
                                                                    <label for="vehicle-price" class="small">Price (NRs.)</label>
                                                                    <input id="vehicle-price" type="number" placeholder="Vehicle price" class="padding-15 margin-bottom-15 radius-5">
                                                                </div>
                                                                <div class="col-50">
                                                                    <label class="small" for="vehicle-body">Body</label>
                                                                    <select name="vehile-body" id="vehicle-body" class="padding-15 margin-bottom-15 radius-5 cursor-pointer">
                                                                        <option value="sedan">Sedan</option>
                                                                        <option value="hatchback">Hatchback</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Overview Tab Content -- end -->

                                                        <!-- Experience Tab Content -- start -->
                                                        <div id="experience-tab" style="display:none;">

                                                            <div class="row has-gap-15"> <!-- First Row -->
                                                                <div class="col-50">
                                                                    <label for="vehicle-engine" class="small">Engine (cc)</label>
                                                                    <input id="vehicle-engine" type="number" placeholder="Engine cc" class="padding-15 margin-bottom-15 radius-5">
                                                                </div>
                                                                <div class="col-50">
                                                                    <label for="vehicle-mileage" class="small">Mileage (Km/ltr)</label>
                                                                    <input id="vehicle-mileage" type="number" placeholder="Kilometer / Litre" class="padding-15 margin-bottom-15 radius-5">
                                                                </div>
                                                            </div>

                                                            <div class="row has-gap-15"> <!-- Second Row -->
                                                                <div class="col-50">
                                                                    <label for="vehicle-turn-radius" class="small">Turn Radius (meter)</label>
                                                                    <input id="vehicle-turn-radius" type="number" placeholder="Enter vehicle name" class="padding-15 margin-bottom-15 radius-5">
                                                                </div>
                                                                <div class="col-50">
                                                                    <label for="vehicle-top-speed" class="small">Top Speed (Km/hr)</label>
                                                                    <input id="vehicle-top-speed" type="number" placeholder="Enter vehicle name" class="padding-15 margin-bottom-15 radius-5">
                                                                </div>
                                                            </div>

                                                            <div class="row has-gap-15"> <!-- Third Row -->
                                                                <div class="col-50">
                                                                    <label for="vehicle-bhp" class="small">Brake Horsepower (BHP)</label>
                                                                    <input id="vehicle-bhp" type="number" placeholder="BHP" class="padding-15 margin-bottom-15 radius-5">
                                                                </div>
                                                                <div class="col-50">
                                                                    <label class="small" for="vehicle-fuel">Fuel Used</label>
                                                                    <select name="vehile-fuel" id="vehicle-fuel" class="padding-15 margin-bottom-15 radius-5 cursor-pointer">
                                                                        <option value="petrol">Petrol</option>
                                                                        <option value="diesel">Diesel</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="row has-gap-15"> <!-- Fourth Row -->
                                                                <div class="col-50">
                                                                    <label for="vehicle-seat" class="small">Total Seats</label>
                                                                    <input id="vehicle-seat" type="number" placeholder="Seat count" class="padding-15 margin-bottom-15 radius-5">
                                                                </div>
                                                                <div class="col-50">
                                                                    <label class="small" for="vehicle-transmission">Transmission Type</label>
                                                                    <select name="vehile-transmission" id="vehicle-transmission" class="padding-15 margin-bottom-15 radius-5 cursor-pointer">
                                                                        <option value="automatic">Automatic</option>
                                                                        <option value="manual">Manual</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Experience Tab Content -- end -->

                                                        <!-- Mechanics Tab Content -- start -->
                                                        <div id="mechanics-tab" style="display:none;">
                                                            <div class="row has-gap-15"> <!-- First Row -->
                                                                <div class="col-50">
                                                                    <label for="vehicle-front-tyre" class="small">Front Tyre</label>
                                                                    <select name="vehile-front-tyre" id="vehicle-front-tyre" class="padding-15 margin-bottom-15 radius-5 cursor-pointer">
                                                                        <option value="tubeless">Tubeless</option>
                                                                        <option value="tubed">Tubed</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-50">
                                                                    <label for="vehicle-rear-tyre" class="small">Rear Tyre</label>
                                                                    <select name="vehile-rear-tyre" id="vehicle-rear-tyre" class="padding-15 margin-bottom-15 radius-5 cursor-pointer">
                                                                        <option value="tubeless">Tubeless</option>
                                                                        <option value="tubed">Tubed</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="row has-gap-15"> <!-- Second Row -->
                                                                <div class="col-50">
                                                                    <label for="vehicle-front-break" class="small">Front Break</label>
                                                                    <select name="vehile-front-break" id="vehicle-front-break" class="padding-15 margin-bottom-15 radius-5 cursor-pointer">
                                                                        <option value="disk">Disk</option>
                                                                        <option value="drum">Drum</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-50">
                                                                    <label for="vehicle-rear-break" class="small">Rear Break</label>
                                                                    <select name="vehile-rear-break" id="vehicle-rear-break" class="padding-15 margin-bottom-15 radius-5 cursor-pointer">
                                                                        <option value="disk">Disk</option>
                                                                        <option value="drum">Drum</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="row has-gap-15"> <!-- Third Row -->
                                                                <div class="col-50">
                                                                    <label for="vehicle-front-suspension" class="small">Front Suspension</label>
                                                                    <select name="vehile-front-suspension" id="vehicle-front-suspension" class="padding-15 margin-bottom-15 radius-5 cursor-pointer">
                                                                        <option value="swing axle">Swing Axle</option>
                                                                        <option value="sliding pillar">Sliding Pillar</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-50">
                                                                    <label for="vehicle-rear-suspension" class="small">Rear Suspension</label>
                                                                    <select name="vehile-rear-suspension" id="vehicle-rear-suspension" class="padding-15 margin-bottom-15 radius-5 cursor-pointer">
                                                                        <option value="swing axle">Swing Axle</option>
                                                                        <option value="sliding pillar">Sliding Pillar</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Mechanics Tab Content -- end -->

                                                    </form>
                                                </div>
                                                <!-- Card Body Content Container -- end -->

                                            </div>
                                            <!-- Card Body -- end -->

                                            <!-- Card Footer -- start -->
                                            <div class="row card-footer padding-x-10 padding-top-10 padding-bottom-0 shadow-20">
                                                <div class="col-30">
                                                    <div class="float-left">
                                                        <a id="card-previous-button" class="button text-deep-purple radius-10" on-hover="is-white-95">Prev</a>
                                                    </div>
                                                </div>
                                                <div class="col-40 padding-10" style="margin-top:6px;">
                                                    <div id="card-progress-bar-container" class="row radius-10 is-white-70">
                                                        <div id="card-progress-bar" class="is-deep-purple display-block padding-y-5"></div>
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

        var cardTitle = document.getElementById('card-title');
        var previousButton = document.getElementById('card-previous-button');
        var nextButton = document.getElementById('card-next-button');
        var progressBar = document.getElementById('card-progress-bar');
        
        var tabs = [
            document.getElementById('overview-tab'),
            document.getElementById('experience-tab'),
            document.getElementById('mechanics-tab')
            ];

        var tabsName = [
            'Overview',
            'Experience',
            'Mechanics'
        ]

        function getCurrentTabIndex(){
            for (var i = 0; i < tabs.length; i++) {
               if(tabs[i].style.display == 'block') return i; 
            }
            return 0;
        }

        function updateButtonsState(){
            var index = getCurrentTabIndex(); 
            previousButton.style.display = (index == 0) ? 'none' : 'block';
            nextButton.innerText = (index == tabs.length-1) ? 'Post' : 'Next';
            //console.log(''+index/Math.max(1, tabs.length-1)*100+'%');
            progressBar.style.minWidth = ''+index/Math.max(1, tabs.length-1)*100+'%';
        }

        function nextTab(){
            var index = getCurrentTabIndex(); 
            tabs[index].style.display = 'none';

            index = (tabs.length - 1 == index) ? index : index+1;
            tabs[index].style.display = 'block';
            cardTitle.innerText = tabsName[index];
            updateButtonsState();
        }

        function previousTab(){
            var index = getCurrentTabIndex(); 
            tabs[index].style.display = 'none';

            index = (index == 0) ? 0 : index-1;
            tabs[index].style.display = 'block';
            cardTitle.innerText = tabsName[index];
            updateButtonsState();
        }

        previousButton.addEventListener("click", previousTab);
        nextButton.addEventListener("click", nextTab);
        updateButtonsState();



    </script>
    
</body>
</html>
<!--
    1. Type
        1.1 Bike
        1.2 Car
    
    2. Condition
        2.1 New 
        2.2 Old

    3. General
        3.1 Name
        3.2 Price
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
        3.1 Petrol
        3.2 Diesel
        3.3 Electric
        3.4 CNG
    
    7. Transmission
        3.1 Automatic
        3.2 Manual

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

<!--

    1. Overview
        1.1 Condition *
        1.2 Type *
        1.3 Name *
        1.4 Price *
        1.5 Body *

    2. Experience
        3.1 Engine *
        3.2 Mileage *
        3.3 Turn Radius *
        3.4 Top Speed *
        3.5 BHP *
        3.6 Fuel *
        3.7 Seat *
        3.8 Transmission *

    3. Mechanics
        5.1 Front Tyre, Rear Tyre *
        5.2 Front Break, Rear Break *
        5.3 Front Suspension, Rear Suspension *

    4. Photos *

    5. Colors *

    6. Features *

-->