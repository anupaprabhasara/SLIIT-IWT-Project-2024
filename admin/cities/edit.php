<?php
    include '../../database/conn.php';
    include '../partials/forother/admin-session-update.php';
    
    date_default_timezone_set('Asia/Colombo');

    if(isset($_GET['city_id'])) {
        $cityId = $_GET['city_id'];

        $sql = "SELECT * FROM `city_info` WHERE `city_id` = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $cityId);
        $stmt->execute();
        $result = $stmt->get_result();
        $existingData = $result->fetch_assoc();

        if(!$existingData) {
            die("City record not found.");
        }
    }
    else {
        die("City ID is required.");
    }

    if(isset($_POST['update'])) {
        $cityId = $_POST['city_id'];
        $cityName = $_POST['city_name'];
        $provinceName = $_POST['province_name'];
        $postalCode = $_POST['postal_code'];
        $locationUrl = $_POST['location_url'];
        $population = $_POST['population'];
        $currentDateTime = date('Y-m-d H:i:s');

        $updateFields = [];
        $params = [];
        $types = '';

        if($cityName !== $existingData['city_name']) {
            $updateFields[] = "`city_name` = ?";
            $params[] = $cityName;
            $types .= 's';
        }

        if($provinceName !== $existingData['province_name']) {
            $updateFields[] = "`province_name` = ?";
            $params[] = $provinceName;
            $types .= 's';
        }

        if($postalCode !== $existingData['postal_code']) {
            $updateFields[] = "`postal_code` = ?";
            $params[] = $postalCode;
            $types .= 'i';
        }

        if($locationUrl !== $existingData['location_url']) {
            $updateFields[] = "`location_url` = ?";
            $params[] = $locationUrl;
            $types .= 's';
        }

        if($population !== $existingData['population']) {
            $updateFields[] = "`population` = ?";
            $params[] = $population;
            $types .= 'i';
        }

        $updateFields[] = "`last_updated` = ?";
        $params[] = $currentDateTime;
        $types .= 's';

        if(!empty($updateFields)) {
            $sql = "UPDATE `city_info` SET " . implode(', ', $updateFields) . " WHERE `city_id` = ?";
            $params[] = $cityId;
            $types .= 'i';

            $stmt = $conn->prepare($sql);
            $stmt->bind_param($types, ...$params);

            if($stmt->execute()) {
                header("Location: ./");
                exit();
            }
            else {
                echo "Error: " . $stmt->error;
                header("Location: ./");
                exit();
            }
        } else {
            echo "No changes detected.";
        }

        $stmt->close();
        $conn->close();
    }
?>

<!DOCTYPE html>
<html lang="en">
<?php include '../partials/forother/edit-page.php';?>
<body>
    <h2>Edit City Details</h2>
    <form action="" method="post">
        <fieldset>
            <legend>Enter New Details:</legend>

            <input type="hidden" name="city_id" value="<?php echo htmlspecialchars($existingData['city_id'] ?? ''); ?>">

            City Name:<br>
            <input type="text" name="city_name" value="<?php echo htmlspecialchars($existingData['city_name'] ?? ''); ?>"><br><br>

            Province Name:<br>
            <input type="text" name="province_name" value="<?php echo htmlspecialchars($existingData['province_name'] ?? ''); ?>"><br><br>

            Postal Code:<br>
            <input type="text" name="postal_code" value="<?php echo htmlspecialchars($existingData['postal_code'] ?? ''); ?>"><br><br>

            Location URL:<br>
            <input type="text" name="location_url" value="<?php echo htmlspecialchars($existingData['location_url'] ?? ''); ?>"><br><br>

            Population:<br>
            <input type="text" name="population" value="<?php echo htmlspecialchars($existingData['population'] ?? ''); ?>"><br><br>

            <input type="submit" value="Update" name="update">
        </fieldset>
    </form>
</body>
</html>