<?php
    include '../../database/conn.php';
    include '../partials/forother/admin-session-delete.php';

    if (isset($_POST['staff_id'])) { 
        $staff_id = $_POST['staff_id'];

        $conn->begin_transaction();

        try {
            $sql1 = "DELETE FROM feedback_info WHERE event_id IN (SELECT event_id FROM event_info WHERE organizer_id = ?)";
            $stmt1 = $conn->prepare($sql1);
            $stmt1->bind_param("i", $staff_id);
            if (!$stmt1->execute()) {
                throw new Exception("Error deleting related feedback_info records: " . $stmt1->error);
            }
            $stmt1->close();

            $sql2 = "DELETE FROM event_info WHERE organizer_id = ?";
            $stmt2 = $conn->prepare($sql2);
            $stmt2->bind_param("i", $staff_id);
            if (!$stmt2->execute()) {
                throw new Exception("Error deleting related event_info records: " . $stmt2->error);
            }
            $stmt2->close();

            $sql3 = "DELETE FROM appo_info WHERE staff_id = ?";
            $stmt3 = $conn->prepare($sql3);
            $stmt3->bind_param("i", $staff_id);
            if (!$stmt3->execute()) {
                throw new Exception("Error deleting related appo_info records: " . $stmt3->error);
            }
            $stmt3->close();

            $sql4 = "DELETE FROM donation_info WHERE staff_id = ?";
            $stmt4 = $conn->prepare($sql4);
            $stmt4->bind_param("i", $staff_id);
            if (!$stmt4->execute()) {
                throw new Exception("Error deleting related donation_info records: " . $stmt4->error);
            }
            $stmt4->close();

            $sql5 = "DELETE FROM staff_info WHERE staff_id = ?";
            $stmt5 = $conn->prepare($sql5);
            $stmt5->bind_param("i", $staff_id);
            if (!$stmt5->execute()) {
                throw new Exception("Error deleting staff record: " . $stmt5->error);
            }
            $stmt5->close();

            $conn->commit();

            echo "success";
        } catch (Exception $e) {
            $conn->rollback();
            echo $e->getMessage();
        }
    }

    $conn->close();
?>