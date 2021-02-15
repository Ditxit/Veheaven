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

<body id="explore-page" class="custom-bg-gray">

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
                            <form autocomplete="off" novalidate onsubmit="return false;">

                                <div class="row has-gap-15">
                                    <div class="col-50">
                                        <label class="small" for="vehicle-condition">Condition</label>
                                        <select name="vehile-condition" id="vehicle-condition" class="padding-15 margin-bottom-15 radius-5 cursor-pointer">
                                            <option value="new used">Any</option>
                                            <option value="new">New</option>
                                            <option value="used">Used</option>
                                        </select>
                                    </div>
                                    <div class="col-50">
                                        <label class="small" for="vehicle-type">Type</label>
                                        <select name="vehile-type" id="vehicle-type" class="padding-15 margin-bottom-15 radius-5 cursor-pointer">
                                            <option value="bike car">Any</option>
                                            <option value="bike">Bike</option>
                                            <option value="car">Car</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row has-gap-15">
                                    <div class="col-100">
                                        <label class="small" for="vehicle-model">Model</label>
                                        <select name="vehile-model" id="vehicle-model" class="padding-15 margin-bottom-15 radius-5 cursor-pointer">
                                            <option class="bike car" value="">Any</option>
                                            <?php 
                                                $bikeBrands = file_get_contents(API_ENDPOINT.'/brand/1');
                                                $bikeBrands = json_decode($bikeBrands,TRUE);

                                                $carBrands = file_get_contents(API_ENDPOINT.'/brand/2');
                                                $carBrands = json_decode($carBrands,TRUE);

                                                foreach($bikeBrands as $brand){
                                                    echo "<option class='bike' value='".$brand['brand']."'>".$brand['brand']."</option>";
                                                }

                                                foreach ($carBrands as $brand){
                                                    echo "<option class='car' value='".$brand['brand']."'>".$brand['brand']."</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="row has-gap-15">
                                    <div class="col-100">
                                        <label class="small" for="vehicle-location">Provinces </label>
                                        <select name="vehile-province" id="vehicle-province" class="padding-15 margin-bottom-15 radius-5 cursor-pointer">
                                            <option value="">Any</option>
                                            <?php 
                                                $provinces = file_get_contents(API_ENDPOINT.'/province');
                                                $provinces = json_decode($provinces,TRUE);

                                                foreach ($provinces as $province){
                                                    echo "<option value='".$province['province']."'>".$province['province']."</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                
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
                                        <input type="submit" name="find-vehicle" id="find-vehicle" value="Find" class="custom-bg-red radius-10 padding-15 margin-y-15 display-block width-100" on-hover="is-deep-purple-60">
                                    </div>
                                </div>

                            </form>
                        </div>
                    </section>
                    <!-- Filter box -- end -->

                </div>
                <!-- right column - content container -->


                <div class="col-70">

                    <!-- Filter Box Search Result Display Section -- start -->
                    <section id="search-result-section" class="margin-y-30 is-white custom-border radius-15" style="display:none;">

                        <!-- Recently added bike label and show-more button -->
                        <div class="row padding-20 custom-border-bottom">
                            <div class="col">
                                <p id="search-result-title" class="h5">
                                    <!-- Data will be added in Js -->
                                </p>
                            </div>
                            <div class="col">
                                <a id="search-result-cancel" class="bold float-right custom-text-blue">Cancel</a>
                            </div>
                        </div>

                        <div id="search-result">
                            <!-- Data will be added in Js -->
                        </div>

                    </section>
                    <!-- Filter Box Search Result Display Section -- start -->

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
                        <div class="row">

                            <div class="col-50">
                                <div class="card is-white text-black custom-border radius-15 margin-right-15">
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
                                <div class="card is-white text-black custom-border radius-15 margin-left-15">
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

    <script type="text/javascript">
        // Create NPR currency formatter.
        var formatter = new Intl.NumberFormat('en-IN', {
            style: 'currency',
            currency: 'NPR',
        });
        function format_NRP(currency){ return formatter.format(currency).replace(/(\.|,)00$/g, '')}

        function format_date(date_string){
            // Month day(th), YYYY
            const month = ['January','February','March','April','May','June','July','August','September','October','November','December'];
            const date = new Date(date_string);
            return "" + month[date.getMonth()] + " " + date.getDate() + ", " + date.getFullYear() + "";
        }

        function textToNode(text) {
            var template = document.createElement('template');
            text = text.trim(); // Never return a text node of whitespace as the result
            template.innerHTML = text;
            return template.content.firstChild;
        }

        function slugify(text){
            return text.toString().toLowerCase()
                .replace(/[^0-9a-zA-Z ]/g, ' ')      // Remove all non-word or non-numeric or non-space chars
                .trim()                              // Trim starting and ending white-spaces
                .replace(/\s+/g, '-')                // Remove all other redundant white-spaces and replace with -
        }

        // Elements of filter box form
        const vehicleCondition = document.getElementById('vehicle-condition');
        const vehicleType = document.getElementById('vehicle-type');
        const vehicleModel = document.getElementById('vehicle-model');
        const vehicleProvince = document.getElementById('vehicle-province');
        const vehicleMinPrice = document.getElementById('vehicle_min_price');
        const vehicleMaxPrice = document.getElementById('vehicle_max_price');
        const findVehicle = document.getElementById('find-vehicle');

        // Elements of search result section
        const searchResultSection = document.getElementById('search-result-section');
        const searchResult = searchResultSection.querySelector('#search-result');
        const searchResultTitle = searchResultSection.querySelector('#search-result-title');
        const searchResultCancel = searchResultSection.querySelector('#search-result-cancel');

        vehicleType.onchange = () => {
            Array.from(vehicleModel.options).forEach( (option) => {
                if(option.classList.contains(vehicleType.value) || vehicleType.value == vehicleType.options[0].value){
                    option.style.display = null;
                }else{
                    option.style.display = 'none';
                }
            });

            if(vehicleModel.options[vehicleModel.selectedIndex].style.display == 'none') vehicleModel.selectedIndex = 0;
        }

        findVehicle.onclick = async () => {
            const keyword = [
                vehicleCondition.value,
                vehicleType.value,
                vehicleModel.value,
                vehicleProvince.value,
                vehicleMinPrice.value,
                vehicleMaxPrice.value
            ].join(" ");
            
            searchResult.innerText = "";
            searchResultTitle.innerText = "Searching...";
            searchResultSection.style.display = null;

            await fetch('<?=API_ENDPOINT.'/search';?>'+'/5/'+slugify(keyword)) // url
            .then(response => response.json())
            .then(vehicles => {
                searchResult.innerText = "";
                if(vehicles.length == 0) {
                    searchResultTitle.innerText = "No result found";
                }else{
                    searchResultTitle.innerText = "Found " + vehicles.length + " vehicles";
                    for(var i = 0; i<vehicles.length; i++){
                        searchResult.appendChild(
                            textToNode(
                                "<div class='row custom-border-bottom padding-20'>" +
                                    "<div class='col-25 is-white-90'>" +
                                        "<img style='object-fit: cover;' class='width-100 radius-5' src='<?=API_ENDPOINT;?>/storage/" + vehicles[i].images[0].name + "' alt='vehicle image'>" +
                                    "</div>" +
                                    "<div class='col-45 padding-x-20'>" +
                                        "<div class='row'>" +
                                            "<div class='col-100'>" +
                                                "<p class='h5 text-ellipsis' title='" + vehicles[i].name + "'>" + vehicles[i].name + "</p>" +
                                            "</div>" +
                                            "<div class='col-100'>" +
                                                "<p class='small'>" +
                                                    "<span><output class='custom-text-blue bold'>" + format_NRP(vehicles[i].price) + "</output></span>" +
                                                "</p>" +
                                            "</div>" +
                                            "<div class='col-100'>" +
                                                "<span class='small bold'>Seller:&nbsp;</span>" +
                                                "<span class='small'>" + vehicles[i].seller.first_name + " " + vehicles[i].seller.last_name + "</span>" +
                                            "</div>" +
                                            "<div class='col-100'>" +
                                                "<span class='small bold'>Added Date:&nbsp;</span>" +
                                                "<span class='small'> " + format_date(vehicles[i].added_date) + "</span>" +
                                            "</div>" +
                                            "<div class='col-100'>" +
                                                "<a class='custom-bg-blue button width-50 padding-y-5 margin-top-15 radius-10'  href='<?=SERVER_NAME;?>/vehicle/?id=" + vehicles[i].id + "' class='button'>View More</a>" +
                                            "</div>" +
                                        "</div>" +
                                    "</div>" +
                                "<div class='col-30'>" +
                                    "<div class='row padding-15 radius-10 is-light-blue-5'>" +
                                        "<div class='col-100'>" +
                                            "<span class='small bold'>Model:&nbsp;</span>" +
                                            "<span class='small'>" + vehicles[i].model.brand + " " + vehicles[i].model.model + "</span>" +
                                        "</div>" +
                                        "<div class='col-100'>" +
                                            "<span class='small bold'>Body:&nbsp;</span>" +
                                            "<span class='small'>" + vehicles[i].body.body + "</span>" +
                                        "</div>" + 
                                        "<div class='col-100'>" +
                                            "<span class='small bold'>Engine:&nbsp;</span>" +
                                            "<span class='small'>" + vehicles[i].engine + " CC</span>" +
                                        "</div>" +
                                        "<div class='col-100'>" +
                                            "<span class='small bold'>Mileage:&nbsp;</span>" +
                                            "<span class='small'>" + vehicles[i].mileage + " Km/ltr</span>" +
                                        "</div>" +
                                        "<div class='col-100'>"+
                                            "<span class='small bold'>Type:&nbsp;</span>" +
                                            "<span class='small'>" + vehicles[i].condition.condition + " " + vehicles[i].type.type + "</span>" +
                                        "</div>" +
                                    "</div>" +
                                "</div>" +
                            "</div>"
                            )
                        );
                    } // For loop
                }
                
            });
        }

        searchResultCancel.onclick = () => {
            searchResultSection.style.display = 'none';
        }

    </script>
    
</body>
</html>