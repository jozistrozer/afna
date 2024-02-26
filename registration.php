<?php include_once 'header.php'; ?>

<html lang="en">
  <head>
    <title>@ - Registracija</title>
    <link href="css/login.css" rel="stylesheet">
  </head>
  <body class="text-center">
    <form action="user_insert.php" method="post" class="form-signin">
      <img class="mb-4" src="img/logo.png" alt="" width="72" height="72">
      <h1 class="h3 mb-3 font-weight-normal">Registriraj se</h1>

      <input type="input"     name="first_name" class="form-control" placeholder="Ime" required autofocus>
      <input type="input"     name="last_name"  class="form-control" placeholder="Priimek" required>
      <input type="password"  name="password"   class="form-control" placeholder="Geslo" required>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="gender" id="flexRadioDefault1" checked>
        <label class="form-check-label" for="flexRadioDefault1">
          Moški
        </label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="gender" id="flexRadioDefault2">
        <label class="form-check-label" for="flexRadioDefault2">
          Ženska
        </label>
      </div>
      <input type="email"     name="email"      class="form-control" placeholder="E-Mail" required>
      <input type="telephone" name="telephone"  class="form-control" placeholder="Telefon">
      <div class="form-check">
        <input class="form-check-input" type="radio" name="relationship_status" id="flexRadioDefault3" checked>
        <label class="form-check-label" for="flexRadioDefault3">
          Samski/samska
        </label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="relationship_status" id="flexRadioDefault4">
        <label class="form-check-label" for="flexRadioDefault4">
          V razmerju
        </label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="relationship_status" id="flexRadioDefault5">
        <label class="form-check-label" for="flexRadioDefault5">
          Zapleteno je
        </label>
      </div>

      <button class="btn btn-lg btn-primary btn-block" style="margin-top:20px;" type="submit">Registriraj se</button>
    </form>
  </body>
</html>
