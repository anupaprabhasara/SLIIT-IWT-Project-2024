<?php
    session_start();
    
    if(!(($_SESSION['permission'] === 'Update') || ($_SESSION['permission'] === 'All'))) {
        header('Location: ../error/');
        exit();
    }
?>