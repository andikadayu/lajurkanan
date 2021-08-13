<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="register new user page">
    <title>Lajur Kanan Official</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #17a2b8;
            height: 100vh;
        }

        #login .container #login-row #login-column #login-box {
            margin-top: 20vh;
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
                            <form id="login-form" class="form" action="controller/register_proccess.php" method="post" autocomplete="off" aria-autocomplete="none">
                                <h3 class="text-center text-info">Register</h3>
                                <div class="form-group">
                                    <label for="name" class="text-info">Nama:</label><br>
                                    <input type="text" name="name" id="name" class="form-control" required aria-required="true">
                                </div>
                                <div class="form-group">
                                    <label for="email" class="text-info">Email:</label><br>
                                    <input type="text" name="email" id="email" class="form-control" required aria-required="true">
                                </div>
                                <div class="form-group">
                                    <label for="no_telp" class="text-info">No Telp:</label><br>
                                    <input type="number" name="no_telp" id="no_telp" class="form-control" required aria-required="true">
                                </div>
                                <div class="form-group">
                                    <label for="alamat" class="text-info">Alamat:</label><br>
                                    <textarea name="alamat" id="alamat" cols="3" rows="3" class="form-control" required aria-required="true"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="password" class="text-info">Password:</label><br>
                                    <input type="password" name="password" id="password" class="form-control" required aria-required="true">
                                </div>
                                <div class="form-group d-flex justify-content-end">
                                    <input type="submit" style="margin-top: 25px;margin-right: 10px;" name="submit" class="btn btn-info form-control" value="Register">
                                </div>
                                <div class="form-group d-flex justify-content-center" style="margin-top: 20px;">
                                    <a href="index.php">Have a Account?</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>