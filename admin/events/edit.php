<?php
    include '../../database/conn.php';
    include '../partials/forother/admin-session-update.php';

    date_default_timezone_set('Asia/Colombo');

    if(isset($_GET['event_id'])) {
        $eventId = $_GET['event_id'];

        $sql = "
            SELECT e.*, s.sf_name AS organizer_name, c.city_name AS location_name 
            FROM event_info e
            JOIN staff_info s ON e.organizer_id = s.staff_id
            JOIN city_info c ON e.location_id = c.city_id
            WHERE e.event_id = ?
        ";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $eventId);
        $stmt->execute();
        $result = $stmt->get_result();
        $existingData = $result->fetch_assoc();

        if(!$existingData) {
            die("Event record not found.");
        }
    } 
    else {
        die("Event ID is required.");
    }

    if(isset($_POST['update'])) {
        $eventId = $_POST['event_id'];
        $eventName = $_POST['event_name'];
        $locationId = $_POST['location_id'];
        $eventDate = $_POST['event_date'];
        $organizerId = $_POST['organizer_id'];
        $eventType = $_POST['event_type'];
        $capacity = $_POST['capacity'];
        $status = $_POST['status'];
        $lastUpdated = date('Y-m-d H:i:s');

        $updateFields = [];
        $params = [];
        $types = '';

        if($eventName !== $existingData['event_name']) {
            $updateFields[] = "event_name = ?";
            $params[] = $eventName;
            $types .= 's';
        }

        if($locationId !== $existingData['location_id']) {
            $updateFields[] = "location_id = ?";
            $params[] = $locationId;
            $types .= 'i';
        }

        if($eventDate !== $existingData['event_date']) {
            $updateFields[] = "event_date = ?";
            $params[] = $eventDate;
            $types .= 's';
        }

        if($organizerId !== $existingData['organizer_id']) {
            $updateFields[] = "organizer_id = ?";
            $params[] = $organizerId;
            $types .= 'i';
        }

        if($eventType !== $existingData['event_type']) {
            $updateFields[] = "event_type = ?";
            $params[] = $eventType;
            $types .= 's';
        }

        if($capacity !== $existingData['capacity']) {
            $updateFields[] = "capacity = ?";
            $params[] = $capacity;
            $types .= 'i';
        }

        if($status !== $existingData['status']) {
            $updateFields[] = "status = ?";
            $params[] = $status;
            $types .= 's';
        }

        if(!empty($updateFields)) {
            $updateFields[] = "last_updated = ?";
            $params[] = $lastUpdated;
            $types .= 's';

            $sql = "UPDATE event_info SET " . implode(', ', $updateFields) . " WHERE event_id = ?";
            $params[] = $eventId;
            $types .= 'i';

            $stmt = $conn->prepare($sql);
            $stmt->bind_param($types, ...$params);

            if($stmt->execute()) {
                header("Location: ./");
                exit();
            } 
            else {
                echo "Error: " . $stmt->error;
            }
        } 
        else {
            echo "No changes detected.";
        }

        $stmt->close();
        $conn->close();
    }
?>

<!DOCTYPE html>
<html lang="en">
<?php include '../partials/forother/edit-page.php';?>
    <style>
        select {
            width: 100%;
            padding: 10px;
            border-radius: 4px;
            margin-top: 10px;
            border: 1px solid #ccc;
            background-color: #fff;
            background-image: url('data:image/svg+xml;charset=UTF-8,%3Csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"%3E%3Cpath d="M7 10l5 5 5-5H7z" fill="%23888"/%3E%3C/svg%3E');
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 16px 16px;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }

        textarea, input[type=date] {
            width: 100%;
            margin-top: 10px;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
            box-sizing: border-box;
            resize: vertical;
        }

        @media (max-width: 600px) {
            select, textarea {
                width: 100%;
            }
        }
    </style>
<body>
    <h2>Change Event Details</h2>
    <form action="" method="post">
        <fieldset>
            <legend>Enter New Details:</legend>

            <input type="hidden" name="event_id" value="<?php echo htmlspecialchars($existingData['event_id'] ?? ''); ?>">

            Event Name:<br>
            <input type="text" name="event_name" value="<?php echo htmlspecialchars($existingData['event_name'] ?? ''); ?>"><br><br>

            Location:<br>
            <select name="location_id">
                <?php
                    // Fetch all cities to populate the dropdown
                    $sql = "SELECT * FROM city_info";
                    $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['city_id'] . "'" . ($row['city_id'] == $existingData['location_id'] ? ' selected' : '') . ">" . htmlspecialchars($row['city_name']) . "</option>";
                    }
                ?>
            </select><br><br>

            Event Date:<br>
            <input type="date" name="event_date" value="<?php echo htmlspecialchars($existingData['event_date'] ?? ''); ?>"><br><br>

            Organizer:<br>
            <select name="organizer_id">
                <?php
                    $sql = "SELECT * FROM staff_info";
                    $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['staff_id'] . "'" . ($row['staff_id'] == $existingData['organizer_id'] ? ' selected' : '') . ">" . htmlspecialchars($row['sf_name'] . ' ' . $row['sl_name']) . "</option>";
                    }
                ?>
            </select><br><br>

            Event Type:<br>
            <input type="text" name="event_type" value="<?php echo htmlspecialchars($existingData['event_type'] ?? ''); ?>"><br><br>

            Capacity:<br>
            <input type="text" name="capacity" value="<?php echo htmlspecialchars($existingData['capacity'] ?? ''); ?>"><br><br>

            Status:<br>
            <select name="status" required>
                <option value="Ongoing" <?php echo ($existingData['status'] == 'Ongoing') ? 'selected' : ''; ?>>Ongoing</option>
                <option value="Upcoming" <?php echo ($existingData['status'] == 'Upcoming') ? 'selected' : ''; ?>>Upcoming</option>
                <option value="Previous" <?php echo ($existingData['status'] == 'Previous') ? 'selected' : ''; ?>>Previous</option>
            </select><br><br>

            <input type="submit" value="Update" name="update">
        </fieldset>
    </form>
</body>
</html>