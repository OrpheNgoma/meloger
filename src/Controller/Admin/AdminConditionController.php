<?php

namespace App\Controller\Admin;

use App\Entity\Condition;
use App\Form\ConditionType;
use App\Repository\ConditionRepository;
use Symfony\Component\HttpFoundation\Request;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/condition")
 */
class AdminConditionController extends AbstractController
{
    /**
     * @Route("/", name="condition_index", methods={"GET"})
     */
    public function index(ConditionRepository $conditionRepository): Response
    {
        return $this->render('admin/condition/index.html.twig', [
            'current_menu' => 'condition',
            'conditions' => $conditionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="condition_new", methods={"GET","POST"})
     */
    public function new(Request $request, FlashyNotifier $flashy): Response
    {
        $condition = new Condition();
        $form = $this->createForm(ConditionType::class, $condition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($condition);
            $entityManager->flush();
            $flashy->success('Nouvelle condition créer avec succès!', '');
            return $this->redirectToRoute('condition_index');
        }

        return $this->render('admin/condition/new.html.twig', [
            'condition' => $condition,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="condition_show", methods={"GET"})
     */
    public function show(Condition $condition): Response
    {
        return $this->render('admin/condition/show.html.twig', [
            'condition' => $condition,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="condition_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Condition $condition, FlashyNotifier $flashy): Response
    {
        $form = $this->createForm(ConditionType::class, $condition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $flashy->primaryDark('Condition modifié avec succès!', '');
            return $this->redirectToRoute('condition_index');
        }

        return $this->render('admin/condition/edit.html.twig', [
            'condition' => $condition,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="condition_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Condition $condition, FlashyNotifier $flashy): Response
    {
        if ($this->isCsrfTokenValid('delete'.$condition->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($condition);
            $entityManager->flush();
            $flashy->warning('Condition supprimé avec succès!', '');
        }

        return $this->redirectToRoute('condition_index');
    }
}
