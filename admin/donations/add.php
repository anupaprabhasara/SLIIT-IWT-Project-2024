<?php
    include '../../database/conn.php';
    include '../partials/forother/admin-session-update.php';

    date_default_timezone_set('Asia/Colombo');

    if (isset($_POST['create'])) {
        $donorId = $_POST['donor_id'];
        $donationDate = $_POST['donation_date'];
        $donationType = $_POST['donation_type'];
        $quantityMl = $_POST['d_quantity_ml'];
        $staffId = $_POST['staff_id'];
        $donationStatus = $_POST['donation_status'];
        $storageLo = $_POST['city_id'];
        $currentDateTime = date('Y-m-d H:i:s');

        $sql = "SELECT bdu_bg, bdu_ldd FROM bd_user WHERE bdu_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $donorId);
        $stmt->execute();
        $stmt->bind_result($bgId, $currentLdd);
        $stmt->fetch();
        $stmt->close();

        $conn->begin_transaction();

        try {
            $sql = "INSERT INTO donation_info (donor_id, bg_id, donation_date, donation_type, d_quantity_ml, staff_id, donation_status, created_date, last_updated)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iissdisss", $donorId, $bgId, $donationDate, $donationType, $quantityMl, $staffId, $donationStatus, $currentDateTime, $currentDateTime);
            $stmt->execute();

            $donationId = $stmt->insert_id;

            $donationDateObj = new DateTime($donationDate);
            $donationDateObj->modify('+42 days');
            $newDonationDate = $donationDateObj->format('Y-m-d');

            $sql = "INSERT INTO b_invent_info (donation_id, bg_id, donor_id, component_type, collection_date, expiry_date, bi_quantity_ml, storage_loca_id, bi_status, created_date)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iissssisss", $donationId, $bgId, $donorId, $donationType, $donationDate, $newDonationDate, $quantityMl, $storageLo, $donationStatus, $currentDateTime);
            $stmt->execute();

            if($donationDate > $currentLdd) {
                $sql = "UPDATE bd_user SET bdu_ldd = ? WHERE bdu_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("si", $donationDate, $donorId);
                $stmt->execute();
            }

            $conn->commit();

            header("Location: ./");
            exit();
        } catch (Exception $e) {
            $conn->rollback();
            echo "Error: " . $e->getMessage();
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

        textarea, input[type=number], input[type=date] {
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
    <h2>Create New Donation Record</h2>
    <form action="" method="post">
        <fieldset>
            <legend>Enter Details:</legend>

            Donor:<br>
            <select name="donor_id" required>
                <?php
                    $result = $conn->query("SELECT bdu_id, CONCAT(bdu_fname, ' ', bdu_lname) AS donor_name FROM bd_user");
                    if ($result) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value=\"" . $row['bdu_id'] . "\">" . $row['donor_name'] . "</option>";
                        }
                    } else {
                        echo "<option value=\"\">Error fetching data</option>";
                    }
                ?>
            </select><br><br>

            Donation Date:<br>
            <input type="date" name="donation_date" required><br><br>

            Donation Type:<br>
            <select name="donation_type" required>
                <option value="Whole Blood">Whole Blood Donation</option>
                <option value="Plasma">Plasma Donation</option>
                <option value="Platelet">Platelet Donation</option>
                <option value="Red Blood Cell">Red Blood Cell Donation</option>
                <option value="Double Red Blood Cell">Double Red Blood Cell Donation</option>
                <option value="Autologous">Autologous Donation</option>
            </select><br><br>

            Donation Quantity (ml):<br>
            <input type="number" name="d_quantity_ml" required><br><br>

            Staff:<br>
            <select name="staff_id" required>
                <?php
                    $result = $conn->query("SELECT staff_id, CONCAT(sf_name, ' ', sl_name) AS staff_name FROM staff_info");
                    if ($result) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value=\"" . $row['staff_id'] . "\">" . $row['staff_name'] . "</option>";
                        }
                    } else {
                        echo "<option value=\"\">Error fetching data</option>";
                    }
                ?>
            </select><br><br>

            Nearest Location:<br>
            <select name="city_id" required>
                <?php
                    $result = $conn->query("SELECT city_id, city_name FROM city_info");
                    if ($result) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value=\"" . $row['city_id'] . "\">" . $row['city_name'] . "</option>";
                        }
                    } else {
                        echo "<option value=\"\">Error fetching data</option>";
                    }
                ?>
            </select><br><br>

            Donation Status:<br>
            <select name="donation_status" required>
                <option value="Completed">Completed</option>
                <option value="Pending">Pending</option>
                <option value="Cancelled">Cancelled</option>
            </select><br><br>

            <input type="submit" name="create" value="Create"></input>
        </fieldset>
    </form>
</body>
</html>