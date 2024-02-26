<?php
include_once 'db.php';

$username = $_POST['username'];
$password = $_POST['password'];
print_r($_POST);
//preverim ali je user vnese email/username in pass
if (!empty($username) && !empty($pass)) {
    $query = "select * from tab_users where email = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        //podatki so pravilni
        session_start();
        $_SESSION['user_id'] = $user['id'];
        header("Location: index.php");
    }
    else {
        header("Location: login.php?p_error=1");
    }
}