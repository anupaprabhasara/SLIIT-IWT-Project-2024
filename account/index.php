<?php include '../database/conn.php';?> 
<?php include '../partials/other/session.php';?>
<?php include '../partials/other/1-css-links.php';?>

<?php
    if(!(isset($_SESSION['user_id']))) {
        header('Location: ../login/');
        $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
        exit();
    }
?>

<?php
    if(isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        $sql = "
            SELECT 
                u.bdu_id, 
                u.bdu_fname, 
                u.bdu_lname, 
                u.profile_pic, 
                u.bdu_email, 
                u.bdu_phone, 
                u.bdu_nic, 
                u.bdu_gender, 
                u.bdu_dob, 
                ci.city_name
            FROM 
                bd_user u
            LEFT JOIN 
                city_info ci ON u.bdu_n_city = ci.city_id
            WHERE 
                u.bdu_id = ?
        ";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
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

<title>My Account</title>
<style>
    .user-details {
        margin-top: 32px;
        padding: 32px;
        background-color: #f9f9f9;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: center;
    }

    .user-details img {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
        margin: 0 40px 0 10px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .user-details p {
        margin: 5px 0;
        font-size: 1.1em;
        color: #333;
    }

    .user-details .label {
        font-weight: bold;
    }

    .action-buttons {
        margin-top: 32px;
        display: flex;
        gap: 15px;
    }

    .action-buttons button {
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 1em;
        transition: background-color 0.3s ease;
    }

    .edit-btn {
        background-color: #4CAF50;
        color: white;
    }

    .edit-btn:hover {
        background-color: #45a049;
    }

    .delete-btn {
        background-color: #f44336;
        color: white;
    }

    .delete-btn:hover {
        background-color: #d32f2f;
    }
</style>
<link rel="stylesheet" href="../css/account.css">

<?php include '../partials/other/2-nav-links.php';?>

<div class="container">
    <div class="leftside">
        <?php include './partials/root/nav.php';?> 
    </div>
    <div class="rightside">
        <h2>My Account</h2>
        
        <div class="user-details">
            <?php
                if(isset($user['profile_pic'])) {
            ?>
            <img src="data:image/jpeg;base64,<?php echo base64_encode($user['profile_pic']); ?>" alt="Profile Picture">
            <?php
                }
                else {
            ?>
            <img src="../images/profile.jpg">
            <?php
                }
            ?>
            <div>
                <p><span class="label">Full Name:</span> <?php echo $user['bdu_fname'] . " " . $user['bdu_lname']; ?></p>
                <p><span class="label">Email:</span> <?php echo $user['bdu_email']; ?></p>
                <p><span class="label">Phone:</span> <?php echo "0" . $user['bdu_phone']; ?></p>
                <p><span class="label">NIC:</span> <?php echo $user['bdu_nic']; ?></p>
                <p><span class="label">Gender:</span> <?php echo $user['bdu_gender']; ?></p>
                <p><span class="label">Date of Birth:</span> <?php echo $user['bdu_dob']; ?></p>
                <p><span class="label">Nearest City:</span> <?php echo $user['city_name']; ?></p>
            </div>
        </div>

        <div class="action-buttons">
            <button class="edit-btn" onclick="window.location.href='./edit-account.php';">Edit Account</button>
            <button class="delete-btn" onclick="confirmDeleteRequest();">Request Account Deletion</button>
        </div>

    </div>
</div>

<script>
    function confirmDeleteRequest() {
        if (confirm('Are you sure you want to request account deletion? This action cannot be undone.')) {
            window.location.href = 'mailto:it23556584@my.sliit.lk?subject=Request Account Deletion&body=Reason';
        }
    }
</script>

<?php include '../partials/other/3-footer-area.php';?>