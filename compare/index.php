<?php
    
?>

<!DOCTYPE html>
<html lang="en">

<head> <?php include_once '../include/header.ui.php';?> </head>

<body class="custom-bg-gray">  

    <?php
        // Including navbar
        include_once '../include/navbar.ui.php';

    ?>

    <div class="outer-container">
        <div class="width-80 float-center margin-top-30">

            <section class="is-white custom-border radius-10">

                <div class="custom-border-bottom padding-20">
                    <p class="h3">Compare vehicles</p>
                </div>

                <div class="row" id="vehiclesCardContainer">

                    <div class="col">
                        <select name="vehicleOne" id="vehicleOne">
                            <!-- Data will be populated from JS -->
                        </select>
                    </div>

                    <div class="col-auto">
                        <p class="bold padding-x-20 padding-y-10">vs</p>
                    </div>

                    <div class="col">
                        <select name="vehicleTwo" id="vehicleTwo">
                            <!-- Data will be populated from JS -->
                        </select>
                    </div>

                </div>
        
            </section>
            
        </div>
    </div>

    <script>

        function textToNode(text) {
            var template = document.createElement('template');
            text = text.trim(); // Never return a text node of whitespace as the result
            template.innerHTML = text;
            return template.content.firstChild;
        }

        var seenVehicleContents = [];

        async function fetchSeenVehicles() {

            let vehicleIds = LocalStorage.get('seenVehicleHistory');

            let vehicleOneSelector = document.getElementById("vehicleOne");
            let vehicleTwoSelector = document.getElementById("vehicleTwo");
            
            for (vehicleId of vehicleIds) {

                let vehicleContent = await fetch('<?=API_ENDPOINT?>/vehicle/' + vehicleId)
                                    .then(response => response.json())
                                    .then(data => { return data; });

                // vehiclesCardContainer.appendChild(
                //     textToNode(
                //         '<div class="col-33" >' +
                //             '<div class="custom-checkbox margin-5">' + 
                //                 '<input id="vehicle' + vehicleId + '" type="checkbox" name="vehicles" value="' + vehicleId + '">' +
                //                 '<label for="vehicle' + vehicleId + '" class="is-white shadow-10 radius-15 padding-20">' + data.name + '</label>' +
                //             '</div>' +
                //         '</div>'
                //     )
                // );
                
                seenVehicleContents.push(vehicleContent);

            } // for

            console.log(seenVehicleContents);

            for (vehicleContent of seenVehicleContents) {

                vehicleOneSelector.add(new Option(vehicleContent.name, vehicleContent.id)); // text, value
                vehicleTwoSelector.add(new Option(vehicleContent.name, vehicleContent.id)); // text, value

            }

        } fetchSeenVehicles();

    </script>

    <!-- Footer -- start -->
    <?php include_once '../include/footer.ui.php'; ?>
    <!-- Footer -- end -->

</body>
</html>