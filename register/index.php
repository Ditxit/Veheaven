<?php
    $PAGE_NAME = 'Register';

    include '../include/redirection.php';
    include '../include/toast.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="../../css/style.css">
    <script type="text/javascript" src="../../js/script.js"></script>
</head>
<body class="custom-bg-gray">

    <?php
        include '../include/header.ui.php';

        // Including navbar
        include_once '../include/navbar.ui.php';
    ?>

    <!-- Login Form -- start -->
    <div class="outer-container">
        <div class="width-80 float-center">
            <div class="card width-70 float-center margin-top-30 is-white radius-15 custom-border">

                <div class="row">
                    <div class="col-50 is-blue-5">
                        <div class=" margin-y-70 margin-x-40">
                            <img src="../assets/backgrounds/account-recovery.svg" alt="Login Illustration Image">
                        </div>
                    </div>
                    <div class="col-50 padding-20">

                    <p class="h4 margin-top-20 margin-bottom-5">Register Account</p>
                    <p class="small margin-bottom-30">A verification link will be send to your email address.</p>

                    <form method="POST" action="../controller/register.php">

                        <!-- Name Row -->
                        <div class="row margin-bottom-20">
                            <div class="col padding-right-15">
                                <label class="small" for="firstName">
                                    First Name
                                    <span id="firstNameStatus" class="float-right"></span>
                                </label>
                                <input id="firstName" type="text" placeholder="First Name" name="firstName" class="radius-10 padding-20 is-white-95 custom-border" autocomplete="on" autofocus required/>
                            </div>

                            <div class="col padding-left-15">
                                <label class="small" for="lastName">
                                    Last Name
                                    <span id="lastNameStatus" class="float-right"></span>
                                </label>
                                <input id="lastName" type="text" placeholder="Last Name" name="lastName" class="radius-10 padding-20 is-white-95 custom-border" autocomplete="on" required/>
                            </div>
                        </div>

                        <!-- Email Row -->
                        <div class="row margin-bottom-20">
                            <div class="col">
                                <label class="small" for="email">
                                    Email Address
                                    <span id="emailStatus" class="float-right"></span>
                                </label>
                                <input id="email" type="email" placeholder="john.doe@email.com" name="email" class="radius-10 padding-20 is-white-95 custom-border" autocomplete="on" required/>
                            </div>
                        </div>

                        <!-- Password Row -->
                        <div class="row">
                            <div class="col">
                                <label class="small" for="phoneNumber">
                                    Phone Number
                                    <span id="phoneNumberStatus" class="float-right"></span>
                                </label>
                                <input id="phoneNumber" type="tel" placeholder="9876543210" name="phoneNumber" class="radius-10 padding-20 margin-bottom-30 is-white-95 custom-border" autocomplete="on"/>
                            </div>
                        </div>

                        <!-- Submit Button Row -->
                        <div class="row">
                            <div class="col">
                                <input type="submit" name="registerButton" value="Register" class="padding-20 custom-bg-red radius-10" on-hover="is-blue-55"/>
                            </div>
                        </div>

                    </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -- start -->
    <?php include_once '../include/footer.ui.php'; ?>
    <!-- Footer -- end -->

    <!-- JavaScript -- start -->
    <script type="text/javascript">

        // For Validating First Name

        const VALID_NAME = /^[a-zA-Z]+$/;

        const firstName = document.getElementById("firstName");
        const firstNameStatus = document.getElementById("firstNameStatus");

        function validateFirstName(){

            firstName.value = firstName.value.replace(/[^A-Za-z]/g, '');

            if(firstName.value.length == 0){

                firstName.style.backgroundColor = '#ffeeee'; // red
                firstNameStatus.style.color = '#ff8888'; // red
                firstNameStatus.innerText = 'Empty';

            }else if (firstName.value.length > 2 && VALID_NAME.test(String(firstName.value)) ){

                firstName.style.backgroundColor = '#eeffee'; // green
                firstNameStatus.innerText = '';

            } else{

                firstName.style.backgroundColor = '#ffeeee'; // red
                firstNameStatus.style.color = '#ff8888'; // red
                firstNameStatus.innerText = 'Invalid';

            }
        }

        firstName.addEventListener("keyup", validateFirstName);
        firstName.addEventListener("focusin", validateFirstName);
        firstName.addEventListener("focusout", () => {firstName.style.backgroundColor = ""; firstNameStatus.innerText = '';});

        // For Validating Last Name

        const lastName = document.getElementById("lastName");
        const lastNameStatus = document.getElementById("lastNameStatus");

        function validateLastName(){

            lastName.value = lastName.value.replace(/[^A-Za-z]/g, '');

            if(lastName.value.length == 0){

                lastName.style.backgroundColor = '#ffeeee'; // red
                lastNameStatus.style.color = '#ff8888'; // red
                lastNameStatus.innerText = 'Empty';

            }else if (lastName.value.length > 2 && VALID_NAME.test(String(lastName.value)) ){

                lastName.style.backgroundColor = '#eeffee'; // green
                lastNameStatus.innerText = '';

            } else{

                lastName.style.backgroundColor = '#ffeeee'; // red
                lastNameStatus.style.color = '#ff8888'; // red
                lastNameStatus.innerText = 'Invalid';

            }
        }

        lastName.addEventListener("keyup", validateLastName);
        lastName.addEventListener("focusin", validateLastName);
        lastName.addEventListener("focusout", () => {lastName.style.backgroundColor = ""; lastNameStatus.innerText = '';});
        
        // For Validating Email Field

        const VALID_EMAIL = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        
        const email = document.getElementById("email");
        const emailStatus = document.getElementById("emailStatus");

        function validateEmail() {
            
            if(email.value.length == 0){

                email.style.backgroundColor = '#ffeeee'; // red
                emailStatus.style.color = '#ff8888'; // red
                emailStatus.innerText = 'Empty email';

            }else if (email.value.length > 6 && VALID_EMAIL.test(String(email.value).toLowerCase()) ){

                email.style.backgroundColor = '#eeffee'; // green
                emailStatus.innerText = '';

            } else{

                email.style.backgroundColor = '#ffeeee'; // red
                emailStatus.style.color = '#ff8888'; // red
                emailStatus.innerText = 'Invalid email';

            }
        }
        
        email.addEventListener("keyup", validateEmail);
        email.addEventListener("focusin", validateEmail);
        email.addEventListener("focusout", () => {email.style.backgroundColor = ""; emailStatus.innerText = '';});

        // For Validating Phone Number
        const phoneNumber = document.getElementById("phoneNumber");
        const phoneNumberStatus = document.getElementById("phoneNumberStatus");

        function validatePhoneNumber() {

            phoneNumber.value = phoneNumber.value.replace(/\D/g,'');
            
            if(phoneNumber.value.length == 0){

                phoneNumber.style.backgroundColor = '#ffeeee'; // red
                phoneNumberStatus.style.color = '#ff8888'; // red
                phoneNumberStatus.innerText = 'Empty phone number';

            }else if (phoneNumber.value.length > 9 && phoneNumber.value.match(/\d/g).length===10){

                phoneNumber.style.backgroundColor = '#eeffee'; // green
                phoneNumberStatus.innerText = '';

            } else{

                phoneNumber.style.backgroundColor = '#ffeeee'; // red
                phoneNumberStatus.style.color = '#ff8888'; // red
                phoneNumberStatus.innerText = 'Invalid phone number';

            }
        }

        phoneNumber.addEventListener("keyup", validatePhoneNumber);
        phoneNumber.addEventListener("focusin", validatePhoneNumber);
        phoneNumber.addEventListener("focusout", () => {phoneNumber.style.backgroundColor = ""; phoneNumberStatus.innerText = '';});

    </script>
    <!-- JavaScript -- end -->

</body>
</html>