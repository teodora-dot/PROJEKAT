<?php
require 'flight/Flight.php';
require 'jsonindent.php';

//registracija baze Database
Flight::register('db', 'Database', array('nitro'));

Flight::route('/', function(){
	die("Izabereti neku od ruta...");
});
Flight::route('GET /sastanak.json',function(){
    header("Content-Type: application/json; charset=utf-8");    
    $db = Flight::db();
	$db->ExecuteQuery("select s.id,s.tema, s.datum, z.ime,z.prezime, t.naziv, s.tip as 'tip_id', s.zaposleni as 'zaposleni_id' from sastanak s inner join zaposleni z on(z.id=s.zaposleni) inner join tip_sastanka t on (t.id=s.tip)");

	$niz =  [];
	while ($red = $db->getResult()->fetch_object())
	{
		array_push($niz,$red);
	}
	echo indent(json_encode($niz));
});
Flight::route('GET /sastanak.xml',function(){
	
	header("Content-Type: application/xml");
    $db = Flight::db();
	$db->ExecuteQuery("select s.id,s.tema, s.datum, z.ime,z.prezime, t.naziv, s.tip as 'tip_id', s.zaposleni as 'zaposleni_id' from sastanak s inner join zaposleni z on(z.id=s.zaposleni) inner join tip_sastanka t on (t.id=s.tip)");

	$dom = new DomDocument('1.0','utf-8');
	if(!$db->getResult()){
		$greska = $dom->appendChild($dom->createElement('greska'));
	}else{
		$sastanci = $dom->appendChild($dom->createElement('sastanci'));
		while ($red = $db->getResult()->fetch_object()){
            
            $sastanak = $sastanci->appendChild($dom->createElement('sastanak'));
            
			$id = $sastanak->appendChild($dom->createElement('id'));
            $id->appendChild($dom->createTextNode($red->id));
            
			$tema = $sastanak->appendChild($dom->createElement('tema'));
            $tema->appendChild($dom->createTextNode($red->tema));

            $datum = $sastanak->appendChild($dom->createElement('datum'));
			$datum->appendChild($dom->createTextNode($red->datum));
            
            $ime = $sastanak->appendChild($dom->createElement('ime'));
            $ime->appendChild($dom->createTextNode($red->ime));
            
            $prezime = $sastanak->appendChild($dom->createElement('prezime'));
            $prezime->appendChild($dom->createTextNode($red->prezime));
            
            $tip_id = $sastanak->appendChild($dom->createElement('tip_id'));
            $tip_id->appendChild($dom->createTextNode($red->tip_id));
            
            $zaposleni_id = $sastanak->appendChild($dom->createElement('zaposleni_id'));
			$zaposleni_id->appendChild($dom->createTextNode($red->zaposleni_id));
		}
		
	}
	$xml_string = $dom->saveXML(); 
		echo $xml_string;
});

Flight::route('GET /sastanak.json/@id',function($id){
    header("Content-Type: application/json; charset=utf-8");    
    $db = Flight::db();
    $db->ExecuteQuery("select s.id,s.tema, s.datum, z.ime,z.prezime, t.naziv, s.tip as 'tip_id', s.zaposleni as 'zaposleni_id' from sastanak s inner join zaposleni z on(z.id=s.zaposleni) inner join tip_sastanka t on (t.id=s.tip) where s.id=".$id);
    
    $red = $db->getResult()->fetch_object();
	echo indent(json_encode($red));
});
Flight::route('GET /sastanak/@id/zaposleni.json',function($id){
    header("Content-Type: application/json; charset=utf-8");    
    $db = Flight::db();
    $db->ExecuteQuery("select z.* from zaposleni z inner join zaposleni_sastanak s on (z.id=s.zaposleni) where s.sastanak=".$id);
    $niz =  [];
	while ($red = $db->getResult()->fetch_object())
	{
		array_push($niz,$red);
	}
	echo indent(json_encode($niz));
});
Flight::route('POST /sastanak',function(){
    header("Content-Type: application/json; charset=utf-8");    
    $db = Flight::db();
    //prima body parametre
    $podaci = file_get_contents('php://input');
    //pretvara JSON tekst 
    //u asocijativni niz
    $niz = json_decode($podaci,true);
    if(isset($niz["tema"]) && isset($niz["datum"])&& isset($niz["tip"])&& isset($niz["zaposleni"])){
        $db->ExecuteQuery("insert INTO sastanak(tema,datum,tip,zaposleni) VALUES ('".$niz["tema"]."','".$niz["datum"]."',".$niz["tip"].",".$niz["zaposleni"].")");
    }else{
        echo "Losi ulazni parametri";
    }
    echo ($db->getResult())?"uspeh":"greska";
	
});

