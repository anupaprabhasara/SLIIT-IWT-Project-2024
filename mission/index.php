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
    .miss {
        display: grid;
        gap: 2rem 1rem;
        overflow: hidden;
        margin: auto 80px auto 80px;
        padding-left: 32px;
    }
    .mission_img {
        width: 200px;
        margin-left: auto;
        margin-right: auto;
    }
    .min {
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
    <title>Mission</title>
<?php include '../partials/other/2-nav-links.php';?>
        <div class="container">
        <div class="miss">
            <img src="../images/mission.png" class="mission_img">
            <h1 class="min">Mission</h1>
            <p class="para">To create an intuitive and accessible online platform that connects voluntary blood donors with patients in need, streamlining the process of donation, educating the community, and ensuring timely access to life-saving blood through collaboration and innovation.</p>
            <script>
                ScrollReveal().reveal('.mission_img',{origin:'right'});
                ScrollReveal().reveal('.min',{origin:'right' , delay:700});
                ScrollReveal().reveal('.para',{origin:'right' , delay:900});

            </script>
        </div>
    </div>
<?php include '../partials/other/3-footer-area.php';?>