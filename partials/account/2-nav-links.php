</head>
<body>
    <header>
        <nav>
            <div class="nav__header">
                <div class="nav__logo">
                    <a href="../../" class="logo"><img src="../../images/logo.png"><span>HopeFlow</span></a>
                </div>
                <div class="nav__menu__btn" id="menu-btn">
                    <i class="ri-menu-line"></i>
                </div>
            </div>
            <ul class="nav__links" id="nav-links">
                <li><a href="../../donate/">Donate Blood</a></li>
                <li><a href="../../request/">Request Blood</a></li>
                <li><a href="../../events/">Events</a></li>
                <li><a href="../../appointment/">Appointment</a></li>
                <li><a href="../../about/">About</a></li>
                <li>
                    <?php
                        if(isset($_SESSION['user_id'])) {
                            ?>
                            <img src="data:image/jpeg;base64,<?php echo $profile_picture_base64; ?>" alt="Profile Picture">
                            <span><?php echo $user['bdu_fname']; ?></span>
                            <span><img src="../../images/down.svg"></span>
                            <?php
                        }
                        else {
                            ?>
                            <a href="../../login/"><button class="btn"><span><i class="ri-login-box-line"></i></span> Login</button></a>
                            <?php
                        }
                    ?>
                </li>
            </ul>
            <div class="nav__btns">
                <?php
                    if(isset($_SESSION['user_id'])) {
                        ?>
                        <div class="menuandalertbtn">
                        <div class="alertbtncount">
                        <span class="alertbtn"><img class="alertb" src="../../images/alert.svg"><img class="alertr" src="../../images/alert-r.svg"></span>
                            <span class="noticount"><p>
                            <?php
                                $sql = "SELECT COUNT(*) as count FROM notifi_info";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    $row = $result->fetch_assoc();
                                    $notifcount = $row['count'];
                                    if($notifcount == 0) {}
                                    else if($notifcount <= 3) {
                                        echo $notifcount;
                                    }
                                    else if($notifcount > 3) {
                                        echo '3';
                                    }
                                }
                            ?>
                            </p>
                        </span>
                        </div>
                        <div class="dropdown-contentx alerts-dropdownx">
                            <?php if (!empty($alerts)) { ?>
                                <?php foreach ($alerts as $alert) {
                                    $admin_picture_base64 = base64_encode($alert['profile_picture']);
                                ?>
                                    <div class="alert-itemx">
                                        <div class="alert-headerx">
                                            <span class="alert-typex"><?php echo $alert['notifi_type']; ?></span>
                                        </div>
                                        <div class="alert-contentx">
                                            <h4><?php echo $alert['notifi_title']; ?></h4>
                                            <p><?php echo $alert['notifi_msg']; ?></p>
                                        </div>
                                        <div class="alert-footerx">
                                            <div class="admin-infox">
                                                <?php
                                                if(isset($alert['profile_picture'])) {
                                                ?>
                                                <img src="data:image/jpeg;base64,<?php echo $admin_picture_base64; ?>" alt="Admin Picture" class="alert-admin-picx">
                                                <?php
                                                }
                                                else {
                                                ?>
                                                <img src="../../images/profile.jpg" alt="Admin Picture" class="alert-admin-picx">
                                                <?php
                                                }
                                                ?>
                                                <span><?php echo $alert['a_f_name'] . " " . $alert['a_l_name']; ?></span>
                                            </div>
                                            <span class="alert-datex"><?php echo date('Y-m-d', strtotime($alert['created_date'])); ?></span>
                                        </div>
                                    </div>
                                <?php } ?>

                            <?php } else { ?>
                                <p>No alerts available</p>
                            <?php } ?>
                        </div>
                        </div>
                            <?php
                                if(isset($user['profile_pic'])) {
                            ?>
                            <img class="profile-pic" src="data:image/jpeg;base64,<?php echo $profile_picture_base64; ?>" alt="Profile Picture">
                            <?php
                                }
                                else {
                            ?>
                            <img class="profile-pic" src="../../images/profile.jpg">
                            <?php
                                }
                            ?>
                        <span class="user-name"><?php echo $user['bdu_fname']; ?></span>
                        <div class="dropdown">
                            <span class="dropbtn"><img src="../../images/down.svg"></span>
                            <div class="dropdown-content">
                                <a href="../../account/">My Account</a>
                                <a href="../appointment-history/">Appointments</a>
                                <a href="../donation-history/">Donations</a>
                                <a href="../health-details/">Health Details</a>
                                <a href="../../logout.php" style="color: #ffffff; background-color: #f44336;" onmouseover="this.style.backgroundColor='#d32f2f';" onmouseout="this.style.backgroundColor='#f44336';">Sign Out</a>
                            </div>
                        </div>
                        <?php
                    }
                    else {
                        ?>
                        <a href="../../login/"><button class="btn"><span><i class="ri-login-box-line"></i></span> Login</button></a>
                        <?php
                    }
                ?>
            </div>
        </nav>