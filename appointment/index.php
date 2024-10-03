<?php 
include '../database/conn.php';
include '../partials/other/session.php';
include '../partials/other/1-css-links.php'; 

date_default_timezone_set('Asia/Colombo');

$id = "no";

if(isset($_GET['id'])) {
    $id = intval($_GET['id']);
}

if (!(isset($_SESSION['user_id']))) {
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
    header('Location: ../login/');
    exit();
}

$cities_query = "SELECT city_id, city_name FROM city_info";
$cities_result = $conn->query($cities_query);

$app_type_query = "SELECT appo_type FROM appo_info GROUP BY appo_type";
$app_type_result = $conn->query($app_type_query);

$staff_query = "SELECT staff_id, sf_name, sl_name, position FROM staff_info";
$staff_result = $conn->query($staff_query);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $donor_id = $_SESSION['user_id'];
    $appointment_date = $_POST['appointment_date'];
    $location_id = $_POST['Location'];
    $appointment_type = $_POST['appointype'];
    $appointment_status = "Pending";
    $staff_id = $_POST['selectdoc'];

    $sql = "
    INSERT INTO appo_info (donor_id, appo_date, loca_id, appo_type, appo_status, staff_id, created_date)
    VALUES (?, ?, ?, ?, ?, ?, NOW())
    ";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param('issssi', $donor_id, $appointment_date, $location_id, $appointment_type, $appointment_status, $staff_id);

    if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Appointment successfully booked!']);
    } else {
    echo json_encode(['status' => 'error', 'message' => 'Booking failed! Please try again.']);
    }

    $stmt->close();

}
?>
<style>
    .container {
        background-color: #fffcfc;
        display: flex;
        justify-content: space-between;
        width: 73rem;
        margin: 60px auto auto;
        border: solid 1px;
        border-color: #ffc7c7;
        border-radius: 20px;
        padding: 100px 0 100px 40px;
        box-shadow: 0 0 5px rgba(0,0,0,0.1);
    }
    .leftside {
        margin: 120px auto auto 40px;
        width: 320px;
        padding: 15px;
        position: sticky;
        top: 150px;
        height: 300px;
    }
    .rightside {
        margin: auto 80px auto auto;
        padding: 20px 0 20px;
    }
    input, select {
        width: 28rem;
        padding: 12px;
        margin-top: 5px;
        margin-bottom: 20px;
        border: solid 0.5px;
        border-radius: 15px;
        font-family: 'Arial', sans-serif;
        font-size: 16px;
        font-weight: 100;
        color: #4a4a4a;
        box-shadow: 0 0 5px rgba(0,0,0,0.1);
    }
    .responseMessage {
        margin-top: -20px;
        margin-bottom: 15px;
    }
</style>
<title>Appointment</title>
<?php include '../partials/other/2-nav-links.php'; ?>

<div class="container">
    <div class="leftside">
        <?php if($id == "no") {?>
            <h1>Appointment</h1><br>
        <?php } ?>

        <?php if($id == "1") {?>
            <h1>Blood Donation</h1><br>
        <?php } ?>
        <p>Please fill out this form to schedule an appointment for blood donations. We will notify you once your appointment is confirmed.</p>
    </div>
    <div class="rightside">
        <form id="requestForm" method="POST" action="" >
            <label for="appointment_date">Appointment Date:</label><br>
            <input type="date" name="appointment_date" required><br>

            <label for="Location">Nearest Location:</label><br>
            <select name="Location" required>
                <option value="">Select Location</option>
                <?php while($city = $cities_result->fetch_assoc()) { ?>
                    <option value="<?php echo $city['city_id']; ?>"><?php echo $city['city_name']; ?></option>
                <?php } ?>
            </select><br>
            
            <?php if($id == "no") {?>
            <label for="appointype">Appointment Type:</label><br>
            <select name="appointype" required>
                <option value="">Select Type</option>
                <option value="Blood Donation">Blood Donation</option>
                <option value="Health Checkup">Health Checkup</option>
                <option value="Counselling">Counselling</option>
            </select><br>
            <?php } ?>

            <?php if($id == "1") {?>
            <select name="appointype" style="display: none;" required>
                <option value="Blood Donation">Blood Donation</option>
            </select>
            <?php } ?>

            <label for="selectdoc">Staff Member:</label><br>
            <select name="selectdoc" required>
                <option value="">Select a Doctor/Nurse</option>
                <?php while($staff = $staff_result->fetch_assoc()) { ?>
                    <option value="<?php echo $staff['staff_id']; ?>">
                        <?php echo $staff['sf_name'] . ' ' . $staff['sl_name'] . ' - ' . $staff['position']; ?>
                    </option>
                <?php } ?>
            </select><br><br>

            <div id="responseMessage" class="responseMessage"></div>
            <button class="btn" type="submit">Book Appointment</button>
        </form>
    </div>
</div>

<script src="../script/appointment.js"></script>

<?php include '../partials/other/3-footer-area.php'; ?>