<?php
    include '../../database/conn.php';
    include '../partials/forother/admin-session-update.php';
    
    date_default_timezone_set('Asia/Colombo');

    $loggedInAdminId = $_SESSION['admin_id'];

    if (isset($_POST['add'])) {
        $notifiType = $_POST['notifi_type'];
        $notifiTitle = $_POST['notifi_title'];
        $notifiMsg = $_POST['notifi_msg'];
        $notifiPriority = $_POST['notifi_priority'];
        $currentDateTime = date('Y-m-d H:i:s');

        $sql = "INSERT INTO `notifi_info` (`notifi_type`, `notifi_title`, `notifi_msg`, `notifi_priority`, `date_sent`, `admin_id`, `created_date`) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssis", $notifiType, $notifiTitle, $notifiMsg, $notifiPriority, $currentDateTime, $loggedInAdminId, $currentDateTime);

        if ($stmt->execute()) {
            header("Location: ./");
            exit();
        } else {
            echo "Error: " . $stmt->error;
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
    <h2>Add New Notification</h2>
    <form action="" method="post">
        <fieldset>
            <legend>Enter New Details:</legend>

            Notification Type:<br>
            <select name="notifi_type" required>
                <option value="Event">Event</option>
                <option value="Emergency">Emergency</option>
                <option value="Alert">Alert</option>
                <option value="News">News</option>
            </select><br><br>

            Notification Title:<br>
            <input type="text" name="notifi_title" required><br><br>

            Notification Message:<br>
            <textarea name="notifi_msg" required></textarea><br><br>

            Notification Priority:<br>
            <select name="notifi_priority" required>
                <option value="High">High</option>
                <option value="Medium">Medium</option>
                <option value="Low">Low</option>
            </select><br><br>

            <input type="submit" value="Add" name="add">
        </fieldset>
    </form>
</body>
</html>