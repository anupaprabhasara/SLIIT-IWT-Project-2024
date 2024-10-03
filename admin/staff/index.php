<?php
    include '../../database/conn.php';
    include '../partials/forother/admin-session-index.php';
?>

<?php    
    $sql = "
        SELECT staff_info.*, city_info.city_name 
        FROM staff_info 
        LEFT JOIN city_info ON staff_info.loca_id = city_info.city_id
    ";
    $result = $conn->query($sql);

    $profile_picture_base64 = base64_encode($user['profile_picture']);
?>

<?php include '../partials/forother/title-fav.php';?>
        .sidebar a.btn-3 {
            background-color: #00ffcc78;
        }
    <?php include '../partials/forother/nav-links.php';?>
    Staff Details&nbsp;&nbsp;&nbsp;<a class="btn btn-info" href="./add.php">Add</a>
    <?php include '../partials/forother/pic-logout.php';?>
        <div class="content-area">
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Position</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Depart</th>
                            <th>City</th>
                            <th>Employment Date</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    ?>
                                    <tr id="staff-row-<?php echo $row['staff_id']; ?>">
                                        <td>
                                            <?php echo $row['staff_id']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['sl_name']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['sf_name']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['position']; ?>
                                        </td>
                                        <td>
                                            <a class="btn btn-info" href="mailto:<?php echo $row['email']; ?>" title="<?php echo $row['email']; ?>">Compose</a>
                                        </td>
                                        <td>
                                            <a href="tel:<?php echo "+94" . $row['phone']; ?>"><?php echo "0" . $row['phone']; ?></a>
                                        </td>
                                        <td>
                                            <?php echo $row['department']; ?>
                                        </td>
                                        <td>
                                            <a href="../cities/"><?php echo $row['city_name']; ?></a>
                                        </td>
                                        <td>
                                            <?php echo $row['emplo_date']; ?>
                                        </td>
                                        <td>
                                            <a class="btn btn-info" href="./edit.php?staff_id=<?php echo $row['staff_id']; ?>">Edit</a>
                                        </td>
                                        <td>
                                        <a class="btn btn-danger" href="#" onclick="deleteStaff(<?php echo $row['staff_id']; ?>); return false;">Delete</a>
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
    <script src="../script/delete-staff.js"></script>
</body>
</html>