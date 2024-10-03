<?php
    include '../../database/conn.php';
    include '../partials/forother/admin-session-index.php';
?>

<?php    
    $sql = "SELECT u.bdu_id,
                   u.bdu_fname,
                   u.bdu_lname,
                   u.profile_pic,
                   u.bdu_email,
                   u.bdu_phone
            FROM
                   bd_user u";         
    $result = $conn->query($sql);

    $profile_picture_base64 = base64_encode($user['profile_picture']);
?>

<?php include '../partials/forother/title-fav.php'; ?>
        .sidebar a.btn-2 {
            background-color: #00ffcc78;
        }
    <?php include '../partials/forother/nav-links.php'; ?>
    Manage Users
    <?php include '../partials/forother/pic-logout.php'; ?>
        <div class="content-area">
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Profile Picture</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>View More</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $profile_picture = base64_encode($row['profile_pic']);
                                    ?>
                                    <tr id="user-row-<?php echo $row['bdu_id']; ?>">
                                        <td><?php echo $row['bdu_id']; ?></td>
                                        <td>
                                            <?php
                                            if(isset($row['profile_pic'])) {
                                            ?>
                                            <img src="data:image/jpeg;base64,<?php echo $profile_picture; ?>" height="50px" width="50px" style="border-radius: 50px;">
                                            <?php
                                            }
                                            else {
                                            ?>
                                            <img src="../images/profile.jpg" height="50px" width="50px" style="border-radius: 50px;">
                                            <?php
                                            }
                                            ?>
                                        </td>
                                        <td><?php echo $row['bdu_fname']; ?></td>
                                        <td><?php echo $row['bdu_lname']; ?></td>
                                        <td>
                                            <a href="mailto:<?php echo $row['bdu_email']; ?>"><?php echo $row['bdu_email']; ?></a>
                                        </td>
                                        <td>
                                            <a href="tel:<?php echo "+94" . $row['bdu_phone']; ?>"><?php echo "0" . $row['bdu_phone']; ?></a>
                                        </td>
                                        <td>
                                            <a class="btn btn-info" href="view.php?id=<?php echo $row['bdu_id']; ?>">View</a>
                                        </td>
                                        <td>
                                            <a class="btn btn-danger" href="#" onclick="deleteUser(<?php echo $row['bdu_id']; ?>); return false;">Delete</a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                        ?>
                    </tbody>
                </table>
            </div>
    <script src="../script/delete-user.js"></script>
</body>
</html>