<?php
  include_once 'header.php';
  if (!empty($_GET)) {
    $error = $_GET['p_error'];
  } else {
    $error = 0;
  }
?>

<html lang="en">
  <head>
    <title>@ - Prijava</title>
    <link href="css/login.css" rel="stylesheet">
  </head>
  <body class="text-center">
    <form action="login_check.php" method="post" class="form-signin">
      <img class="mb-4" src="img/logo.png" alt="" width="72" height="72">
      <h1 class="h3 mb-3 font-weight-normal">Prijavi se</h1>

      <input type="input"    name="username" class="form-control" placeholder="Email naslov" required autofocus>
      <input type="password" name="password" class="form-control" placeholder="Geslo" required>
      <?php if ($error == 1) { ?>
      <span style="color:red;font-weight:bold;">Email ali geslo je napačno!</span>
      <?php } ?>
      <button class="btn btn-lg btn-primary btn-block" type="submit">Prijavi se</button>
    </form>
  </body>
</html>
