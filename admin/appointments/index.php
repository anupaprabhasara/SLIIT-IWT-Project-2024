<?php
    include '../../database/conn.php';
    include '../partials/forother/admin-session-index.php';
?>

<?php    
    $sql = "SELECT 
                appo_info.appo_id, 
                bd_user.bdu_id, 
                bd_user.bdu_fname, 
                bd_user.bdu_lname,
                city_info.city_name, 
                staff_info.sf_name, 
                staff_info.sl_name, 
                appo_info.appo_date, 
                appo_info.appo_type, 
                appo_info.appo_status
            FROM appo_info 
            JOIN bd_user ON appo_info.donor_id = bd_user.bdu_id 
            JOIN city_info ON appo_info.loca_id = city_info.city_id 
            JOIN staff_info ON appo_info.staff_id = staff_info.staff_id
            ORDER BY appo_info.appo_id ASC";
    
    $result = $conn->query($sql);

    $profile_picture_base64 = base64_encode($user['profile_picture']);
?>

<?php include '../partials/forother/title-fav.php';?>
        .sidebar a.btn-5 {
            background-color: #00ffcc78;
        }
        a:hover {
            cursor: pointer;
        }
    <?php include '../partials/forother/nav-links.php';?>
    Manage Appointments
    <?php include '../partials/forother/pic-logout.php';?>
        <div class="content-area">
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Appo NO</th>
                            <th>Full Name</th>
                            <th>Appo Date</th>
                            <th>City</th>
                            <th>Appointment Type</th>
                            <th>Status</th>
                            <th>Staff Name</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    ?>
                                    <tr id="appo-row-<?php echo $row['appo_id']; ?>">
                                        <td>
                                            <?php echo $row['appo_id']; ?>
                                        </td>
                                        <td>
                                            <a href="../users/view.php?id=<?php echo $row['bdu_id']; ?>"><?php echo $row['bdu_fname'] . ' ' . $row['bdu_lname']; ?></a>
                                        </td>
                                        <td>
                                            <?php echo $row['appo_date']; ?>
                                        </td>
                                        <td>
                                            <a href="../cities/"><?php echo $row['city_name']; ?></a>
                                        </td>
                                        <td>
                                            <?php echo $row['appo_type']; ?>
                                        </td>
                                        <td>
                                            <?php
                                                if ($row['appo_status'] == 'Pending') {
                                                    echo '<a class="btn btn-info" onclick="approveRequest(' . $row['appo_id'] . ')">Pending</a>';
                                                } else {
                                                    echo $row['appo_status'];
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <a href="../staff/"><?php echo $row['sf_name'] . ' ' . $row['sl_name']; ?></a>
                                        </td>
                                        <td>
                                            <a class="btn btn-danger" href="#" onclick="deleteAppo(<?php echo $row['appo_id']; ?>); return false;">Delete</a>
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
    <script src="../script/approve-appo.js"></script>
    <script src="../script/delete-appo.js"></script>
</body>
</html>