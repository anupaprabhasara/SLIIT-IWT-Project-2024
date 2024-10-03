<?php
    include '../../database/conn.php';
    include '../partials/forother/admin-session-index.php';
?>

<?php
    $sql = "SELECT n.*, a.a_f_name, a.a_l_name 
            FROM notifi_info n
            JOIN admin_info a ON n.admin_id = a.admin_id";
    $result = $conn->query($sql);

    $profile_picture_base64 = base64_encode($user['profile_picture']);
?>

<?php include '../partials/forother/title-fav.php'; ?>
    .sidebar a.btn-12 {
        background-color: #00ffcc78;
    }
<?php include '../partials/forother/nav-links.php'; ?>
Manage Notifications&nbsp;&nbsp;&nbsp;<a class="btn btn-info" href="./add.php">Create</a>
<?php include '../partials/forother/pic-logout.php'; ?>
    <div class="content-area">
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Created By</th>
                        <th>Type</th>
                        <th>Title</th>
                        <th>Message</th>
                        <th>Date Sent</th>
                        <th>Priority</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <tr id="notifi-row-<?php echo $row['notifi_id']; ?>">
                                    <td>
                                        <?php echo $row['notifi_id']; ?>
                                    </td>
                                    <td>
                                        <a href="../"><?php echo $row['a_f_name'] . ' ' . $row['a_l_name']; ?></a>
                                    </td>
                                    <td>
                                        <?php echo $row['notifi_type']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['notifi_title']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['notifi_msg']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['date_sent']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['notifi_priority']; ?>
                                    </td>
                                    <td>
                                        <a class="btn btn-info" href="./edit.php?notifi_id=<?php echo $row['notifi_id']; ?>">Edit</a>
                                    </td>
                                    <td>
                                        <a class="btn btn-danger" href="#" onclick="deleteNotification(<?php echo $row['notifi_id']; ?>); return false;">Delete</a>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo "<tr><td colspan='9'>No notifications found.</td></tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="../script/delete-notifi.js"></script>
</body>
</html>