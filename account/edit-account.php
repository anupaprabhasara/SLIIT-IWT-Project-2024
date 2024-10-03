<?php include '../database/conn.php';?> 
<?php include '../partials/other/session.php';?>
<?php include '../partials/other/1-css-links.php';?>

<?php
    date_default_timezone_set('Asia/Colombo');

    if(!(isset($_SESSION['user_id']))) {
        header('Location: ../login/');
        $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
        exit();
    }
?>

<?php
    if(isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        $sql = "SELECT * FROM `bd_user` WHERE `bdu_id` = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $existingData = $result->fetch_assoc();

        if(!$existingData) {
            die("User record not found.");
        }
    }
    else {
        die("User ID is required.");
    }

    if(isset($_POST['update'])) {
        $fname = $_POST['first_name'];
        $lname = $_POST['last_name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $nic = $_POST['nic'];
        $gender = $_POST['gender'];
        $dob = $_POST['dob'];
        $city = $_POST['city'];
        $currentDateTime = date('Y-m-d H:i:s');

        $updateFields = [];
        $params = [];
        $types = '';

        if($fname !== $existingData['bdu_fname']) {
            $updateFields[] = "`bdu_fname` = ?";
            $params[] = $fname;
            $types .= 's';
        }

        if($lname !== $existingData['bdu_lname']) {
            $updateFields[] = "`bdu_lname` = ?";
            $params[] = $lname;
            $types .= 's';
        }

        if($email !== $existingData['bdu_email']) {
            $updateFields[] = "`bdu_email` = ?";
            $params[] = $email;
            $types .= 's';
        }

        if($phone !== $existingData['bdu_phone']) {
            $updateFields[] = "`bdu_phone` = ?";
            $params[] = $phone;
            $types .= 'i';
        }

        if($nic !== $existingData['bdu_nic']) {
            $updateFields[] = "`bdu_nic` = ?";
            $params[] = $nic;
            $types .= 'i';
        }

        if($gender !== $existingData['bdu_gender']) {
            $updateFields[] = "`bdu_gender` = ?";
            $params[] = $gender;
            $types .= 's';
        }

        if($dob !== $existingData['bdu_dob']) {
            $updateFields[] = "`bdu_dob` = ?";
            $params[] = $dob;
            $types .= 's';
        }

        if($city !== $existingData['bdu_n_city']) {
            $updateFields[] = "`bdu_n_city` = ?";
            $params[] = $city;
            $types .= 'i';
        }
        
        if(isset($_FILES['profile_pic']['tmp_name']) && !empty($_FILES['profile_pic']['tmp_name'])) {
            $profilepic = file_get_contents($_FILES['profile_pic']['tmp_name']);
            $updateFields[] = "`profile_pic` = ?";
            $params[] = $profilepic;
            $types .= 'b';
        }

        $updateFields[] = "`last_updated` = ?";
        $params[] = $currentDateTime;
        $types .= 's';

        if(!empty($updateFields)) {
            $sql = "UPDATE `bd_user` SET " . implode(', ', $updateFields) . " WHERE `bdu_id` = ?";
            $params[] = $user_id;
            $types .= 'i';

            $stmt = $conn->prepare($sql);
            $stmt->bind_param($types, ...$params);

            if(isset($_FILES['profile_pic']['tmp_name']) && !empty($_FILES['profile_pic']['tmp_name'])) {
                $stmt->send_long_data(array_search('b', str_split($types)), $profilepic);
            }

            if($stmt->execute()) {
                header("Location: ./");
                exit();
            }
            else {
                echo "Error: " . $stmt->error;
                header("Location: ./");
                exit();
            }
        } 
        else {
            echo "No changes detected.";
        }

        $stmt->close();
        $conn->close();
    }
?>

<title>Edit Account</title>
<style>
    .edit-form-container {
        margin: 32px 0 5px;
        padding: 32px;
        background-color: #f9f9f9;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: center;
    }

    .edit-form-container img {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
        margin: 0 40px 0 10px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .edit-form-container form {
        flex-grow: 1;
    }

    .edit-form-container form .form-group {
        margin-bottom: 15px;
    }

    .edit-form-container form label {
        font-weight: bold;
        display: block;
        margin-bottom: 5px;
    }

    .edit-form-container form input,
    .edit-form-container form select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 1em;
        box-sizing: border-box;
    }

    .action-buttons {
        margin-top: 20px;
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

    .save-btn {
        background-color: #4CAF50;
        color: white;
    }

    .save-btn:hover {
        background-color: #45a049;
    }

    .cancel-btn {
        background-color: #f44336;
        color: white;
    }

    .cancel-btn:hover {
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
        <h2>Edit Account</h2>
        
        <div class="edit-form-container">
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
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($existingData['bdu_fname'] ?? ''); ?>">
                </div>

                <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($existingData['bdu_lname'] ?? ''); ?>">
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($existingData['bdu_email'] ?? ''); ?>">
                </div>

                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="tel" id="phone" name="phone" value="<?php echo "0" . htmlspecialchars($existingData['bdu_phone'] ?? ''); ?>">
                </div>

                <div class="form-group">
                    <label for="nic">NIC</label>
                    <input type="number" id="nic" name="nic" value="<?php echo htmlspecialchars($existingData['bdu_nic'] ?? ''); ?>">
                </div>

                <div class="form-group">
                    <label for="gender">Gender</label>
                    <select name="gender" required>
                        <option value="Female" <?php echo ($existingData['bdu_gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                        <option value="Male" <?php echo ($existingData['bdu_gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                        <option value="Rather not say" <?php echo ($existingData['bdu_gender'] == 'Rather not say') ? 'selected' : ''; ?>>Rather not say</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="dob">Date of Birth</label>
                    <input type="date" id="dob" name="dob" value="<?php echo "0" . htmlspecialchars($existingData['bdu_dob'] ?? ''); ?>">
                </div>

                <div class="form-group">
                    <label for="city">Nearest City</label>
                    <select name="city" required>
                        <?php
                            $result = $conn->query("SELECT city_id, city_name FROM city_info");
                                if ($result) {
                                    while ($row = $result->fetch_assoc()) {
                                        $selected = ($existingData['bdu_n_city'] == $row['city_id']) ? ' selected' : '';
                                        echo "<option value=\"" . $row['city_id'] . "\"" . $selected . ">" . $row['city_name'] . "</option>";
                                    }
                                }
                                else {
                                    echo "<option value=\"\">Error fetching data</option>";
                                }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="profile_pic">Profile Picture</label>
                    <input type="file" id="profile_pic" name="profile_pic" accept="image/*">
                </div>

                <div class="action-buttons">
                    <button type="submit" class="save-btn" name="update">Save Changes</button>
                    <button type="button" class="cancel-btn" onclick="window.location.href='./';">Cancel</button>
                </div>
            </form>
        </div>

    </div>
</div>

<?php include '../partials/other/3-footer-area.php';?>