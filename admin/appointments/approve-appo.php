<?php
include '../../database/conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $appo_id = $_POST['appo_id'];

    $sql = "UPDATE appo_info SET appo_status = 'Approved' WHERE appo_id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        http_response_code(500);
        echo "Error preparing statement: " . $conn->error;
        exit;
    }

    $stmt->bind_param("i", $appo_id);

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