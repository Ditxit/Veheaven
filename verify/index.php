<?php
    include '../include/redirection.php';

    if(!isset($_GET['code']) || !$_GET['code']) {
        header('Location: ../explore');
        exit;
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="../css/style.css">
    <script type="text/javascript" src="../js/script.js"></script>
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
            <div class="card width-70 float-center margin-top-30 is-white radius-10 custom-border">

                <div class="row">
                    <div class="col-50 is-blue-5">
                        <div class=" margin-y-70 margin-x-40">
                            <img src="../assets/backgrounds/account-recovery.svg" alt="Login Illustration Image">
                        </div>
                    </div>
                    <div class="col-50 padding-20">

                    <p class="h4 margin-top-20 margin-bottom-5">Set a Password</p>
                    <p class="small margin-bottom-30">Use a strong password with atlease 8 characters</p>

                    <form method="POST" action="../controller/verify.php" autocomplete="off">

                        <!-- Password Row -->
                        <div class="row margin-bottom-20">
                            <div class="col">
                                <label class="small" for="password">
                                    Password
                                    <span id="passwordStatus" class="float-right"></span>
                                </label>
                                <div id="passwordContainer" class="row radius-10 is-white-95 custom-border margin-bottom-5">
                                    <div class="col-85">
                                        <input id="password" type="password" placeholder="Password" name="password" class="radius-0 padding-20 margin-bottom-0 is-transparent" style="border: none;" minlength="8" required/>
                                    </div>
                                    <div id="togglePassword" class="col-15 text-gray padding-20 cursor-pointer" title="Toggle visibility">
                                        <img class="showPassword" src="../assets/icons/show.svg" height="18" alt="show" style="display:block;" />
                                        <img class="hidePassword" src="../assets/icons/hide.svg" height="18" alt="hide" style="display:none;"  />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Confirm Password Row -->
                        <div class="row margin-bottom-20">
                            <div class="col">
                                <label class="small" for="password">
                                    Confirm Password
                                    <span id="confirmPasswordStatus" class="float-right"></span>
                                </label>
                                <div id="confirmPasswordContainer" class="row radius-10 is-white-95 custom-border margin-bottom-5">
                                    <div class="col-85">
                                        <input id="confirmPassword" type="password" placeholder="Confirm Password" name="confirmPassword" class="radius-0 padding-20 margin-bottom-0 is-transparent" style="border: none;" minlength="8" required/>
                                    </div>
                                    <div id="toggleConfirmPassword" class="col-15 text-gray padding-20 cursor-pointer" title="Toggle visibility">
                                        <img class="showPassword" src="../assets/icons/show.svg" height="18" alt="show" style="display:block;" />
                                        <img class="hidePassword" src="../assets/icons/hide.svg" height="18" alt="hide" style="display:none;"  />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button Row -->
                        <div class="row">
                            <div class="col">
                                <input type="hidden" name="code" value="<?=$_GET['code']?>">
                                <input id="proceedButton" type="submit" name="submit" value="Proceed" class="padding-20 custom-bg-red radius-10"/>
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
    
        // For Validating Password Field
        var proceedButton = document.getElementById("proceedButton");

        var password = document.getElementById("password");
        var passwordStatus = document.getElementById("passwordStatus");
        var passwordContainer = document.getElementById("passwordContainer");

        var confirmPassword = document.getElementById("confirmPassword");
        var confirmPasswordStatus = document.getElementById("confirmPasswordStatus");
        var confirmPasswordContainer = document.getElementById("confirmPasswordContainer");

        function validatePassword(){

            if(password.value.length == 0){

                passwordContainer.style.backgroundColor = '#ffeeee'; // red
                passwordStatus.style.color = '#ff8888'; // red
                passwordStatus.innerText = 'Empty password';
                proceedButton.setAttribute("disabled","disabled");

            }else if(password.value.length < 8){

                passwordContainer.style.backgroundColor = '#ffeeee'; // red
                passwordStatus.style.color = '#ff8888'; // red
                passwordStatus.innerText = 'Minimum 8 characters';
                proceedButton.setAttribute("disabled","disabled");

            }else if(password.value != confirmPassword.value){

                passwordContainer.style.backgroundColor = '#ffeeee'; // red
                passwordStatus.style.color = '#ff8888'; // red
                passwordStatus.innerText = 'Passwords do not match';
                proceedButton.setAttribute("disabled","disabled");

            }else{

                passwordContainer.style.backgroundColor = '#eeffee'; // green
                passwordStatus.innerText = '';
                document.getElementById("proceedButton").disable = false;
                proceedButton.removeAttribute("disabled");

            }

        }

        password.addEventListener("keyup", validatePassword);
        password.addEventListener("focusin", validatePassword);
        password.addEventListener("focusout", () => {passwordContainer.style.backgroundColor = ""; passwordStatus.innerText = '';});

        // For Password Field Show/Hide Toggle Button

        var togglePassword = document.getElementById("togglePassword");
        var showPassword = togglePassword.querySelector(".showPassword");
        var hidePassword = togglePassword.querySelector(".hidePassword");

        function togglePasswordVisibility() {

            if(showPassword.style.display == "block"){
                showPassword.style.display = "none";
                hidePassword.style.display = "block";
                password.type = "text";
            }else{
                hidePassword.style.display = "none";
                showPassword.style.display = "block";
                password.type = "password";
            }

            password.focus();
        }

        togglePassword.addEventListener("click", togglePasswordVisibility);


        // For Validating Confirm Password Field

        function validateConfirmPassword(){

            if(confirmPassword.value.length == 0){

                confirmPasswordContainer.style.backgroundColor = '#ffeeee'; // red
                confirmPasswordStatus.style.color = '#ff8888'; // red
                confirmPasswordStatus.innerText = 'Empty confirm password';
                proceedButton.setAttribute("disabled","disabled");

            }else if(confirmPassword.value.length < 8){

                confirmPasswordContainer.style.backgroundColor = '#ffeeee'; // red
                confirmPasswordStatus.style.color = '#ff8888'; // red
                confirmPasswordStatus.innerText = 'Minimum 8 characters';
                proceedButton.setAttribute("disabled","disabled");

            }else if(confirmPassword.value != password.value){

                confirmPasswordContainer.style.backgroundColor = '#ffeeee'; // red
                confirmPasswordStatus.style.color = '#ff8888'; // red
                confirmPasswordStatus.innerText = 'Passwords do not match';
                proceedButton.setAttribute("disabled","disabled");

            }else{

                confirmPasswordContainer.style.backgroundColor = '#eeffee'; // green
                confirmPasswordStatus.innerText = '';
                proceedButton.removeAttribute("disabled");

            }

        }

        confirmPassword.addEventListener("keyup", validateConfirmPassword);
        confirmPassword.addEventListener("focusin", validateConfirmPassword);
        confirmPassword.addEventListener("focusout", () => {confirmPasswordContainer.style.backgroundColor = ""; confirmPasswordStatus.innerText = '';});

        // For Confirm Password Field Show/Hide Toggle Button

        var toggleConfirmPassword = document.getElementById("toggleConfirmPassword");
        var showConfirmPassword = toggleConfirmPassword.querySelector(".showPassword");
        var hideConfirmPassword = toggleConfirmPassword.querySelector(".hidePassword");

        function toggleConfirmPasswordVisibility() {

            if(showConfirmPassword.style.display == "block"){
                showConfirmPassword.style.display = "none";
                hideConfirmPassword.style.display = "block";
                confirmPassword.type = "text";
            }else{
                hideConfirmPassword.style.display = "none";
                showConfirmPassword.style.display = "block";
                confirmPassword.type = "password";
            }

            confirmPassword.focus();
        }

        toggleConfirmPassword.addEventListener("click", toggleConfirmPasswordVisibility);

    </script>
    <!-- JavaScript -- end -->

</body>
</html>