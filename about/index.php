<?php include '../database/conn.php';?>
<?php include '../partials/other/session.php';?>
<?php include '../partials/other/1-css-links.php';?>
<style>
    .container {
        background-color: #fffcfc;
        display: flex;
        justify-content: space-between;
        width: 73rem;
        margin: 40px auto auto;
        border: solid 1px;
        border-color: #ffc7c7;
        border-radius: 20px;
        padding: 30px 0;
        box-shadow: 0 0 5px rgba(0,0,0,0.1);      
    }

    .container.c1 {
        margin-top: 80px;
    }
    .container.c3 {
        margin-bottom: 32px;
    }

    .abo{
        margin: auto;
        padding: 15px;
    }
    .abo h1 {
        padding-left: 80px;
    }
    .abo p {
        padding-left: 80px;
    }
    .abo.a2 h1 {
        padding-left: 0;
        padding-right: 80px;
    }
    .abo.a2 p {
        padding-left: 0;
        padding-right: 80px;
    }
    .header{
        color: #2e2e2e;
        font-size: 2.5rem;
    }

    .para{
        margin: auto;
        color: #595959;
    }
    .image {
        margin-left: 20px;
        margin-right: 80px;
    }
    .image.i2 {
        margin-left: 60px;
        margin-right: 20px;
    }
    .image img {
        border-radius: 32px;
    }
    .about1_img{
        margin-left: 1rem;
        padding: 15px;
        width: 250px;
        height: 250px;
    }

</style>
    <title>About</title>
<?php include '../partials/other/2-nav-links.php';?>
        <div class="container c1">
            <div class="abo">
                <h1 class="header">About Us</h1><br>
                <p class="para">We are committed to saving lives by connecting blood donors with those in need. Every donation helps provide life-saving support for patients in hospitals. Join us in making a difference today.</p>
            </div>
            <div class="image i1">
                <img src="../images/abo.jpg" class="about1_img">
            </div>
        </div>
        <div class="container c2">
            <div class="image i2">
                <img src="../images/about2.jpg" class="about1_img">
            </div>
            <div class="abo a2">
                <h1 class="header">Helping of Organizations</h1><br>
                <p class="para">Hope Flow is dedicated to saving lives through blood donations. We connect generous donors with patients in need, bringing hope and healing. Together, we make a difference, one donation at a time.</p>
            </div>
        </div>
        <div class="container c3">
            <div class="abo">
                <h1 class="header">Our Story</h1><br>
                <p class="para">We started with a mission to make blood available for those in need. What began with a small group of volunteers has grown into a community of life-saving donors. Together, we’re helping save lives, one donation at a time.</p>
            </div>
            <div class="image i3">
                <img src="../images/about3.jpg" class="about1_img">
            </div>
        </div>
    
    <script src="../script/scrollreveal.js"></script>
    <script>
        ScrollReveal().reveal('.container.c1', { delay: 100 })
        ScrollReveal().reveal('.container.c2', { delay: 200 })
        ScrollReveal().reveal('.container.c3', { delay: 300 })
     </script>

<?php include '../partials/other/3-footer-area.php';?>