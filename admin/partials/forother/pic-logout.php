</div>
    <div class="user-info">
        <?php
        if(isset($user['profile_picture'])) {
        ?>
        <img src="data:image/jpeg;base64,<?php echo $profile_picture_base64; ?>" alt="Profile Picture">
        <?php
        }
        else {
        ?>
        <img src="../images/profile.jpg" alt="Profile Picture">
        <?php
        }
        ?>
        <span><?php echo $user['a_f_name'] . ' ' . $user['a_l_name']; ?></span>
        <a href="../logout.php" class="logout-btn">Logout</a>
    </div>
</div>