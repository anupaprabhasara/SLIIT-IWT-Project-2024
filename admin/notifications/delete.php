<?php
    include '../../database/conn.php';
    include '../partials/forother/admin-session-delete.php';

    if (isset($_POST['notifi_id'])) {
        $notifi_id = $_POST['notifi_id'];

        $sql = "DELETE FROM notifi_info WHERE notifi_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $notifi_id);

        if ($stmt->execute()) {
            echo "success";
        } else {
            echo "Error: " . $conn->error;
        }

        $stmt->close();
    }
    else {
        echo "Invalid request!";
    }

    $conn->close();
?>