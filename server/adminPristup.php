<?php

include "vratiNaLogin.php";
if($_SESSION["zaposleni"]->kategorija>1){
    header("Location: ./index.php");
}

?>