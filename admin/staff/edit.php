<?php
    include '../../database/conn.php';
    include '../partials/forother/admin-session-update.php';
    
    date_default_timezone_set('Asia/Colombo');

    if(isset($_GET['staff_id'])) {
        $staffId = $_GET['staff_id'];

        $sql = "
            SELECT s.*, c.city_name 
            FROM staff_info s 
            JOIN city_info c ON s.loca_id = c.city_id 
            WHERE s.staff_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $staffId);
        $stmt->execute();
        $result = $stmt->get_result();
        $existingData = $result->fetch_assoc();

        if(!$existingData) {
            die("Staff record not found.");
        }
    }
    else {
        die("Staff ID is required.");
    }

    if(isset($_POST['update'])) {
        $staffId = $_POST['staff_id'];
        $firstname = $_POST['sf_name'];
        $lastname = $_POST['sl_name'];
        $position = $_POST['position'];
        $email = $_POST['email'];
        $department = $_POST['department'];
        $phone = $_POST['phone'];
        $locaId = $_POST['city_id'];
        $emploDate = $_POST['emplo_date'];
        $currentDateTime = date('Y-m-d H:i:s');

        $updateFields = [];
        $params = [];
        $types = '';

        if($firstname !== $existingData['sf_name']) {
            $updateFields[] = "sf_name = ?";
            $params[] = $firstname;
            $types .= 's';
        }

        if($lastname !== $existingData['sl_name']) {
            $updateFields[] = "sl_name = ?";
            $params[] = $lastname;
            $types .= 's';
        }

        if($position !== $existingData['position']) {
            $updateFields[] = "position = ?";
            $params[] = $position;
            $types .= 's';
        }

        if($email !== $existingData['email']) {
            $updateFields[] = "email = ?";
            $params[] = $email;
            $types .= 's';
        }

        if($department !== $existingData['department']) {
            $updateFields[] = "department = ?";
            $params[] = $department;
            $types .= 's';
        }

        if($phone !== $existingData['phone']) {
            $updateFields[] = "phone = ?";
            $params[] = $phone;
            $types .= 'i';
        }

        if($locaId !== $existingData['loca_id']) {
            $updateFields[] = "loca_id = ?";
            $params[] = $locaId;
            $types .= 'i';
        }

        if($emploDate !== $existingData['emplo_date']) {
            $updateFields[] = "emplo_date = ?";
            $params[] = $emploDate;
            $types .= 's';
        }

        $updateFields[] = "last_updated = ?";
        $params[] = $currentDateTime;
        $types .= 's';

        if(!empty($updateFields)) {
            $sql = "UPDATE staff_info SET " . implode(', ', $updateFields) . " WHERE staff_id = ?";
            $params[] = $staffId;
            $types .= 'i';

            $stmt = $conn->prepare($sql);
            $stmt->bind_param($types, ...$params);

            if($stmt->execute()) {
                header("Location: ./");
                exit();
            } else {
                echo "Error: " . $stmt->error;
                header("Location: ../");
                exit();
            }
        } else {
            echo "No changes detected.";
        }

        $stmt->close();
        $conn->close();
    }
?>

<!DOCTYPE html>
<html lang="en">
<?php include '../partials/forother/edit-page.php';?>
    <style>
        select {
            width: 100%;
            padding: 10px;
            border-radius: 4px;
            margin-top: 10px;
            border: 1px solid #ccc;
            background-color: #fff;
            background-image: url('data:image/svg+xml;charset=UTF-8,%3Csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"%3E%3Cpath d="M7 10l5 5 5-5H7z" fill="%23888"/%3E%3C/svg%3E');
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 16px 16px;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }

        textarea, input[type=date] {
            width: 100%;
            margin-top: 10px;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
            box-sizing: border-box;
            resize: vertical;
        }

        @media (max-width: 600px) {
            select, textarea {
                width: 100%;
            }
        }
    </style>
<body>
    <h2>Edit Staff Member Details</h2>
    <form action="" method="post">
        <fieldset>
            <legend>Enter New Details:</legend>

            <input type="hidden" name="staff_id" value="<?php echo htmlspecialchars($existingData['staff_id'] ?? ''); ?>">

            First Name:<br>
            <input type="text" name="sf_name" value="<?php echo htmlspecialchars($existingData['sf_name'] ?? ''); ?>"><br><br>

            Last Name:<br>
            <input type="text" name="sl_name" value="<?php echo htmlspecialchars($existingData['sl_name'] ?? ''); ?>"><br><br>

            Position:<br>
            <input type="text" name="position" value="<?php echo htmlspecialchars($existingData['position'] ?? ''); ?>"><br><br>

            Email:<br>
            <input type="text" name="email" value="<?php echo htmlspecialchars($existingData['email'] ?? ''); ?>"><br><br>

            Department:<br>
            <input type="text" name="department" value="<?php echo htmlspecialchars($existingData['department'] ?? ''); ?>"><br><br>

            Phone:<br>
            <input type="text" name="phone" value="<?php echo htmlspecialchars($existingData['phone'] ?? ''); ?>"><br><br>

            City:<br>
            <select name="city_id">
                <?php
                    $citySql = "SELECT city_id, city_name FROM city_info";
                    $cityResult = $conn->query($citySql);

                    while ($cityRow = $cityResult->fetch_assoc()) {
                        $selected = $existingData['loca_id'] == $cityRow['city_id'] ? 'selected' : '';
                        echo "<option value='{$cityRow['city_id']}' $selected>{$cityRow['city_name']}</option>";
                    }
                ?>
            </select><br><br>

            Employment Date:<br>
            <input type="date" name="emplo_date" value="<?php echo htmlspecialchars($existingData['emplo_date'] ?? ''); ?>"><br><br>

            <input type="submit" value="Update" name="update">
        </fieldset>
    </form>
</body>
</html>