<?php 

    $PAGE_NAME = "Explore";

    include '../include/header.ui.php'; 

    // Display Cookie Message (if any)
    include '../include/toast.php';

?>

<!DOCTYPE html>
<html lang="en">

<head> <?php include '../include/header.ui.php';?> </head>

<body class="is-white-100">  

    <!-- Navigation Bar -- start -->
    <?php include '../include/navbar.ui.php';?>
    <!-- Navigation Bar -- end -->

    <!-- Search Section -- start -->
	<div class="outer-container padding-top-50 padding-bottom-100 shadow-100 is-light-blue-10">
		<div class="inner-container">
			<div class="row has-gap-100">
				<div class="col-45">
					
					<div class="card is-white radius-20 shadow-100 padding-25 margin-top-40" on-hover="-shadow-100 shadow-50">
						<form>
                            <p class="h4 margin-top-20 margin-bottom-5">Enter vehicle details</p>
                            <p class="small margin-bottom-30">Tinker with options and hit find.</p>
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
				<div class="col-55">
					
					<img src="../assets/backgrounds/search-illustration.svg" class="padding-100 margin-top-30">

				</div>
			</div>
		</div>
	</div>
    <!-- Search Section -- end -->
    
    <!-- Be A Seller Section -- start -->
    <div class="outer-container is-white-95">
        <div class="inner-container padding-y-100">
            <div class="row">
                <div class="col-50">
                    <img src="../assets/backgrounds/vehicle-explore-illustration.svg" class="padding-100 margin-top-30">
                </div>
                <div class="col-50"></div>
            </div>
        </div>
    </div>
    
</body>
</html>