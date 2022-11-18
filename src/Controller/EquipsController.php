<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
class EquipsController
{
    private $equips = array(
        array("codi" => "1", "nom" => "Equip Roig", "cicle" =>"DAW", "curs" =>"22/23", "membres" => array("Elena","Vicent","Joan","Maria")),
        array("codi" => "2", "nom" => "Equip Verd", "cicle" =>"DAM", "curs" =>"21/22", "membres" => array("Pepe","Pepa","Pepito","Pepita")),
        array("codi" => "3", "nom" => "Equip Blau", "cicle" =>"ASIX", "curs" =>"20/21", "membres" => array("Antonita","Antonito","Antonia","Antonio")),
        array("codi" => "4", "nom" => "Equip Groc", "cicle" =>"SMX", "curs" =>"19/20", "membres" => array("Paquito","Paquita","Paco","Paca"))
    );

    #[Route('/equip/{codi}', name:'dades_equip')]
    public function equip($codi)
    {

        $resultat = array_filter($this->equips,
            function($equip) use ($codi)
            {
                return $equip["codi"] == $codi;
            });
        if (count($resultat) > 0)
        {

            $resposta = "";
            $resultat = array_shift($resultat); #torna el primer element
            $resposta .= "<ul><li>" . $resultat["codi"] . "</li>" .
                                "<li>" . $resultat["nom"] . "</li>" .
                                "<li>" . $resultat["cicle"] . "</li>" .
                                "<li>" . $resultat["curs"] . "</li>" .
                                "<li>" . $resultat["membres"][0] . "</li>" .
                                "<li>" . $resultat["membres"][1] . "</li>" .
                                "<li>" . $resultat["membres"][2] . "</li>" .
                                "<li>" . $resultat["membres"][3] . "</li>" .
                                "</ul>";



            return new Response("<html><body>$resposta</body></html>");
        } else {
            return new Response("No s'ha trobat l'equip: $codi");
        }

    }
}
?>