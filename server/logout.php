<?php
if(session_status()!=PHP_SESSION_ACTIVE)
    session_start();
if(isset($_SESSION["zaposleni"])){
    $_SESSION["zaposleni"]=null;
    session_destroy();
    header("Location: ../index.php");
}

?>