<?php
    $currentPath = $_SERVER['REQUEST_URI'];

    if (strpos($currentPath, 'index.php') !== false) {
        header("Location: ./");
        exit();
    }
?>

<?php
    session_start();
    
    if(!(($_SESSION['permission'] === 'Update') || ($_SESSION['permission'] === 'Read'))) {
        header('Location: ../');
        exit();
    }

    if(isset($_SESSION['admin_id'])) {
        $admin_id = $_SESSION['admin_id'];
    
        $sql = "SELECT a_f_name, a_l_name, profile_picture FROM admin_info WHERE admin_id = ?";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $admin_id);
        $stmt->execute();
        
        $result = $stmt->get_result();
        
        if($result->num_rows > 0) {
            $user = $result->fetch_assoc();
        }
        else {
            echo "User not found!";
        }
    }
?>