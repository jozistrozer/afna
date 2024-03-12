<?php
/*
    Skripta vstavi uporabnika v bazo
*/
include_once 'db.php';

$first_name          = $_POST['first_name'];
$last_name           = $_POST['last_name'];
$telephone           = $_POST['telephone'];
$email               = $_POST['email'];
$pass                = $_POST['password'];
$relationship_status = $_POST['relationship_status'];
$gender              = $_POST['gender'];

//preverim ali so vnešeni vsi obvezni podatki
if (!empty($first_name) && !empty($last_name) && !empty($email) && !empty($pass)) {
    //vse ok
    $pass = password_hash($pass, PASSWORD_DEFAULT);
    $query = "insert into tab_users(first_name, last_name, password, email, telephone, relationship_status, gender)
                   values (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$first_name,$last_name,$pass,$email,$telephone,$relationship_status,$gender]);
    //preusmeri na login
    header("Location: login.php");
}
else {
    //preusmeri nazaj na registracijo
    header("Location: registration.php");
}
