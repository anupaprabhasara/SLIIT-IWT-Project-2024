<?php
    include '../../database/conn.php';
    include '../partials/forother/admin-session-update.php';

    date_default_timezone_set('Asia/Colombo');

    if (isset($_GET['donation_id'])) {
        $donationId = $_GET['donation_id'];

        $sql = "SELECT 
                    di.donation_id,
                    bu.bdu_id AS donor_id,
                    CONCAT(bu.bdu_fname, ' ', bu.bdu_lname) AS donor_name,
                    di.bg_id,
                    bg.bg_type,
                    di.donation_date,
                    di.donation_type,
                    di.d_quantity_ml,
                    di.staff_id,
                    CONCAT(si.sf_name, ' ', si.sl_name) AS staff_name,
                    di.donation_status,
                    bi.storage_loca_id
                FROM 
                    donation_info di
                INNER JOIN 
                    bd_user bu ON di.donor_id = bu.bdu_id
                INNER JOIN 
                    blood_group bg ON di.bg_id = bg.bg_id
                INNER JOIN 
                    staff_info si ON di.staff_id = si.staff_id
                LEFT JOIN 
                    b_invent_info bi ON di.donation_id = bi.donation_id
                WHERE 
                    di.donation_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $donationId);
        $stmt->execute();
        $result = $stmt->get_result();
        $existingData = $result->fetch_assoc();

        if (!$existingData) {
            die("Donation record not found.");
        }

        $donationType = $existingData['donation_type'];
        $currentDateTime = date('Y-m-d H:i:s');
    } else {
        die("Donation ID is required.");
    }

    if (isset($_POST['update'])) {
        $donationId = $_POST['donation_id'];
        $donorId = $_POST['donor_id'];
        $donationDate = $_POST['donation_date'];
        $donationType = $_POST['donation_type'];
        $quantityMl = $_POST['d_quantity_ml'];
        $staffId = $_POST['staff_id'];
        $donationStatus = $_POST['donation_status'];
        $storageLo = $_POST['city_id'];

        $sql = "SELECT bdu_bg FROM bd_user WHERE bdu_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $donorId);
        $stmt->execute();
        $result = $stmt->get_result();
        $userData = $result->fetch_assoc();
        $bgId = $userData['bdu_bg'];

        $updateFields = [];
        $params = [];
        $types = '';

        if ($donorId !== $existingData['donor_id']) {
            $updateFields[] = "donor_id = ?";
            $params[] = $donorId;
            $types .= 'i';
        }

        if ($bgId !== $existingData['bg_id']) {
            $updateFields[] = "bg_id = ?";
            $params[] = $bgId;
            $types .= 'i';
        }

        if ($donationDate !== $existingData['donation_date']) {
            $updateFields[] = "donation_date = ?";
            $params[] = $donationDate;
            $types .= 's';
        }

        if ($donationType !== $existingData['donation_type']) {
            $updateFields[] = "donation_type = ?";
            $params[] = $donationType;
            $types .= 's';
        }

        if ($quantityMl !== $existingData['d_quantity_ml']) {
            $updateFields[] = "d_quantity_ml = ?";
            $params[] = $quantityMl;
            $types .= 'd';
        }

        if ($staffId !== $existingData['staff_id']) {
            $updateFields[] = "staff_id = ?";
            $params[] = $staffId;
            $types .= 'i';
        }

        if ($donationStatus !== $existingData['donation_status']) {
            $updateFields[] = "donation_status = ?";
            $params[] = $donationStatus;
            $types .= 's';
        }

        $updateFields[] = "last_updated = ?";
        $params[] = $currentDateTime;
        $types .= 's';

        if (!empty($updateFields)) {
            $sql = "UPDATE donation_info SET " . implode(', ', $updateFields) . " WHERE donation_id = ?";
            $params[] = $donationId;
            $types .= 'i';

            $stmt = $conn->prepare($sql);
            $stmt->bind_param($types, ...$params);

            if ($stmt->execute()) {
                $sql = "UPDATE bd_user SET bdu_ldd = ? WHERE bdu_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("si", $donationDate, $donorId);

                if (!$stmt->execute()) {
                    echo "Error updating user: " . $stmt->error;
                }
                
                $sql = "SELECT * FROM b_invent_info WHERE donation_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $donationId);
                $stmt->execute();
                $inventoryResult = $stmt->get_result();
                $inventoryData = $inventoryResult->fetch_assoc();

                if ($inventoryData) {
                    $updateInventoryFields = [];
                    $inventoryParams = [];
                    $inventoryTypes = '';

                    if ($bgId !== $inventoryData['bg_id']) {
                        $updateInventoryFields[] = "bg_id = ?";
                        $inventoryParams[] = $bgId;
                        $inventoryTypes .= 'i';
                    }

                    if ($donorId !== $inventoryData['donor_id']) {
                        $updateInventoryFields[] = "donor_id = ?";
                        $inventoryParams[] = $donorId;
                        $inventoryTypes .= 'i';
                    }

                    if ($donationType !== $inventoryData['component_type']) {
                        $updateInventoryFields[] = "component_type = ?";
                        $inventoryParams[] = $donationType;
                        $inventoryTypes .= 's';
                    }

                    if ($donationDate !== $inventoryData['collection_date']) {
                        $updateInventoryFields[] = "collection_date = ?";
                        $inventoryParams[] = $donationDate;
                        $inventoryTypes .= 's';
                    }

                    $donationDateObj = new DateTime($donationDate);
                    $donationDateObj->modify('+42 days');
                    $newDonationDate = $donationDateObj->format('Y-m-d');

                    if ($newDonationDate !== $inventoryData['expiry_date']) {
                        $updateInventoryFields[] = "expiry_date = ?";
                        $inventoryParams[] = $newDonationDate;
                        $inventoryTypes .= 's';
                    }

                    if ($quantityMl !== $inventoryData['bi_quantity_ml']) {
                        $updateInventoryFields[] = "bi_quantity_ml = ?";
                        $inventoryParams[] = $quantityMl;
                        $inventoryTypes .= 'd';
                    }

                    if ($storageLo !== $inventoryData['storage_loca_id']) {
                        $updateInventoryFields[] = "storage_loca_id = ?";
                        $inventoryParams[] = $storageLo;
                        $inventoryTypes .= 's';
                    }

                    if ($donationStatus !== $inventoryData['bi_status']) {
                        $updateInventoryFields[] = "bi_status = ?";
                        $inventoryParams[] = $donationStatus;
                        $inventoryTypes .= 's';
                    }

                    if (!empty($updateInventoryFields)) {
                        $sql = "UPDATE b_invent_info SET " . implode(', ', $updateInventoryFields) . " WHERE donation_id = ?";
                        $inventoryParams[] = $donationId;
                        $inventoryTypes .= 'i';

                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param($inventoryTypes, ...$inventoryParams);

                        if (!$stmt->execute()) {
                            echo "Error updating inventory: " . $stmt->error;
                        }
                    }
                }

                header("Location: ./");
                exit();
            } else {
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

        textarea, input[type=date], input[type=number] {
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
    <h2>Edit Donation Details</h2>
    <form action="" method="post">
        <fieldset>
            <legend>Enter New Details:</legend>

            <input type="hidden" name="donation_id" value="<?php echo htmlspecialchars($existingData['donation_id'] ?? ''); ?>">

            Donor:<br>
            <select name="donor_id" required>
                <?php
                    $result = $conn->query("SELECT bdu_id, CONCAT(bdu_fname, ' ', bdu_lname) AS donor_name FROM bd_user");
                    if ($result) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value=\"" . $row['bdu_id'] . "\"" . ($existingData['donor_id'] == $row['bdu_id'] ? ' selected' : '') . ">" . $row['donor_name'] . "</option>";
                        }
                    } else {
                        echo "<option value=\"\">Error fetching data</option>";
                    }
                ?>
            </select><br><br>

            Donation Date:<br>
            <input type="date" name="donation_date" value="<?php echo htmlspecialchars($existingData['donation_date'] ?? ''); ?>"><br><br>

            Donation Type:<br>
            <select name="donation_type" required>
                <option value="Whole Blood" <?php echo ($existingData['donation_type'] == 'Whole Blood') ? 'selected' : ''; ?>>Whole Blood Donation</option>
                <option value="Plasma" <?php echo ($existingData['donation_type'] == 'Plasma') ? 'selected' : ''; ?>>Plasma Donation</option>
                <option value="Platelet" <?php echo ($existingData['donation_type'] == 'Platelet') ? 'selected' : ''; ?>>Platelet Donation</option>
                <option value="Red Blood Cell" <?php echo ($existingData['donation_type'] == 'Red Blood Cell') ? 'selected' : ''; ?>>Red Blood Cell Donation</option>
                <option value="Double Red Blood Cell" <?php echo ($existingData['donation_type'] == 'Double Red Blood Cell') ? 'selected' : ''; ?>>Double Red Blood Cell Donation</option>
                <option value="Autologous" <?php echo ($existingData['donation_type'] == 'Autologous') ? 'selected' : ''; ?>>Autologous Donation</option>
            </select><br><br>

            Donation Quantity (ml):<br>
            <input type="number" name="d_quantity_ml" value="<?php echo htmlspecialchars($existingData['d_quantity_ml'] ?? ''); ?>" required><br><br>

            Staff:<br>
            <select name="staff_id" required>
                <?php
                    $result = $conn->query("SELECT staff_id, CONCAT(sf_name, ' ', sl_name) AS staff_name FROM staff_info");
                    if ($result) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value=\"" . $row['staff_id'] . "\"" . ($existingData['staff_id'] == $row['staff_id'] ? ' selected' : '') . ">" . $row['staff_name'] . "</option>";
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
                            $selected = ($existingData['storage_loca_id'] == $row['city_id']) ? ' selected' : '';
                            echo "<option value=\"" . $row['city_id'] . "\"" . $selected . ">" . $row['city_name'] . "</option>";
                        }
                    } else {
                        echo "<option value=\"\">Error fetching data</option>";
                    }
                ?>
            </select><br><br>

            Donation Status:<br>
            <select name="donation_status" required>
                <option value="Completed" <?php echo ($existingData['donation_status'] == 'Completed') ? 'selected' : ''; ?>>Completed</option>
                <option value="Pending" <?php echo ($existingData['donation_status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                <option value="Cancelled" <?php echo ($existingData['donation_status'] == 'Cancelled') ? 'selected' : ''; ?>>Cancelled</option>
            </select><br><br>

            <input type="submit" name="update" value="Update"></input>
        </fieldset>
    </form>
</body>
</html>