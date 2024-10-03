<?php
include '../../database/conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $req_id = $_POST['req_id'];

    $sql = "UPDATE b_request_info SET req_status = 'Approved' WHERE req_id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        http_response_code(500);
        echo "Error preparing statement: " . $conn->error;
        exit;
    }

    $stmt->bind_param("i", $req_id);

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