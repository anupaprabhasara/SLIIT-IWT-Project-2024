<?php include '../database/conn.php';?>
<?php include '../partials/other/session.php';?>
<?php include '../partials/other/1-css-links.php';?>
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
        padding: 100px 0;
        box-shadow: 0 0 5px rgba(0,0,0,0.1);  
    }
    .vis {
        display: grid;
        gap: 2rem 1rem;
        overflow: hidden;
        margin: auto 80px auto 80px;
        padding-left: 32px;
    }
    .vision_img {
        width: 200px;
        margin-left: auto;
        margin-right: auto;
    }
    .vin {
        color: #2e2e2e;
        text-align: center;
        margin-left: auto;
        margin-right: auto;
    }
    .para {
        text-align: center;
        color: #595959;
    }
</style>
<script src="../script/scrollreveal.js"></script>
    <title>Vision</title>
<?php include '../partials/other/2-nav-links.php';?>
    <div class="container">
        <div class="vis">
            <img src="../images/vision.png" class="vision_img">
            <h1 class="vin">Vision</h1>
            <p class="para">To be the leading digital hub for blood donation, empowering individuals to save lives through an easy-to-use platform, and fostering a global community of donors committed to making safe blood accessible for everyone, everywhere.</p>
            <script>
                ScrollReveal().reveal('.vision_img',{origin:'right'});
                ScrollReveal().reveal('.vin',{origin:'right' , delay:700});
                ScrollReveal().reveal('.para',{origin:'right' , delay:900});

            </script>
        </div>
    </div>
<?php include '../partials/other/3-footer-area.php';?>