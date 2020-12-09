<?php
    include '../include/redirection.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="../../css/style.css">
    <script src="../../js/script.js"></script>
</head>
<body class="is-blue-10">
    <div class="outer-container">
        <div class="inner-container">
            <div class="card width-40 float-center margin-top-100 padding-20 is-white radius-10 shadow-10">

                <p class="h4 margin-y-40">Admin Login</p>

                <form method="POST" action="../controller/login.php">

                    <!-- Eamil Row -->
                    <div class="row">
                        <div class="col">
                            <input type="text" placeholder="Email Address" name="email" class="padding-20 margin-bottom-10"/>
                        </div>
                    </div>

                    <!-- Password Row -->
                    <div class="row">
                        <div class="col">
                            <input type="password" placeholder="Password" name="password" class="padding-20 margin-bottom-10"/>
                        </div>
                    </div>

                    <!-- Forgot Password Row -->
                    <div class="row">
                        <div class="col">
                            <a href="../recovery"></a>
                        </div>
                    </div>

                    <!-- Submit Button Row -->
                    <div class="row">
                        <div class="col">
                            <input type="submit" name="submit" value="Login" class="padding-20 is-blue radius-10"/>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
</body>
</html>