<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

use phpCAS;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @Route("/login/{force_authentification}", name="login", methods={"GET","HEAD"}))
     */
    public function index($force_authentification): Response
    {
        include_once('CAS/CAS.php');
        $page_accueil = "/";
        
        include_once('cas.sso');
        
        echo var_dump($serveurSSOPort);
        phpCAS::client(CAS_VERSION_2_0,$serveurSSO,$serveurSSOPort,$serveurSSORacine,true);
        phpCAS::setLang(PHPCAS_LANG_ENGLISH);
        
        if (isset($Url_CAS_setFixedServiceURL) && ($Url_CAS_setFixedServiceURL != ''))
        phpCAS::setFixedServiceURL($Url_CAS_setFixedServiceURL);
        
        phpCAS::setNoCasServerValidation();
        
        phpCAS::handleLogoutRequests(false);
        if (phpCAS::checkAuthentication()){
        // L'utilisateur est déjà authentifié, on continue
        }else{
        // L'utilisateur n'est pas authentifié. Que fait-on ?
        if (isset($force_authentification))
        phpCAS::forceAuthentication();
        }
        $user = phpCAS::getUser();
        
        return $this->render('login/index.html.twig', [
            'controller_name' => 'LoginController',
            'force_authentification' => $_GET['force_authentification'],
            'user' => $user
        ]);
    }
}
