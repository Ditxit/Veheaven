<?php 

    $PAGE_NAME = "Explore";

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

        // Including global constants
        include_once '../include/config.php';
    ?>

    <!-- Search Section -- start -->
	<div class="outer-container padding-y-90 display-block is-deep-purple">
		<div class="inner-container shadow-100 radius-20" on-hover="-shadow-100 shadow-50">
			<div class="row">
				<div class="col-50">
					
					<div class="card is-white padding-40">
						<form>
                            <p class="h4 margin-top-20 margin-bottom-5">Find Your Next Vehicle at Veheaven</p>
                            <p class="small margin-bottom-30">Tinker with the options and hit find.</p>
							<div class="row has-gap-15">
								<div class="col-50">
                                    <label class="small" for="vehicle-condition">Condition</label>
                                    <select name="vehile-condition" id="vehicle-condition" class="padding-15 margin-bottom-15 radius-5 cursor-pointer">
                                        <option value="any">Any</option>
                                        <option value="new">New</option>
                                        <option value="used">Used</option>
                                    </select>
								</div>
								<div class="col-50">
                                    <label class="small" for="vehicle-type">Type</label>
                                    <select name="vehile-type" id="vehicle-type" class="padding-15 margin-bottom-15 radius-5 cursor-pointer">
                                        <option value="any">Any</option>
                                        <option value="new">Bike</option>
                                        <option value="used">Car</option>
                                    </select>
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

							<div class="row has-gap-15">
								<div class="col-100">
                                    <label class="small" for="vehicle-location">Location</label>
									<select name="vehile-location" id="vehicle-location" class="padding-15 margin-bottom-15 radius-5 cursor-pointer">
                                        <option value="any">Any</option>
                                        <option value="kathmandu">Kathmandu</option>
                                        <option value="bhaktapur">Bhaktapur</option>
                                    </select>
								</div>
							</div>

							<div class="row has-gap-15">
								<div class="col-50">
                                    <label class="small" for="vehicle-min-price">Minimum Price</label>
									<select name="vehicle-min-price" id="vehicle-min-price" class="padding-15 margin-bottom-15 radius-5 cursor-pointer">
                                        <option value="any">Any</option>
                                        <option value="10000">10 Thousand</option>
                                        <option value="20000">20 Thousand</option>
                                        <option value="50000">50 Thousand</option>
                                        <option value="100000">1 Lakh</option>
                                        <option value="200000">2 Lakh</option>
                                    </select>
								</div>
								<div class="col-50">
                                    <label class="small" for="vehicle-max-price">Maximum Price</label>
									<select name="vehicle-max-price" id="vehicle-max-price" class="padding-15 margin-bottom-15 radius-5 cursor-pointer">
                                        <option value="any">Any</option>
                                        <option value="10000">10 Thousand</option>
                                        <option value="20000">20 Thousand</option>
                                        <option value="50000">50 Thousand</option>
                                        <option value="100000">1 Lakh</option>
                                        <option value="200000">2 Lakh</option>
                                    </select>
								</div>
							</div>

							<div class="row has-gap-15">
								<div class="col-100">
									<input type="submit" name="" value="Find" class="is-deep-purple-50 radius-10 padding-15 margin-y-15 display-block width-40" on-hover="is-deep-purple-60">
								</div>
							</div>
							
						</form>
					</div>

				</div>
				<div class="col-50 is-blue-5">
					
					<img src="../assets/backgrounds/search-illustration.svg" class="padding-100 margin-y-40">

				</div>
			</div>
		</div>
	</div>
    <!-- Search Section -- end -->

    <!-- Recently Added Bike Section -- start -->
    <div class="outer-container margin-y-30">
        <div class="inner-container padding-15">
            <div class="row margin-10">
                <div class="col">
                    <p class="h5 margin-top-10">Recently Added Bikes</p>
                </div>
                <div class="col">
                    <a href="" class="button is-deep-purple float-right radius-10">See More →</a>
                </div>
            </div>
            
            <!-- Recently added bike vehicle cards here -->
            <div class="row">
                <?php
                    $bikes = json_decode(file_get_contents(API_ENDPOINT.'/recent/bike/4'), TRUE);
                    foreach($bikes as $bike){
                        echo '
                            <div class="col-25 padding-x-10">
                                <div class="custom-border radius-20 is-white">
                                    <div clas="row" title="'.$bike['name'].'">
                                        <div class="col-100 custom-border-bottom">
                                            <img src="'.API_ENDPOINT.'/storage/'.$bike['images'][0]['name'].'" alt="">
                                        </div>
                                        <div class="col-100 padding-20 custom-border-bottom">
                                            <p class="h5 text-ellipsis">'.$bike['name'].'</p>
                                            <p class="bold margin-top-5 text-deep-purple">NRs. '.$bike['price'].'</p>
                                        </div>
                                        
                                        <div class="col-100">
                                            <a href="'.SERVER_NAME.'/vehicle/?id='.$bike['id'].'" on-hover="text-deep-purple is-white-95" class="width-100 padding-15 text-center">View Details →</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-25 padding-x-10">
                                <div class="custom-border radius-20 is-white">
                                    <div clas="row" title="'.$bike['name'].'">
                                        <div class="col-100 custom-border-bottom">
                                            <img src="'.API_ENDPOINT.'/storage/'.$bike['images'][0]['name'].'" alt="">
                                        </div>
                                        <div class="col-100 padding-20 custom-border-bottom">
                                            <p class="h5 text-ellipsis">'.$bike['name'].'</p>
                                            <p class="bold margin-top-5 text-deep-purple">NRs. '.$bike['price'].'</p>
                                        </div>
                                        
                                        <div class="col-100">
                                            <a href="'.SERVER_NAME.'/vehicle/?id='.$bike['id'].'" on-hover="text-deep-purple is-white-95" class="width-100 padding-15 text-center">View Details →</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        ';
                    }
                ?>
            </div>
        </div>
    </div>
    <!-- Recently Added Bike Section -- end -->

    <!-- Be A Seller Or Login Section -- start -->
    <div class="outer-container margin-y-30">
        <div class="inner-container padding-15">
            <div class="card">
                <div class="row custom-border margin-x-10 is-white radius-20">
                    <div class="col-50 padding-100 custom-border-right">
                        <p class="h4">Want to Sell Your Vehicle?</p>
                        <p class="small">Register an account for free and list your vehicle</p>
                        <a href="" class="button is-deep-purple-50 radius-10 padding-10 margin-top-25 display-block width-40" on-hover="is-deep-purple-60">Be a Seller</a>
                    </div>
                    <div class="col-50 padding-100">
                        <p class="h4">Already have an account?</p>
                        <p class="small">Login to your account to see the vehicles you listed</p>
                        <a href="../login" class="button is-deep-purple-50 radius-10 padding-10 margin-top-25 display-block width-40" on-hover="is-deep-purple-60">Goto Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Be A Seller Or Login Section -- end -->

    <!-- Recently Added Car Section -- start -->
    <div class="outer-container margin-y-30">
        <div class="inner-container padding-15">
            <div class="row margin-10">
                <div class="col">
                    <p class="h5 margin-top-10">Recently Added Cars</p>
                </div>
                <div class="col">
                    <a href="" class="button is-deep-purple float-right radius-10">See More →</a>
                </div>
            </div>
            
            <!-- Recently added car vehicle cards here -->
            <div class="row">
                <?php
                    $cars = json_decode(file_get_contents(API_ENDPOINT.'/recent/bike/4'), TRUE);
                    foreach($cars as $car){
                        echo '
                            <div class="col-25 padding-x-10">
                                <div class="custom-border radius-20 is-white">
                                    <div clas="row" title="'.$car['name'].'">
                                        <div class="col-100 custom-border-bottom">
                                            <img src="'.API_ENDPOINT.'/storage/'.$car['images'][0]['name'].'" alt="">
                                        </div>
                                        <div class="col-100 padding-20 custom-border-bottom">
                                            <p class="h5 text-ellipsis">'.$car['name'].'</p>
                                            <p class="bold margin-top-5 text-deep-purple">NRs. '.$car['price'].'</p>
                                        </div>
                                        
                                        <div class="col-100">
                                            <a href="'.SERVER_NAME.'/vehicle/?id='.$car['id'].'" on-hover="text-deep-purple is-white-95" class="width-100 padding-15 text-center">View Details →</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-25 padding-x-10">
                                <div class="custom-border radius-20 is-white">
                                    <div clas="row" title="'.$car['name'].'">
                                        <div class="col-100 custom-border-bottom">
                                            <img src="'.API_ENDPOINT.'/storage/'.$car['images'][0]['name'].'" alt="">
                                        </div>
                                        <div class="col-100 padding-20 custom-border-bottom">
                                            <p class="h5 text-ellipsis">'.$car['name'].'</p>
                                            <p class="bold margin-top-5 text-deep-purple">NRs. '.$car['price'].'</p>
                                        </div>
                                        
                                        <div class="col-100">
                                            <a href="'.SERVER_NAME.'/vehicle/?id='.$car['id'].'" on-hover="text-deep-purple is-white-95" class="width-100 padding-15 text-center">View Details →</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        ';
                    }
                ?>
            </div>
        </div>
    </div>
    <!-- Recently Added car Section -- end -->

    <!-- Footer -- start -->
    <div class="outer-container is-deep-purple margin-top-30">
        <div class="inner-container padding-y-40">
            <div class="row">
                <div class="col">
                    <p class="h6">OVERVIEW</p>
                    <p><a href="">About Us</a></p>
                    <p><a href="">FAQs</a></p>
                    <p><a href="">Privacy Policies</a></p>
                    <p><a href="">Terms & Conditions</a></p>
                </div>
                <div class="col"></div>
                <div class="col"></div>
            </div>
        </div>
    </div>
    <div class="outer-container is-deep-purple-70">
        <div class="inner-container padding-y-30">
            <p class="h6">&copy; Manish Gautam</p>
        </div>
    </div>
    <!-- Footer -- end -->

    
</body>
</html>