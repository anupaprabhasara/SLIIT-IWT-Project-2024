<?php
    $currentPath = $_SERVER['REQUEST_URI'];

    if (strpos($currentPath, 'index.php') !== false) {
        header("Location: ./");
        exit();
    }
?>

<?php

function getAlerts($conn) {
    $alerts_query = "SELECT notifi_info.*, admin_info.a_f_name, admin_info.a_l_name, admin_info.profile_picture 
                     FROM notifi_info 
                     JOIN admin_info ON notifi_info.admin_id = admin_info.admin_id
                     ORDER BY notifi_info.created_date DESC
                     LIMIT 3";
    
    $alerts_result = mysqli_query($conn, $alerts_query);
    
    if (mysqli_num_rows($alerts_result) > 0) {
        $alerts = [];
        while ($row = mysqli_fetch_assoc($alerts_result)) {
            $alerts[] = $row;
        }
        return $alerts;
    } else {
        return [];
    }
}

$alerts = getAlerts($conn);
?>

<?php
    session_start();

    if(isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
    
        $sql = "SELECT bdu_fname, profile_pic FROM bd_user WHERE bdu_id = ?";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        
        $result = $stmt->get_result();
        
        if($result->num_rows > 0) {
            $user = $result->fetch_assoc();
        }
        $profile_picture_base64 = base64_encode($user['profile_pic']);
    }
?>