<?php

include "broker.php";

$broker=Broker::getBroker();

if($_POST["login"]){
    $username=trim($_POST["username"]);
    $password=trim($_POST["password"]);
    $broker->izvrsi("select * from zaposleni where username='".$username."'and password='".$password."' ");
    $rezultat=$broker->getRezultat();
    $zaposleni =$rezultat->fetch_object();
    if($rezultat){
        header("Location: ../index.php");
        if(session_status()!=PHP_SESSION_ACTIVE){
            session_start();
        
        }
        $_SESSION["zaposleni"]=$zaposleni;
       
    }
    
}



?>