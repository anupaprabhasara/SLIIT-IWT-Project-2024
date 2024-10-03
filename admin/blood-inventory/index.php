<?php
    include '../../database/conn.php';
    include '../partials/forother/admin-session-index.php';
?>

<?php    
    $sql = "
    SELECT
        bdu.bdu_id as bdu_id,
        b.bi_id,
        bg.bg_type AS blood_type,
        bdu.bdu_fname AS donor_name,
        b.donation_id as donation_id,
        ci.city_name AS storage_location,
        b.component_type,
        b.collection_date,
        b.expiry_date,
        b.bi_quantity_ml,
        b.bi_status,
        b.created_date
    FROM b_invent_info b
    JOIN blood_group bg ON b.bg_id = bg.bg_id
    JOIN bd_user bdu ON b.donor_id = bdu.bdu_id
    JOIN city_info ci ON b.storage_loca_id = ci.city_id
    ORDER BY b.bi_id ASC";
    $result = $conn->query($sql);

    $profile_picture_base64 = base64_encode($user['profile_picture']);
?>

<?php include '../partials/forother/title-fav.php';?>
        .sidebar a.btn-7 {
            background-color: #00ffcc78;
        }
    <?php include '../partials/forother/nav-links.php';?>
    Blood Inventory
    <?php include '../partials/forother/pic-logout.php';?>
        <div class="content-area">
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Donation ID</th>
                            <th>BG</th>
                            <th>Donor</th>
                            <th>Storage Location</th>
                            <th>Component Type</th>
                            <th>Collected Date</th>
                            <th>Expiration Date</th>
                            <th>Quantity (mL)</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Do necessary changes for this section -->
                        <?php
                            if($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    ?>
                                    <tr id="inventory-row-<?php echo $row['bi_id']; ?>">
                                        <td>
                                            <?php echo $row['bi_id']; ?>
                                        </td>
                                        <td>
                                            <a href="../donations/"><?php echo $row['donation_id']; ?></a>
                                        </td>
                                        <td>
                                            <a href="../blood-groups/"><?php echo $row['blood_type']; ?></a>
                                        </td>
                                        <td>
                                            <a href="../users/view.php?id=<?php echo $row['bdu_id']; ?>"><?php echo $row['donor_name']; ?></a>
                                        </td>
                                        <td>
                                            <a href="../cities/"><?php echo $row['storage_location']; ?></a>
                                        </td>
                                        <td>
                                            <?php echo $row['component_type']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['collection_date']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['expiry_date']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['bi_quantity_ml']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['bi_status']; ?>
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
    <script src="../script/delete-invent.js"></script>
</body>
</html>