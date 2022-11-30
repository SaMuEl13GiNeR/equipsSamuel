<?php
namespace App\Controller;
use App\Service\ServeiDadesEquips;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
class EquipsController extends AbstractController
{

    private $equips;
    public function __construct(ServeiDadesEquips $dades){
        $this->equips = $dades->get();
    }


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