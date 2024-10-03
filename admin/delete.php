<?php
    include '../database/conn.php';
    include './partials/forroot/admin-session-delete.php';

    if((isset($_POST['admin_id'])) && $_SESSION['admin_id'] != $_POST['admin_id']) {
        $admin_id = $_POST['admin_id'];

        $conn->begin_transaction();

        try {
            $sql1 = "DELETE FROM notifi_info WHERE admin_id = ?";
            $stmt1 = $conn->prepare($sql1);
            $stmt1->bind_param("i", $admin_id);

            if (!$stmt1->execute()) {
                throw new Exception("Error deleting related records: " . $stmt1->error);
            }

            $stmt1->close();

            $sql2 = "DELETE FROM admin_info WHERE admin_id = ?";
            $stmt2 = $conn->prepare($sql2);
            $stmt2->bind_param("i", $admin_id);

            if (!$stmt2->execute()) {
                throw new Exception("Error deleting admin record: " . $stmt2->error);
            }

            $stmt2->close();

            $conn->commit();

            echo "success";
        } catch (Exception $e) {
            $conn->rollback();
            echo $e->getMessage();
        }
    }

    $conn->close();
?>