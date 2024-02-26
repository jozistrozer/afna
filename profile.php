<?php
    include_once 'session.php';
    include_once 'db.php';
    $own_profile = 0;
    if (isset($_GET['user_id'])) {
        $user_id = $_GET['user_id'];
    } else {
        $user_id = $_SESSION['user_id'];
    }

    $query = "select *, profile_picture(id) slika from tab_users where id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$user_id]);
    $user = $stmt->fetch();


    if ($user['relationship_status'] == 0) {
        $relationship_status = 'Samski/samska';
    } elseif ($user['relationship_status'] == 1) {
        $relationship_status = 'V razmerju';
    } elseif ($user['relationship_status'] == 2) {
        $relationship_status = 'Zapleteno je';
    } else {
        $relationship_status = '';
    }

    $query = "select count(*) cnt from tab_user_follower where user_id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$user_id]);
    $num_followers = $stmt->fetch();
    $num_followers = $num_followers['cnt'];


    $query = "select count(*) cnt from tab_user_follower where follower_id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$user_id]);
    $num_following = $stmt->fetch();
    $num_following = $num_following['cnt'];

?>

<div class="profile-section-user" style="margin-top:15%;">

    <div class="profile-info-brief p-3"><img class="img-fluid user-profile-avatar" src="<?php echo $user['slika']; ?>" alt="">
        <div class="text-center">
            <h5 class="text-uppercase mb-4"><?php echo '@ ' . $user['first_name'] . ' ' . $user['last_name']; ?></h5>
            <p class="text-muted fz-base"><?php echo $user['description']; ?></p>

            <p>Sledilcev: <?php echo $num_followers; ?><span style="color:grey;margin-right:10px;margin-left:10px;">.</span> Sledi: <?php echo $num_following; ?></p>
        </div>
    </div>

    <form action="follow.php" method="post">
    <input type="hidden" name="user_id" value="<?php echo $user_id ?>" />
    <div style="display:flex;justify-content:center;">
    <?php
        if ($user_id != $_SESSION['user_id']) {
            $query = "select is_follower(?,?) is_following";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$_SESSION['user_id'],$user_id]);
            $following = $stmt->fetch();

            if ($following['is_following'] == 1) {
                echo '<button type="submit" name="unfollow" type="button" class="btn btn-light" style="margin-bottom:25px;">Odsledi</button>';
            } else {
                echo '<button type="submit" name="follow" type="button" class="btn btn-primary" style="margin-bottom:25px;">Sledi</button>';
            }
        }
    ?>
    </div>
    </form>

    <hr class="m-0">
    <div class="hidden-sm-down">
        <hr class="m-0">
        <div class="profile-info-contact p-4">
            <h6 class="mb-3">Podatki</h6>
            <table class="table">
                <tbody>
                    <tr>
                        <td><strong>Telefon:</strong></td>
                        <td>
                            <p class="text-muted mb-0"><?php echo $user['telephone']; ?></p>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Status:</strong></td>
                        <td>
                            <p class="text-muted mb-0"><?php echo $relationship_status; ?></p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <hr class="m-0">
    </div>
</div>