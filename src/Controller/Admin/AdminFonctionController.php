<?php

namespace App\Controller\Admin;

use App\Entity\Fonction;
use App\Form\FonctionType;
use App\Repository\FonctionRepository;
use Symfony\Component\HttpFoundation\Request;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/fonction")
 */
class AdminFonctionController extends AbstractController
{
    /**
     * @Route("/", name="fonction_index", methods={"GET"})
     */
    public function index(FonctionRepository $fonctionRepository): Response
    {
        return $this->render('admin/fonction/index.html.twig', [
            'current_menu' => 'fonction',
            'fonctions' => $fonctionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="fonction_new", methods={"GET","POST"})
     */
    public function new(Request $request, FlashyNotifier $flashy): Response
    {
        $fonction = new Fonction();
        $form = $this->createForm(FonctionType::class, $fonction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($fonction);
            $entityManager->flush();
            $flashy->success('Nouvelle fonction créer avec succès!', '');
            return $this->redirectToRoute('fonction_index');
        }

        return $this->render('admin/fonction/new.html.twig', [
            'fonction' => $fonction,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="fonction_show", methods={"GET"})
     */
    public function show(Fonction $fonction): Response
    {
        return $this->render('admin/fonction/show.html.twig', [
            'fonction' => $fonction,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="fonction_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Fonction $fonction, FlashyNotifier $flashy): Response
    {
        $form = $this->createForm(FonctionType::class, $fonction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $flashy->primaryDark('Fonction modifié avec succès!', '');
            return $this->redirectToRoute('fonction_index');
        }

        return $this->render('admin/fonction/edit.html.twig', [
            'fonction' => $fonction,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="fonction_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Fonction $fonction, FlashyNotifier $flashy): Response
    {
        if ($this->isCsrfTokenValid('delete'.$fonction->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($fonction);
            $entityManager->flush();
            $flashy->warning('Fonction supprimé avec succès!', '');
        }

        return $this->redirectToRoute('fonction_index');
    }
}
