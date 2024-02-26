<?php
include_once 'session.php';
include_once 'db.php';
include_once 'header.php';

?>

<html lang="en">
  <head>
    <title>@ - Urejanje profila</title>
    <link href="css/login.css" rel="stylesheet">
  </head>
  <body class="text-center">

  <form action="user_update.php" method="post" class="form-signin" enctype="multipart/form-data">
  <?php
    $query = "select *,profile_picture(?) profilna_slika from tab_users where id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$_SESSION['user_id'],$_SESSION['user_id']]);
    $user = $stmt->fetch();
  ?>
  <h1 class="h3 mb-3 font-weight-normal">Urejanje profila</h1>
  <img src="<?php echo $user['profilna_slika']; ?>" width=100 height=100 style="margin-bottom:5px;">
  <input class="form-control" type="file" id="formFile" name="fileToUpload">

  <hr />

  <input type="input" name="first_name" class="form-control" placeholder="Ime" required autofocus value="<?php echo $user['first_name']; ?>">
  <input type="input" name="last_name"  class="form-control" placeholder="Priimek" required value="<?php echo $user['last_name']; ?>">

  <div class="form-check">
    <input class="form-check-input" type="radio" name="gender" value="0" id="flexRadioDefault1" <?php if ($user['gender'] == 0) { echo 'checked';}?>>
    <label class="form-check-label" for="flexRadioDefault1">
      Moški
    </label>
  </div>
  <div class="form-check">
    <input class="form-check-input" type="radio" name="gender" value="1" id="flexRadioDefault2" <?php if ($user['gender'] == 1) { echo 'checked';}?>>
    <label class="form-check-label" for="flexRadioDefault2">
      Ženska
    </label>
  </div>
  <input type="email"     name="email"      class="form-control" placeholde  r="E-Mail" value="<?php echo $user['email']; ?>">
  <input type="telephone" name="telephone"  class="form-control" placeholder="Telefon" value="<?php echo $user['telephone']; ?>">
  <div class="form-check">
    <input class="form-check-input" type="radio" value="0" name="relationship_status" id="flexRadioDefault3" <?php if ($user['relationship_status'] == 0) { echo 'checked';}?>>
    <label class="form-check-label" for="flexRadioDefault3">
      Samski/samska
    </label>
  </div>
  <div class="form-check">
    <input class="form-check-input" type="radio" value="1" name="relationship_status" id="flexRadioDefault4" <?php if ($user['relationship_status'] == 1) { echo 'checked';}?>>
    <label class="form-check-label" for="flexRadioDefault4">
      V razmerju
    </label>
  </div>
  <div class="form-check">
    <input class="form-check-input" type="radio" value="2" name="relationship_status" id="flexRadioDefault5" <?php if ($user['relationship_status'] == 2) { echo 'checked';}?>>
    <label class="form-check-label" for="flexRadioDefault5">
      Zapleteno je
    </label>
  </div>
  <div class="form-check" style="margin-top:25px;">
    <div class="form-group">
      <label for="exampleFormControlTextarea1">Opis profila</label>
      <textarea class="form-control" id="post-field" name="description" rows="3" placeholder="Tvoj opis"><?php echo $user['description']; ?></textarea>
    </div>
  </div>
  <button class="btn btn-lg btn-primary btn-block" style="margin-top:20px;" type="submit">Shrani podatke</button>
    </form>


  </body>
</html>
