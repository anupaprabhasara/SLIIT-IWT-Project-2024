<?php include '../database/conn.php';?>
<?php include '../partials/other/session.php';?>
<?php include '../partials/other/1-css-links.php';?>
    <title>FAQs</title>
<?php include '../partials/other/2-nav-links.php';?>

<style>
    .accordion {
        width: 73rem;
        margin: 50px auto;
    }

    .accordion h2 {
        text-align: center;
        margin-top: 100px;
        margin-bottom: 10px;
    }

    .accordion-item {
        margin: 20px 0;
        border-bottom: 1px solid #ccc;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 0 5px rgba(0,0,0,0.1);
    }

    .accordion-header {
        width: 100%;
        background-color: #f5f5f5;
        border: none;
        outline: none;
        padding: 15px;
        text-align: left;
        font-size: 18px;
        cursor: pointer;
        position: relative;
        border-radius: 10px 10px 0 0;
    }

    .accordion-header::after {
        content: '+';
        font-size: 20px;
        position: absolute;
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
    }

    .accordion-header.active::after {
        content: '-';
    }

    .accordion-content {
    padding: 0 20px;
    display: block;
    max-height: 0;
    overflow: hidden;
    background-color: white;
    transition: max-height 0.3s ease-out;
    border-radius: 0 0 10px 10px;
    }

    .accordion-content p {
        padding: 20px 0;
    }

    .accordion-content ul {
        padding: 20px 0;
    }

    .accordion-header.active + .accordion-content {
        max-height: 500px;
    }
    .dropdownx:hover .dropdown-contentx {
        display: none;
    }
    .menuandalertbtn:hover .dropdown-contentx {
        display: none;
    }
</style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frequently Asked Questions</title>
</head>
<body>

<div class="accordion">
    <h2>Frequently Asked Questions</h2>
    <br>

    <div class="accordion-item">
        <button class="accordion-header">Who can donate blood?</button>
        <div class="accordion-content">
            <p>Anyone who is healthy, weighs at least 50 kg (110 lbs), and is aged 18 to 65 years can typically donate blood. Some factors like medical conditions, medications, and travel history may impact your eligibility.</p>
        </div>
    </div>
    <div class="accordion-item">
        <button class="accordion-header">What types of blood donations can I make?</button>
        <div class="accordion-content">
            <br>
            <ul>
                <li><b>Whole blood</b>: This is the most common type of donation, where you donate all blood components.</li><br>
                <li><b>Plasma</b>: Used to help patients with clotting issues, plasma is separated from your blood.</li><br>
                <li><b>Platelets</b>: These are essential for cancer patients and those undergoing surgeries.</li><br>
                <li><b>Double red cells</b>: A special process collects two units of red blood cells while returning the plasma and platelets to your body.</li><br>
            </ul>
        </div>
    </div>
    <div class="accordion-item">
        <button class="accordion-header">How often can I donate blood?</button>
        <div class="accordion-content">
            <p>You can donate whole blood every 56 days (approximately every 8 weeks). For other types of donations, such as platelets or plasma, the interval may be shorter.</p>
        </div>
    </div>
    <div class="accordion-item">
        <button class="accordion-header">How long does the blood donation process take?</button>
        <div class="accordion-content">
            <p>Blood collection only takes about 15 minutes.</p>
        </div>
    </div>
    <div class="accordion-item">
        <button class="accordion-header">Can I donate blood if I have a tattoo or piercing?</button>
        <div class="accordion-content">
            <p>If your tattoo or piercing was done in a licensed facility using sterile needles, you may donate blood after a brief waiting period (usually 3 to 6 months, depending on the region). If unsure, check with the blood donation center.</p>
        </div>
    </div>
    <div class="accordion-item">
        <button class="accordion-header">Can I donate if I am on medication?</button>
        <div class="accordion-content">
            <p>It depends on the type of medication. Some medications may prevent you from donating temporarily or permanently. Consult the donation center for specific details about your medication.</p>
        </div>
    </div>
    <div class="accordion-item">
        <button class="accordion-header">How can I register to donate blood?</button>
        <div class="accordion-content">
            <p>You can register online through our website, visit any blood donation center, or participate in mobile blood drives. Check the upcoming donation events or contact our center for more information.</p>
        </div>
    </div>
    <div class="accordion-item">
        <button class="accordion-header">What should I do before donating blood?</button>
        <div class="accordion-content">
        <br>
            <ul>
                <li>Get a good night's sleep.</li><br>
                <li>Eat a healthy meal a few hours before donation (avoid fatty foods).</li><br>
                <li>Drink plenty of water or other non-alcoholic fluids.</li><br>
                <li>Bring your NIC or any type of identification document.</li><br>
            </ul>
        </div>
    </div>
    <div class="accordion-item">
        <button class="accordion-header">Can I donate if I’ve traveled outside the country?</button>
        <div class="accordion-content">
            <p>Travel to certain regions with a risk of infectious diseases, such as malaria, may result in temporary deferral from blood donation. You will need to discuss your travel history with the donation center staff.</p>
        </div>
    </div>
    <div class="accordion-item">
        <button class="accordion-header"> What should I eat after donating blood?</button>
        <div class="accordion-content">
            <p>After donating, it’s important to replenish your energy with snacks, such as fruit, crackers, and juice. Drinking extra fluids throughout the day is also advised to help your body recover.</p>
        </div>
    </div>
</div>

<script src="../script/faqs.js"></script>
</body>
</html>

<?php include '../partials/other/3-footer-area.php';?>