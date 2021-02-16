<?php
include "broker.php";
if(session_status()!=PHP_SESSION_ACTIVE)
    session_start();
$broker=Broker::getBroker();

if(isset($_SESSION["zaposleni"])){
    $broker->izvrsi("select s.tema, s.datum, z2.username, t.naziv as 'kategorija' from sastanak s inner join zaposleni_sastanak zs on (zs.sastanak=s.id)inner join zaposleni z on(z.id=zs.zaposleni) inner join tip_sastanka t on (t.id=s.tip) inner join zaposleni z2 on (z2.id=s.zaposleni) where z.id=".$_SESSION["zaposleni"]->id);
    $niz =  [];
	while ($red = $broker->getRezultat()->fetch_object())
	{
		array_push($niz,$red);
	}
	echo json_encode($niz);
}


?>