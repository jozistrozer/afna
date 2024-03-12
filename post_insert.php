<?php
include_once 'session.php';
include_once 'db.php';

$user_id = $_SESSION['user_id'];
$description = $_POST['post_content'];

//preverim ali so vnešeni vsi obvezni podatki
if (!empty($description)) {
    //vse ok
    $query = "insert into tab_posts(description, date_add, user_id)
                   values (?, now(), ?)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$description, $user_id]);

    // Ne najdem funkcije, da bi vrnala zadnji insertiran ID razen selecta.
    $query = "select * from tab_posts where user_id = ? order by id desc limit 1";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$user_id]);
    $last_id = $stmt->fetch();
    $last_id = $last_id['id'];

    $target_dir = "slike/";

    $files = $_FILES['fileToUpload'];
    $total_count = count($files['name']);

    print_r($files);
    for( $i=0 ; $i < $total_count ; $i++ ) {

        $uploadOk = 1;
        $tmpFilePath = $files['tmp_name'][$i];
        $imageFileType = strtolower(pathinfo($files['name'][$i] ,PATHINFO_EXTENSION));

        $target_file = $target_dir . date("YmdHisu") . basename($files["name"][$i]);

        if($imageFileType == "image/jpeg" || $imageFileType != "image/png") {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
        }

        if ($uploadOk == 1) {
            if (move_uploaded_file($files["tmp_name"][$i], $target_file)) {
                // Zapis v bazo
                $query = "insert into tab_pictures (url, post_id) values (?,?)";
                $stmt = $pdo->prepare($query);
                $stmt->execute([$target_file,$last_id]);
            }
        }

    }

    header("Location: user.php?user_id=".$user_id);
}
else {
    header("Location: index.php");
}
