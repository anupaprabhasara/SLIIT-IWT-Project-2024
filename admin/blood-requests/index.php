<?php
    include '../../database/conn.php';
    include '../partials/forother/admin-session-index.php';
?>

<?php
    $sql = "
        SELECT
            u.bdu_id as bdu_id,
            b.req_id,
            u.bdu_fname,
            u.bdu_lname,
            bg.bg_type AS blood_type,
            b.component_type,
            b.quant_req_ml,
            b.req_date,
            b.required_date,
            b.req_status,
            c.city_name AS location,
            b.req_reason,
            b.created_date
        FROM b_request_info b
        JOIN bd_user u ON b.requester = u.bdu_id
        JOIN blood_group bg ON b.bg_id = bg.bg_id
        JOIN city_info c ON b.req_loca_id = c.city_id
        ORDER BY b.req_id ASC
    ";
    $result = $conn->query($sql);

    $profile_picture_base64 = base64_encode($user['profile_picture']);
?>

<?php include '../partials/forother/title-fav.php';?>
        .sidebar a.btn-4 {
            background-color: #00ffcc78;
        }
        a:hover {
            cursor: pointer;
        }
<?php include '../partials/forother/nav-links.php';?>
    Blood Requests
<?php include '../partials/forother/pic-logout.php';?>

    <div class="content-area">
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Requester Name</th>
                        <th>Blood Type</th>
                        <th>Component Type</th>
                        <th>Quantity (ml)</th>
                        <th>Request Date</th>
                        <th>Required Date</th>
                        <th>Status</th>
                        <th>Location</th>
                        <th>Reason</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                    ?>
                    <tr id="request-row-<?php echo $row['req_id']; ?>">
                        <td><?php echo $row['req_id']; ?></td>
                        <td>
                            <a href="../users/view.php?id=<?php echo $row['bdu_id']; ?>" title="<?php echo $row['bdu_fname'] . " " . $row['bdu_lname']; ?>"><?php echo $row['bdu_fname']; ?></a>
                        </td>
                        <td>
                            <a href="../blood-groups/"><?php echo $row['blood_type']; ?></a>
                        </td>
                        <td><?php echo $row['component_type']; ?></td>
                        <td><?php echo $row['quant_req_ml']; ?></td>
                        <td><?php echo $row['req_date']; ?></td>
                        <td><?php echo $row['required_date']; ?></td>
                        <td>
                            <?php
                                if ($row['req_status'] == 'Pending') {
                                    echo '<a class="btn btn-info" onclick="approveRequest(' . $row['req_id'] . ')">Pending</a>';
                                } else {
                                    echo $row['req_status'];
                                }
                            ?>
                        </td>
                        <td>
                            <a href="../cities/"><?php echo $row['location']; ?></a>
                        </td>
                        <td><?php echo $row['req_reason']; ?></td>
                        <td>
                            <a class="btn btn-danger" href="#" onclick="deleteRequest(<?php echo $row['req_id']; ?>); return false;">Delete</a>
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
    <script src="../script/approve-req.js"></script>
    <script src="../script/delete-request.js"></script>
</body>
</html>