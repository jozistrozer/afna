<?php
include_once 'db.php';
include_once 'session.php';

if (isset($_GET['id'])) {
    $query = "delete from tab_pictures where post_id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$_GET['id']]);

    $query = "delete from tab_posts where id = ? and user_id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$_GET['id'], $_SESSION['user_id']]);
}

header('Location: user.php?user_id='.$_SESSION['user_id']);

?>
