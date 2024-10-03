<?php
    include '../../database/conn.php';
    include '../partials/forother/admin-session-delete.php';

    if(isset($_POST['event_id'])) {
        $event_id = $_POST['event_id'];

        $conn->begin_transaction();

        try {
            $sql1 = "DELETE FROM feedback_info WHERE event_id = ?";
            $stmt1 = $conn->prepare($sql1);
            $stmt1->bind_param("i", $event_id);

            if (!$stmt1->execute()) {
                throw new Exception("Error deleting related records: " . $stmt1->error);
            }

            $stmt1->close();

            $sql2 = "DELETE FROM event_info WHERE event_id = ?";
            $stmt2 = $conn->prepare($sql2);
            $stmt2->bind_param("i", $event_id);

            if (!$stmt2->execute()) {
                throw new Exception("Error deleting event record: " . $stmt2->error);
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