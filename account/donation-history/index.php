<?php include '../../database/conn.php';?>
<?php include '../../partials/account/session.php';?>
<?php include '../../partials/account/1-css-links.php';?>

<?php
    if(!(isset($_SESSION['user_id']))) {
        header('Location: ../../login/');
        $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
        exit();
    }
?>

    <link rel="stylesheet" href="../../css/account.css">
    <title>Donation History</title>
<?php include '../../partials/account/2-nav-links.php';?>
    <div class="container">
        <div class="leftside">
            <?php include '../partials/other/nav.php';?> 
        </div>
        <div class="rightside">
         
            
       <?php


$user_id = $_SESSION['user_id']; 

$sql = "SELECT * FROM donation_info WHERE donor_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Donation History</title>
    <style>
        table {
            width: 100%;
            margin: 32px auto 10px;
            border-collapse: collapse;
            border-radius: 10px; 
            overflow: hidden; 
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: #ffc7c7;
        }
        tr:nth-child(odd) {
            background-color: #fff4f4;
        }

        .status-cancelled {
            background-color: rgb(255, 76, 76,0.7);
            padding:2px 5px; 
            border-radius:5px;
        }

        .status-completed {
            background-color: rgb(76,175,80,0.7); 
            padding:2px 5px;
            border-radius:5px;
        }
        .status-pending {
            background-color: rgb(255,235,59,0.7);
            padding:2px 5px;
            border-radius:5px;
        }
    </style>
</head>
<body>
    <h2>My Donation History</h2>
    <table>
        <tr>

            <th>Donation Type</th>
            <th>Quantity (ml)</th>
            <th>Status</th>
            <th>Donation Date</th>
           
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                
                $statusClass = '';
                if ($row['donation_status'] === 'Cancelled') {
                    $statusClass = 'status-cancelled';
                } elseif ($row['donation_status'] === 'Completed') {
                    $statusClass = 'status-completed';
                } elseif ($row['donation_status'] === 'Pending') {
                    $statusClass = 'status-pending';
                }

                echo "<tr>
                     
                        
                        <td>" . $row['donation_type'] . "</td>
                        <td>" . $row['d_quantity_ml'] . "</td>
                        <td><span class='status-box " . $statusClass . "'>" . $row['donation_status'] . "</span></td>
                        <td>" . $row['donation_date'] . "</td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='6' style='text-align: center; padding: 20px;'>No donation history available</td></tr>";

        }
        $stmt->close();
        $conn->close();
        ?>
    </table>
</body>
</html>

        </div>
    </div>
<?php include '../../partials/account/3-footer-area.php';?>