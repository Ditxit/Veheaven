<?php
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
<body class="is-white-95">

    <?php include '../include/header.ui.php'; ?>

    <!-- Login Form -- start -->
    <div class="outer-container">
        <div class="inner-container">
            <div class="card width-70 float-center margin-top-100 is-white radius-10 shadow-15" on-hover="shadow-50">

                <div class="row">
                    <div class="col-50 is-blue-5">
                        <div class=" margin-y-70 margin-x-40">
                            <img src="../../assets/account-recovery.svg" alt="Login Illustration Image">
                        </div>
                    </div>
                    <div class="col-50 padding-20">

                    <p class="h4 margin-top-20 margin-bottom-5">Recover Account</p>
                    <p class="small margin-bottom-30">A recovery code will be send to your email address.</p>

                    <form method="POST" action="../controller/recovery.php">

                        <!-- Eamil Row -->
                        <div class="row">
                            <div class="col">
                                <label class="small" for="email">
                                    Email Address
                                    <span id="emailStatus" class="float-right"></span>
                                </label>
                                <input id="email" type="email" placeholder="Email Address" name="email" class="radius-10 padding-20 margin-bottom-35" autocomplete="off" autofocus required/>
                            </div>
                        </div>

                        <!-- Password Row -->
                        <div class="row">
                            <div class="col">
                                <label class="small" for="confirmEmail">
                                    Confirm Email Address
                                    <span id="confirmEmailStatus" class="float-right"></span>
                                </label>
                                <input id="confirmEmail" type="email" placeholder="Confirm Email" name="confirm_email" class="radius-10 padding-20 margin-bottom-40" autocomplete="off" required/>
                            </div>
                        </div>

                        <!-- Submit Button Row -->
                        <div class="row">
                            <div class="col">
                                <input type="submit" name="recovery_info" value="Send Code" class="padding-20 is-blue radius-10" on-hover="is-blue-55"/>
                            </div>
                        </div>

                    </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -- start -->
    <script type="text/javascript">
        
        // For Validating Email Field

        const VALID_EMAIL = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        
        var email = document.getElementById("email");
        var emailStatus = document.getElementById("emailStatus");

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


        // For Validating Confirm Email Field

        var confirmEmail = document.getElementById("confirmEmail");
        var confirmEmailStatus = document.getElementById("confirmEmailStatus");

        function validaidateConfirmEmail(){

            if(confirmEmail.value.length == 0){

                confirmEmail.style.backgroundColor = '#ffeeee'; // red
                confirmEmailStatus.style.color = '#ff8888'; // red
                confirmEmailStatus.innerText = 'Empty email';

            }else if(confirmEmail.value != email.value) {

                confirmEmail.style.backgroundColor = '#ffeeee'; // red
                confirmEmailStatus.style.color = '#ff8888'; // red
                confirmEmailStatus.innerText = 'Emails not matching';

            }else {

                confirmEmail.style.backgroundColor = '#eeffee'; // green
                confirmEmailStatus.innerText = '';

            }

        }

        confirmEmail.addEventListener("keyup", validaidateConfirmEmail);
        confirmEmail.addEventListener("focusin", validaidateConfirmEmail);
        confirmEmail.addEventListener("focusout", () => {confirmEmail.style.backgroundColor = ""; confirmEmailStatus.innerText = '';});

    </script>
    <!-- JavaScript -- end -->

</body>
</html>