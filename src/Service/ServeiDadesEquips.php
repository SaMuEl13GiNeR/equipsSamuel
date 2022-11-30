<?php
namespace App\Service;
class ServeiDadesEquips {
    private $equips = array(
        array("img"=>"catFlash.jpg", "codi" => "1", "nom" => "FlashCat", "cicle" =>"DAW", "curs" =>"22/23", "membres" => array("Elena","Vicent","Joan","Maria")),
        array("img"=>"hulkat.jpg", "codi" => "2", "nom" => "Hulkat", "cicle" =>"DAM", "curs" =>"21/22", "membres" => array("Pepe","Pepa","Pepito","Pepita")),
        array("img"=>"catBatMan.jpg", "codi" => "3", "nom" => "BatCat", "cicle" =>"ASIX", "curs" =>"20/21", "membres" => array("Antonita","Antonito","Antonia","Antonio")),
        array("img"=>"aquacat.jpg", "codi" => "4", "nom" => "AquaCat", "cicle" =>"SMX", "curs" =>"19/20", "membres" => array("Paquito","Paquita","Paco","Paca"))
    );

    public function get(){
        return $this->equips;
    }
}