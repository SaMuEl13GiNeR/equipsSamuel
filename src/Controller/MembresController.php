<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Equip;
use App\Entity\Membre;

use Doctrine\Persistence\ManagerRegistry;
class MembresController extends AbstractController
{


    #[Route('/membre/nou' ,name:'nouMembre')]
    public function nou(Request $request, ManagerRegistry $doctrine)
    {
        $membre = new Membre();
        $formulari = $this->createFormBuilder($membre)
            ->add('nom', TextType::class)
            ->add('cognoms', TextType::class)
            ->add('email', TextType::class, array('label' => 'Correu Electrònic'))
            ->add('dataNaixement', DateType::class, array('label' => 'Data de Naixement', 'years' => range(1920,2022)))
            ->add('imatgePerfil', FileType::class,array('required' => false))
            ->add('equip', EntityType::class, array('class' => Equip::class, 'choice_label' => 'nom'))
            ->add('nota', NumberType::class)
            ->add('save', SubmitType::class, array('label' => 'Enviar'))
            ->getForm();
        $formulari->handleRequest($request);

        if ($formulari->isSubmitted() && $formulari->isValid())
        {
            $membre = $formulari->getData();

            $imatge = $formulari->get('imatgePerfil')->getData();

            if ($imatge) {
                $nomFitxer = $imatge->getClientOriginalName();
                $directori = $this->getParameter('kernel.project_dir') . "/public/img/membres/";
                try {
                    $imatge->move($directori,$nomFitxer);
                } catch (FileException $e) {
                    return $this->render('nou_membre.html.twig', array('membre' => $membre, 'error' => $e));
                }
                $membre->setImatgePerfil($nomFitxer);
            } else {
                $membre->setImatgePerfil('catIronMan.jpg');
            }


            $entityManager = $doctrine->getManager();
            $entityManager->persist($membre);
            $entityManager->flush();
            return $this->redirectToRoute('inici');
        }
        return $this->render('nou_membre.html.twig', array('formulari' => $formulari->createView()));
    }

    #[Route('/membre/inserir', name:'inserir_membre')]
    public function inserir_membre(ManagerRegistry $doctrine)
    {



        $entityManager = $doctrine->getManager();

        $repositori = $doctrine->getRepository(Equip::class);
        $equip = $repositori->find(39);
        $membre = new Membre();
        $membre->setNom("Sarah");
        $membre->setCognoms("Connor");
        $membre->setEmail("sarahconnor@skynet.com");
        $membre->setImatgePerfil("catFlash.jpg");
        $membre->setDataNaixement(new \DateTime("1963-11-29"));
        $membre->setNota("9");
        $membre->setEquip($equip);
        $entityManager->persist($membre);

        try {
            $entityManager->flush();
            return $this->render('inserir_membre.html.twig', array('membre' => $membre, 'error' => NULL));
        } catch (\Exception $e) {
            return $this->render('inserir_membre.html.twig', array('membre' => $membre, 'error' => $e));
        }

    }

}



?>