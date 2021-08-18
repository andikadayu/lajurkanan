<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="forgot your password">
    <title>Lajur Kanan Official</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.min.css">
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
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

    <script src="assets/js/remember.min.js"></script>

</body>

</html>