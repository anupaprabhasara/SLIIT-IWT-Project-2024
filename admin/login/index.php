<?php
session_start();

if(isset($_SESSION['admin_id'])) {
    header('Location: ../');
    exit();
}

include '../../database/conn.php';

$error = '';

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $recaptchaSecret = '6LeBnU4qAAAAAA0st520XS4n_ygMFx_1JLJwtwK4';
    $recaptchaResponse = $_POST['g-recaptcha-response'];

    $recaptchaURL = 'https://www.google.com/recaptcha/api/siteverify';
    $recaptchaData = [
        'secret' => $recaptchaSecret,
        'response' => $recaptchaResponse,
        'remoteip' => $_SERVER['REMOTE_ADDR']
    ];

    $options = [
        'http' => [
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($recaptchaData)
        ]
    ];
    $context  = stream_context_create($options);
    $recaptchaVerifyResponse = file_get_contents($recaptchaURL, false, $context);
    $recaptchaResult = json_decode($recaptchaVerifyResponse, true);

    if ($recaptchaResult['success']) {
        $stmt = $conn->prepare("SELECT admin_id, permission, password FROM admin_info WHERE username = ?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($admin_id, $permission, $hashed_password);
        $stmt->fetch();

        if($stmt->num_rows > 0 && password_verify($password, $hashed_password)) {
            $_SESSION['permission'] = $permission;
            $_SESSION['admin_id'] = $admin_id;
            header('Location: ../');
            exit();
        } else {
            $error = "Invalid username or password!";
        }
        $stmt->close();
    } else {
        $error = "Please verify you're not a robot!";
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HopeFlow Admin | Login</title>
    <link rel="stylesheet" href="../css/login.css">
    <link rel="shortcut icon" href="../images/favicon.svg" type="image/x-icon">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="../script/rclick-notsele.js"></script>
    <style>
        .g-recaptcha {
            margin: 20px 0 5px
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Admin <img src="../images/blood.svg" class="blood-svg"> Login</h2>
        <form action="" method="POST">
            <div class="input-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="g-recaptcha" data-sitekey="6LeBnU4qAAAAABo8aNot364uNwOpIhH6746f_Avk"></div>

            <?php if (isset($error)): ?>
                <p style="color: red; text-align: left;"><?php echo $error; ?></p>
            <?php endif; ?>
            
            <button type="submit" name="login">Login</button>
        </form>
        <a href="mailto:it23556584@my.sliit.lk" class="register-link">Don't have an account?</a>
    </div>
</body>
</html>