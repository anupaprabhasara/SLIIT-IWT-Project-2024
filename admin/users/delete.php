<?php
    include '../../database/conn.php';
    include '../partials/forother/admin-session-delete.php';

    if (isset($_POST['user_id'])) {
        $user_id = $_POST['user_id'];

        $conn->begin_transaction();

        try {
            $sql1 = "DELETE FROM b_invent_info WHERE donor_id = ?";
            $stmt1 = $conn->prepare($sql1);
            $stmt1->bind_param("i", $user_id);
            if (!$stmt1->execute()) {
                throw new Exception("Error deleting from b_invent_info: " . $stmt1->error);
            }
            $stmt1->close();

            $sql2 = "DELETE FROM b_request_info WHERE requester = ?";
            $stmt2 = $conn->prepare($sql2);
            $stmt2->bind_param("i", $user_id);
            if (!$stmt2->execute()) {
                throw new Exception("Error deleting from b_request_info: " . $stmt2->error);
            }
            $stmt2->close();

            $sql3 = "DELETE FROM donation_info WHERE donor_id = ?";
            $stmt3 = $conn->prepare($sql3);
            $stmt3->bind_param("i", $user_id);
            if (!$stmt3->execute()) {
                throw new Exception("Error deleting from donation_info: " . $stmt3->error);
            }
            $stmt3->close();

            $sql4 = "DELETE FROM appo_info WHERE donor_id = ?";
            $stmt4 = $conn->prepare($sql4);
            $stmt4->bind_param("i", $user_id);
            if (!$stmt4->execute()) {
                throw new Exception("Error deleting from appo_info: " . $stmt4->error);
            }
            $stmt4->close();

            $sql5 = "DELETE FROM feedback_info WHERE user_id = ?";
            $stmt5 = $conn->prepare($sql5);
            $stmt5->bind_param("i", $user_id);
            if (!$stmt5->execute()) {
                throw new Exception("Error deleting from feedback_info: " . $stmt5->error);
            }
            $stmt5->close();

            $sql6 = "DELETE FROM bd_user WHERE bdu_id = ?";
            $stmt6 = $conn->prepare($sql6);
            $stmt6->bind_param("i", $user_id);
            if (!$stmt6->execute()) {
                throw new Exception("Error deleting from bd_user: " . $stmt6->error);
            }
            $stmt6->close();

            $conn->commit();

            echo "success";
        } catch (Exception $e) {
            $conn->rollback();
            echo $e->getMessage();
        }
    }

    $conn->close();
?>