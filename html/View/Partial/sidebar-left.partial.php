<nav class="sidebar-left close">
    <header>
             <div class="image-text">
                <span class="image">
                    <?php if ($settings->getLogoFile()) : ?>
                        <img src="<?php echo $settings->getLogoFile() ?>" alt="logo">
                    <?php else : ?>
                    <img src="../../framework/assets/images/logo-learner.png" alt="logo">
                    <?php endif; ?>
                </span>
            </div>

        <i class='bx bx-chevron-right toggle'></i>
    </header>

    <div class="menu-bar">
        <div class="menu">

            <li class="search-box">
                <i class='bx bx-search icon'></i>
                <input type="text" placeholder="Search...">
            </li>

            <ul class="menu-links">
                <li class="nav-link">
                    <a href="/homePage">
                        <i class='bx bx-home-alt icon'></i>
                        <span class="text nav-text">Dashboard</span>
                    </a>
                </li>


                <li class="nav-link">
                    <a href="#">
                        <i class='bx bx-bell icon'></i>
                        <span class="text nav-text">Notifications</span>
                    </a>
                </li>

                <?php if( \App\Model\User::getUserConnected()->getRoleId() === 2 ):?>
                <li class="nav-link">

                        <a href="/courses">
                        <i class='bx bxs-graduation icon'></i>
                        <span class="text nav-text">My courses</span>
                    </a>
                </li>
                <?php endif; ?>


                <li class="nav-link">
                    <a href="/searchCourses">
                        <i class='bx bx-search icon'></i>
                        <span class="text nav-text">Search courses</span>
                    </a>
                </li>
                <li class="nav-link">
                    <a href="#">
                        <i class='bx bx-pie-chart-alt icon'></i>
                        <span class="text nav-text">Analytics</span>
                    </a>
                </li>

                <li class="nav-link">
                    <a href="#">
                        <i class='bx bx-wallet icon'></i>
                        <span class="text nav-text">Wallets</span>
                    </a>
                </li>

                <li class="nav-link">
                    <a href="/edit/profile">
                        <i class='bx bx-user-circle icon'></i>
                        <span class="text nav-text">My account</span>
                    </a>
                </li>

            </ul>
        </div>

        <div class="bottom-content">
            <li class="">
                <a href="/logout">
                    <i class='bx bx-log-out icon'></i>
                    <span class="text nav-text">Logout</span>
                </a>
            </li>

            <li class="mode">
                <div class="sun-moon">
                    <i class='bx bx-moon icon moon'></i>
                    <i class='bx bx-sun icon sun'></i>
                </div>
                <span class="mode-text text">Dark mode</span>

                <div class="toggle-switch">
                    <span class="switch"></span>
                </div>
            </li>

        </div>
    </div>

</nav>
