<?php include '../../database/conn.php';?>
<?php include '../../partials/account/session.php';?>
<?php include '../../partials/account/1-css-links.php';?>

<?php
    if(!(isset($_SESSION['user_id']))) {
        header('Location: ../../login/');
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
                u.profile_pic, 
                u.bdu_weight_kg,
                bg.bg_type, 
                u.bdu_ldd, 
                u.bdu_fod_month, 
                u.last_updated
            FROM 
                bd_user u
            LEFT JOIN 
                blood_group bg ON u.bdu_bg = bg.bg_id
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

<title>Health Details</title>
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
<link rel="stylesheet" href="../../css/account.css">
<?php include '../../partials/account/2-nav-links.php';?>
    <div class="container">
        <div class="leftside">
            <?php include '../partials/other/nav.php';?> 
        </div>
        <div class="rightside">
            <h2>Health Details</h2>
            <div class="user-details">
                <?php
                if(isset($user['profile_pic'])) {
                ?>
                <img src="data:image/jpeg;base64,<?php echo base64_encode($user['profile_pic']); ?>" alt="Profile Picture">
                <?php
                }
                else {
                ?>
                <img src="../../images/profile.jpg">
                <?php
                }
                ?>
                <div>
                    <p><span class="label">Blood Group:</span> <?php echo $user['bg_type']; ?></p>
                    <p><span class="label">Weight:</span> <?php echo $user['bdu_weight_kg'] . " kg"; ?></p>
                    <p><span class="label">Last Donation Date:</span> <?php if(isset($user['bdu_ldd'])) {echo $user['bdu_ldd'];} else {echo "You have not donated yet";} ?></p>
                    <p><span class="label">Frequency of Donations:</span> <?php echo "One Donation Every " . $user['bdu_fod_month'] . " Months"; ?></p>
                    <p><span class="label">Last Updated On:</span> <?php if(isset($user['last_updated'])) {echo $user['last_updated'];} else {echo "There have been no changes made yet";} ?></p>
                </div>
            </div>

            <div class="action-buttons">
                <button class="edit-btn" onclick="window.location.href='./edit.php';">Edit Details</button>
            </div>
        </div>
    </div>
<?php include '../../partials/account/3-footer-area.php';?>