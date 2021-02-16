<?php
if(session_status()!=PHP_SESSION_ACTIVE)
    session_start();
?>

<header class="masthead mb-auto">
    <div class="inner">
        <h3 class="masthead-brand">Agenda</h3>
        <nav class="nav nav-masthead justify-content-center">
            <a class="nav-link" href="./index.php">Pocetna</a>
            <a class="nav-link" href="./praznici.php">Neradni dani</a>
            <?php
                if(!isset($_SESSION["zaposleni"])){
                    ?>
                    <a class="nav-link" href="./login.php">Login</a>
                    <?php
                }else{
                    ?>
                    <a class="nav-link" href="./korisnikoviSastanci.php"> Vasi sastanci</a>
                   
                    <?php
                        if($_SESSION["zaposleni"]->kategorija==1){
                    ?>
                    <a class="nav-link" href="./sastanci.php">Sastanci</a>
                    <?php
                        }
                        ?>
                        <a class="nav-link" href="./server/logout.php">Logout</a>
                        <?php
                }
            ?>
        </nav>
    </div>
</header>