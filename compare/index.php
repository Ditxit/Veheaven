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
                        <select id="vehicleOneSelector">
                            <!-- Data will be populated from JS -->
                        </select>

                        <div id="vehicleOneDetails" class="custom-border-right">
                            <img class="image" src="">
                            <p class="price padding-10 custom-border-bottom"></p>
                            <p class="conditionAndType padding-10 custom-border-bottom"></p>
                            <p class="makeAndModel padding-10 custom-border-bottom"></p>
                            <p class="body padding-10 custom-border-bottom"></p>
                            <p class="mileage padding-10 custom-border-bottom"></p>
                            <p class="engine padding-10 custom-border-bottom"></p>
                            <p class="bhp padding-10 custom-border-bottom"></p>
                            <p class="turnRadius padding-10 custom-border-bottom"></p>
                            <p class="topSpeed padding-10 custom-border-bottom"></p>
                            <p class="color padding-10 custom-border-bottom"></p>
                            <p class="fuel padding-10 custom-border-bottom"></p>
                            <p class="transmission padding-10 custom-border-bottom"></p>
                            <p class="seatCapacity padding-10 custom-border-bottom"></p>
                            <p class="tyres padding-10 custom-border-bottom"></p>
                            <p class="brakes padding-10 custom-border-bottom"></p>
                            <p class="suspensions padding-10"></p>
                        </div>

                    </div>

                    <div class="col-auto">
                        <p class="bold padding-x-20 padding-y-10">vs</p>
                    </div>

                    <div class="col">
                        <select id="vehicleTwoSelector">
                            <!-- Data will be populated from JS -->
                        </select>

                        <div id="vehicleTwoDetails" class="custom-border-left">
                            <img class="image" src="">
                            <p class="price padding-10 custom-border-bottom"></p>
                            <p class="conditionAndType padding-10 custom-border-bottom"></p>
                            <p class="makeAndModel padding-10 custom-border-bottom"></p>
                            <p class="body padding-10 custom-border-bottom"></p>
                            <p class="mileage padding-10 custom-border-bottom"></p>
                            <p class="engine padding-10 custom-border-bottom"></p>
                            <p class="bhp padding-10 custom-border-bottom"></p>
                            <p class="turnRadius padding-10 custom-border-bottom"></p>
                            <p class="topSpeed padding-10 custom-border-bottom"></p>
                            <p class="color padding-10 custom-border-bottom"></p>
                            <p class="fuel padding-10 custom-border-bottom"></p>
                            <p class="transmission padding-10 custom-border-bottom"></p>
                            <p class="seatCapacity padding-10 custom-border-bottom"></p>
                            <p class="tyres padding-10 custom-border-bottom"></p>
                            <p class="brakes padding-10 custom-border-bottom"></p>
                            <p class="suspensions padding-10"></p>
                        </div>
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

        async function applyChangeToVehicleDetails(elementId, vehicle) {
            console.log(vehicle)
            let targetedElement = document.getElementById(elementId); 

            targetedElement.querySelector('.image').src = '<?=API_ENDPOINT . '/storage/'?>' + vehicle.images[0].name;
            targetedElement.querySelector('.price').innerText = "Price: NPR " + vehicle.price;
            targetedElement.querySelector('.conditionAndType').innerText = "Condition & Type: " + vehicle.condition.condition + ' ' + vehicle.type.type;
            targetedElement.querySelector('.makeAndModel').innerText = "Make & Model: " + vehicle.model.brand + ' ' + vehicle.model.model + ' (' + vehicle.model.year + ')';
            targetedElement.querySelector('.body').innerText = "Body: " + vehicle.body.body;
            targetedElement.querySelector('.mileage').innerText = "Mileage: " + vehicle.mileage + ' Km/ltr';
            targetedElement.querySelector('.engine').innerText = "Engine: " + vehicle.engine + ' cc';
            targetedElement.querySelector('.bhp').innerText = "BHP: " + vehicle.bhp + ' bhp';
            targetedElement.querySelector('.turnRadius').innerText = "Turn Radius: " + vehicle.turn_radius + ' meter';
            targetedElement.querySelector('.topSpeed').innerText = "Top Speed: " + vehicle.top_speed + ' Km/hr';

            colors = [];
            for(color of vehicle.colors) { colors.push(color.color); }
            colors = colors.join(',');
            targetedElement.querySelector('.color').innerText = "Colors: " + colors;

            targetedElement.querySelector('.fuel').innerText = "Fuel: " + vehicle.fuel.fuel;
            targetedElement.querySelector('.transmission').innerText = "Transmision: " + vehicle.transmission.transmission;
            targetedElement.querySelector('.seatCapacity').innerText = "Seats: " + vehicle.seat;
            targetedElement.querySelector('.tyres').innerText = "Front Tyre: " + vehicle.front_tyre.tyre + ", Rear Tyre: " + vehicle.rear_tyre.tyre;
            targetedElement.querySelector('.brakes').innerText = "Front Brake: " + vehicle.front_break.break + ", Rear Brake: " + vehicle.rear_break.break;
            targetedElement.querySelector('.suspensions').innerText = "Front Suspension: " + vehicle.front_suspension.suspension + ", Rear Suspension: " + vehicle.rear_suspension.suspension;

        }

        async function fetchSeenVehicleDetails() {

            const seenVehicleIds = LocalStorage.get('seenVehicleHistory');
            const seenVehicleContents = new Map();

            for (seenVehicleId of seenVehicleIds) {

                let vehicleContent = await fetch('<?=API_ENDPOINT?>/vehicle/' + seenVehicleId)
                                                .then(response => response.json())
                                                .then(data => { return data; })
                                                .catch(error => { console.log(error) });

                seenVehicleContents.set(vehicleContent.id, vehicleContent);

            } // for

            return seenVehicleContents;
        }

        fetchSeenVehicleDetails().then((seenVehicleContents) => {

            const vehicleOneSelector = document.getElementById("vehicleOneSelector");
            const vehicleTwoSelector = document.getElementById("vehicleTwoSelector");

            const vehicleOneDetails = document.getElementById("vehicleOneDetails");
            const vehicleTwoDetails = document.getElementById("vehicleTwoDetails");

            for (const [_, vehicleContent] of seenVehicleContents.entries()) {

                vehicleOneSelector.add(new Option(vehicleContent.name, vehicleContent.id)); // text, value
                vehicleTwoSelector.add(new Option(vehicleContent.name, vehicleContent.id)); // text, value

            } // for

            applyChangeToVehicleDetails("vehicleOneDetails", seenVehicleContents.get(Number(vehicleOneSelector.value)));
            applyChangeToVehicleDetails("vehicleTwoDetails", seenVehicleContents.get(Number(vehicleTwoSelector.value)));

            vehicleOneSelector.addEventListener('change', (event) => {
                applyChangeToVehicleDetails("vehicleOneDetails", seenVehicleContents.get(Number(event.target.value)));
            });

            vehicleTwoSelector.addEventListener('change', (event) => {
                applyChangeToVehicleDetails("vehicleTwoDetails", seenVehicleContents.get(Number(event.target.value)));
            });

        });

    </script>

    <!-- Footer -- start -->
    <?php include_once '../include/footer.ui.php'; ?>
    <!-- Footer -- end -->

</body>
</html>