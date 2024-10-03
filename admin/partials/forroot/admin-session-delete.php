<?php
    session_start();
    
    if(!($_SESSION['permission'] === 'All')) {
        exit();
    }
?>