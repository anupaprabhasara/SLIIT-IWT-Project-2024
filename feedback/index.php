<?php include '../database/conn.php';?>
<?php include '../partials/other/session.php';?>
<?php
    date_default_timezone_set('Asia/Colombo');

    if(!(isset($_SESSION['user_id']))) {
        header('Location: ../login/');
        $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
        exit();
    }

    if(isset($_GET['id'])) {
        $id = intval($_GET['id']);
    }
    else {
        header('Location: ../');
    }
?>
<?php include '../partials/other/1-css-links.php';?>
<title>Feedback</title>
<link rel="stylesheet" href="../css/feedback.css">
    <script src="../script/fontawe.js" crossorigin="anonymous"></script>
<?php include '../partials/other/2-nav-links.php';?>
    <div class="container">
        <div class="leftside">
            <h1>Feedback Form</h1><br>
            <p>Share your thoughts with us! Fill out this form to provide feedback. Your input helps us improve our services.</p>
        </div>
        <div class="rightside">
        <form id="fbForm" method="POST">
                <label for="feedback">Feedback:</label><br>
                <textarea id="feedback" name="feedback" rows="4" cols="50" placeholder="Enter your feedback"></textarea><br>

                <label for="rating">Your Rating:</label><br><br>
                <div class="stars">
                    <input type="radio" id="star5" name="rating" value="1">
                    <label for="star5">
                        <i class="fa-duotone fa-solid fa-star"></i>
                    </label>
                    <input type="radio" id="star4" name="rating" value="2">
                    <label for="star4">
                        <i class="fa-duotone fa-solid fa-star"></i>
                    </label>
                    <input type="radio" id="star3" name="rating" value="3">
                    <label for="star3">
                        <i class="fa-duotone fa-solid fa-star"></i>
                    </label>
                    <input type="radio" id="star2" name="rating" value="4">
                    <label for="star2">
                        <i class="fa-duotone fa-solid fa-star"></i>
                    </label>
                    <input type="radio" id="star1" name="rating" value="5">
                    <label for="star1">
                        <i class="fa-duotone fa-solid fa-star"></i>
                    </label>
                </div><br>
                <p id="responseMessage" class="resmsg"></p>
                <button class="btn submit" type="submit">Submit</button>      
        </form>
        </div>
    </div>  

    <script src="../script/feed-star.js"></script>
    <script src="../script/feedback.js"></script>
    
<?php
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $userid = $_SESSION['user_id'];
        $fbtype = "Event";
        $eventid = $id;
        $rating = $_POST['rating'];
        $feedback = $_POST['feedback'];
        $status = "Pending";
        $createdDate = date('Y-m-d H:i:s');

        $sql = "
            INSERT INTO feedback_info (fb_type, event_id, user_id, rating, comments, status, created_date) 
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('siiisss', $fbtype, $eventid, $userid, $rating, $feedback, $status, $createdDate);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Successfully requested!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Request failed!']);
        }

        $stmt->close();
    }
?>
<?php include '../partials/other/3-footer-area.php';?>