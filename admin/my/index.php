<?php
    include '../../database/conn.php';
    include '../partials/forother/admin-session-my.php';
?>

<?php    
    $sql = "SELECT * FROM admin_info";
    $result = $conn->query($sql);

    $profile_picture_base64 = base64_encode($user['profile_picture']);

    if (isset($_SESSION['admin_id'])) {
        $admin_id = $_SESSION['admin_id'];

        $sql = "
            SELECT 
                admin_id, 
                a_f_name, 
                a_l_name, 
                username, 
                profile_picture, 
                admin_email, 
                admin_phone, 
                role, 
                permission
            FROM 
                admin_info
            WHERE 
                admin_id = ?
        ";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $admin_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0) {
            $user = $result->fetch_assoc();
        }
        else {
            echo "No user found.";
            exit();
        }
    }
    else {
        echo "Invalid request.";
        exit();
    }
?>

<?php include '../partials/forother/title-fav.php';?>
    .sidebar a.btn-1 {
        background-color: #00ffcc78;
    }

    .admin-name-h2 {
        text-align: center;
    }
    
    .user-details {
        display: box;
        margin: 20px auto;
        width: 50%;
        padding: 25px;
        border: 1px solid #ddd;
        border-radius: 10px;
        max-width: 480px;
        background-color: #f9f9f9;
        box-sizing: border-box;
        text-align: left;
    }

    .user-details img {
        display: block;
        margin: 5px auto 10px auto;
    }

    .user-details strong {
        display: inline-block;
        width: 180px;
        margin: 0 10px 15px 15px;
        text-align: left;
        box-sizing: border-box;
    }

    .button {
        display: inline-block;
        width: 100%;
        background-color: #1abc9c;
        color: white;
        border: none;
        cursor: pointer;
        padding: 10px;
        border-radius: 4px;
        transition: background-color 0.3s ease;
        text-decoration: none;
        text-align: center;
        box-sizing: border-box;
    }

    .button:hover {
        background-color: #16a085;
    }
    <?php include '../partials/forother/nav-links.php';?>
    My Admin Profile
    <?php include '../partials/forother/pic-logout.php';?>
        <div class="content-area">
            <div class="table-wrapper">
                <h2 class="admin-name-h2"><?php echo $user['a_f_name'] . " " . $user['a_l_name']; ?><br></h2>
                <div class="user-details">
                    <?php
                        if(isset($user['profile_picture'])) {
                    ?>
                    <img src="data:image/jpeg;base64,<?php echo base64_encode($user['profile_picture']); ?>" height="150px" style="border-radius: 75px;">
                    <?php
                        }
                        else {
                    ?>
                    <img src="../images/profile.jpg" height="150px" style="border-radius: 75px;">
                    <?php
                        }
                    ?><br><br>
                    <strong>Full Name</strong> <?php echo ": " . $user['a_f_name'] . " " . $user['a_l_name']; ?><br>
                    <strong>Username</strong> <?php echo ": " . $user['username']; ?><br>
                    <strong>Email</strong> <?php echo ": " . $user['admin_email']; ?><br>
                    <strong>Phone</strong> <?php echo ": " . "0" . $user['admin_phone']; ?><br>
                    <strong>Role</strong> <?php echo ": " . $user['role']; ?><br>
                    <strong>Permission</strong> <?php echo ": " . $user['permission']; ?><br>
                </div>
            </div>
        </div>
    </div>
</body>
</html>