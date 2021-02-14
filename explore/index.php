<?php 

    $PAGE_NAME = "Explore";

    // Including toast
    include_once '../include/toast.php';

    // Bug
    include_once '../include/header.ui.php'; 

?>

<!DOCTYPE html>
<html lang="en">

<head> <?php include_once '../include/header.ui.php';?> </head>

<body class="custom-bg-gray">

    <?php
        // Including navbar
        include_once '../include/navbar.ui.php';

        // Including global constants
        include_once '../include/config.php';
    ?>

    <!-- Two Sideded UI container -->
    <div class="outer-container">
        <div class="width-80 float-center">
            <div class="row">
                <!-- Left column - filter box container -->
                <div class="col-30">
                    <!-- Filter box -- start -->
                    <section class="sticky top margin-y-30 margin-right-30" style="top: 84px; z-index: 0;">
                        <div class="card is-white radius-15 custom-border padding-20 padding-y-0">
                            <p class="h5 margin-bottom-5">Find Your Next Vehicle</p>
                            <p class="small margin-bottom-30">Tinker with the options and hit find.</p>
                            <form action="">

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
                                    <div class="col-100">
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
                                        <label class="small" for="vehicle-location">Provinces </label>
                                        <select name="vehile-provinces " id="vehicle-provinces " class="padding-15 margin-bottom-15 radius-5 cursor-pointer">
                                            <option value="any">Any</option>
                                            <option value="kathmandu">Kathmandu</option>
                                            <option value="bhaktapur">Bhaktapur</option>
                                        </select>
                                    </div>
                                </div>
                                <script type="text/javascript">
                                    // Create NPR currency formatter.
                                    var formatter = new Intl.NumberFormat('en-IN', {
                                        style: 'currency',
                                        currency: 'NPR',
                                    });
                                    function format_NRP(currency){ return formatter.format(currency).replace(/(\.|,)00$/g, '')}
                                    
                                </script>
                                <div class="row">
                                    <div class="col-100">
                                        <label class="small" for="vehicle-max-price">
                                            <span class="float-left">Minimum Price</span>
                                            <output class="float-right" id="vehicle_min_price_output" name="vehicle_min_price_output" for="vehicle_min_price">NPR 0</output>
                                        </label>
                                        <input type="range" min="0" max="800000" value="0" step="1000" id="vehicle_min_price" name="vehicle_min_price" oninput="vehicle_min_price_output.value=format_NRP(vehicle_min_price.value)">
                                    </div>
                                    <div class="col-100">
                                        <label class="small" for="vehicle-max-price">
                                            <span class="float-left">Maximum Price</span>
                                            <output class="float-right" id="vehicle_max_price_output" name="vehicle_max_price_output" for="vehicle_max_price">NPR 8,00,000</output>
                                        </label>
                                        <input type="range" min="800000" max="100000000" value="800000" step="1000" id="vehicle_max_price" name="vehicle_max_price" oninput="vehicle_max_price_output.value=format_NRP(vehicle_max_price.value)">
                                    </div>
                                    <div class="col">
                                    </div>
                                </div>

                                <div class="row has-gap-15">
                                    <div class="col-100">
                                        <input type="submit" name="" value="Find" class="custom-bg-red radius-10 padding-15 margin-y-15 display-block width-100" on-hover="is-deep-purple-60">
                                    </div>
                                </div>

                            </form>
                        </div>
                    </section>
                    <!-- Filter box -- end -->
                </div>
                <!-- right column - content container -->
                <div class="col-70">

                    <!-- Recently Added Bike Section -- start -->
                    <section class="margin-y-30 is-white custom-border radius-15">
                        <!-- Recently added bike label and show-more button -->
                        <div class="row padding-20 custom-border-bottom">
                            <div class="col">
                                <p class="h5">Recently Added Bikes</p>
                            </div>
                            <div class="col">
                                <a href="" class="bold float-right custom-text-blue">See More</a>
                            </div>
                        </div>
                        
                        <!-- Recently added bike cards rows -->
                        <div class="row">
                            <?php
                                $bikes = json_decode(file_get_contents(API_ENDPOINT.'/recent/bike/3'), TRUE);
                                foreach($bikes as $bike){
                                    echo '
                                        <!-- Single vehicle row -- start -->
                                        <div class="col-100">
                                            

                                            <div class="row custom-border-bottom padding-20" data-user-vehicle-row="'.$bike['name'].'">
                                                <div class="col-25 is-white-90">
                                                    <img style="object-fit: cover;" class="width-100 radius-5" src="'.API_ENDPOINT.'/storage/'.$bike['images'][0]['name'].'" alt="vehicle image">
                                                </div>
                                                <div class="col-45 padding-x-20">
                                                    <div class="row">
                                                        <div class="col-100">
                                                            <p class="h5 text-ellipsis" title="'.$bike['name'].'">'.$bike['name'].'</p>
                                                        </div>
                                                        <div class="col-100">
                                                            <p class="small">
                                                                <span><output class="custom-text-blue bold" onclick="this.innerText=format_NRP(this.innerText)">'.$bike['price'].'</output></span>
                                                            </p>
                                                        </div>
                                                        <div class="col-100">
                                                            <span class="small bold">Seller: </span>
                                                            <span class="small">'.$bike['seller']['first_name'].' '.$bike['seller']['last_name'].'</span>
                                                        </div>
                                                        <div class="col-100">
                                                            <span class="small bold">Added Date: </span>
                                                            <span class="small">'.date("F jS, Y", strtotime($bike['added_date'])).'</span>
                                                        </div>
                                                        <div class="col-100">
                                                            <a class="custom-bg-blue button width-50 padding-y-5 margin-top-15 radius-10" href="../vehicle/?id='.$bike['id'].'" class="button">View More</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-30">
                                                    <div class="row padding-15 radius-10 is-light-blue-5">
                                                        <div class="col-100">
                                                            <span class="small bold">Model: </span>
                                                            <span class="small">'.$bike['model']['brand'].' '.$bike['model']['model'].'</span>
                                                        </div>
                                                        <div class="col-100">
                                                            <span class="small bold">Body: </span>
                                                            <span class="small">'.$bike['body']['body'].'</span>
                                                        </div>
                                                        <div class="col-100">
                                                            <span class="small bold">Engine: </span>
                                                            <span class="small">'.$bike['engine'].'&nbsp;CC</span>
                                                        </div>
                                                        <div class="col-100">
                                                            <span class="small bold">Mileage: </span>
                                                            <span class="small">'.$bike['mileage'].'&nbsp;Km/ltr</span>
                                                        </div>
                                                        <div class="col-100">
                                                            <span class="small bold">Type: </span>
                                                            <span class="small">'.$bike['condition']['condition'].' '.$bike['type']['type'].'</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <!-- Single vehicle row -- end -->
                                    ';
                                }
                            ?>
                        </div>
                    </section>
                    <!-- Recently Added Bike Section -- end -->

                    <!-- Be A Seller Or Login Section -- start -->
                    <section class="margin-y-30">
                        <div class="row has-gap-30">

                            <div class="col-50">
                                <div class="card is-white text-black custom-border radius-20">
                                    <div class="card-body padding-40 custom-border-bottom">
                                        <p class="h4">Want to Sell Your Vehicle?</p>
                                        <p class="small">Register an account for free and list your vehicle</p>
                                    </div>
                                    <div class="card-footer">
                                        <a href="" class="button custom-text-blue bold padding-10 width-100" on-hover="is-white-95">Be a Seller</a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-50">
                                <div class="card is-white text-black custom-border radius-20">
                                    <div class="card-body padding-40 custom-border-bottom">
                                        <p class="h4">Already have an account?</p>
                                        <p class="small">Login to your account to see the vehicles you listed</p>
                                    </div>
                                    <div class="card-footer">
                                        <a href="../login" class="button custom-text-blue bold padding-10 width-100" on-hover="is-white-95">Goto Login</a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </section>
                    <!-- Be A Seller Or Login Section -- end -->

                    <!-- Recently Added Car Section -- start -->
                    <section class="margin-y-30 is-white custom-border radius-15">
                        <!-- Recently added car label and show-more button -->
                        <div class="row padding-20 custom-border-bottom">
                            <div class="col">
                                <p class="h5">Recently Added Cars</p>
                            </div>
                            <div class="col">
                                <a href="" class="bold float-right custom-text-blue">See More</a>
                            </div>
                        </div>
                        
                        <!-- Recently added cars cards rows -->
                        <div class="row">
                            <?php
                                $bikes = json_decode(file_get_contents(API_ENDPOINT.'/recent/bike/3'), TRUE);
                                foreach($bikes as $bike){
                                    echo '
                                        <!-- Single vehicle row -- start -->
                                        <div class="col-100">
                                            

                                            <div class="row custom-border-bottom padding-20" data-user-vehicle-row="'.$bike['name'].'">
                                                <div class="col-25 is-white-90">
                                                    <img style="object-fit: cover;" class="width-100 radius-5" src="'.API_ENDPOINT.'/storage/'.$bike['images'][0]['name'].'" alt="vehicle image">
                                                </div>
                                                <div class="col-45 padding-x-20">
                                                    <div class="row">
                                                        <div class="col-100">
                                                            <p class="h5 text-ellipsis" title="'.$bike['name'].'">'.$bike['name'].'</p>
                                                        </div>
                                                        <div class="col-100">
                                                            <p class="small">
                                                                <span>NRs.&nbsp;</span>
                                                                <span class="custom-text-blue bold">'.$bike['price'].'</span>
                                                            </p>
                                                        </div>
                                                        <div class="col-100">
                                                            <span class="small bold">Seller: </span>
                                                            <span class="small">'.$bike['seller']['first_name'].' '.$bike['seller']['last_name'].'</span>
                                                        </div>
                                                        <div class="col-100">
                                                            <span class="small bold">Added Date: </span>
                                                            <span class="small">'.date("F jS, Y", strtotime($bike['added_date'])).'</span>
                                                        </div>
                                                        <div class="col-100">
                                                            <a class="custom-bg-blue button width-50 padding-y-5 margin-top-15 radius-10" href="../vehicle/?id='.$bike['id'].'" class="button">View More</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-30">
                                                    <div class="row padding-15 radius-10 is-light-blue-5">
                                                        <div class="col-100">
                                                            <span class="small bold">Model: </span>
                                                            <span class="small">'.$bike['model']['brand'].' '.$bike['model']['model'].'</span>
                                                        </div>
                                                        <div class="col-100">
                                                            <span class="small bold">Body: </span>
                                                            <span class="small">'.$bike['body']['body'].'</span>
                                                        </div>
                                                        <div class="col-100">
                                                            <span class="small bold">Engine: </span>
                                                            <span class="small">'.$bike['engine'].'&nbsp;CC</span>
                                                        </div>
                                                        <div class="col-100">
                                                            <span class="small bold">Mileage: </span>
                                                            <span class="small">'.$bike['mileage'].'&nbsp;Km/ltr</span>
                                                        </div>
                                                        <div class="col-100">
                                                            <span class="small bold">Type: </span>
                                                            <span class="small">'.$bike['condition']['condition'].' '.$bike['type']['type'].'</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <!-- Single vehicle row -- end -->
                                    ';
                                }
                            ?>
                        </div>
                    </section>
                    <!-- Recently Added Car Section -- end -->

                </div>
            </div>
        </div>
    </div>

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