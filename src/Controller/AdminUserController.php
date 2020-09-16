<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\UserType;
use App\Entity\User;

class AdminUserController extends AbstractController
{
    /**
     * @Route("/admin/users", name="admin_user")
     */
    public function index(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user, [
            'method' => 'POST',]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$user` variable has also been updated
            $user = $form->getData();

            // ... perform some action, such as saving the user to the database
            // for example, if User is a Doctrine entity, save it!
             $entityManager = $this->getDoctrine()->getManager();
             $entityManager->persist($user);
             $entityManager->flush();
        }
        return $this->render('admin/user.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
