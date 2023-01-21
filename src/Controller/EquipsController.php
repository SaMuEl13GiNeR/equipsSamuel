<?php
namespace App\Controller;
//use App\Service\ServeiDadesEquips;
use App\Entity\Membre;
use App\Form\EquipEditarType;
use App\Form\EquipNouType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Equip;

use Doctrine\Persistence\ManagerRegistry;
class EquipsController extends AbstractController
{


//    private $equips;
//    public function __construct(ServeiDadesEquips $dades){
//        $this->equips = $dades->get();
//    }



    #[Route('/equip/editar/{codi}' ,name:'editarEquip', requirements: ['codi' => '\d+'])]
    public function editar(Request $request, $codi, ManagerRegistry $doctrine)
    {
        $equip = new Equip();
        $repositori = $doctrine->getRepository(Equip::class);
        $equip = $repositori->find($codi);
        $imatgeOld = $equip->getImatge();
        $formulari = $this->createForm(EquipEditarType::class, $equip);

        $formulari->handleRequest($request);
        if ($formulari->isSubmitted() && $formulari->isValid())
        {
            $equip = $formulari->getData();

            $imatge = $formulari->get('imatge')->getData();
            

            //$imatge = $equip->getImatge();
            if ($imatge) {
                $nomFitxer = $imatge->getClientOriginalName();
                $directori = $this->getParameter('kernel.project_dir') . "/public/img/equips/";
                unlink("img/equips/".$imatgeOld);
                try {
                    $imatge->move($directori,$nomFitxer);
                } catch (FileException $e) {
                    return $this->render('editar_equip.html.twig', array('equip' => $equip, 'error' => $e));
                }
                $equip->setImatge($nomFitxer);
            } else {
                $equip->setImatge('catIronMan.jpg');
            }


            $entityManager = $doctrine->getManager();
            $entityManager->persist($equip);
            $entityManager->flush();
            return $this->redirectToRoute('inici');
        }
        return $this->render('editar_equip.html.twig', array('formulari' => $formulari->createView(), 'equip' => $equip));
    }

    #[Route('/equip/nou' ,name:'nouEquip')]
    public function nou(Request $request, ManagerRegistry $doctrine)
    {
        $equip = new Equip();
        $formulari = $this->createForm(EquipNouType::class, $equip);
        $formulari->handleRequest($request);
        if ($formulari->isSubmitted() && $formulari->isValid())
        {
            $equip = $formulari->getData();

            $imatge = $formulari->get('imatge')->getData();

            //$imatge = $equip->getImatge();
            if ($imatge) {
                $nomFitxer = $imatge->getClientOriginalName();
                $directori = $this->getParameter('kernel.project_dir') . "/public/img/equips/";
                try {
                    $imatge->move($directori,$nomFitxer);
                } catch (FileException $e) {
                    return $this->render('nou_equip.html.twig', array('equip' => $equip, 'error' => $e));
                }
                $equip->setImatge($nomFitxer);
            } else {
                $equip->setImatge('catIronMan.jpg');
            }


            $entityManager = $doctrine->getManager();
            $entityManager->persist($equip);
            $entityManager->flush();
            return $this->redirectToRoute('inici');
        }
        return $this->render('nou_equip.html.twig', array('formulari' => $formulari->createView()));
    }

    #[Route('/equip/inserir', name:'inserir')]
    public function inserir(ManagerRegistry $doctrine)
    {
        $entityManager = $doctrine->getManager();
        $equip = new Equip();
        $equip->setNom("Simarrets");
        $equip->setCicle("DAW");
        $equip->setCurs("22/23");
        $equip->setNota("9");
        $equip->setImatge("thorcat.jpg");
        $entityManager->persist($equip);

        try {
            $entityManager->flush();
            return $this->render('inserir_equip.html.twig', array('equip' => $equip, 'error' => NULL));
        } catch (\Exception $e) {
            return $this->render('inserir_equip.html.twig', array('equip' => $equip, 'error' => $e));
        }

    }

    #[Route('/equip/inserirmultiple', name:'inserirmultiple')]
    public function inserirmultiple(ManagerRegistry $doctrine)
    {
        $entityManager = $doctrine->getManager();
        $equip1 = new Equip();
        $equip1->setNom("SpiderCat");
        $equip1->setCicle("DAW");
        $equip1->setCurs("22/23");
        $equip1->setNota("5");
        $equip1->setImatge("spidercat.jpg");
        $entityManager->persist($equip1);

        $equip2 = new Equip();
        $equip2->setNom("IronCat");
        $equip2->setCicle("DAW");
        $equip2->setCurs("22/23");
        $equip2->setNota("7.5");
        $equip2->setImatge("catIronMan.jpg");
        $entityManager->persist($equip2);

        $equip3 = new Equip();
        $equip3->setNom("ThorCat");
        $equip3->setCicle("DAW");
        $equip3->setCurs("22/23");
        $equip3->setNota("4");
        $equip3->setImatge("thorcat.jpg");
        $entityManager->persist($equip3);

        $equips = array($equip1, $equip2, $equip3);

        try {
            $entityManager->flush();
            return $this->render('inserir_equip_multiple.html.twig', array('equips' => $equips, 'error' => NULL));
        } catch (\Exception $e) {
            return $this->render('inserir_equip_multiple.html.twig', array('equips' => $equips, 'error' => $e));
        }

    }

    #[Route('/equip/{id}', name:'dades_equips')]
    public function equip($id, ManagerRegistry $doctrine)
    {
        $repositoriEquip = $doctrine->getRepository(Equip::class);
        $repositoriMembre = $doctrine->getRepository(Membre::class);
        $membres = $repositoriMembre->findAll();
        $equip = $repositoriEquip->find($id);
        if($equip){
            return $this->render('dades_equips.html.twig', array('equip' =>$equip, 'membres' => $membres));
        } else {
            return $this->render('dades_equips.html.twig', array('equip' =>NULL, 'membres' => NULL));
        }
    }



    #[Route('/equip/nota/{nota}', name:'filtrar_nota')]
    public function nota($nota, ManagerRegistry $doctrine)
    {
        $repositori = $doctrine->getRepository(Equip::class);
        $equips = $repositori->findAll();
         $a = array();

        forEach ($equips as $equip ){
            if ($equip->getNota() >= $nota){
                array_push($a, $equip);
            }
        }

        arsort($a);
        if($a){
            return $this->render('inici.html.twig', array('equips' =>$a));
        } else {
            return $this->render('inici.html.twig', array('equips' =>NULL));
        }
    }
}



?>