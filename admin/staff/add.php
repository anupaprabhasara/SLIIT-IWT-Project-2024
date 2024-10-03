<?php
include '../../database/conn.php';
include '../partials/forother/admin-session-update.php';

date_default_timezone_set('Asia/Colombo');

$cityQuery = "SELECT city_id, city_name FROM city_info";
$cityResult = $conn->query($cityQuery);

$staffQuery = "
    SELECT s.staff_id, CONCAT(s.sf_name, ' ', s.sl_name) AS staff_name, c.city_name
    FROM staff_info s
    JOIN city_info c ON s.loca_id = c.city_id";
$staffResult = $conn->query($staffQuery);

if(isset($_POST['create'])) {
    $firstname = $_POST['sf_name'];
    $lastname = $_POST['sl_name'];
    $position = $_POST['position'];
    $email = $_POST['email'];
    $department = $_POST['department'];
    $phone = $_POST['phone'];
    $loca_id = $_POST['city_id'];
    $emplo_date = $_POST['emplo_date'];
    $currentDateTime = date('Y-m-d H:i:s');

    $sql = "INSERT INTO staff_info (sf_name, sl_name, position, email, 
                                       department, phone, loca_id, emplo_date, created_date, last_updated)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        die("Error in prepare statement: " . $conn->error);
    }

    $stmt->bind_param("sssssiisss", $firstname, $lastname, $position, $email, $department, $phone, $loca_id, $emplo_date, $currentDateTime, $currentDateTime);

    if($stmt->execute()) {
        header("Location: ./");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
        header("Location: ../");
        exit();
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include '../partials/forother/add-page.php';?>
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

        textarea, input[type=email], input[type=date] {
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
    <h2>Add Staff Member</h2>
    <form action="" method="post">
        <fieldset>
            <legend>Enter Details:</legend>

            First Name:<br>
            <input type="text" name="sf_name" required><br><br>

            Last Name:<br>
            <input type="text" name="sl_name" required><br><br>

            Position:<br>
            <input type="text" name="position" required><br><br>

            Email:<br>
            <input type="email" name="email" required><br><br>

            Department:<br>
            <input type="text" name="department" required><br><br>

            Phone:<br>
            <input type="text" name="phone" required><br><br>

            City:<br>
            <select name="city_id" required>
                <?php
                    $cityQuery = "SELECT city_id, city_name FROM city_info";
                    $result = $conn->query($cityQuery);

                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['city_id'] . "'>" . $row['city_name'] . "</option>";
                    }
                ?>
            </select><br><br>

            Employment Date:<br>
            <input type="date" name="emplo_date" required><br><br>

            <input type="submit" value="Create" name="create">
        </fieldset>
    </form>
</body>
</html>