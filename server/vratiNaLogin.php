<?php
if(session_status()!=PHP_SESSION_ACTIVE)
    session_start();
if(!isset($_SESSION["zaposleni"])){
    header("Location: ./login.php");
}

?>