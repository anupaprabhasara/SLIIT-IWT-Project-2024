<?php
    include '../../database/conn.php';
    include '../partials/forother/admin-session-update.php';
    
    date_default_timezone_set('Asia/Colombo');

    $loggedInAdminId = $_SESSION['admin_id'];

    if (isset($_GET['notifi_id'])) {
        $notifiId = $_GET['notifi_id'];

        $sql = "SELECT * FROM `notifi_info` WHERE `notifi_id` = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $notifiId);
        $stmt->execute();
        $result = $stmt->get_result();
        $existingData = $result->fetch_assoc();

        if (!$existingData) {
            die("Notification record not found.");
        }
    }
    else {
        die("Notification ID is required.");
    }

    if (isset($_POST['update'])) {
        $notifiId = $_POST['notifi_id'];
        $notifiType = $_POST['notifi_type'];
        $notifiTitle = $_POST['notifi_title'];
        $notifiMsg = $_POST['notifi_msg'];
        $notifiPriority = $_POST['notifi_priority'];
        $currentDateTime = date('Y-m-d H:i:s');

        $updateFields = [];
        $params = [];
        $types = '';

        if ($notifiType !== $existingData['notifi_type']) {
            $updateFields[] = "`notifi_type` = ?";
            $params[] = $notifiType;
            $types .= 's';
        }

        if ($notifiTitle !== $existingData['notifi_title']) {
            $updateFields[] = "`notifi_title` = ?";
            $params[] = $notifiTitle;
            $types .= 's';
        }

        if ($notifiMsg !== $existingData['notifi_msg']) {
            $updateFields[] = "`notifi_msg` = ?";
            $params[] = $notifiMsg;
            $types .= 's';
        }

        $updateFields[] = "`date_sent` = ?";
        $params[] = $currentDateTime;
        $types .= 's';

        if ($notifiPriority !== $existingData['notifi_priority']) {
            $updateFields[] = "`notifi_priority` = ?";
            $params[] = $notifiPriority;
            $types .= 's';
        }

        $updateFields[] = "`admin_id` = ?";
        $params[] = $loggedInAdminId;
        $types .= 'i';

        $updateFields[] = "`last_updated` = ?";
        $params[] = $currentDateTime;
        $types .= 's';

        if (!empty($updateFields)) {
            $sql = "UPDATE `notifi_info` SET " . implode(', ', $updateFields) . " WHERE `notifi_id` = ?";
            $params[] = $notifiId;
            $types .= 'i';

            $stmt = $conn->prepare($sql);
            $stmt->bind_param($types, ...$params);

            if ($stmt->execute()) {
                header("Location: ./");
                exit();
            } else {
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
    <h2>Edit Notification Details</h2>
    <form action="" method="post">
        <fieldset>
            <legend>Enter New Details:</legend>

            <input type="hidden" name="notifi_id" value="<?php echo htmlspecialchars($existingData['notifi_id'] ?? ''); ?>">

            Notification Type:<br>
            <select name="notifi_type" required>
                <option value="Event" <?php echo ($existingData['notifi_type'] == 'Event') ? 'selected' : ''; ?>>Event</option>
                <option value="Emergency" <?php echo ($existingData['notifi_type'] == 'Emergency') ? 'selected' : ''; ?>>Emergency</option>
                <option value="Alert" <?php echo ($existingData['notifi_type'] == 'Alert') ? 'selected' : ''; ?>>Alert</option>
                <option value="News" <?php echo ($existingData['notifi_type'] == 'News') ? 'selected' : ''; ?>>News</option>
            </select><br><br>

            Notification Title:<br>
            <input type="text" name="notifi_title" value="<?php echo htmlspecialchars($existingData['notifi_title'] ?? ''); ?>"><br><br>

            Notification Message:<br>
            <textarea name="notifi_msg"><?php echo htmlspecialchars($existingData['notifi_msg'] ?? ''); ?></textarea><br><br>

            Notification Priority:<br>
            <select name="notifi_priority" required>
                <option value="High" <?php echo ($existingData['notifi_priority'] == 'High') ? 'selected' : ''; ?>>High</option>
                <option value="Medium" <?php echo ($existingData['notifi_priority'] == 'Medium') ? 'selected' : ''; ?>>Medium</option>
                <option value="Low" <?php echo ($existingData['notifi_priority'] == 'Low') ? 'selected' : ''; ?>>Low</option>
            </select><br><br>

            <input type="submit" value="Update" name="update">
        </fieldset>
    </form>
</body>
</html>