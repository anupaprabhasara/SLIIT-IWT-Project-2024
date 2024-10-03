<?php
    include '../../database/conn.php';
    include '../partials/forother/admin-session-update.php';

    date_default_timezone_set('Asia/Colombo');

    if(isset($_POST['add'])) {
        $eventName = $_POST['event_name'];
        $locationId = $_POST['location_id'];
        $eventDate = $_POST['event_date'];
        $organizerId = $_POST['organizer_id'];
        $eventType = $_POST['event_type'];
        $capacity = $_POST['capacity'];
        $status = $_POST['status'];
        $createdDate = date('Y-m-d H:i:s');
        $lastUpdated = $createdDate;

        $sql = "
            INSERT INTO event_info (event_name, location_id, event_date, organizer_id, event_type, capacity, status, created_date, last_updated) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sisssssss', $eventName, $locationId, $eventDate, $organizerId, $eventType, $capacity, $status, $createdDate, $lastUpdated);

        if($stmt->execute()) {
            header("Location: ./");
            exit();
        } else {
            echo "Error: " . $stmt->error;
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
    <h2>Add New Event</h2>
    <form action="" method="post">
        <fieldset>
            <legend>Enter Details:</legend>

            Event Name:<br>
            <input type="text" name="event_name" required><br><br>

            Location:<br>
            <select name="location_id" required>
                <?php
                    // Fetch all cities to populate the dropdown
                    $sql = "SELECT * FROM city_info";
                    $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['city_id'] . "'>" . htmlspecialchars($row['city_name']) . "</option>";
                    }
                ?>
            </select><br><br>

            Event Date:<br>
            <input type="date" name="event_date" required><br><br>

            Organizer:<br>
            <select name="organizer_id" required>
                <?php
                    $sql = "SELECT * FROM staff_info";
                    $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['staff_id'] . "'>" . htmlspecialchars($row['sf_name'] . ' ' . $row['sl_name']) . "</option>";
                    }
                ?>
            </select><br><br>

            Event Type:<br>
            <input type="text" name="event_type" required><br><br>

            Capacity:<br>
            <input type="text" name="capacity" required><br><br>

            Status:<br>
            <select name="status" required>
                <option value="Ongoing">Ongoing</option>
                <option value="Upcoming">Upcoming</option>
                <option value="Previous">Previous</option>
            </select><br><br>

            <input type="submit" value="Add Event" name="add">
        </fieldset>
    </form>
</body>
</html>