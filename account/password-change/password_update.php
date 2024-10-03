<?php
    include '../../database/conn.php';
    session_start();

    if (isset($_POST['update'])) {
        $userId = $_SESSION['user_id'];
        $currentPassword = $_POST['cpass'];
        $newPassword = $_POST['npass'];

        if (empty($currentPassword) || empty($newPassword)) {
            echo 'Error: Please fill all required fields.';
            exit();
        }

        $query = "SELECT bdu_password FROM bd_user WHERE bdu_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $stmt->bind_result($storedPassword);
        $stmt->fetch();
        $stmt->close();

        if (!password_verify($currentPassword, $storedPassword)) {
            echo 'Error: Current password is incorrect.';
            exit();
        }

        $newHashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        $updateQuery = "UPDATE bd_user SET bdu_password = ?, last_updated = NOW() WHERE bdu_id = ?";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bind_param('si', $newHashedPassword, $userId);

        if ($updateStmt->execute()) {
            echo 'Password updated successfully.';
        } else {
            echo 'Error: Failed to update password. Please try again.';
        }

        $updateStmt->close();
    }
?>