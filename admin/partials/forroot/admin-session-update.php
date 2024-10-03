<?php
    session_start();
    
    if(!($_SESSION['permission'] === 'All')) {
        header('Location: ./error/');
        exit();
    }
?>