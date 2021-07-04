<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    /**
     * Permet d'afficher le profil d'un utilisateur
     * 
     * @Route("/user/{slug}", name="user_show")
     * 
     * @return Response
     */
    public function index(User $user): Response
    {
        return $this->render('user/index.html.twig', [
            'user' =>  $user,
        ]);
    }
   
}
