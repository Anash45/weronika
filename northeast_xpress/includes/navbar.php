<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <!-- LOGO -->
        <a class="navbar-brand" href="index.php"> Northeast Xpress Inc. </a>
        <!-- HAMBURGER -->
        <button class="navbar-toggler d-lg-none d-xl-none" type="button" aria-label="Toggle navigation"
            aria-controls="overlayMenu" aria-expanded="false">
            <div class="hamburger">
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
        </button>
        <!-- MENU -->
        <div id="overlayMenu" class="overlay-menu" aria-hidden="true">
            <a href="index.php"><!--index logged in--> Home </a>
            <?php
            if (isUser()) {
                ?>
                <a href="profile.php"><!--profile of user logged in--> Profile </a>
                <a href="vehicles.php"> Your Vehicles </a>
                <a href="inbox.php"> Inbox </a>
                <a href="login.php"> Log Out </a>
                <?php
            } else {
                ?>
                <a href="login.php"> Log In </a>
                <a href="signup.php"> Book Now </a>
                <?php
            }
            ?>
        </div>
        <!-- MENU: HAMBURGER -->
        <ul id="navbar-links" class="navbar-nav ml-auto d-none d-lg-flex">
            <li class="nav-item">
                <a class="nav-link" href="index.php"> Home </a>
            </li>
            <?php
            if (isLoggedIn()) {
                ?>
                <li class="nav-item">
                    <a class="nav-link" href="profile.php"> Profile </a>
                </li>
                <?php
                if (isAdmin()) {
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="vehicles.php"> Vehicles </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="inbox.php"> Inbox </a>
                    </li>
                    <?php
                } else {
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="vehicles.php"> Your Vehicles </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="message.php"> Inbox </a>
                    </li>
                    <?php
                }
                ?>
                <?php
            } else {
                ?>
                <li class="nav-item">
                    <a class="nav-link" href="login.php"> Log in </a>
                </li>
                <?php
            }
            ?>
        </ul>
        <?php
        if (isLoggedIn()) {
            ?>
            <a id="log-out-button" href="logout.php" class="log-out-button d-none d-lg-block"> Log Out </a>
            <?php
        } else {
            ?>
            <a id="log-out-button" href="signup.php" class="log-out-button d-none d-lg-block"> Book Now </a>
            <?php
        }
        ?>
    </div>
</nav>