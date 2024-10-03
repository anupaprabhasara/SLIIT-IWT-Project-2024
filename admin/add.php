<?php
    include '../database/conn.php';
    include './partials/forroot/admin-session-update.php';

    date_default_timezone_set('Asia/Colombo');

    if(isset($_POST['create'])) {
        $username = $_POST['username'];
        $firstname = $_POST['a_f_name'];
        $lastname = $_POST['a_l_name'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
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
    
        if(isset($_FILES['profile_picture']['tmp_name']) && !empty($_FILES['profile_picture']['tmp_name'])) {
            $profilepic = file_get_contents($_FILES['profile_picture']['tmp_name']);

            $sql = "INSERT INTO `admin_info` (`username`, `a_f_name`, `a_l_name`, `password`, 
                                              `profile_picture`, `admin_email`, `admin_phone`, `role`, `permission`, `created_date`)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssbsssss", $username, $firstname, $lastname, $password, $profilepic, $email, $phone, $role, $permission, $currentDateTime);
        
            $stmt->send_long_data(4, $profilepic);
        }
        else {
            $sql = "INSERT INTO `admin_info` (`username`, `a_f_name`, `a_l_name`, `password`, 
                                              `admin_email`, `admin_phone`, `role`, `permission`, `created_date`)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssssss", $username, $firstname, $lastname, $password, $email, $phone, $role, $permission, $currentDateTime);
        }

        if($stmt->execute()) {
            header("Location: ./");
            exit();
        }
        else {
            echo "Error: " . $sql . "<br>" . $conn->error;
            header("Location: ./");
            exit();
        }

        $stmt->close();
        $conn->close();
    }
?>

<!DOCTYPE html>
<html lang="en">
<?php include './partials/forroot/add-page.php';?>
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
    <h2>Create New Admin</h2>
    <form action="" method="post" enctype="multipart/form-data">
        <fieldset>
            <legend>Enter Details:</legend>

            Username:<br>
            <input type="text" name="username" required><br><br>

            First Name:<br>
            <input type="text" name="a_f_name" required><br><br>

            Last Name:<br>
            <input type="text" name="a_l_name" required><br><br>

            Password:<br>
            <input type="password" name="password" required><br><br>

            Profile Picture:<br>
            <input type="file" name="profile_picture" accept="image/*"><br><br>

            Email:<br>
            <input type="text" name="admin_email" required><br><br>

            Phone:<br>
            <input type="text" name="admin_phone" required><br><br>

            Permissions:<br>
            <select name="permission" required>
                <option value="All">All</option>
                <option value="Read">Read</option>
                <option value="Update">Update</option>
            </select><br><br>

            <input type="submit" value="Create" name="create">
        </fieldset>
    </form>
</body>
</html>