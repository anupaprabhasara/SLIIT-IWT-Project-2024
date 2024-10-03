<?php
    include '../../database/conn.php';
    include '../partials/forother/admin-session-index.php';

    if (isset($_GET['id'])) {
        $user_id = $_GET['id'];

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
                u.bdu_weight_kg, 
                ci.city_name, 
                bg.bg_type, 
                u.bdu_ldd, 
                u.bdu_fod_month 
            FROM 
                bd_user u
            LEFT JOIN 
                city_info ci ON u.bdu_n_city = ci.city_id
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

<!DOCTYPE html>
<html lang="en">
<?php include '../partials/forother/add-page.php'; ?>
<style>
    a {
        text-decoration: none;
        color: #800080;
    }

    .user-details {
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
        margin: 5px auto 20px auto;
    }

    .user-details strong {
        display: inline-block;
        width: 180px;
        margin: 0 20px 10px 0;
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
</style>
<body>
    <h2><?php echo $user['bdu_fname'] . " " . $user['bdu_lname']; ?><br></h2>
    <div class="user-details">
    <?php
    if(isset($user['profile_pic'])) {
    ?>
    <img src="data:image/jpeg;base64,<?php echo base64_encode($user['profile_pic']); ?>" height="150px" width="150px" style="border-radius: 75px;">
    <?php
    }
    else {
    ?>
    <img src="../images/profile.jpg" height="150px" width="150px" style="border-radius: 75px;">
    <?php
    }
    ?><br><br>
        <strong>First Name</strong> <?php echo ": " . $user['bdu_fname']; ?><br>
        <strong>Last Name</strong> <?php echo ": " . $user['bdu_lname']; ?><br>
        <strong>Email</strong> <?php echo ": "; ?><a href="mailto:<?php echo $user['bdu_email']; ?>"><?php echo $user['bdu_email']; ?></a><br>
        <strong>Phone</strong> <?php echo ": "; ?><a href="tel:<?php echo "+94" . $user['bdu_phone']; ?>"><?php echo "0" . $user['bdu_phone']; ?></a><br>
        <strong>NIC</strong> <?php echo ": " . $user['bdu_nic']; ?><br>
        <strong>Gender</strong> <?php echo ": " . $user['bdu_gender']; ?><br>
        <strong>Date of Birth</strong> <?php echo ": " . $user['bdu_dob']; ?><br>
        <strong>Weight</strong> <?php echo ": " . $user['bdu_weight_kg'] . " kg" ? ": " . $user['bdu_weight_kg'] . " kg" : 'N/A'; ?><br>
        <strong>Nearest City</strong> <?php echo ": " ; ?> <a href="../cities/"><?php echo $user['city_name']; ?></a><br>
        <strong>Blood Group</strong> <?php echo ": " ; ?> <a href="../blood-groups/"><?php echo $user['bg_type']; ?></a><br>
        <strong>Last Donation</strong> <?php echo ": " . $user['bdu_ldd'] ? ": " . $user['bdu_ldd'] : 'N/A'; ?><br>
        <strong>Frequency</strong> <?php echo ": 1 Donation / " . $user['bdu_fod_month'] . " Months" ? ": 1 Donation / " . $user['bdu_fod_month'] . " Months" : 'N/A'; ?><br>
        <br><br><a class="button" href="javascript:history.back()">Back</a>
    </div>
</body>
</html>