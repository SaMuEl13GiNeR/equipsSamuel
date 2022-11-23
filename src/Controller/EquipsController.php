<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
class EquipsController extends AbstractController
{
    private $equips = array(
        array("codi" => "1", "nom" => "Equip Roig", "cicle" =>"DAW", "curs" =>"22/23", "membres" => array("Elena","Vicent","Joan","Maria")),
        array("codi" => "2", "nom" => "Equip Verd", "cicle" =>"DAM", "curs" =>"21/22", "membres" => array("Pepe","Pepa","Pepito","Pepita")),
        array("codi" => "3", "nom" => "Equip Blau", "cicle" =>"ASIX", "curs" =>"20/21", "membres" => array("Antonita","Antonito","Antonia","Antonio")),
        array("codi" => "4", "nom" => "Equip Groc", "cicle" =>"SMX", "curs" =>"19/20", "membres" => array("Paquito","Paquita","Paco","Paca"))
    );

    #[Route('/equip/{codi}', name:'dades_equips')]
    public function equip($codi = 1)
    {

        $resultat = array_filter($this->equips,
            function($equip) use ($codi)
            {
                return $equip["codi"] == $codi;
            });



            return $this->render('dades_equips.html.twig',
                array('equip' => array_shift($resultat)));




    }
}
?>