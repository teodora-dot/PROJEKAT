<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="#">

    <title>Pocetna strana</title>

    <link href="./assets/bootstrap.min.css" rel="stylesheet">

    <link href="cover.css" rel="stylesheet">
  </head>

  <body class="text-center">
    <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
     <?php include "header.php" ?>
      <div id="vreme">

      </div>
      <main role="main" class="inner cover">
        <h1 class="cover-heading">Zdravo!</h1>
        <p class="lead">Zakažite svoje sastanke.</p>
        <p class="lead">
          <?php 
          if(session_status()!=PHP_SESSION_ACTIVE)
          session_start();
          if(!isset($_SESSION["zaposleni"])){
            ?>
            <a href="./login.php" class="btn btn-lg btn-secondary">Uloguj se</a>
            <?php
          }else{
            ?>
            <a href="./korisnikoviSastanci.php" class="btn btn-lg btn-secondary">Vidi svoje sastanke</a>
            <?php
          }

?>
        </p>
      </main>
      <?php include "footer.php" ?>
     
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="./assets/jquery-slim.min.js"><\/script>')</script>
    <script src="./assets/popper.min.js"></script>
    <script src="./assets/bootstrap.min.js"></script>
  </body>
</html>
