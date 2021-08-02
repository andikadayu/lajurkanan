<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lajur Kanan Official</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #17a2b8;
            height: 100vh;
        }

        #login .container #login-row #login-column #login-box {
            margin-top: 25vh;
            max-width: 600px;
            height: auto;
            border: 1px solid #9C9C9C;
            background-color: #EAEAEA;
        }

        #login .container #login-row #login-column #login-box #login-form {
            padding: 20px;
        }
    </style>
</head>
<?php
include 'config.php';
session_start();
if ($_SESSION != null) {
    header("location:scrap.php");
}
?>

<body>

    <div class="container-fluid">
        <div id="login">
            <div class="container">
                <div id="login-row" class="row justify-content-center align-items-center">
                    <div id="login-column" class="col-md-6">
                        <div id="login-box" class="col-md-12">
                            <form id="login-form" class="form" action="controller/forgoting_password.php" method="post" autocomplete="off" aria-autocomplete="none">
                                <h3 class="text-center text-info">Remember Password</h3>
                                <div class="form-group">
                                    <div class="row">
                                        <label for="email" class="text-info">Email:</label><br>
                                        <div class="col-10">
                                            <input type="text" name="email" id="email" class="form-control" required aria-required="true">
                                        </div>
                                        <div class="col-2">
                                            <button type="button" class="btn btn-sm btn-success" onclick="sendSMTP();">Check</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label for="code" class="text-info">Code OTP:</label><br>
                                        <div class="col-10">
                                            <input type="number" name="code" id="code" class="form-control" required aria-required="true" disabled>
                                        </div>
                                        <div class="col-2">
                                            <button type="button" class="btn btn-sm btn-success" id="codeBtn" onclick="checkOTP()" disabled>Check</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="password" class="text-info">Password:</label><br>
                                    <input type="password" name="password" id="password" class="form-control" required aria-required="true" disabled>
                                </div>
                                <div class="form-group d-flex justify-content-end">
                                    <input type="submit" style="margin-top: 25px;margin-right: 10px;" name="submit" id="btnSubmit" class="btn btn-info form-control" value="change password" disabled>
                                </div>
                                <div class="form-group d-flex justify-content-center" style="margin-top: 20px;">
                                    <a href="index.php">Login?</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function sendSMTP() {
            var email = $('#email').val();
            if (email != "") {
                $.ajax({
                    url: "controller/remember_pass.php",
                    method: "GET",
                    data: {
                        email: email,
                        purpose: "cekEmail"
                    }
                }).done(function(data) {
                    if (data == 'success') {
                        $('#code').prop("disabled", false);
                        $('#codeBtn').prop("disabled", false);
                        alert("Success send Code OTP check your email");
                    } else {
                        alert(data);
                    }
                })
            } else {
                alert("input your email");
            }
        }

        function checkOTP() {
            var email = $('#email').val();
            var code = $('#code').val();

            if (email != "" && code != "") {
                $.ajax({
                    url: "controller/remember_pass.php",
                    method: "GET",
                    data: {
                        email: email,
                        purpose: "cekOTP",
                        code: code
                    }
                }).done(function(data) {
                    if (data == 'success') {
                        $('#password').prop("disabled", false);
                        $('#btnSubmit').prop("disabled", false);
                        alert("The Code OTP Is Correctly");
                    } else {
                        alert("The Code OTP Is not Correctly");
                    }
                })
            } else {
                alert("input your code otp");
            }
        }
    </script>

</body>

</html>