<?php
    $currentPath = $_SERVER['REQUEST_URI'];

    if(strpos($currentPath, 'index.php') !== false) {
        header("Location: ./");
        exit();
    }
?>

<?php
    session_start();

    if(isset($_SESSION['user_id'])) {
        header('Location: ../account/');
        exit();
    }

    include '../database/conn.php';

    $error_message = "";

    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $stmt = $conn->prepare("SELECT bdu_id, bdu_password FROM bd_user WHERE bdu_email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($user_id, $hashed_password);
        $stmt->fetch();

        if($stmt->num_rows > 0 && password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $user_id;
            if(isset($_SESSION['redirect_url'])) {
                $redirect_url = $_SESSION['redirect_url'];
                unset($_SESSION['redirect_url']);
                header("Location: $redirect_url");
            }
            else {
                header("Location: ../account/");
            }
            exit();
        } else {
            $error_message = "Invalid email or password!";
        }
        $stmt->close();
    }
    $conn->close();
?>

<?php include '../partials/other/1-css-links.php';?>
    <link rel="stylesheet" href="../css/login.css">
    <title>Login</title>
<?php include '../partials/other/2-nav-links.php';?>
    <div class="container">
        <div class="leftside">
            <h1>Login</h1>
            <p>Save Lives – Your Journey to Hope Starts Here!</p>
        </div>
        <div class="rightside">
            <form action="" method="POST">
                <label for="email">Email:</label><br>
                <input type="email" name="email" required><br>
                <label for="password">Password:</label><br>
                <input type="password" name="password" required><br>
                <p style="color: #f54748" id="errormsg"><?php echo $error_message; ?></p>
                <div style="display: flex;">
                    <button class="btn" type="submit" name="login"><span><i class="ri-login-box-line"></i></span> Login</button>
                    <p class="sign-in">&nbsp &nbsp &nbsp Don't have an account? <a href="../register/" style="color: #f54748">Sign up</a></p>
                </div>
            </form>
        </div>
    </div>
<?php include '../partials/other/3-footer-area.php';?>