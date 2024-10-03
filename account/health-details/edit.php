<?php include '../../database/conn.php';?> 
<?php include '../../partials/account/session.php';?>
<?php include '../../partials/account/1-css-links.php';?>

<?php
    date_default_timezone_set('Asia/Colombo');

    if(!(isset($_SESSION['user_id']))) {
        header('Location: ../../login/');
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
        $blood = $_POST['bloodgroup'];
        $weight = $_POST['weight'];
        $fod = $_POST['fod'];
        $currentDateTime = date('Y-m-d H:i:s');

        $updateFields = [];
        $params = [];
        $types = '';

        if($blood !== $existingData['bdu_bg']) {
            $updateFields[] = "`bdu_bg` = ?";
            $params[] = $blood;
            $types .= 's';
        }

        if($weight !== $existingData['bdu_weight_kg']) {
            $updateFields[] = "`bdu_weight_kg` = ?";
            $params[] = $weight;
            $types .= 's';
        }

        if($fod !== $existingData['bdu_fod_month']) {
            $updateFields[] = "`bdu_fod_month` = ?";
            $params[] = $fod;
            $types .= 's';
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

<title>Edit Details</title>
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
<link rel="stylesheet" href="../../css/account.css">

<?php include '../../partials/account/2-nav-links.php';?>

<div class="container">
    <div class="leftside">
        <?php include '../partials/other/nav.php';?> 
    </div>
    <div class="rightside">
        <h2>Edit Health Details</h2>
        
        <div class="edit-form-container">
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
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="bloodgroup">Blood Group</label>
                    <select name="bloodgroup" required>
                    <?php
                        $result = $conn->query("SELECT bg_id, bg_type FROM blood_group");
                        if($result) {
                            while ($row = $result->fetch_assoc()) {
                                $selected = ($existingData['bdu_bg'] == $row['bg_id']) ? ' selected' : '';
                                echo "<option value=\"" . $row['bg_id'] . "\"" . $selected . ">" . $row['bg_type'] . "</option>";
                            }
                        }
                        else {
                            echo "<option value=\"\">Error fetching data</option>";
                        }
                    ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="weight">Weight (kg)</label>
                    <input type="number" id="weight" name="weight" value="<?php echo htmlspecialchars($existingData['bdu_weight_kg'] ?? ''); ?>">
                </div>

                <div class="form-group">
                    <label for="fod">Frequency of Donations</label>
                    <input type="number" id="fod" name="fod" value="<?php echo htmlspecialchars($existingData['bdu_fod_month'] ?? ''); ?>">
                </div>

                <div class="action-buttons">
                    <button type="submit" class="save-btn" name="update">Save Changes</button>
                    <button type="button" class="cancel-btn" onclick="window.location.href='./';">Cancel</button>
                </div>
            </form>
        </div>

    </div>
</div>

<?php include '../../partials/account/3-footer-area.php';?>