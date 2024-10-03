<?php
    session_start();
    include '../database/conn.php';

    $currentPath = $_SERVER['REQUEST_URI'];

    if(strpos($currentPath, 'index.php') !== false) {
        header("Location: ./");
        exit();
    }

    if(isset($_SESSION['user_id'])) {
        header('Location: ../');
        exit();
    }
    
    date_default_timezone_set('Asia/Colombo');

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $password = $_POST['password'];
        $cpassword = $_POST['cpassword'];
        $nic = $_POST['nic'];
        $gender = $_POST['gender'];
        $dob = $_POST['dob'];
        $city = $_POST['city'];
        $bg = $_POST['bg'];
        $weight = $_POST['weight'];
        $fod = $_POST['fod'];
        $createdDate = date('Y-m-d H:i:s');

        if($password !== $cpassword) {
            echo json_encode(['success' => false, 'message' => 'Passwords do not match!']);
            exit();
        }

        $hashpass = password_hash($password, PASSWORD_DEFAULT);

        $profilepic = null;
        if(isset($_FILES['profilepic']) && $_FILES['profilepic']['error'] == UPLOAD_ERR_OK) {
            $profilepic = file_get_contents($_FILES['profilepic']['tmp_name']);
        }

        $sql = "
            INSERT INTO bd_user (bdu_fname, bdu_lname, profile_pic, bdu_email, bdu_phone, bdu_password, bdu_nic, bdu_gender, bdu_dob, bdu_weight_kg, bdu_n_city, bdu_bg, bdu_fod_month, created_date) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ";
        $stmt = $conn->prepare($sql);

        $stmt->bind_param('ssbssssssdiiis', $fname, $lname, $profilepic, $email, $phone, $hashpass, $nic, $gender, $dob, $weight, $city, $bg, $fod, $createdDate);

        if($profilepic) {
            $stmt->send_long_data(2, $profilepic);
        }

        if($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Successfully registered!']);
        }
        else {
            echo json_encode(['success' => false, 'message' => 'Registration failed!']);
        }

        $stmt->close();
        exit();
    }
?>

<?php include '../partials/other/1-css-links.php'; ?>
    <link rel="stylesheet" href="../css/register.css">
    <title>Register</title>
<?php include '../partials/other/2-nav-links.php'; ?>

<div class="container">
    <div class="leftside">
        <h1>Register</h1>
        <p>Save Lives – Your Journey to Hope Starts Here!</p>
    </div>
    <div class="rightside">
        <form id="registerForm" method="POST" enctype="multipart/form-data">
            <label for="fname">First Name:</label><br>
            <input type="text" name="fname" required><br>
            <label for="lname">Last Name:</label><br>
            <input type="text" name="lname" required><br>
            <label for="email">Email:</label><br>
            <input type="email" name="email" required><br>
            <label for="phone">Phone:</label><br>
            <input type="tel" name="phone" required><br>
            <label for="password">Password:</label><br>
            <input type="password" name="password" required><br>
            <label for="cpassword">Confirm Password:</label><br>
            <input type="password" name="cpassword" required><br>
            <label for="profilepic">Profile Picture:</label><br>
            <input type="file" accept="image/*" name="profilepic"><br>
            <label for="nic">NIC Number:</label><br>
            <input type="number" name="nic" required><br>
            <label for="gender">Gender:</label><br>
            <select name="gender" required>
                <option value="">Select Gender</option>
                <option value="Female">Female</option>
                <option value="Male">Male</option>
                <option value="Rather not say">Rather not say</option>
            </select><br>
            <label for="dob">Date Of Birth:</label><br>
            <input type="date" name="dob" required><br>
            <label for="city">Nearest City:</label><br>
            <select name="city" required>
                <option value="">Select City</option>
                <?php
                    $sql = "SELECT * FROM city_info";
                    $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['city_id'] . "'>" . htmlspecialchars($row['city_name']) . "</option>";
                    }
                ?>
            </select><br>
            <label for="bg">Blood Group:</label><br>
            <select name="bg" required>
                <option value="">Select Blood Group</option>
                <?php
                    $sql = "SELECT * FROM blood_group";
                    $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['bg_id'] . "'>" . htmlspecialchars($row['bg_type']) . "</option>";
                    }
                ?>
            </select><br>
            <label for="weight">Weight (Kg):</label><br>
            <input type="number" name="weight"><br>
            <label for="fod">Frequency of Donations (Months):</label><br>
            <input type="number" name="fod"><br>
            <input type="checkbox" required><span> I agree to the <a href="../terms/">terms and conditions</a>.</span><br>
            <p id="responseMessage"></p>
            <div style="display: flex;">
                <button class="btn" type="submit"><span><i class="ri-login-box-line"></i></span> Register</button>
                <p class="sign-in">&nbsp &nbsp &nbsp Already have an account?  <a href="../login/index.php" style="color: #f54748">Log in</a></p>
            </div>
        </form>
    </div>
</div>

<script src="../script/register.js"></script>

<?php include '../partials/other/3-footer-area.php'; ?>