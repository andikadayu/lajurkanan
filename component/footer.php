<?php if (strpos($_SERVER['REQUEST_URI'], 'index.php') !== false || strpos($_SERVER['REQUEST_URI'], 'register.php') !== false || strpos($_SERVER['REQUEST_URI'], 'remember.php') !== false) { ?>
    <footer class="footer bg-light text-center text-dark text-lg-start" style="position: relative;bottom: 0; width: 100%;left:0;margin-top: auto;">
        <!-- Copyright -->
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
            Developer By
            <a class="text-dark" href="https://cv-globalsolusindo.com">CV Global Solusindo</a>
        </div>
        <!-- Copyright -->
    </footer>
<?php } else { ?>

    <footer class="footer bg-primary text-center text-white text-lg-start" style="position: relative;bottom: 0; width: 100%;left:0;margin-top: auto;">
        <div class="container-fluid bg-primary">
            <!-- Copyright -->
            <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0);">
                Developer By
                <a class="text-white" href="https://cv-globalsolusindo.com">CV Global Solusindo</a>
            </div>
            <!-- Copyright -->
        </div>
    </footer>


<?php } ?>