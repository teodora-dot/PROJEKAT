<?php
    if(session_status()!=PHP_SESSION_ACTIVE)
        session_start();
    if(isset($_SESSION["zaposleni"])){
        header("Location: ./sastanci.php");
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./assets/bootstrap.min.css" rel="stylesheet">
    <link href="cover.css" rel="stylesheet">
    <title>Login</title>
</head>

<body class="text-center">

    <div class="cover-container d-flex w-100 h-50 p-3 mx-auto flex-column">
        <?php include "header.php" ?>
        <div class="about-block content content-center" id="about">
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                    </div>
                    <div class="col-md-6">
                        <h2><strong>Login</strong></h2>

                        <form method="POST" action="./server/login.php">

                            <label for="username">Username</label>
                            <input type="text" placeholder="Unesite username" id="username" name="username"
                                class="form-control">
                            <label for="password">Password</label>
                            <input type="password" placeholder="Unesite password" id="password" name="password"
                                class="form-control">
                            <label for="submit"></label>
                            <input type="submit" value="Uloguj se" id="submit" name="login"
                                class=" btn btn-primary margin-top-10">
                        </form>
                    </div>
                    <div class="col-md-3">
                    </div>
                </div>
            </div>
        </div>


    </div>
    <?php include "footer.php" ?>

</body>

</html>