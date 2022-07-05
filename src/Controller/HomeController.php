<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProductsRepository;
use App\Entity\Products;

class HomeController extends AbstractController
{
    
    /**
     * @Route("/", name="home")
     */
    public function index(ProductsRepository $productsRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'products' => $productsRepository->findAll(),
        ]);
    }


}