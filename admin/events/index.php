<?php
    include '../../database/conn.php';
    include '../partials/forother/admin-session-index.php';
?>

<?php    
    $sql = "
        SELECT 
            ei.event_id, 
            ei.event_name, 
            ci.city_name, 
            ei.event_date, 
            CONCAT(si.sf_name, ' ', si.sl_name) AS organizer_name,
            ei.event_type, 
            ei.capacity, 
            ei.status
        FROM 
            event_info ei
        JOIN 
            city_info ci ON ei.location_id = ci.city_id
        JOIN 
            staff_info si ON ei.organizer_id = si.staff_id
        ORDER BY 
            ei.event_id ASC
    ";
    $result = $conn->query($sql);

    $profile_picture_base64 = base64_encode($user['profile_picture']);
?>

<?php include '../partials/forother/title-fav.php';?>
        .sidebar a.btn-11 {
            background-color: #00ffcc78;
        }
    <?php include '../partials/forother/nav-links.php';?>
    Manage Events&nbsp;&nbsp;&nbsp;<a class="btn btn-info" href="./add.php">Create</a>
    <?php include '../partials/forother/pic-logout.php';?>
        <div class="content-area">
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Event ID</th>
                            <th>Event Name</th>
                            <th>City Name</th>
                            <th>Event Date</th>
                            <th>Organizer Name</th>
                            <th>Event Type</th>
                            <th>Capacity</th>
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
                                    <tr id="event-row-<?php echo $row['event_id']; ?>">
                                        <td><?php echo $row['event_id']; ?></td>
                                        <td><?php echo $row['event_name']; ?></td>
                                        <td><a href="../cities/"><?php echo $row['city_name']; ?></a></td>
                                        <td><?php echo $row['event_date']; ?></td>
                                        <td><a href="../staff/"><?php echo $row['organizer_name']; ?></a></td>
                                        <td><?php echo $row['event_type']; ?></td>
                                        <td><?php echo $row['capacity']; ?></td>
                                        <td><?php echo $row['status']; ?></td>
                                        <td>
                                            <a class="btn btn-info" href="./edit.php?event_id=<?php echo $row['event_id']; ?>">Edit</a>
                                        </td>
                                        <td>
                                            <a class="btn btn-danger" href="#" onclick="deleteEvent(<?php echo $row['event_id']; ?>); return false;">Delete</a>
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
    <script src="../script/delete-event.js"></script>
</body>
</html>