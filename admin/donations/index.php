<?php
    include '../../database/conn.php';
    include '../partials/forother/admin-session-index.php';
?>

<?php    
    $sql = "SELECT 
                di.donation_id,
                bu.bdu_id AS donor_id,
                bu.bdu_fname,
                CONCAT(bu.bdu_fname, ' ', bu.bdu_lname) AS donor_name,
                bg.bg_type,
                di.donation_date,
                di.donation_type,
                di.d_quantity_ml,
                si.sf_name,
                CONCAT(si.sf_name, ' ', si.sl_name) AS staff_name,
                di.donation_status
            FROM 
                donation_info di
            INNER JOIN 
                bd_user bu ON di.donor_id = bu.bdu_id
            INNER JOIN 
                blood_group bg ON di.bg_id = bg.bg_id
            INNER JOIN 
                staff_info si ON di.staff_id = si.staff_id
            ORDER BY di.donation_id ASC";
    $result = $conn->query($sql);

    $profile_picture_base64 = base64_encode($user['profile_picture']);
?>

<?php include '../partials/forother/title-fav.php';?>
        .sidebar a.btn-9 {
            background-color: #00ffcc78;
        }
    <?php include '../partials/forother/nav-links.php';?>
    Donation Details&nbsp;&nbsp;&nbsp;<a class="btn btn-info" href="./add.php">Create Record</a>
    <?php include '../partials/forother/pic-logout.php';?>
        <div class="content-area">
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Donor Name</th>
                            <th>Blood Group</th>
                            <th>Donation Date</th>
                            <th>Donation Type</th>
                            <th>Quantity (ml)</th>
                            <th>Staff Name</th>
                            <th>Status</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    ?>
                                    <tr id="donation-row-<?php echo $row['donation_id']; ?>">
                                        <td><?php echo $row['donation_id']; ?></td>
                                        <td><a href="../users/view.php?id=<?php echo $row['donor_id']; ?>" title="<?php echo $row['donor_name']; ?>"><?php echo $row['bdu_fname']; ?></a></td>
                                        <td><a href="../blood-groups/"><?php echo $row['bg_type']; ?></a></td>
                                        <td><?php echo $row['donation_date']; ?></td>
                                        <td><?php echo $row['donation_type']; ?></td>
                                        <td><?php echo $row['d_quantity_ml']; ?></td>
                                        <td><a href="../staff/" title="<?php echo $row['staff_name']; ?>"><?php echo $row['sf_name']; ?></a></td>
                                        <td><?php echo $row['donation_status']; ?></td>
                                        <td>
                                            <a class="btn btn-info" href="./edit.php?donation_id=<?php echo $row['donation_id']; ?>">Edit</a>
                                        </td>
                                        <td>
                                        <a class="btn btn-danger" href="#" onclick="deleteDonation(<?php echo $row['donation_id']; ?>); return false;">Delete</a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo "<tr><td colspan='11'>No records found.</td></tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="../script/delete-donation.js"></script>
</body>
</html>