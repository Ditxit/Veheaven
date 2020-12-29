<?php 

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

    <div class="outer-container">
        <div class="inner-container">

            <div id="vehicle-info-section" class="is-white margin-y-50 shadow-20 radius-20 padding-40">
                <div class="row">
                    <!-- vehicle image column -->
                    <div class="col">
                        <div class="radius-20 is-white-95">
                            <img src="../assets/avatars/default.jpg" alt="Vehicle Image"/>
                        </div>
                    </div>
                    <div class="col">
                        <div class="padding-left-40">
                            <p class="h1">This is vehicle name</p>
                            <p class="h6">
                                <span>NRs.</span>
                                <span>19 Lakh</span>
                            </p>
                            <p class="">
                                This is owner's message section
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>



</body>