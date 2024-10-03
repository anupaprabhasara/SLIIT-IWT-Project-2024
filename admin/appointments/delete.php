<?php
    include '../../database/conn.php';
    include '../partials/forother/admin-session-delete.php';

    if(isset($_POST['appo_id'])) {
        $appo_id = $_POST['appo_id'];

        $sql = "DELETE FROM appo_info WHERE appo_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $appo_id);

        if($stmt->execute()) {
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