<?php include '../database/conn.php';?>
<?php include '../partials/other/session.php';?>

<?php
    $sqle = "SELECT
            ei.event_id,
            ei.event_name,
            ci.city_name,
            ei.event_date,
            si.sf_name,
            si.sl_name,
            ei.event_type,
            ei.capacity,
            ei.status,
            ei.last_updated
        FROM
            event_info ei
        LEFT JOIN
            city_info ci ON ei.location_id = ci.city_id
        LEFT JOIN
            staff_info si ON ei.organizer_id = si.staff_id";

    
?>

<?php include '../partials/other/1-css-links.php'; ?>
<title>Events</title>
<link rel="stylesheet" href="../css/events.css">
<script src="../script/scrollreveal.js"></script>
<?php include '../partials/other/2-nav-links.php'; ?>

<div class="container">
    <h1 class="heading">Upcoming Events</h1><br>

    <?php
        $resulte = $conn->query($sqle);
        $counting = 0;
        if($resulte->num_rows > 0) {
            while($event = $resulte->fetch_assoc()) {
                if($event['status'] == "Upcoming") {
                ?>
    <div class="box1">  
         
        <div class="event1">
            <h2><?php echo $event['event_name']; ?></h2><br>
        
            <div class="details">    
                <div class="details_r1">
                    <p><b>Date:</b> <?php echo $event['event_date']; ?><br></p>
                    
                    <p><b>Capacity:</b> <?php echo $event['capacity']; ?></p>
                </div>

                <div class="details_r2">
                    <p><b>Event Type:</b> <?php echo $event['event_type']; ?></p>
                    <p><b>Location:</b> <?php echo $event['city_name']; ?></p>
                   
                </div>
            </div>
        </div>

        <div class="details_r3">
            <p class="left-align"><b>Organizer:</b> <?php echo $event['sf_name'] . " " . $event['sl_name']; ?></p>
            <p class="right-align"><b>Created On:</b> <?php echo $event['last_updated']; ?></p>
        </div>
    </div>
    <?php
    $counting += 1;
            }
    }
    }
    if($counting == 0) {
        ?>
    <p class="no-records">No Upcoming Events Found!</p>
    <?php
}
    ?>


    <h1 class="heading">Ongoing Events</h1><br>

    <?php
        $resultf = $conn->query($sqle);
        $counting = 0;
        if($resultf->num_rows > 0) {
            while($event = $resultf->fetch_assoc()) {
                if($event['status'] == "Ongoing") {
                ?>
    <div class="box1">  
         
        <div class="event1">
            <h2><?php echo $event['event_name']; ?></h2><br>
        
            <div class="details">    
                <div class="details_r1">
                    <p><b>Date:</b> <?php echo $event['event_date']; ?><br></p>
                    
                    <p><b>Capacity:</b> <?php echo $event['capacity']; ?></p>
                </div>

                <div class="details_r2">
                    <p><b>Event Type:</b> <?php echo $event['event_type']; ?></p>
                    <p><b>Location:</b> <?php echo $event['city_name']; ?></p>
                   
                </div>
            </div>
        </div>

        <div class="details_r3">
            <p class="left-align"><b>Organizer:</b> <?php echo $event['sf_name'] . " " . $event['sl_name']; ?></p>
            <p class="right-align"><b>Created On:</b> <?php echo $event['last_updated']; ?></p>
        </div>
    </div>
    <?php
    $counting += 1;
            }
    }
    }
    if($counting == 0) {
        ?>
    <p class="no-records">No Previous Events Found!</p>
    <?php
}
    ?>


    <h1 class="heading">Previous Events</h1><br>

    <?php
        $resultg = $conn->query($sqle);
        $counting = 0;
        if($resultg->num_rows > 0) {
            while($event = $resultg->fetch_assoc()) {
                if($event['status'] == "Previous") {
                ?>
    <div class="box1">  
         
        <div class="event1">
            <h2><?php echo $event['event_name']; ?></h2><br>
        
            <div class="details">    
                <div class="details_r1">
                    <p><b>Date:</b> <?php echo $event['event_date']; ?><br></p>
                    
                    <p><b>Capacity:</b> <?php echo $event['capacity']; ?></p>
                </div>

                <div class="details_r2">
                    <p><b>Event Type:</b> <?php echo $event['event_type']; ?></p>
                    <p><b>Location:</b> <?php echo $event['city_name']; ?></p>
                   
                </div>
            </div>
        </div>

        <div class="details_r3">
            <p class="left-align"><b>Organizer:</b> <?php echo $event['sf_name'] . " " . $event['sl_name']; ?></p>
            <p class="right-align"><b>Created On:</b> <?php echo $event['last_updated']; ?></p>
        </div>

        <div class="feedback-btn-container">
            <a href="../feedback/?id=<?php echo $event['event_id']; ?>" class="feedback-btn">Give Feedback</a>
        </div>
    </div>
    <?php
    $counting += 1;
            }
    }
    }
    if($counting == 0) {
        ?>
    <p class="no-records">No Previous Events Found!</p>
    <?php
}
    ?>
     
</div>

</div>

<script src="../script/events.js"></script>


<?php include '../partials/other/3-footer-area.php'; ?>