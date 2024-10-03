<?php include './database/conn.php';?>
<?php include './partials/root/session.php';?>
<?php include './partials/root/1-css-links.php';?>
    <title>HopeFlow</title>
    <style>
        .service__card img {
            height: 100px;
            width: 100px;
        }
    </style>
    <script src="./script/jquery-3.1.1.min.js"></script>
    <script src="./script/videopopup.js"></script>
    <link rel="stylesheet" href="./css/videopopup.css" media="screen">
<?php include './partials/root/2-nav-links.php';?>
        <div class="section__container header__container" id="home">
            <div class="header__image">
                <img src="./images/header.png">
            </div>
            <div class="header__content">
                <div class="header__tag">Together, We Save Lives<img src="./images/icon-header.png"></div>
                <h1>Donate <span>Blood</span> Save Lives</h1>
                <p class="section__description">
                    Join hands with us at HopeFlow and become a lifeline-your blood donation can bring hope and save lives.
                </p>
                <div class="header__btns">
                    <a href="./donate/"><button class="btn">Donate Now</button></a>
                    <a href="javascript:void(0)" id="video1"><span><i class="ri-play-fill"></i></span>Watch Video</a>
                </div>
            </div>
        </div>
    </header>
    <section class="section__container service__container" id="service">
        <p class="section__subheader">OUR SERVICES</p>
        <h2 class="section__header">Your Trusted Partner in Saving Lives</h2>
        <div class="service__grid">
            <div class="service__card">
                <img src="./images/service-1.jpg">
                <h4>Blood Donations</h4>
                <p>You can donate blood through us and help save lives</p>
            </div>
            <div class="service__card">
                <img src="./images/service-2.jpg">
                <h4>Health Checkups</h4>
                <p>Schedule regular health checkups with us to stay healthy</p>
            </div>
            <div class="service__card">
                <img src="./images/service-3.jpg">
                <h4>Blood Requests</h4>
                <p>Request a blood donation through our organization</p>
            </div>
        </div>
    </section>
    <section class="download__container" id="contact">
        <div class="section__container">
            <div class="download__image">
                <img src="./images/download.png">
            </div>
            <div class="download__content">
                <p class="section__subheader">DOWNLOAD HOPEFLOW APP</p>
                <h2 class="section__header">HopeFlow Now Available on Mobile!</h2>
                <p class="section__description">
                    Inspire life-saving blood donations, ensuring every patient in need receives support through the generosity of our donors.
                </p>
                <div class="download__btn">
                    <a href="https://play.google.com/"><button class="btn">Download</button></a>
                </div>
            </div>
        </div>
    </section>
    <div id="vidBox">
        <div id="videCont">
		<video id="v1" loop controls="controls" controlsList="nodownload">
            <source src="../videos/donation_video.mp4" type="video/mp4">
        </video>
        </div>
    </div>
        <script type="text/javascript">
            $(function () {
               $('#vidBox').VideoPopUp({
                	backgroundColor: "#17212a",
                	opener: "video1",
                    maxweight: "640",
                    idvideo: "v1"
                });
            });
        </script>
<?php include './partials/root/3-footer-area.php';?>