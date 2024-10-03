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
<title>Appointment History</title>
<?php include '../../partials/account/2-nav-links.php'; ?>

<div class="container">
    <div class="leftside">
        <?php include '../partials/other/nav.php'; ?> 
    </div>
    <div class="rightside">
        
      

        <?php
        
        $user_id = $_SESSION['user_id']; 

      
        $sql = "SELECT * FROM appo_info WHERE donor_id = ?";
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
            <title>My Appointment History</title>
            <style>
                table {
                    width: 100%;
                    margin: 32px auto  10px;
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
                .status-Approved {
                    background-color: rgba(76, 175, 80, 0.7); 
                    padding: 5px 10px;
                    border-radius: 5px;
                    color: white;
                }
                .status-pending {
                    background-color: rgba(255, 235, 59, 0.7); 
                    padding: 5px 10px;
                    border-radius: 5px;
                    color: black;
                }
                
            </style>
        </head>
        <body>
            <h2>My Appointment History</h2>
            <table>
                <tr>
                    <th>Appointment Type</th>
                    <th>Status</th>
                    <th>Appointment Date</th>
                    <th>Created Date</th>
                </tr>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                       
                        $statusClass = '';
                        if ($row['appo_status'] === 'Pending') {
                            $statusClass = 'status-pending';
                        } elseif ($row['appo_status'] === 'Approved') {
                            $statusClass = 'status-Approved';
                        } 

                        echo "<tr>
                                <td>" . htmlspecialchars($row['appo_type']) . "</td>
                                <td><span class='" . $statusClass . "'>" . htmlspecialchars($row['appo_status']) . "</span></td>
                                <td>" . htmlspecialchars($row['appo_date']) . "</td>
                                <td>" . htmlspecialchars($row['created_date']) . "</td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4' style='text-align: center; padding: 20px;'>No appointment history available</td></tr>";
                }
                $stmt->close();
                $conn->close();
                ?>
            </table>
        </body>
        </html>
    </div>
</div>
<?php include '../../partials/account/3-footer-area.php'; ?>