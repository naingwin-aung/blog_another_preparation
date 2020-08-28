<?php
    session_start();
    require_once('../config/admin_config.php');
    if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
      header("location: login.php"); 
    }
    if($_SESSION['role'] != 1) {
      header("location: login.php");
    }