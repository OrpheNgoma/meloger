<?php

namespace App\Controller;

use App\Repository\PropertyRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(PropertyRepository $repository)
    {
        $properties = $repository->findLatest();
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'current_menu' => 'home',
            'properties' => $properties
        ]);
    }
}
