<?php
    include '../database/conn.php';
    include './partials/forroot/admin-session-index.php';
?>

<?php    
    $sql = "SELECT * FROM admin_info";
    $result = $conn->query($sql);

    $profile_picture_base64 = base64_encode($user['profile_picture']);
?>

<?php include './partials/forroot/title-fav.php';?>
        .sidebar a.btn-1 {
            background-color: #00ffcc78;
        }
    <?php include './partials/forroot/nav-links.php';?>
    Manage Admins&nbsp;&nbsp;&nbsp;<a class="btn btn-info" href="./add.php">Add</a>
    <?php include './partials/forroot/pic-logout.php';?>
        <div class="content-area">
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Username</th>
                            <th>Profile Picture</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Role</th>
                            <th>Permissions</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    ?>
                                    <tr id="admin-row-<?php echo $row['admin_id']; ?>">
                                        <td>
                                            <?php echo $row['admin_id']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['a_f_name']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['a_l_name']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['username']; ?>
                                        </td>
                                        <td>
                                            <?php $profilepic = base64_encode($row['profile_picture']); ?>
                                            <?php
                                            if(isset($row['profile_picture'])) {
                                            ?>
                                            <img src="data:image/jpeg;base64,<?php echo $profilepic; ?>" height="50px" width="50px" style="border-radius: 50px;">
                                            <?php
                                            }
                                            else {
                                            ?>
                                            <img src="./images/profile.jpg" height="50px" width="50px" style="border-radius: 50px;">
                                            <?php
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <a href="mailto:<?php echo $row['admin_email']; ?>"><?php echo $row['admin_email']; ?></a>
                                        </td>
                                        <td>
                                            <a href="tel:<?php echo "+94" . $row['admin_phone']; ?>"><?php echo "0" . $row['admin_phone']; ?></a>
                                        </td>
                                        <td>
                                            <?php echo $row['role']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['permission']; ?>
                                        </td>
                                        <td>
                                            <a class="btn btn-info" href="./edit.php?admin_id=<?php echo $row['admin_id']; ?>">Edit</a>
                                        </td>
                                        <td>
                                        <a class="btn btn-danger" href="#" onclick="deleteAdmin(<?php echo $row['admin_id']; ?>); return false;">Delete</a>
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
    <script src="./script/delete-admin.js"></script>
</body>
</html>