<?php


class Broker{

    private $rezultat;
    private $mysqli;
    private static $broker;
    public function getRezultat(){
        return $this->rezultat;
    }
    public function getMysqli(){
        return $this->mysqli;
    }
    private function __construct(){
        $this->mysqli = new mysqli("localhost", "root", "", "nitro");
        $this->mysqli->set_charset("utf8");
    }

    public static function getBroker(){
        if(!isset($broker)){
            $broker=new Broker();
        }
        return $broker;
    }
    public function izvrsi($upit){
		$this->rezultat=$this->mysqli->query($upit);
    }
    public function getZadnjiId(){
        return $this->mysqli->insert_id;
    }
   
}

?>
