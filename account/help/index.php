<?php include '../../database/conn.php';?>
<?php include '../../partials/account/session.php';?>
<?php include '../../partials/account/1-css-links.php';?>

<?php
    if(!(isset($_SESSION['user_id']))) {
        header('Location: ../../login/');
        $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
        exit();
    }
?>

    <link rel="stylesheet" href="../../css/account.css">
    <title>Help</title>
<?php include '../../partials/account/2-nav-links.php';?>
    <div class="container">
        <div class="leftside">
            <?php include '../partials/other/nav.php';?> 
        </div>
        <div class="rightside">
            <html>
                <head>
<style>
.help-center {
    text-align: center;
}

h1 {
    font-size: 30px;
    margin-bottom: 32px;
    text-align: left;
}

.help-box-container {
    padding:  0 20px 20px;
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 50px;
}

.help-box {
    background-color: #ffffff;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 14px 15px;
    width: 22rem;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: box-shadow 0.3s ease;
}

.help-box:hover {
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
}

.help-box h2 {
    font-size:30px;
}

.help-box p {
    font-size: 16px;
    color: #666;
    margin-bottom: 20px;
    margin-top: 5px;
}
.btn{
    padding :12px 20px;
    background-color:#ff5959; 
    border: none;
    border-radius: 20px;
    color: white;
}

</style>
</head>

<body>
    <div class="help-center">
        <h1>We’re Here to Help</h1>
    <div class="help-box-container">
        <div class="help-box">
            <h3>Book an Appointment</h3>
            <p>Click the button to book an appointment.</p>
            <a href="../../appointment/"> <button class="btn">Appointment</button></a>
                
        </div>
            <div class="help-box">
                <h3>How to Request Blood</h3>
                <p>Click the button to request blood on HopeFlow.</p>
                <a href="../../request/"> <button class="btn">Request Blood</button></a>

        </div>
            <div class="help-box">
                <h3>How to Donate Blood</h3>
                <p>Click the button to donate blood through HopeFlow.</p>
                <a href="../../donate/"> <button class="btn">Donate Blood</button></a>
            </div>
            <div class="help-box">
                <h3>Need More Help?</h3>
                <p>Click the button if you need further assistance.</p>
               <a href="../../contact/"> <button class="btn" >Contact Us</button></a>
            </div>
        </div>
    </div>

                </body>
            </html>
        </div>
    </div>
<?php include '../../partials/account/3-footer-area.php';?>