<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AccountController extends AbstractController
{

    /**
     * Connect to the administration
     *
     * @param AuthenticationUtils $utils
     * @return Response
     */
    #[Route('/', name: 'account_login')]
    public function index(AuthenticationUtils $utils): Response
    {
        $error = $utils->getLastAuthenticationError();
        $username = $utils->getLastUsername();

        return $this->render('account/index.html.twig', [
            'hasError' => $error !== null,
            'username' => $username
        ]);
    }

     /**
     * Permet la déconnexion de l'utilisateur
     *
     * @return void
     */
    #[Route("/logout", name:"account_logout")]
    public function logout():void
    {
        //
    }


}
