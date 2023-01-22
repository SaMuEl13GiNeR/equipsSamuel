<?php
namespace App\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Jenssegers\Date\Date;
class LoginController extends AbstractController
{
    #[Route('/login', name: 'login')]
    public function login(AuthenticationUtils $authenticationUtils)
    {
        Date::setLocale('ca_ES');
        $hui = Date::now();

        $data = $hui->format('d') . ', ' . $hui->format('')  ;
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('login.html.twig', array('error' => $error,'lastUsername' => $lastUsername));
    }
}
?>