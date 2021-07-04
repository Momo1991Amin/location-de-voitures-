<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route()
 */
class CategoryController extends AbstractController
{
    /**
     * Récupère toute les category de la base de donnée
     * 
     * @Route("/category", name="category")
     */
    public function index(CategoryRepository $categories): Response
    {
        return $this->render('partials/_header.html.twig', [
            'categories' => $categories->findAll(),
        ]);
    }
}
