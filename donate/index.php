<?php include '../database/conn.php';?>
<?php include '../partials/other/session.php';?>
<?php include '../partials/other/1-css-links.php';?>
<style>
    .container{
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
    .donation{
        display: grid;
        gap: 2rem 1rem;
        overflow: hidden;
        margin: auto 80px auto 80px;
        padding-left: 32px;
    }
    .donate_img{
        width: 150px;
        height: 200px;
        margin-left: auto;
        margin-right: auto;
    }
    .header{
        color: #2e2e2e;
        text-align: center;
        margin-left: auto;
        margin-right: auto;
        font-size: 2rem;
    }
    .para{
        text-align: center;
        color: #595959;
        width: 60rem;
    }
    .question{
        color: #2e2e2e;
        text-align: center;
        font-size: 1.2rem;
    }
    .icons {
        margin: -60px auto 0;
    }
    .icons a {
        margin: 0 10px
    }
</style>
<script src="../script/scrollreveal.js"></script>
    <title>Blood Donate</title>
<?php include '../partials/other/2-nav-links.php';?>
    <div class="container">
        <div class="donation">
            <img src="../images/donate.png" class="donate_img">
            <h1 class="header">Why Do We Donate Blood?</h1>
            <p class="para">We donate blood because it’s a simple way to save lives. One donation can help up to three people in need, whether from accidents, surgeries, or illnesses.
                It’s also a way to keep the blood supply ready for emergencies, ensuring no one goes without when they need it most. Plus, donating is quick, easy, and gives you the chance to be a hero for someone in your community!</p>
            <h2 class="question">Will you join us in donating blood?</h2><br>
            <div class="icons">    
                <a href="../appointment/?id=1"><button class="btn">Yes</button></a>
                <a href="../"><button class="btn">No</button></a>
            </div>
            <script>
                ScrollReveal().reveal('.donate_img',{origin:'right'});
                ScrollReveal().reveal('.header',{origin:'right' , delay:100});
                ScrollReveal().reveal('.para',{origin:'right' , delay:200});
                ScrollReveal().reveal('.question',{origin:'right' , delay:250});
                ScrollReveal().reveal('.icons',{origin:'right' , delay:300});
            </script>
        </div>
    </div>
<?php include '../partials/other/3-footer-area.php';?>