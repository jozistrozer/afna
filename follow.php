<?php
include_once 'db.php';
include_once 'session.php';

if (array_key_exists('follow', $_POST)) {
    $query = "insert into tab_user_follower(user_id, follower_id) values (?, ?)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$_POST['user_id'],$_SESSION['user_id']]);
} elseif (array_key_exists('unfollow', $_POST)) {
    $query = "delete from tab_user_follower where user_id = ? and follower_id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$_POST['user_id'],$_SESSION['user_id']]);
}

header('Location: user.php?user_id='.$_POST['user_id']);

?>
