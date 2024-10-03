<?php
    include '../../database/conn.php';
    include '../partials/forother/admin-session-delete.php';

    if(isset($_POST['donation_id'])) {
        $donation_id = $_POST['donation_id'];
        
        $conn->begin_transaction();
        
        try {
            $sql_b_invent = "DELETE FROM b_invent_info WHERE donation_id = ?";
            $stmt_b_invent = $conn->prepare($sql_b_invent);
            $stmt_b_invent->bind_param("i", $donation_id);
            $stmt_b_invent->execute();
            $stmt_b_invent->close();
            
            $sql_donation_info = "DELETE FROM donation_info WHERE donation_id = ?";
            $stmt_donation_info = $conn->prepare($sql_donation_info);
            $stmt_donation_info->bind_param("i", $donation_id);
            $stmt_donation_info->execute();
            $stmt_donation_info->close();
            
            $conn->commit();
            echo "success";
        } catch (Exception $e) {
            $conn->rollback();
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Invalid request!";
    }

    $conn->close();
?>