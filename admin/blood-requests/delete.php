<?php
    include '../../database/conn.php';
    include '../partials/forother/admin-session-delete.php';

    if(isset($_POST['req_id'])) {
        $req_id = $_POST['req_id'];
    
        $sql = "DELETE FROM b_request_info WHERE req_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $req_id);
    
        if($stmt->execute()) {
            echo "success";
        } else {
            echo "Error: " . $conn->error;
        }

        $stmt->close();
    } else {
        echo "Invalid request!";
    }

    $conn->close();
?>