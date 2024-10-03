<?php
    include '../../database/conn.php';
    include '../partials/forother/admin-session-index.php';
?>

<?php    
    $sql = "SELECT * FROM city_info";
    $result = $conn->query($sql);

    $profile_picture_base64 = base64_encode($user['profile_picture']);
?>

<?php include '../partials/forother/title-fav.php';?>
        .sidebar a.btn-8 {
            background-color: #00ffcc78;
        }
    <?php include '../partials/forother/nav-links.php';?>
    Manage Cities&nbsp;&nbsp;&nbsp;<a class="btn btn-info" href="./add.php">Add</a>
    <?php include '../partials/forother/pic-logout.php';?>
        <div class="content-area">
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>City ID</th>
                            <th>City Name</th>
                            <th>Province Name</th>
                            <th>Postal Code</th>
                            <th>Location URL</th>
                            <th>Population</th>
                            <th>Edit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    ?>
                                    <tr id="city-row-<?php echo $row['city_id']; ?>">
                                        <td>
                                            <?php echo $row['city_id']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['city_name']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['province_name']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['postal_code']; ?>
                                        </td>
                                        <td>
                                            <a href="<?php echo $row['location_url']; ?>" target="_blank">View Location</a>
                                        </td>
                                        <td>
                                            <?php echo $row['population']; ?>
                                        </td>
                                        <td>
                                            <a class="btn btn-info" href="./edit.php?city_id=<?php echo $row['city_id']; ?>">Edit</a>
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
    <script src="../script/delete-city.js"></script>
</body>
</html>