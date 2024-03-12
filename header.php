<?php
include_once 'session.php';
?>
<!doctype html>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

<style>
    html,
    body {
    height: 100%;
    }

    body {
    background-color: #f5f5f5;
    }
</style>
<head>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="index.php" style="margin-left:25px;font-weight:bold;">@ Afna</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <a class="nav-item nav-link active" href="index.php">Domov</a>
      <?php
      if (isset($_SESSION['user_id'])) {
        echo '<a class="nav-item nav-link" href="user.php?user_id='.$_SESSION['user_id'].'">Moj profil</a>';
        echo '<a class="nav-item nav-link" href="profile_edit.php">Uredi profil</a>';
        echo '<a class="nav-item nav-link" href="followers.php">Išči sledilce</a>';
        echo '<a class="nav-item nav-link" href="logout.php">Odjavi se</a>';
      } else {
        echo '<a class="nav-item nav-link" href="login.php">Prijavi se</a>';
        echo '<a class="nav-item nav-link" href="registration.php">Registriraj se</a>';
      }
      ?>
    </div>
  </div>
</nav>
