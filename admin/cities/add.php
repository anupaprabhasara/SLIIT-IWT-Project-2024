<?php
    include '../../database/conn.php';
    include '../partials/forother/admin-session-update.php';

    date_default_timezone_set('Asia/Colombo');

    if(isset($_POST['create'])) {
        $cityName = $_POST['city_name'];
        $provinceName = $_POST['province_name'];
        $postalCode = $_POST['postal_code'];
        $locationUrl = $_POST['location_url'];
        $population = $_POST['population'];
        $createdDate = date('Y-m-d H:i:s');

        $sql = "INSERT INTO `city_info` (`city_name`, `province_name`, `postal_code`, 
                                          `location_url`, `population`, `created_date`)
                VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssisis", $cityName, $provinceName, $postalCode, $locationUrl, $population, $createdDate);

        if($stmt->execute()) {
            header("Location: ./");
            exit();
        }
        else {
            echo "Error: " . $sql . "<br>" . $conn->error;
            header("Location: ./");
            exit();
        }

        $stmt->close();
        $conn->close();
    }
?>

<!DOCTYPE html>
<html lang="en">
<?php include '../partials/forother/add-page.php';?>
<body>
    <h2>Add New City</h2>
    <form action="" method="post">
        <fieldset>
            <legend>Enter Details:</legend>

            City Name:<br>
            <input type="text" name="city_name" required><br><br>

            Province Name:<br>
            <input type="text" name="province_name" required><br><br>

            Postal Code:<br>
            <input type="text" name="postal_code" required><br><br>

            Location URL:<br>
            <input type="text" name="location_url" required><br><br>

            Population:<br>
            <input type="text" name="population" required><br><br>

            <input type="submit" value="Create" name="create">
        </fieldset>
    </form>
</body>
</html>