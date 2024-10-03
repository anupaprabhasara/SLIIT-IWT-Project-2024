<?php include '../../database/conn.php';?>
<?php include '../../partials/account/session.php';?>
<?php include '../../partials/account/1-css-links.php';?>

<?php
    date_default_timezone_set('Asia/Colombo');

    if (!(isset($_SESSION['user_id']))) {
        header('Location: ../../login/');
        $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
        exit();
    }
?>

<title>Password Change</title>
<link rel="stylesheet" href="../../css/passcha.css">
<link rel="stylesheet" href="../../css/account.css">

<?php include '../../partials/account/2-nav-links.php';?>

<div class="container">
    <div class="leftside">
        <?php include '../partials/other/nav.php';?> 
    </div>
    <div class="rightside">
        <h2>Password Change</h2>
        
        <div class="edit-form-container">
            <form id="passwordChangeForm" action="" method="POST">
                <div class="form-group">
                    <label for="cpass">Current Password</label>
                    <input type="password" id="cpass" name="cpass" required>
                </div>

                <div class="form-group">
                    <label for="npass">New Password</label>
                    <input type="password" id="npass" name="npass" required>
                </div>

                <div class="form-group">
                    <label for="cnpass">Confirm New Password</label>
                    <input type="password" id="cnpass" name="cnpass" required>
                </div>

                <div id="error-message" style="color: red; margin-top: 10px;"></div>
                <div id="success-message" style="color: green; margin-top: 10px;"></div>

                <div class="action-buttons">
                    <button type="submit" class="save-btn" name="update">Save Changes</button>
                    <button type="button" class="cancel-btn" onclick="window.location.href='../';">Cancel</button>
                </div>

            </form>
        </div>
    </div>
</div>

<script src="../../script/passcha.js"></script>

<?php include '../../partials/account/3-footer-area.php';?>