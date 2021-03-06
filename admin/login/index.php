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
            <div class="card width-70 float-center margin-top-100 is-white radius-10 shadow-15" on-hover="shadow-50" phone="width-100 -margin-top-100">

                <div class="row">
                    <div class="col-50 is-blue-5" phone="col-100">
                        <div class=" margin-y-100 margin-x-40">
                            <img src="../../assets/account-login.svg" alt="Login Illustration Image">
                        </div>
                    </div>
                    <div class="col-50 padding-20" phone="col-100">

                    <p class="h4 margin-top-20 margin-bottom-5">Admin Login</p>
                    <p class="small margin-bottom-30">Enter your email and password to continue.</p>

                    <form method="POST" action="../controller/login.php">

                        <!-- Eamil Row -->
                        <div class="row">
                            <div class="col">
                                <label class="small" for="email">
                                    Email Address
                                    <span id="emailStatus" class="float-right"></span>
                                </label>
                                <input id="email" type="email" placeholder="Email Address" name="email" class="radius-10 padding-20 margin-bottom-35 is-white-95" autofocus required/>
                            </div>
                        </div>

                        <!-- Password Row -->
                        <div class="row">
                            <div class="col">
                                <label class="small" for="password">
                                    Password
                                    <span id="passwordStatus" class="float-right"></span>
                                </label>
                                <div id="passwordContainer" class="row radius-10 is-white-95" style="border: 1.2px solid #e7e7e7;">
                                    <div class="col-85">
                                        <input id="password" type="password" placeholder="Password" name="password" class="radius-0 padding-20 margin-bottom-0 is-transparent" style="border: none;" minlength="8" autocomplete="off" required/>
                                    </div>
                                    <div id="togglePassword" class="col-15 text-gray padding-20 cursor-pointer" title="Toggle visibility">
                                        <img id="showPassword" src="../../assets/icons/show.svg" height="18" alt="show" style="display:block;" />
                                        <img id="hidePassword" src="../../assets/icons/hide.svg" height="18" alt="hide" style="display:none;"  />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Forgot Password Row -->
                        <div class="row">
                            <div class="col">
                                <div class="margin-bottom-10">
                                    <span class="float-right">
                                        <a class="small text-blue" href="../recovery">Forgot password? </a>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button Row -->
                        <div class="row">
                            <div class="col">
                                <input type="submit" name="submit" value="Login" class="padding-20 is-blue radius-10" on-hover="is-blue-55"/>
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


        // For Validating Password Field

        var password = document.getElementById("password");
        var passwordStatus = document.getElementById("passwordStatus");

        function validatePassword(){

            if(password.value.length == 0){

                passwordContainer.style.backgroundColor = '#ffeeee'; // red
                passwordStatus.style.color = '#ff8888'; // red
                passwordStatus.innerText = 'Empty password';

            }else if(password.value.length < 8){

                passwordContainer.style.backgroundColor = '#ffeeee'; // red
                passwordStatus.style.color = '#ff8888'; // red
                passwordStatus.innerText = 'Minimum 8 characters';

            }else{

                passwordContainer.style.backgroundColor = '#eeffee'; // green
                passwordStatus.innerText = '';

            }

        }

        password.addEventListener("keyup", validatePassword);
        password.addEventListener("focusin", validatePassword);
        password.addEventListener("focusout", () => {passwordContainer.style.backgroundColor = ""; passwordStatus.innerText = '';});


        // For Password Field Show/Hide Toggle Button
        var togglePassword = document.getElementById("togglePassword");
        var showPassword = document.getElementById("showPassword");
        var hidePassword = document.getElementById("hidePassword");

        function togglePasswordVisibility() {

            if(showPassword.style.display == "block"){
                showPassword.style.display = "none";
                hidePassword.style.display = "block";
                //console.log(showPassword.style.display+" "+hidePassword.style.display);
                password.type = "text";
            }else{
                hidePassword.style.display = "none";
                showPassword.style.display = "block";
                password.type = "password";
            }

            password.focus();
        }

        togglePassword.addEventListener("click", togglePasswordVisibility);

    </script>
    <!-- JavaScript -- end -->

</body>
</html>