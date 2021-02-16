<?php

include "broker.php";

$broker=Broker::getBroker();
$req=json_decode($_POST["podaci"]);
if($req->akcija){
    if($req->akcija=='obrisi' && isset($req->id)){
        $broker->izvrsi("delete from sastanak where id=".$req->id);
        if($broker->getRezultat()){
            echo "uspesno obrisan sastanak";
        }else{
            echo $broker->getMysqli()->error;
        }
        exit;
    }
    if(!validirajSastanak($req->sastanak)){
        echo "Losi podaci";
        exit;
    }
    $sastanak=$req->sastanak;
    if($req->akcija=='dodaj'){
        
        
        $broker->izvrsi("insert INTO sastanak(tema,datum,tip,zaposleni) VALUES ('".$sastanak->tema."','".$sastanak->datum."',".$sastanak->tip.",".$sastanak->zaposleni.")");
        $id=$broker->getZadnjiId();
        foreach ($sastanak->clanovi as $clan) {
            $broker->izvrsi("insert INTO zaposleni_sastanak(sastanak,zaposleni) VALUES (".$id.",".$clan.")");
            
        }
        if($broker->getRezultat()){
            echo "uspesno dodat sastanak";
        }else{
            echo $broker->getMysqli()->error;
        }
    }
    if($req->akcija=='izmeni'){
        $broker->izvrsi("update sastanak set tema='".$sastanak->tema."', datum='".$sastanak->datum."', tip=".$sastanak->tip.",zaposleni=".$sastanak->zaposleni." where id=".$sastanak->id);
        if($broker->getRezultat()){
            echo "uspesno dodat sastanak";
        }else{
            echo $broker->getMysqli()->error;
        }
    }
}



function validirajSastanak($sastanak){
    
    return strlen(trim($sastanak->datum))>0 && strlen(trim($sastanak->tema))>0 && intval($sastanak->zaposleni)&& intval($sastanak->tip);
}

?>