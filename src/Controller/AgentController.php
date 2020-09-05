<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\property;
use App\Repository\PropertyRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/agent/property")
 */
class AgentController extends AbstractController
{
    /**
     * @Route("/", name="agent_index", methods={"GET"})
     */
    public function index(PropertyRepository $repository)
    {
        // $properties = $this->getDoctrine()->getRepository(property::class)->findOneBy([
        //     'properties' => $this->getUser()
        // ]);

        return $this->render('agent/property/index.html.twig', [
            'controller_name' => 'AgentController',
            'current_menu' => 'gestagent',
            'properties' => $repository->findAll(),
        ]);
    }
}
