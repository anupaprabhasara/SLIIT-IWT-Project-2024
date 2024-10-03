<?php
    include '../../database/conn.php';
    include '../partials/forother/admin-session-delete.php';

    if(isset($_POST['fb_id'])) {
        $fb_id = $_POST['fb_id'];
    
        $sql = "DELETE FROM feedback_info WHERE fb_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $fb_id);
    
        if($stmt->execute()) {
            echo "success";
        }
        else {
            echo "Error: " . $conn->error;
        }

        $stmt->close();
    }
    else {
        echo "Invalid request!";
    }

    $conn->close();
?>