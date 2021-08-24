<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Login Page of Website">
    <title>Lajur Kanan Official</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.min.css">
    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</head>
<?php
include 'config.php';
session_start();
if (strpos($_SERVER['REQUEST_URI'], 'index.php') == false) {
    header("location:index.php");
}

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
                            <form id="login-form" class="form" action="controller/login_proccess.php" method="post" autocomplete="on" aria-autocomplete="both">
                                <h3 class="text-center text-info">Login</h3>
                                <div class="form-group">
                                    <label for="email" class="text-info">Email:</label><br>
                                    <input type="text" name="email" id="email" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="password" class="text-info">Password:</label><br>
                                    <input type="password" name="password" id="password" class="form-control">
                                </div>
                                <div class="form-group d-flex justify-content-end">
                                    <input type="submit" style="margin-top: 25px;margin-right: 10px;" name="submit" class="btn btn-info form-control" value="Login">
                                </div>
                                <div class="form-group d-flex justify-content-between" style="margin-top: 20px;">
                                    <a href="register.php">Register Account?</a>
                                    <a href="remember.php">Remember Password?</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'component/footer.php'; ?>

</body>

</html>