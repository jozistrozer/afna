<?php
session_start();

if (!isset($_SESSION['user_id']) &&
    ($_SERVER['REQUEST_URI'] != '/afna/login.php') &&
    ($_SERVER['REQUEST_URI'] != '/afna/registration.php')) {
    header("Location: login.php");
    die();
}