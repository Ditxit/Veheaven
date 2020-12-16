<?php 

    $PAGE_NAME = "Explore";

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
    
    <!-- Be A Seller Or Login Section -- start -->
    <div class="outer-container is-white">
        <div class="inner-container padding-y-20">
            <div class="card">
                <div class="row">
                    <div class="col-50">
                        <div class="padding-40 margin-x-5 margin-y-60 radius-20 cursor-pointer" on-hover="is-white-95">
                            <div class="is-blue-5 radius-20 padding-50 padding-y-90 margin-bottom-25 shadow-15" on-hover="shadow-20">
                                <img src="../assets/backgrounds/vehicle-explore-illustration.svg">
                            </div>
                            <p class="h4">Want to Sell Your Vehicle?</p>
                            <p class="small">Register an account for free and list your vehicle</p>
                            <a href="" class="button is-deep-purple-50 radius-10 padding-10 margin-y-25 display-block width-40" on-hover="is-deep-purple-60">Be a Seller</a>
                        </div>
                    </div>
                    <div class="col-50">
                    <div class="padding-40 margin-x-5 margin-y-60 radius-20 cursor-pointer" on-hover="is-white-95">
                            <div class="is-blue-5 radius-20 padding-50 margin-bottom-25 shadow-15" on-hover="shadow-20">
                                <img src="../assets/backgrounds/account-login.svg">
                            </div>
                            <p class="h4">Already have an account?</p>
                            <p class="small">Login to your account to see the vehicles you listed</p>
                            <a href="../login" class="button is-deep-purple-50 radius-10 padding-10 margin-y-25 display-block width-40" on-hover="is-deep-purple-60">Login to Account</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Be A Seller Or Login Section -- end -->

    <!-- Footer -- start -->
    <div class="outer-container is-deep-purple">
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