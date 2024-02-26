<?php
include_once 'db.php';
include_once 'session.php';

$post_id          = $_POST['post_id'];
$comment_content  = $_POST['comment_content'];

//preverim ali so vnešeni vsi obvezni podatki
if (!empty($comment_content)) {
    $query = "insert into tab_comments (content, date_add, post_id, user_id) values (?, now(), ?, ?)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$comment_content, $post_id, $_SESSION['user_id']]);
}
header("Location: post.php?id=".$post_id);

