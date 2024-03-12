<?php
  include_once 'header.php';
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
      <button class="btn btn-lg btn-primary btn-block" type="submit">Prijavi se</button>
    </form>
  </body>
</html>
