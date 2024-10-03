<?php
    include '../../database/conn.php';
    include '../partials/forother/admin-session-index.php';
?>


<?php    
    $sql = "SELECT * FROM blood_group";
    $result = $conn->query($sql);
    
    $profile_picture_base64 = base64_encode($user['profile_picture']);
?>


<?php include '../partials/forother/title-fav.php';?>
        .sidebar a.btn-6 {
            background-color: #00ffcc78;
        }
    <?php include '../partials/forother/nav-links.php';?>
    Blood Groups
    <?php include '../partials/forother/pic-logout.php';?>
        <div class="content-area">
            <div class="table-wrapper">
                <table>
                    <thead>
                        
                        <tr>
                            <th>BG ID</th>
                            <th>ABO Type</th>
                            <th>Blood Group Type</th>
                            <th>Rare or Abundant</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                            if($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    ?>
                                    <tr id="blood-group-row-<?php echo $row['bg_id']; ?>">
                                        <td>
                                            <?php echo $row['bg_id']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['abo_type']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['bg_type']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['rare_or_not']; ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>