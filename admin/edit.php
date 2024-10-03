<?php
    include '../database/conn.php';
    include './partials/forroot/admin-session-update.php';
    
    date_default_timezone_set('Asia/Colombo');

    if(isset($_GET['admin_id'])) {
        $adminId = $_GET['admin_id'];

        $sql = "SELECT * FROM `admin_info` WHERE `admin_id` = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $adminId);
        $stmt->execute();
        $result = $stmt->get_result();
        $existingData = $result->fetch_assoc();

        if(!$existingData) {
            die("Admin record not found.");
        }
    }
    else {
        die("Admin ID is required.");
    }

    if(isset($_POST['update'])) {
        $adminId = $_POST['admin_id'];
        $username = $_POST['username'];
        $firstname = $_POST['a_f_name'];
        $lastname = $_POST['a_l_name'];
        $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : $existingData['password'];
        $email = $_POST['admin_email'];
        $phone = $_POST['admin_phone'];
        $permission = $_POST['permission'];
        $currentDateTime = date('Y-m-d H:i:s');

        if($permission === 'All') {
            $role = 'Admin';
        }
        else if($permission === 'Read' || $permission === 'Update') {
            $role = 'Manager';
        }

        $updateFields = [];
        $params = [];
        $types = '';

        if($username !== $existingData['username']) {
            $updateFields[] = "`username` = ?";
            $params[] = $username;
            $types .= 's';
        }

        if($firstname !== $existingData['a_f_name']) {
            $updateFields[] = "`a_f_name` = ?";
            $params[] = $firstname;
            $types .= 's';
        }

        if($lastname !== $existingData['a_l_name']) {
            $updateFields[] = "`a_l_name` = ?";
            $params[] = $lastname;
            $types .= 's';
        }

        if($password !== $existingData['password']) {
            $updateFields[] = "`password` = ?";
            $params[] = $password;
            $types .= 's';
        }

        if($email !== $existingData['admin_email']) {
            $updateFields[] = "`admin_email` = ?";
            $params[] = $email;
            $types .= 's';
        }

        if($phone !== $existingData['admin_phone']) {
            $updateFields[] = "`admin_phone` = ?";
            $params[] = $phone;
            $types .= 's';
        }

        if ($permission !== $existingData['permission']) {
            $updateFields[] = "`role` = ?";
            $updateFields[] = "`permission` = ?";
            $params[] = $role;
            $params[] = $permission;
            $types .= 'ss';
        }
        
        if(isset($_FILES['profile_picture']['tmp_name']) && !empty($_FILES['profile_picture']['tmp_name'])) {
            $profilepic = file_get_contents($_FILES['profile_picture']['tmp_name']);
            $updateFields[] = "`profile_picture` = ?";
            $params[] = $profilepic;
            $types .= 'b';
        }

        $updateFields[] = "`last_updated` = ?";
        $params[] = $currentDateTime;
        $types .= 's';

        if(!empty($updateFields)) {
            $sql = "UPDATE `admin_info` SET " . implode(', ', $updateFields) . " WHERE `admin_id` = ?";
            $params[] = $adminId;
            $types .= 'i';

            $stmt = $conn->prepare($sql);
            $stmt->bind_param($types, ...$params);

            if(isset($_FILES['profile_picture']['tmp_name']) && !empty($_FILES['profile_picture']['tmp_name'])) {
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

<!DOCTYPE html>
<html lang="en">
<?php include './partials/forroot/edit-page.php';?>
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

        textarea {
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
    <h2>Update Admin</h2>
    <form action="" method="post" enctype="multipart/form-data">
        <fieldset>
            <legend>Enter Details:</legend>

            <input type="hidden" name="admin_id" value="<?php echo htmlspecialchars($existingData['admin_id'] ?? ''); ?>">

            Username:<br>
            <input type="text" name="username" value="<?php echo htmlspecialchars($existingData['username'] ?? ''); ?>"><br><br>

            First Name:<br>
            <input type="text" name="a_f_name" value="<?php echo htmlspecialchars($existingData['a_f_name'] ?? ''); ?>"><br><br>

            Last Name:<br>
            <input type="text" name="a_l_name" value="<?php echo htmlspecialchars($existingData['a_l_name'] ?? ''); ?>"><br><br>

            Password:<br>
            <input type="password" name="password" placeholder="Leave empty to keep current"><br><br>

            Profile Picture:<br>
            <input type="file" name="profile_picture"><br><br>

            Email:<br>
            <input type="text" name="admin_email" value="<?php echo htmlspecialchars($existingData['admin_email'] ?? ''); ?>"><br><br>

            Phone:<br>
            <input type="text" name="admin_phone" value="<?php echo htmlspecialchars($existingData['admin_phone'] ?? ''); ?>"><br><br>

            Permissions:<br>
            <select name="permission" required>
                <option value="All" <?php echo ($existingData['permission'] == 'All') ? 'selected' : ''; ?>>All</option>
                <option value="Read" <?php echo ($existingData['permission'] == 'Read') ? 'selected' : ''; ?>>Read</option>
                <option value="Update" <?php echo ($existingData['permission'] == 'Update') ? 'selected' : ''; ?>>Update</option>
            </select><br><br>

            <input type="submit" value="Update" name="update">
        </fieldset>
    </form>
</body>
</html>