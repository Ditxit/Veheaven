<?php 

    $PAGE_NAME = "Profile";

    include '../include/header.ui.php'; 

?>

<!DOCTYPE html>
<html lang="en">

<head> <?php include '../include/header.ui.php';?> </head>

<body class="is-white-100">  

    <!-- Cookie Message -- start -->
    <?php include '../include/toast.php'; ?>
    <!-- Cookie Message -- end -->

    <!-- Navigation Bar -- start -->
    <?php include '../include/navbar.ui.php';?>
    <!-- Navigation Bar -- end -->

    
    <div class="outer-container">
        <div class="inner-container">
            <div class="row">
                <div class="col-20">
                    <div class="row">
                        <div class="col-100">
                            <a href="">Profile</a>
                        </div>
                        <div class="col-100">
                            <a href="">Vehicle</a>
                        </div>
                        <div class="col-100"><a href="../controller/logout.php">Logout</a></div>
                        <div class="col-100"></div>
                    </div>
                </div>
                <div class="col-80"></div>
            </div>
        </div>
    </div>

    
</body>
</html>