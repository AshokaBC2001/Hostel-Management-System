<nav class="navbar top-navbar navbar-expand-md">

    <style>
        /* Round dropdown menu corners */
        .user-dd {
            border-radius: 0.75rem !important;
            overflow: hidden;
            box-shadow: 0 6px 20px rgba(0,0,0,0.15);
        }
    </style>

    <div class="navbar-header" data-logobg="skin6">
        <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)">
            <i class="ti-menu ti-close"></i>
        </a>

        <div class="navbar-brand">
            <a href="dashboard.php">
                <span class="logo-text">
                    <img src="../assets/images/hub.png" alt="homepage" class="dark-logo" />
                </span>
            </a>
        </div>

        <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)"
            data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
            aria-expanded="false" aria-label="Toggle navigation">
            <i class="ti-more"></i>
        </a>
    </div>

    <div class="navbar-collapse collapse" id="navbarSupportedContent">

        <ul class="navbar-nav float-left mr-auto ml-3 pl-1">
        </ul>

        <ul class="navbar-nav float-right">
            <li class="nav-item dropdown">

                <a class="nav-link dropdown-toggle" href="javascript:void(0)" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">

                    <img src="../assets/images/users/admin-icn.png" alt="user" class="rounded-circle" width="35">

                    <?php	
                        $aid = $_SESSION['id'];
                        $ret = "SELECT * from admin where id=?";
                        $stmt = $mysqli->prepare($ret);
                        $stmt->bind_param('i', $aid);
                        $stmt->execute();
                        $res = $stmt->get_result();

                        while ($row = $res->fetch_object()) {
                    ?>

                    <span class="ml-2 d-none d-lg-inline-block">
                        <span>Hello,</span>
                        <span class="text-dark"><?php echo $row->username; } ?></span>
                        <i data-feather="chevron-down" class="svg-icon"></i>
                    </span>

                </a>

                <!-- Dropdown Menu with Rounded Corners -->
                <div class="dropdown-menu dropdown-menu-right user-dd animated flipInY">

                    <a class="dropdown-item" href="profile.php">
                        <i data-feather="user" class="svg-icon mr-2 ml-1"></i>
                        My Profile
                    </a>

                    <div class="dropdown-divider"></div>

                    <a class="dropdown-item" href="acc-setting.php">
                        <i data-feather="settings" class="svg-icon mr-2 ml-1"></i>
                        Account Setting
                    </a>

                    <div class="dropdown-divider"></div>

                    <a class="dropdown-item" href="logout.php">
                        <i data-feather="power" class="svg-icon mr-2 ml-1"></i>
                        Logout
                    </a>
                </div>

            </li>
        </ul>

    </div>
</nav>
