<?php
/*
    Ta stran služi kot urejanje profila in pregled profila odvisno od vhodnih parametrov.
*/
$user_id = $_GET['user_id'];
if (!isset($user_id) || $user_id == null) {
    header('Location: index.php');
}
include_once 'session.php';
include_once 'header.php';
include_once 'db.php';
?>
<link href="css/main.css" rel="stylesheet">

<?php
    /*
        Pridobivanje vseh podatkov podanega uporabnika.
    */
    $query = "select * from tab_users where id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$user_id]);
    $user = $stmt->fetch();
?>
<div class="container">
<div class="profile-wrapper">
    <!-- Profilni del -->
    <?php include_once 'profile.php'; ?>

    <div class="profile-section-main">
        <div class="tab-content profile-tabs-content">
            <div class="tab-pane active" id="profile-overview" role="tabpanel">

                <div class="stream-posts">
                    <?php
                        /*
                            Poizvedovanje vseh objav uporabnika iz view-a v_posts.
                        */
                        $query = "select *
                                    from v_posts
                                   where user_id = ?";
                        $stmt = $pdo->prepare($query);
                        $stmt->execute([$user_id]);

                        /*
                            Prikazovanje vseh objav.
                        */
                        while ($post = $stmt->fetch()) {
                    ?>
                    <div class="stream-post">
                        <div class="sp-author">
                            <a href="user.php?user_id=<?php echo $post['user_id']; ?>" class="sp-author-avatar"><img src="<?php echo $post['profile_pic']; ?>" alt=""></a>
                            <h6 class="sp-author-name"><a href="#"><?php echo $post['first_name'] . ' ' . $post['last_name']?></a></h6></div>
                        <div class="sp-content">
                            <?php
                                /*
                                    Omogočanje brisanje objave, če je prijavljen uporabnik na svojem profilu.
                                */
                                if ($user_id == $_SESSION['user_id']) {
                                    echo '<div style="display:flex;justify-content:right;"><a onclick="return confirm(\'Prepričani?\');" href="post_delete.php?id='. $post['id'] . '" style="color:red;text-decoration:none;">Izbriši</a></div>';
                                }
                            ?>

                            <div class="sp-info">objavljeno <?php echo date("d.m.Y H:i:s", strtotime($post['date_add'])).' '; ?>| <a href=<?php echo 'post.php?id='.$post['id']; ?>>Pojdi na objavo</a></div>
                            <p class="sp-paragraph mb-0"><?php echo $post['description']; ?></p>
                            <hr />
                            <div style="display:flex;gap:50px;flex-wrap:wrap;">
                                <?php
                                    /*
                                        Prikazovanje slik za vsako objavo. Predogled slik je omejen na 5 slik per post.
                                        Za več slik je potrebno iti direktno na objavo (post.php).
                                    */
                                    $query = "select *
                                                from tab_pictures
                                              where post_id = ? limit 5";
                                    $stmt = $pdo->prepare($query);
                                    $stmt->execute([$post['id']]);

                                    while ($post_pic = $stmt->fetch()) {
                                        /*
                                            Fiksiranje slik na width,height
                                            TODO JS: Ob kliku na sliko se poveča. (dialogno okno)
                                        */
                                        echo '<img src="'.$post_pic['url'].'" width=150 height=150>';
                                    }
                                ?>
                            </div>
                            <hr />
                            <!-- Prikazovanje število komentarjev na objavi (podatek se črpa iz view-a) -->
                            <p style="font-weight:bold;">Komentarji: <?php echo $post['num_comments']; ?></p>
                        </div>
                    </div>
                    <?php }; ?>
                </div>
            </div>
        </div>
    </div>
</div>
</div>