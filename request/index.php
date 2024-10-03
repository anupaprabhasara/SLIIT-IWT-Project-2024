<?php include '../database/conn.php';?>
<?php include '../partials/other/session.php';?>
<?php
    date_default_timezone_set('Asia/Colombo');

    if(!(isset($_SESSION['user_id']))) {
        header('Location: ../login/');
        $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
        exit();
    }
?>

<?php include '../partials/other/1-css-links.php';?>
    <link rel="stylesheet" href="../css/request.css">
    <title>Blood Request</title>
<?php include '../partials/other/2-nav-links.php';?>

    <div class="container">
        <div class="leftside">
            <h1>Blood Request</h1><br>
            <p>Fill out this form to request blood donations. We will notify you when a matching donor is found.</p>
        </div>
        <div class="rightside">
            <form id="requestForm" method="POST">
                <label for="blood_group">Blood Group:</label><br>
                <select name="blood_group" required>
                    <option value="">Select Blood Group</option>
                    <?php
                        $sql = "SELECT * FROM blood_group";
                        $result = $conn->query($sql);
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['bg_id'] . "'>" . htmlspecialchars($row['bg_type']) . "</option>";
                        }
                    ?>
                </select><br>
                
                <label for="component_type">Component Type:</label><br>
                <select name="component_type" required>
                    <option value="">Select Component Type</option>
                    <option value="Whole Blood">Whole Blood</option>
                    <option value="Plasma">Plasma</option>
                    <option value="Platelet">Platelet</option>
                    <option value="Red Blood Cell">Red Blood Cell</option>
                    <option value="Double Red Blood Cell">Double Red Blood Cell</option>
                    <option value="Autologous">Autologous</option>
                </select><br>
                
                <label for="text">Required Quantity (ml):</label><br>
                <input type="number" name="quantity" required><br>

                <label for="required_date">Required Date:</label><br>
                <input type="date" name="required_date" required><br>

                <label for="Location">Location:</label><br>
                <select name="Location" required>
                    <option value="">Select Nearest Location</option>
                    <?php
                        $sql = "SELECT * FROM city_info";
                        $result = $conn->query($sql);
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['city_id'] . "'>" . htmlspecialchars($row['city_name']) . "</option>";
                        }
                    ?>
                </select><br>

                <label for="reason">Reason For Requesting:</label><br>
                <textarea id="reason" name="reason" rows="4" cols="50" placeholder="Enter your reason" required></textarea><br>

                <input type="checkbox" required><span> I agree to the <a href="../terms/">terms and conditions</a>.</span><br>
                <p id="responseMessage"></p>
                <button class="btn" type="submit">Request</button>
            </form>
        </div>
    </div>

<script src="../script/request.js"></script>

<?php
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $requester = $_SESSION['user_id'];
        $bg = $_POST['blood_group'];
        $ct = $_POST['component_type'];
        $qua = $_POST['quantity'];
        $requestedd = date('Y-m-d');
        $requiredd = $_POST['required_date'];
        $status = "Pending";
        $loca = $_POST['Location'];
        $reas = $_POST['reason'];
        $createdDate = date('Y-m-d H:i:s');

        $sql = "
            INSERT INTO b_request_info (requester, bg_id, component_type, quant_req_ml, req_date, required_date, req_status, req_loca_id, req_reason, created_date) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('iisssssiss', $requester, $bg, $ct, $qua, $requestedd, $requiredd, $status, $loca, $reas, $createdDate);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Successfully requested!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Request failed!']);
        }

        $stmt->close();
    }
?>

<?php include '../partials/other/3-footer-area.php';?>