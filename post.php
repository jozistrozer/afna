<?php
include_once 'session.php';
include_once 'header.php';
include_once 'db.php';
?>

<?php
    $query = "select *
                from v_posts
                where id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$_GET['id']]);


    while ($post = $stmt->fetch()) {
?>
<link href="css/main.css" rel="stylesheet">
<div class="stream-post">
    <div class="sp-author">
        <a href="user.php?user_id=<?php echo $post['user_id']; ?>" class="sp-author-avatar"><img src="<?php echo $post['profile_pic']; ?>" alt=""></a>
        <h6 class="sp-author-name"><a href="#"><?php echo $post['first_name'] . ' ' . $post['last_name']?></a></h6></div>
    <div class="sp-content">
        <div class="sp-info">objavljeno <?php echo $post['date_add']; ?></div>
        <p class="sp-paragraph mb-0"><?php echo $post['description']; ?></p>
        <hr />
        <div style="display:flex;gap:50px;flex-wrap:wrap;">
            <?php
                $query = "select *
                            from tab_pictures
                            where post_id = ? limit 5";
                $stmt = $pdo->prepare($query);
                $stmt->execute([$post['id']]);

                while ($post_pic = $stmt->fetch()) {
                    echo '<img src="'.$post_pic['url'].'" width=150 height=150>';
                }
            ?>
        </div>
        <hr />
        <p style="font-weight:bold;">Komentarji: <?php echo $post['num_comments']; ?></p>
        <?php
            $query = "select a.content, b.first_name, b.last_name, a.date_add, b.id user_id, profile_picture(b.id) user_pic
                        from tab_comments a
                        join tab_users b
                          on a.user_id = b.id
                       where post_id = ?
                       order by date_add desc";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$_GET['id']]);

            while ($comment = $stmt->fetch()) {
        ?>
        <div class="stream-post">
            <div class="sp-author">
                <a href="<?php echo 'user.php?user_id='.$comment['user_id'] ?>" class="sp-author-avatar"><img src="<?php echo $comment['user_pic']; ?>" alt=""></a>
                <h6 class="sp-author-name"><a href="user.php?id=<?php echo $comment['user_id']; ?>"><?php echo $comment['first_name'] . ' ' . $comment['last_name']; ?></a></h6></div>
            <div class="sp-content">
                <div class="sp-info">objavljeno <?php echo $comment['date_add']; ?></div>
                <p class="sp-paragraph mb-0"><?php echo $comment['content']; ?></p>
            </div>
            <!-- /.sp-content -->
        </div>
        <?php } ?>
        <form action="comment_insert.php" method="post">
            <div class="post-editor">
                <input name="post_id" type="hidden" value="<?php echo $_GET['id']; ?>" />
                <textarea name="comment_content" id="post-field" class="post-field" placeholder="Dodaj komentar"></textarea>

                <div class="d-flex">
                    <button style="margin-top:5px;"class="btn btn-success px-4 py-1" type="submit">Komentiraj</button>
                </div>
            </div>
        </form>
    </div>

</div>
<?php } ?>