<?php
include '../../database/conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fb_id = $_POST['fb_id'];

    $sql = "UPDATE feedback_info SET status = 'Approved' WHERE fb_id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        http_response_code(500);
        echo "Error preparing statement: " . $conn->error;
        exit;
    }

    $stmt->bind_param("i", $fb_id);

    if ($stmt->execute()) {
        echo "Success";
    } else {
        http_response_code(500);
        echo "Error executing query: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>