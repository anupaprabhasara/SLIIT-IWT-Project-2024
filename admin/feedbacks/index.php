<?php
    include '../../database/conn.php';
    include '../partials/forother/admin-session-index.php';
?>

<?php    
    $sql = "SELECT fb.fb_id, fb.fb_type, e.event_name, u.bdu_id, u.bdu_fname, u.bdu_lname, fb.rating, fb.comments, fb.status, fb.created_date
            FROM feedback_info fb
            JOIN event_info e ON fb.event_id = e.event_id
            JOIN bd_user u ON fb.user_id = u.bdu_id";
    $result = $conn->query($sql);

    $profile_picture_base64 = base64_encode($user['profile_picture']);
?>

<?php include '../partials/forother/title-fav.php';?>
        .sidebar a.btn-10 {
            background-color: #00ffcc78;
        }
        a:hover {
            cursor: pointer;
        }
    <?php include '../partials/forother/nav-links.php';?>
    Manage Feedbacks
    <?php include '../partials/forother/pic-logout.php';?>
        <div class="content-area">
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Type</th>
                            <th>Event Name</th>
                            <th>User Name</th>
                            <th>Rating (1-5)</th>
                            <th>Comments</th>
                            <th>Status</th>
                            <th>Created Date</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    $user_name = $row['bdu_fname'] . ' ' . $row['bdu_lname'];
                                    ?>
                                    <tr id="feedback-row-<?php echo $row['fb_id']; ?>">
                                        <td>
                                            <?php echo $row['fb_id']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['fb_type']; ?>
                                        </td>
                                        <td>
                                            <a href="../events/"><?php echo $row['event_name']; ?></a>
                                        </td>
                                        <td>
                                            <a href="../users/view.php?id=<?php echo $row['bdu_id']; ?>"><?php echo $user_name; ?></a>
                                        </td>
                                        <td>
                                            <?php echo $row['rating']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['comments']; ?>
                                        </td>
                                        <td>
                                            <?php
                                                if ($row['status'] == 'Pending') {
                                                    echo '<a class="btn btn-info" onclick="approveRequest(' . $row['fb_id'] . ')">Pending</a>';
                                                }
                                                else {
                                                    echo $row['status'];
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <?php echo $row['created_date']; ?>
                                        </td>
                                        <td>
                                            <a class="btn btn-danger" href="#" onclick="deleteFeedback(<?php echo $row['fb_id']; ?>); return false;">Delete</a>
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
    <script src="../script/approve-feedback.js"></script>
    <script src="../script/delete-feedback.js"></script>
</body>
</html>