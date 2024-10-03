<?php include '../database/conn.php';?>
<?php include '../partials/other/session.php';?>
<?php include '../partials/other/1-css-links.php';?>
    <title>Contact</title>
    <style>
    .container {
        background-color: #fffcfc;
        width: 73rem;
        margin: 60px auto auto;
        border: solid 1px;
        border-color: #ffc7c7;
        border-radius: 20px;
        padding: 100px 0;
        display:flex;
        box-shadow: 0 0 5px rgba(0,0,0,0.1);
    }
    .leftside {
        margin-left:100px;
        margin-top:0px;
        height: 400px;
        width: 2200px;
        border-radius: 4%;
        overflow: hidden;
        box-shadow: 0 0 5px rgba(0,0,0,0.1);
    }

    .leftside img {
        height: 400px;
        width: 600px;
        border-radius: 6px;
        filter: grayscale(50%);
        transition: 0.6s ease;
        cursor: pointer;
        box-shadow: 0 0 5px rgba(0,0,0,0.1);
    }

    .leftside img:hover {
        transform: scale(1.3);
        filter: grayscale(0%);
    }

    h1 {
        text-align:left;
        margin-top:30px;
    }

    .rightside {
        margin-left:50px;
        margin-right:100px
    }
    
    .icons1 {
        display: flex;
        align-items: left;
        gap: 36px;
        font-size: 1.5rem;
        
    }

    .icons1 i {
        color: #f54748;
        transition: 0.5s;
    }


    .icons1 i:hover {
        color: #d83e3e;
        transition: 0.5s;
    }
    </style>
    <script src="../script/fontawe.js" crossorigin="anonymous"></script>
    <script src="../script/scrollreveal.js"></script>

<?php include '../partials/other/2-nav-links.php';?>
    <div class="container">
        <div class="leftside">
            <div class="img">
                <img src="../images/contact.jpg" alt="">
            </div>
        </div>
            <div class="rightside">

                <h1 class="header">Contact Us</h1><br>
                <p class="content">We're here to assist you! Whether you have questions about donating or requesting blood, 
                    or any other inquiries, please feel free to reach out to us through the contact methods below.
                     Your support makes a difference, and we're happy to help in any way we can.</p><br><br>
            
                <div class="icons1">
                    <a href="mailto:it23556584@my.sliit.lk"><i class="fa-solid fa-envelope fa-1x"></i></a>
                    <a href="tel:+94712003344"> <i class="fa-solid fa-phone fa-1x"></i></a>
                    <a href="https://www.facebook.com/"><i class="fa-brands fa-facebook fa-1x"></i></a>
                    <a  href="https://x.com/"><i class="fa-brands fa-twitter fa-1x"></i></a>
                </div>
            </div>
          
        </div>

     <script>
        ScrollReveal().reveal('.img', { delay: 200 })
        ScrollReveal().reveal('.header', { delay: 800 })
        ScrollReveal().reveal('.content', { delay: 1400 })
        ScrollReveal().reveal('.icons1', { delay: 2000 })
        ScrollReveal().reveal('.icons2', { delay: 2600 })

     </script>

<?php include '../partials/other/3-footer-area.php';?>