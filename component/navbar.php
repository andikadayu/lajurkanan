<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Lajur Kanan</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?php if (strpos($_SERVER['REQUEST_URI'], 'scrap.php') !== false) {
                                            echo 'active';
                                        } ?>" href="scrap.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if (strpos($_SERVER['REQUEST_URI'], 'shopee_page.php') !== false) {
                                            echo 'active';
                                        } ?>" href="shopee_page.php">byPass Shopee</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if (strpos($_SERVER['REQUEST_URI'], 'lazada_page.php') !== false) {
                                            echo 'active';
                                        } ?>" href="lazada_page.php">byPass Lazada</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if (strpos($_SERVER['REQUEST_URI'], 'profile.php') !== false) {
                                            echo 'active';
                                        } ?>" href="profile.php">Profile</a>
                </li>
                <?php if ($_SESSION['role'] == 'superadmin') { ?>
                    <li class="nav-item">
                        <a class="nav-link <?php if (strpos($_SERVER['REQUEST_URI'], 'manage_admin.php') !== false) {
                                                echo 'active';
                                            } ?>" href="manage_admin.php">Manage Admin</a>
                    </li>
                <?php } ?>
                <li class="nav-item">
                    <a class="nav-link" href="controller/logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>