Flight::route('PUT /sastanak/@id',function($id){
    header("Content-Type: application/json; charset=utf-8");    
    $db = Flight::db();
    $podaci = file_get_contents('php://input');
    $niz = json_decode($podaci,true);
    $flag=0;
    if(isset($niz["tema"]) ){
        $flag=1;
        $db->ExecuteQuery("update sastanak SET tema='".$niz["tema"]."' WHERE id=".$id);
    }if(isset($niz["datum"])){
        $flag=1;
        $db->ExecuteQuery("update sastanak SET datum='".$niz["datum"]."' where id=".$id);
    }
    if(isset($niz["tip"])){
        $flag=1;
        $db->ExecuteQuery("update sastanak SET tip='".$niz["tip"]."' where id=".$id);
    }
    if(isset($niz["zaposleni"])){
        $flag=1;
        $db->ExecuteQuery("update sastanak SET zaposleni='".$niz["zaposleni"]."' where id=".$id);
    }
    if($flag==0){
        echo "Losi ulazni parametri";
        return;
    }
    echo ($db->getResult())?"uspeh":"greska";
	
});

Flight::route('DELETE /sastanak/@id',function($id){
    header("Content-Type: application/json; charset=utf-8");
    $db = Flight::db();
    $db->ExecuteQuery("DELETE FROM sastanak WHERE id=".$id);

    echo ($db->getResult())?"uspeh":"greska";
});
Flight::route('GET /zaposleni.json',function(){
    header("Content-Type: application/json; charset=utf-8");    
    $db = Flight::db();
	$db->ExecuteQuery("select * from zaposleni");

	$niz =  [];
	while ($red = $db->getResult()->fetch_object())
	{
		array_push($niz,$red);
	}
	echo indent(json_encode($niz));
});
Flight::route('GET /tip.json',function(){
    header("Content-Type: application/json; charset=utf-8");    
    $db = Flight::db();
	$db->ExecuteQuery("select * from tip_sastanka");

	$niz =  [];
	while ($red = $db->getResult()->fetch_object())
	{
		array_push($niz,$red);
	}
	echo indent(json_encode($niz));
});
Flight::route('GET /zaposleni.json/@id',function($id){
    header("Content-Type: application/json; charset=utf-8");    
    $db = Flight::db();
    $db->ExecuteQuery("select * from zaposleni where id=".$id);
    
    $red = $db->getResult()->fetch_object();
	echo indent(json_encode($red));
});

Flight::route('POST /zaposleni',function(){
    header("Content-Type: application/json; charset=utf-8");    
    $db = Flight::db();
    //prima body parametre
    $podaci = file_get_contents('php://input');
    //pretvara JSON tekst 
    //u asocijativni niz
    $niz = json_decode($podaci,true);
    if(isset($niz["ime"]) && isset($niz["prezime"])&& isset($niz["username"])&& isset($niz["zaposleni"])){
        $db->ExecuteQuery("insert INTO sastanak(ime,prezime,username,password,kategorija) VALUES ('".$niz["ime"]."','".$niz["prezime"]."',".$niz["username"].",".$niz["password"].",1)");
    }else{
        echo "Losi ulazni parametri";
    }
    echo ($db->getResult())?"uspeh":"greska";
	
});

Flight::route('PUT /sastanak/@id',function($id){
    header("Content-Type: application/json; charset=utf-8");    
    $db = Flight::db();
    $podaci = file_get_contents('php://input');
    $niz = json_decode($podaci,true);
    $flag=0;
    if(isset($niz["ime"]) ){
        $flag=1;
        $db->ExecuteQuery("update sastanak SET ime='".$niz["ime"]."' WHERE id=".$id);
    }if(isset($niz["prezime"])){
        $flag=1;
        $db->ExecuteQuery("update sastanak SET prezime='".$niz["prezime"]."' where id=".$id);
    }
    if(isset($niz["username"])){
        $flag=1;
        $db->ExecuteQuery("update sastanak SET username='".$niz["username"]."' where id=".$id);
    }
    if(isset($niz["password"])){
        $flag=1;
        $db->ExecuteQuery("update sastanak SET password='".$niz["password"]."' where id=".$id);
    }
    if($flag==0){
        echo "Losi ulazni parametri";
        return;
    }
    echo ($db->getResult())?"uspeh":"greska";
	
});

Flight::route('delete /sastanak/@id',function($id){
    header("Content-Type: application/json; charset=utf-8");
    $db = Flight::db();
    $db->ExecuteQuery("DELETE FROM sastanak WHERE id=".$id);

    echo ($db->getResult())?"uspeh":"greska";
});


Flight::start();
?>
