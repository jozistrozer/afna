<?php
/*
  Skripta služi posodabljanu profila.
*/
include_once 'session.php';
include_once 'db.php';


/*
  Nabiranje spremenljivk od client-a...
*/
$first_name          = $_POST['first_name'];
$last_name           = $_POST['last_name'];
$telephone           = $_POST['telephone'];
$email               = $_POST['email'];
$relationship_status = $_POST['relationship_status'];
$gender              = $_POST['gender'];
$description         = $_POST['description'];

/*
  V primeru da gre za zamenjavo slike se ta naloži na strežnik
  Pri prikazovanju profilne slike se prikaže zadnja naložena (funkcija profile_picture(p_id))
*/
$target_dir = "slike/";
$target_file = $target_dir . date("YmdHisu") . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    $uploadOk = 1;
  } else {
    $uploadOk = 0;
  }
}

if ($_FILES["fileToUpload"]["size"] > 10000000) {
  $uploadOk = 0;
}

if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
  $uploadOk = 0;
}

//preverim ali so vnešeni vsi obvezni podatki
if (!empty($first_name) && !empty($last_name) && !empty($email)) {
    //vse ok
    $query = "update tab_users
                 set first_name = ?,
                     last_name = ?,
                     email = ?,
                     telephone = ?,
                     relationship_status = ?,
                     gender = ?,
                     description = ?
               where id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$first_name,$last_name,$email,$telephone,$relationship_status,$gender,$description,$_SESSION['user_id']]);

    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            // Zapis v bazo
            $query = "insert into tab_pictures (url, user_id) values (?,?)";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$target_file,$_SESSION['user_id']]);
        }
    }

    header("Location: index.php");
}
else {
    header("Location: profile_edit.php");
}
