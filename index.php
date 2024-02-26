<?php
include_once 'session.php';
include_once 'header.php';
include_once 'db.php';
?>
<link href="css/main.css" rel="stylesheet">
<style>

    #objave {
        flex-grow: 0;
        flex-shrink: 0;
        flex-basis: 50%;
    }
</style>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
<div class="container">
<div class="profile-wrapper">
    <?php include_once 'profile.php'; ?>
    <!-- /.profile-section-user -->
    <div class="profile-section-main">
        <!-- /.nav-tabs -->
        <!-- Tab panes -->
        <div class="tab-content profile-tabs-content">
            <div class="tab-pane active" id="profile-overview" role="tabpanel">
                <form action="post_insert.php" method="post" enctype="multipart/form-data">
                    <div class="post-editor">
                        <textarea name="post_content" id="post-field" class="post-field" placeholder="Napiši objavo in jo deli s prijatelji!"></textarea>

                        <input class="form-control" type="file" id="formFile" name="fileToUpload[]" multiple>
                        <div class="d-flex">
                            <button style="margin-top:5px;"class="btn btn-success px-4 py-1" type="submit">Objavi</button>
                        </div>
                    </div>
                </form>

                <div class="stream-posts">
                    <?php
                        $query = "select *
                                    from v_posts
                                   where is_follower(?,user_id) = 1";
                        $stmt = $pdo->prepare($query);
                        $stmt->execute([$_SESSION['user_id']]);


                        while ($post = $stmt->fetch()) {
                    ?>
                    <div class="stream-post">
                        <div class="sp-author">
                            <a href="user.php?user_id=<?php echo $post['user_id']; ?>" class="sp-author-avatar"><img src="<?php echo $post['profile_pic']; ?>" alt=""></a>
                            <h6 class="sp-author-name"><a href="#"><?php echo $post['first_name'] . ' ' . $post['last_name']?></a></h6></div>
                        <div class="sp-content">
                            <div class="sp-info">objavljeno <?php echo date("d.m.Y H:i:s", strtotime($post['date_add'])).' '; ?> | <a href=<?php echo 'post.php?id='.$post['id']; ?>>Pojdi na objavo</a></div>
                            <p class="sp-paragraph mb-0"><?php echo $post['description']; ?></p>
                            <hr />
                            <div style="display:flex;gap:50px;flex-wrap:wrap;">
                                <?php
                                    $query1 = "select *
                                                from tab_pictures
                                              where post_id = ? limit 5";
                                    $stmt1 = $pdo->prepare($query1);
                                    $stmt1->execute([$post['id']]);

                                    while ($post_pic = $stmt1->fetch()) {
                                        echo '<img src="'.$post_pic['url'].'" width=150 height=150>';
                                    }
                                ?>
                            </div>
                            <hr />
                            <p style="font-weight:bold;">Komentarji: <?php echo $post['num_comments']; ?></p>
                        </div>
                        <!-- /.sp-content -->
                    </div>

                    <?php }; ?>
                </div>
                <!-- /.stream-posts -->
            </div>
        </div>
        <!-- /.tab-content -->
    </div>
    <!-- /.profile-section-main -->
</div>
</div>